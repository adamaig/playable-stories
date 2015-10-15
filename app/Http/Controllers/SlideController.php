<?php

namespace PlayableStories\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use File;
use Config;

use PlayableStories\Http\Requests;
use PlayableStories\Http\Controllers\Controller;

use PlayableStories\Story;
use PlayableStories\Slide;
use PlayableStories\Choice;
use PlayableStories\Outcome;
use PlayableStories\OutcomeResult;

class SlideController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {
        $currentSlideCount = count(Slide::where('story_id', '=', $id)->get());

        $slide = new Slide;
        $slide->story_id = $id;
        $slide->order = $currentSlideCount + 1;
        $slide->save();

        return redirect('/slide/' . $slide->id . '/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, $order)
    {
        $story = Story::findOrFail($id);
        $slide = Slide::where('story_id', $story->id)->where('order', $order)->first();

        $googleFontList = Config::get('fonts');

        return view('slide.show')->withStory($story)->withSlide($slide)->withFonts($googleFontList);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $slide = Slide::findOrFail($id);
        $meters = $slide->story->meters()->get();
        $meters = $meters->toArray();
        return view('slide.edit')->withSlide($slide)->withMeters($meters);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'name' => 'required',
            'image' => 'image',
            'content' => 'required',
            'text-placement' => 'required|in:under,left,right',
            'text-alignment' => 'required|in:left,right,center',
        );

        $this->validate($request, $rules);

        $slide = Slide::findOrFail($id);
        $slide->name = $request->input('name');
        $slide->content = $request->input('content');
        $slide->text_placement = $request->input('text-placement');
        $slide->text_alignment = $request->input('text-alignment');

        // Save photo
        if ($request->file('image')) {
            $imageName = $slide->id . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(base_path() . '/public/img/slide-photos/', $imageName);
            $slide->image = $imageName;
        }

        $slide->save();

        \Flash::success('Your slide has been updated!');

        return redirect('/slide/' . $slide->id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $slide = Slide::find($id);

        $affectedRows = Slide::destroy($id);

        foreach (Slide::where('story_id', '=', $slide->story->id)->where('order', '>', $slide->order)->get() as $slide) {
            $slide->order = ($slide->order - 1);
            $slide->save();
        }

        if ($affectedRows > 0) {
            \Flash::info('The slide has been deleted permanently.');
        } else {
            \Flash::error('The slide could not be deleted.');
        }

        return $affectedRows;
    }

    /**
     * Duplicate the specified slide within the story.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id)
    {
        $slide = Slide::find($id);

        $currentSlideCount = count(Slide::where('story_id', '=', $slide->story->id)->get());

        $newSlide = new Slide;
        $newSlide->story_id = $slide->story_id;
        $newSlide->order = $currentSlideCount + 1;
        $newSlide->name = $slide->name;
        $newSlide->image = $slide->image;
        $newSlide->content = $slide->content;
        $newSlide->text_placement = $slide->text_placement;
        $newSlide->text_alignment = $slide->text_alignment;
        $newSlide->save();

        \Flash::success('The slide has been duplicated and added to the end of your story.');

        return redirect('/story/' . $slide->story->id . '/edit');
    }

    /**
     * Shift the order of the specified slide up or down.
     *
     * @param  int  $id
     * @return Response
     */
    public function shift($id, $direction)
    {
        $slide = Slide::findOrFail($id);

        $originalSlideOrder = $slide->order;

        if ($direction == 'down') {
            if ($slide->order == 1) {
                return redirect('/story/' . $slide->story->id . '/edit');
            }

            $oldSlide = Slide::where('story_id', $slide->story->id)->where('order', $originalSlideOrder - 1)->first();
            $oldSlide->order = $originalSlideOrder;
            $oldSlide->save();

            $slide->order = ($slide->order - 1);
        } elseif ($direction == 'up') {
            if ($slide->order == count($slide->story->slides()->get())) {
                return redirect('/story/' . $slide->story->id . '/edit');
            }

            $oldSlide = Slide::where('story_id', $slide->story->id)->where('order', $originalSlideOrder + 1)->first();
            $oldSlide->order = $originalSlideOrder;
            $oldSlide->save();

            $slide->order = ($slide->order + 1);
        }
        $slide->save();

        return redirect('/story/' . $slide->story->id . '/edit');
    }

    /**
     * Process the user's choice and advance them to the next slide.
     *
     * @param  int  $id
     * @return Response
     */
    public function choose($id, $order, $choiceId)
    {
        $story = Story::findOrFail($id);
        $choice = Choice::findOrFail($choiceId);
        $slide = Slide::where('story_id', $story->id)->where('order', $order)->first();
        $vignette = null;
        
        $googleFontList = Config::get('fonts');
        
        if ($choice->meter_effect == 'none') {
            if (count($story->slides()->get()) == $order) {
                return view('slide.end')->withText($story->success_content)->withHeading($story->success_heading)->withSlide($slide)->withStory($story)->withFonts($googleFontList)->withVignette($vignette);
            }

            $outcome = Outcome::where('choice_id', $choice->id)->first();
            $vignette = $outcome->vignette;

            return redirect('/story/' . $story->id . '/' . ($order+1))->with('vignette', $vignette);;
        } elseif ($choice->meter_effect == 'specific') {
            $outcome = Outcome::where('choice_id', $choiceId)->first();
            $vignette = $outcome->vignette;

            foreach ($outcome->results()->get() as $key => $result) {
                $newMeterValue = (Session::get('story-'.$story->id.'-meter-'.($key+1).'-value') + $result->change);
                Session::put('story-'.$story->id.'-meter-'.($key+1).'-value', $newMeterValue);
            }

            foreach ($story->meters()->get() as $key => $meter) {
                if (Session::get('story-'.$story->id.'-meter-'.($key+1).'-value') <= $meter->min_value && $meter->min_value !== null) {
                    return view('slide.end')->withText($meter->min_value_text)->withHeading($meter->min_value_header)->withSlide($slide)->withStory($story)->withFonts($googleFontList)->withVignette($vignette);
                }

                if (Session::get('story-'.$story->id.'-meter-'.($key+1).'-value') >= $meter->max_value && $meter->max_value !== null) {
                    return view('slide.end')->withText($meter->max_value_text)->withHeading($meter->max_value_header)->withSlide($slide)->withStory($story)->withFonts($googleFontList)->withVignette($vignette);
                }
            }

            if (count($story->slides()->get()) == $order) {
                return view('slide.end')->withText($story->success_content)->withHeading($story->success_heading)->withSlide($slide)->withStory($story)->withFonts($googleFontList);
            }

            return redirect('/story/' . $story->id . '/' . ($order+1))->with('vignette', $vignette);;
        } elseif ($choice->meter_effect == 'chance') {
            $outcome = Outcome::where('choice_id', $choiceId)->first();
            $vignette = $outcome->vignette;

            if (rand(1,100) <= $outcome->likelihood) {
                foreach ($outcome->results()->get() as $key => $result) {
                    $newMeterValue = (Session::get('story-'.$story->id.'-meter-'.($key+1).'-value') + $result->change);
                    Session::put('story-'.$story->id.'-meter-'.($key+1).'-value', $newMeterValue);
                }
            } else {
                $outcome = Outcome::where('choice_id', $choiceId)->orderBy('id', 'desc')->first();
                $vignette = $outcome->vignette;

                foreach ($outcome->results()->get() as $key => $result) {
                    $newMeterValue = (Session::get('story-'.$story->id.'-meter-'.($key+1).'-value') + $result->change);
                    Session::put('story-'.$story->id.'-meter-'.($key+1).'-value', $newMeterValue);
                }
            }

            foreach ($story->meters()->get() as $key => $meter) {
                if (Session::get('story-'.$story->id.'-meter-'.($key+1).'-value') <= $meter->min_value && $meter->min_value !== null) {
                    return view('slide.end')->withText($meter->min_value_text)->withHeading($meter->min_value_header)->withSlide($slide)->withStory($story)->withFonts($googleFontList)->withVignette($vignette);
                }

                if (Session::get('story-'.$story->id.'-meter-'.($key+1).'-value') >= $meter->max_value && $meter->max_value !== null) {
                    return view('slide.end')->withText($meter->max_value_text)->withHeading($meter->max_value_header)->withSlide($slide)->withStory($story)->withFonts($googleFontList)->withVignette($vignette);
                }
            }

            if (count($story->slides()->get()) == $order) {
                return view('slide.end')->withText($story->success_content)->withHeading($story->success_heading)->withSlide($slide)->withStory($story)->withFonts($googleFontList)->withVignette($vignette);
            }

            return redirect('/story/' . $story->id . '/' . ($order+1))->with('vignette', $vignette);
        }
    }

    /**
     * Remove current image attached to slide.
     *
     * @param  int  $id
     * @return Response
     */
    public function removeImage($id)
    {
        $slide = Slide::findOrFail($id);

        File::delete('img/slide-photos/' . $slide->image);

        $slide->image = null;
        $slide->save();

        return redirect('slide/'.$id.'/edit');
    }

    /**
     * Force display of end slide.
     *
     * @param  int  $id
     * @return Response
     */
    public function end($id)
    {
        $googleFontList = Config::get('fonts');

        $story = Story::findOrFail($id);
        $slide = Slide::where('story_id', $story->id)->orderBy('order')->first();

        return view('slide.end')->withText($story->success_content)->withHeading($story->success_heading)->withStory($story)->withSlide($slide)->withFonts($googleFontList);
    }
}
