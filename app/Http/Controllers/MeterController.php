<?php

namespace PlayableStories\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use PlayableStories\Http\Requests;
use PlayableStories\Http\Controllers\Controller;

use PlayableStories\Story;
use PlayableStories\Meter;
use PlayableStories\OutcomeResult;

class MeterController extends Controller
{
    /**
     * Instantiate a new MeterController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {
        $story = Story::findOrFail($id);

        if ($story->author != Auth::id()) {
            return redirect('/');
        }

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

        foreach ($story->slides()->get() as $slide) {
            foreach ($slide->choices()->get() as $choice) {
                foreach ($choice->outcomes()->get() as $outcome) {
                    $result = new OutcomeResult;
                    $result->outcome_id = $outcome->id;
                    $result->meter_id = $meter->id;
                    $result->change = 0;
                    $result->save();
                }
            }
        }

        return redirect('/story/' . $story->id . '/edit#tab_meters');
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

        if ($meter->story->author != Auth::id()) {
            return redirect('/');
        }

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

        if ($meter->story->author != Auth::id()) {
            return redirect('/');
        }

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
        $meter = Meter::findOrFail($id);

        if ($meter->story->author != Auth::id()) {
            return redirect('/');
        }

        $affectedRows = Meter::destroy($id);

        if ($affectedRows > 0) {
            \Flash::info('The meter has been deleted permanently.');
        } else {
            \Flash::error('The meter could not be deleted.');
        }

        return $affectedRows;
    }
}
