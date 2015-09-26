<?php

namespace PlayableStories\Http\Controllers;

use Illuminate\Http\Request;

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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

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

        return redirect('/story/' . $id . '/edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
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
            'text-placement' => 'required|in:overlay,under',
            'text-alignment' => 'required|in:left,right,center,justify',
        );

        $this->validate($request, $rules);

        $slide = Slide::findOrFail($id);
        $slide->name = $request->input('name');
        $slide->image = $request->input('image');
        $slide->content = $request->input('content');
        $slide->text_placement = $request->input('text-placement');
        $slide->text_alignment = $request->input('text-alignment');
        
        $slide->save();

        // Save photo
        if ($request->file('image')) {
            $imageName = $slide->id . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(base_path() . '/public/img/slide-photos/', $imageName);
        }

        // Loop through each choice and save them after deleting any old choices
        Choice::where('slide_id', '=', $slide->id)->delete();

        if (!empty($request->get('choice-text'))) {
            foreach ($request->get('choice-text') as $key => $val) {
                $currentChoices = $slide->choices()->get();

                if ($request->input('choice-type.'.$key) == 'none') {
                    $choice = new Choice;
                    $choice->slide_id = $slide->id;
                    $choice->order = count($currentChoices) + 1;
                    $choice->meter_effect = 'none';
                    $choice->save();

                    $outcome = new Outcome;
                    $outcome->choice_id = $choice->id;
                    $outcome->likelihood = '100';
                    $outcome->vignette = $request->input('vignette.'.$key);
                    $outcome->save();
                } elseif ($request->input('choice-type.'.$key) == 'specific') {
                    $choice = new Choice;
                    $choice->slide_id = $slide->id;
                    $choice->order = count($currentChoices) + 1;
                    $choice->meter_effect = 'specific';
                    $choice->save();

                    $outcome = new Outcome;
                    $outcome->choice_id = $choice->id;
                    $outcome->likelihood = '100';
                    $outcome->vignette = $request->input('vignette.'.$key);
                    $outcome->save();

                    foreach ($slide->story->meters()->get() as $meterKey => $meter) {
                        $result = new OutcomeResult;
                        $result->outcome_id = $outcome->id;
                        $result->meter_id = $meter->id;
                        $result->change = $request->input('meter-'.($meterKey+1).'-change.'.$key);
                        $result->save();
                    }
                } elseif ($request->input('choice-type.'.$key) == 'chance') {
                    $choice = new Choice;
                    $choice->slide_id = $slide->id;
                    $choice->order = count($currentChoices) + 1;
                    $choice->meter_effect = 'chance';
                    $choice->save();

                    $outcome1 = new Outcome;
                    $outcome1->choice_id = $choice->id;
                    $outcome1->likelihood = $request->input('likelihood-1.'.$key);
                    $outcome1->save();

                    $outcome2 = new Outcome;
                    $outcome2->choice_id = $choice->id;
                    $outcome2->likelihood = $request->input('likelihood-2.'.$key);
                    $outcome2->save();

                    foreach ($slide->story->meters()->get() as $meterKey => $meter) {
                        $result1 = new OutcomeResult;
                        $result1->outcome_id = $outcome1->id;
                        $result1->meter_id = $meter->id;
                        $result1->change = $request->input('meter-'.$meter->id.'-outcome-1.'.$key);
                        $result1->save();

                        $result2 = new OutcomeResult;
                        $result2->outcome_id = $outcome2->id;
                        $result2->meter_id = $meter->id;
                        $result2->change = $request->input('meter-'.$meter->id.'-outcome-2.'.$key);
                        $result2->save();
                    }
                }
            }
        }

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
        $slide = Slide::find($id);

        $originalSlideOrder = $slide->order;

        if ($direction == 'down') {
            $slide->order = ($slide->order - 1);
        } elseif ($direction == 'up') {
            $slide->order = ($slide->order + 1);
        }
        $slide->save();

        $adjacentSlide = Slide::where('order', '=', $slide->order)->where('id', '<>', $id)->first();
        $adjacentSlide->order = ($originalSlideOrder);
        $adjacentSlide->save();

        return redirect('/story/' . $slide->story->id . '/edit');
    }
}
