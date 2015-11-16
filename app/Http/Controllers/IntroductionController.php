<?php

namespace PlayableStories\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Config;
use Auth;

use PlayableStories\Http\Requests;
use PlayableStories\Http\Controllers\Controller;

use PlayableStories\Story;
use PlayableStories\Introduction;

class IntroductionController extends Controller
{
    /**
     * Instantiate a new IntroductionController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {
        if (Introduction::where('story_id', '=', $id)->exists()) {
            return redirect('/story/' . $id . '/introduction/edit');
        } else {
            $introduction = new Introduction;
            $introduction->story_id = $id;
            $introduction->save();
            return redirect('/story/' . $id . '/introduction/edit');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $introduction = Introduction::findOrFail($id);

        $googleFontList = Config::get('fonts');

        return view('introduction.show')->withIntroduction($introduction)->withFonts($googleFontList);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $introduction = Introduction::where('story_id', '=', $id)->firstOrFail();

        if ($introduction->story->author != Auth::id()) {
            return redirect('/');
        }

        return view('introduction.edit')->withIntroduction($introduction);
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
            'text-alignment' => 'required|in:left,right,center',
            'message' => 'required',
            'background-color' => 'required|hex',
            'photo' => 'image',
            'photo-type' => 'required|in:above,below,background',
            'background-placement' => 'required|in:left_top,center_top,tile,fill',
        );

        $this->validate($request, $rules);

        $introduction = Introduction::where('story_id', '=', $id)->firstOrFail();

        if ($introduction->story->author != Auth::id()) {
            return redirect('/');
        }

        $introduction->message = $request->input('message');
        $introduction->text_alignment = $request->input('text-alignment');
        $introduction->background_color = $request->input('background-color');
        $introduction->photo_type = $request->input('photo-type');
        $introduction->background_placement = $request->input('background-placement');

        // Save photo
        if ($request->file('photo')) {
            $photoName = $introduction->id . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(base_path() . '/public/img/introduction-photos/', $photoName);
            $introduction->photo = $photoName;
        }

        $introduction->save();

        \Flash::success('Your introduction slide has been saved! You can <a href="/story/' . $id . '" target="_blank">view it</a> to see your changes.');

        return redirect('/story/' . $id . '/introduction/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $introduction = Introduction::findOrFail($id);

        if ($introduction->story->author != Auth::id()) {
            return redirect('/');
        }

        $affectedRows = Introduction::destroy($id);

        if ($affectedRows > 0) {
            \Flash::info('The introduction slide has been deleted permanently.');
        } else {
            \Flash::error('The introduction slide could not be deleted.');
        }

        return $affectedRows;
    }

    /**
     * Remove current photo attached to introduction.
     *
     * @param  int  $id
     * @return Response
     */
    public function removePhoto($id)
    {
        $introduction = Introduction::findOrFail($id);

        if ($introduction->story->author != Auth::id()) {
            return redirect('/');
        }

        File::delete('img/introduction-photos/' . $introduction->photo);

        $introduction->photo = null;
        $introduction->save();

        return redirect('story/'.$introduction->story->id.'/introduction/edit');
    }
}
