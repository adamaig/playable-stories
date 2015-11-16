<?php

namespace PlayableStories\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Config;
use Auth;

use PlayableStories\Http\Requests;
use PlayableStories\Http\Controllers\Controller;

use PlayableStories\Story;
use PlayableStories\Slide;
use PlayableStories\Meter;
use PlayableStories\Introduction;

class StoryController extends Controller
{
    /**
     * Instantiate a new StoryController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $stories = Story::where('author', Auth::id())->get();
        return view('homepage')->withStories($stories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $story = new Story;
        $story->author = Auth::id();
        $story->save();

        $meter = new Meter;
        $meter->story_id = $story->id;
        $meter->order = 1;
        $meter->name = 'Cash';
        $meter->type = 'currency';
        $meter->start_value = 1000;
        $meter->min_value = 0;
        $meter->min_value_header = 'You are out of money!';
        $meter->min_value_text = '<p>Sorry, but it looks like you don\'t have any cash left to continue. Game over pal!</p>';
        $meter->max_value = null;
        $meter->max_value_header = null;
        $meter->max_value_text = null;
        $meter->save();

        return redirect('/story/' . $story->id . '/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $story = Story::findOrFail($id);

        foreach ($story->meters()->get() as $key => $meter) {
            Session::forget('story-'.$story->id.'-meter-'.($key+1).'-value');
            Session::forget('story-'.$story->id.'-meter-'.($key+1).'-name');
            Session::forget('story-'.$story->id.'-meter-'.($key+1).'-type');

            Session::put('story-'.$story->id.'-meter-'.($key+1).'-value', $meter->start_value);
            Session::put('story-'.$story->id.'-meter-'.($key+1).'-name', $meter->name);
            Session::put('story-'.$story->id.'-meter-'.($key+1).'-type', $meter->type);
        }

        if (count($story->introductions()->get()) == 0) {
            return redirect('/story/'.$story->id.'/1');
        } else {
            $introduction = Introduction::where('story_id', $story->id)->first();
            return redirect('/introduction/'.$introduction->id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $story = Story::findOrFail($id);

        if ($story->author != Auth::id()) {
            return redirect('/');
        }

        $googleFontList = Config::get('fonts');

        return view('story.edit')->withStory($story)->withFonts($googleFontList);
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
        // Design tab
        $rules = array(
            'story-name' => 'required',
            'background-color' => 'required|hex',
            'heading-font-color' => 'required|hex',
            'body-font-size' => 'required|numeric|min:10',
            'body-font-color' => 'required|hex',
            'link-color' => 'required|hex',
            'button-background-color' => 'required|hex',
            'button-text-color' => 'required|hex',
        );

        $this->validate($request, $rules);

        $story = Story::findOrFail($id);

        if ($story->author != Auth::id()) {
            return redirect('/');
        }

        $story->name = $request->input('story-name');
        // Design tab
        $story->background_color = $request->input('background-color');
        $story->heading_font = $request->input('heading-font');
        $story->heading_font_color = $request->input('heading-font-color');
        $story->body_font = $request->input('body-font');
        $story->body_font_size = $request->input('body-font-size');
        $story->body_font_color = $request->input('body-font-color');
        $story->link_color = $request->input('link-color');
        $story->button_background_color = $request->input('button-background-color');
        $story->button_text_color = $request->input('button-text-color');
        // Meters tab
        $story->success_heading = $request->input('success-heading');
        $story->success_content = $request->input('success-content');

        $story->save();

        \Flash::success('Your story has been updated! You can <a href="/story/' . $story->id . '" target="_blank">view it</a> to see your changes.');

        return redirect('/story/' . $story->id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $story = Story::findOrFail($id);

        if ($story->author != Auth::id()) {
            return redirect('/');
        }

        $affectedRows  = Story::where('id', '=', $id)->delete();
        if ($affectedRows > 0) {
            \Flash::info('The story has been deleted permanently.');
        } else {
            \Flash::error('The story could not be deleted.');
        }
        return $affectedRows;
    }
}
