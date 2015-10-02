<?php

namespace PlayableStories\Http\Controllers;

use Illuminate\Http\Request;

use PlayableStories\Http\Requests;
use PlayableStories\Http\Controllers\Controller;

use PlayableStories\Story;
use PlayableStories\Meter;

class MeterController extends Controller
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
        $story = Story::findOrFail($id);

        $currentMeters = $story->meters()->get();

        if (count($currentMeters) > 3) {
            \Flash::error('You already have the maximum number of meters for this story.');
            return redirect('/story/' . $id . '/edit');
        }

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

        return redirect('/story/' . $story->id . '/edit#tab_meters');
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
        $meter = Meter::findOrFail($id);
        return view('meter.edit')->withMeter($meter);
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
        $meter = Meter::findOrFail($id);

        $meter->name = $request->input('meter-name');
        $meter->type = $request->input('meter-type');
        $meter->start_value = $request->input('meter-start-value');
        if ($request->input('meter-no-min') != 'true') {
            $meter->min_value = $request->input('meter-min-value'); 
        } else {
            $meter->min_value = null; 
        }
        $meter->min_value_header = $request->input('meter-min-value-header');
        $meter->min_value_text = $request->input('meter-min-value-text');
        if ($request->input('meter-no-max') != 'true') {
            $meter->max_value = $request->input('meter-max-value');
        } else {
            $meter->max_value = null; 
        }
        $meter->max_value_header = $request->input('meter-max-value-header');
        $meter->max_value_text = $request->input('meter-max-value-text');

        $meter->save();

        \Flash::success('Your meter changes have been saved!');

        return redirect('/story/' . $meter->story->id . '/edit#tab_meters');
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
