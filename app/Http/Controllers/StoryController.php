<?php

namespace PlayableStories\Http\Controllers;

use Illuminate\Http\Request;
use Session;

use PlayableStories\Http\Requests;
use PlayableStories\Http\Controllers\Controller;

use PlayableStories\Story;
use PlayableStories\Slide;
use PlayableStories\Meter;
use PlayableStories\Introduction;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $stories = Story::all();
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

        $googleFontList = array(
            'Abril Fatface (No natural italic)' => array(
                'link_code' => 'Abril+Fatface',
                'css_name' => 'Abril Fatface',
                'weight' => 400,
            ),
            'Archivo Narrow' => array(
                'link_code' => 'Archivo+Narrow:400italic,400',
                'css_name' => 'Archivo Narrow',
                'weight' => 400,
            ),
            'Archivo Narrow Bold' => array(
                'link_code' => 'Archivo+Narrow:700italic,700',
                'css_name' => 'Archivo Narrow',
                'weight' => 700,
            ),
            'Arvo' => array(
                'link_code' => 'Arvo:400italic,400',
                'css_name' => 'Arvo',
                'weight' => 400,
            ),
            'Arvo Bold' => array(
                'link_code' => 'Arvo:700italic,700',
                'css_name' => 'Arvo',
                'weight' => 700,
            ),
            'Crete Round' => array(
                'link_code' => 'Crete+Round:400italic,400',
                'css_name' => 'Crete Round',
                'weight' => 400,
            ),
            'Droid Serif' => array(
                'link_code' => 'Droid+Serif:400italic,400',
                'css_name' => 'Droid Serif',
                'weight' => 400,
            ),
            'Droid Serif Bold' => array(
                'link_code' => 'Droid+Serif:700italic,700',
                'css_name' => 'Droid Serif',
                'weight' => 700,
            ),
            'Josefin Slab' => array(
                'link_code' => 'Josefin+Slab:400,400italic',
                'css_name' => 'Josefin Slab',
                'weight' => 400,
            ),
            'Josefin Slab Bold' => array(
                'link_code' => 'Josefin+Slab:700,700italic',
                'css_name' => 'Josefin Slab',
                'weight' => 700,
            ),
            'Lato' => array(
                'link_code' => 'Lato:400italic,400',
                'css_name' => 'Lato',
                'weight' => 400,
            ),
            'Lato Bold' => array(
                'link_code' => 'Lato:700italic,700',
                'css_name' => 'Lato',
                'weight' => 700,
            ),
            'Merriweather' => array(
                'link_code' => 'Merriweather:400italic,400',
                'css_name' => 'Merriweather',
                'weight' => 400,
            ),
            'Merriweather Bold' => array(
                'link_code' => 'Merriweather:700italic,700',
                'css_name' => 'Merriweather',
                'weight' => 700,
            ),
            'Open Sans' => array(
                'link_code' => 'Open+Sans:400,400italic',
                'css_name' => 'Open Sans',
                'weight' => 400,
            ),
            'Open Sans Bold' => array(
                'link_code' => 'Open+Sans:700,700italic',
                'css_name' => 'Open Sans',
                'weight' => 700,
            ),
            'Oswald (No natural italic)' => array(
                'link_code' => 'Oswald:400',
                'css_name' => 'Oswald',
                'weight' => 400,
            ),
            'Oswald Bold (No natural italic)' => array(
                'link_code' => 'Oswald:700',
                'css_name' => 'Oswald',
                'weight' => 700,
            ),
            'Roboto' => array(
                'link_code' => 'Roboto:400,400italic',
                'css_name' => 'Roboto',
                'weight' => 400,
            ),
            'Roboto Bold' => array(
                'link_code' => 'Roboto:700,700italic',
                'css_name' => 'Roboto',
                'weight' => 700,
            ),
            'Roboto Condensed' => array(
                'link_code' => 'Roboto+Condensed:400,400italic',
                'css_name' => 'Roboto Condensed',
                'weight' => 400,
            ),
            'Roboto Condensed Bold' => array(
                'link_code' => 'Roboto+Condensed:700,700italic',
                'css_name' => 'Roboto Condensed',
                'weight' => 700,
            ),
            'Roboto Slab (No natural italic)' => array(
                'link_code' => 'Roboto+Slab:400,400italic',
                'css_name' => 'Roboto Slab',
                'weight' => 400,
            ),
            'Roboto Slab Bold (No natural italic)' => array(
                'link_code' => 'Roboto+Slab:700,700italic',
                'css_name' => 'Roboto Slab',
                'weight' => 700,
            ),
            'Ubuntu' => array(
                'link_code' => 'Ubuntu:400,400italic',
                'css_name' => 'Ubuntu',
                'weight' => 400,
            ),
            'Ubuntu Bold' => array(
                'link_code' => 'Ubuntu:700,700italic',
                'css_name' => 'Ubuntu',
                'weight' => 700,
            ),
            'Varela Round (No natural italic)' => array(
                'link_code' => 'Varela+Round',
                'css_name' => 'Varela Round',
                'weight' => 400,
            ),
        );

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
            'heading-font-size' => 'required|numeric|min:10',
            'heading-font-color' => 'required|hex',
            'body-font-size' => 'required|numeric|min:10',
            'body-font-color' => 'required|hex',
            'link-color' => 'required|hex',
            'button-background-color' => 'required|hex',
            'button-text-color' => 'required|hex',
        );

        $this->validate($request, $rules);

        $story = Story::findOrFail($id);
        $story->name = $request->input('story-name');
        // Design tab
        $story->background_color = $request->input('background-color');
        $story->heading_font = $request->input('heading-font');
        $story->heading_font_size = $request->input('heading-font-size');
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
        $affectedRows  = Story::where('id', '=', $id)->delete();
        if ($affectedRows > 0) {
            \Flash::info('The story has been deleted permanently.');
        } else {
            \Flash::error('The story could not be deleted.');
        }
        return $affectedRows;
    }
}
