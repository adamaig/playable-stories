<?php

namespace PlayableStories\Http\Controllers;

use Illuminate\Http\Request;
use File;

use PlayableStories\Http\Requests;
use PlayableStories\Http\Controllers\Controller;

use PlayableStories\Story;
use PlayableStories\Introduction;

class IntroductionController extends Controller
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
        $introduction = Introduction::findOrFail($id);

        $googleFontList = array(
            'Abril Fatface' => array(
                'link_code' => 'Abril+Fatface',
                'css_name' => 'Abril Fatface',
                'normal_weight' => 400,
                'bold_weight' => 700,
            ),
            'Archivo Narrow' => array(
                'link_code' => 'Archivo+Narrow:400italic,400,700italic,700',
                'css_name' => 'Archivo Narrow',
                'normal_weight' => 400,
                'bold_weight' => 700,
            ),
            'Arvo' => array(
                'link_code' => 'Arvo:400italic,400,700italic,700',
                'css_name' => 'Arvo',
                'normal_weight' => 400,
                'bold_weight' => 700,
            ),
            'Crete Round' => array(
                'link_code' => 'Crete+Round:400italic,400',
                'css_name' => 'Crete Round',
                'normal_weight' => 400,
                'bold_weight' => 700,
            ),
            'Droid Serif' => array(
                'link_code' => 'Droid+Serif:400italic,400,700italic,700',
                'css_name' => 'Droid Serif',
                'normal_weight' => 400,
                'bold_weight' => 700,
            ),
            'Josefin Slab' => array(
                'link_code' => 'Josefin+Slab:400,400italic,700,700italic',
                'css_name' => 'Josefin Slab',
                'normal_weight' => 400,
                'bold_weight' => 700,
            ),
            'Lato' => array(
                'link_code' => 'Lato:400italic,400,700,700italic',
                'css_name' => 'Lato',
                'normal_weight' => 400,
                'bold_weight' => 700,
            ),
            'Merriweather' => array(
                'link_code' => 'Merriweather:400italic,400,700italic,700',
                'css_name' => 'Merriweather',
                'normal_weight' => 400,
                'bold_weight' => 700,
            ),
            'Open Sans' => array(
                'link_code' => 'Open+Sans:400,400italic,700italic,700',
                'css_name' => 'Open Sans',
                'normal_weight' => 400,
                'bold_weight' => 700,
            ),
            'Oswald' => array(
                'link_code' => 'Oswald:400,700',
                'css_name' => 'Oswald',
                'normal_weight' => 400,
                'bold_weight' => 700,
            ),
            'Roboto' => array(
                'link_code' => 'Roboto:400,400italic,700,700italic',
                'css_name' => 'Roboto',
                'normal_weight' => 400,
                'bold_weight' => 700,
            ),
            'Roboto Condensed' => array(
                'link_code' => 'Roboto+Condensed:400,400italic,700,700italic',
                'css_name' => 'Roboto Condensed',
                'normal_weight' => 400,
                'bold_weight' => 700,
            ),
            'Roboto Slab' => array(
                'link_code' => 'Roboto+Slab:400,400italic,700,700italic',
                'css_name' => 'Roboto Slab',
                'normal_weight' => 400,
                'bold_weight' => 700,
            ),
            'Ubuntu' => array(
                'link_code' => 'Ubuntu:400,400italic,700,700italic',
                'css_name' => 'Ubuntu',
                'normal_weight' => 400,
                'bold_weight' => 700,
            ),
            'Varela Round' => array(
                'link_code' => 'Varela+Round',
                'css_name' => 'Varela Round',
                'normal_weight' => 400,
                'bold_weight' => 700,
            ),
        );

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

        File::delete('img/introduction-photos/' . $introduction->photo);

        $introduction->photo = null;
        $introduction->save();

        return redirect('story/'.$introduction->story->id.'/introduction/edit');
    }
}
