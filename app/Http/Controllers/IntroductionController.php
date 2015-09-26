<?php

namespace PlayableStories\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('introduction.show')->withIntroduction($introduction);
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
            'heading' => 'required',
            'message' => 'required',
            'text-alignment' => 'required|in:left,right,center,justify',
            'background-color' => 'required|hex',
            'photo' => 'image',
            'photo-type' => 'required|in:above,below,background',
            'background-placement' => 'required|in:left_top,center_top,tile,fill',
        );

        $this->validate($request, $rules);

        $introduction = Introduction::where('story_id', '=', $id)->firstOrFail();
        $introduction->heading = $request->input('heading');
        $introduction->message = $request->input('message');
        $introduction->text_alignment = $request->input('text-alignment');
        $introduction->background_color = $request->input('background-color');
        $introduction->photo_type = $request->input('photo-type');
        $introduction->background_placement = $request->input('background-placement');
        $introduction->save();

        // Save photo
        if ($request->file('photo')) {
            $photoName = $introduction->id . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(base_path() . '/public/img/introduction-photos/', $photoName);
        }

        \Flash::success('Your introduction slide has been saved!');

        return redirect('/story/' . $id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
