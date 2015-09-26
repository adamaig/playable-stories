<?php

namespace PlayableStories\Http\Controllers;

use Illuminate\Http\Request;

use PlayableStories\Http\Requests;
use PlayableStories\Http\Controllers\Controller;

use PlayableStories\Choice;
use PlayableStories\Slide;
use PlayableStories\Outcome;
use PlayableStories\OutcomeResult;

class ChoiceController extends Controller
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
    public function create($id, Request $request)
    {
        $slide = Slide::findOrFail($id);

        $currentChoices = $slide->choices()->get();

        if (count($currentChoices) > 3) {
            \Flash::error('You already have the maximum number of choices for this slide.');
            return redirect('/slide/' . $id . '/edit');
        }

        if ($request->input('choice-type') == 'chance') {
            $choice = new Choice;
            $choice->slide_id = $slide->id;
            $choice->order = count($currentChoices) + 1;
            $choice->meter_effect = 'chance';
            $choice->save();

            $outcome1 = new Outcome;
            $outcome1->choice_id = $choice->id;
            $outcome1->likelihood = '70';
            $outcome1->save();

            foreach ($slide->story->meters()->get() as $meter) {
                $result = new OutcomeResult;
                $result->outcome_id = $outcome1->id;
                $result->meter_id = $meter->id;
                $result->change = rand(1, 100);
                $result->save();
            }

            $outcome2 = new Outcome;
            $outcome2->choice_id = $choice->id;
            $outcome2->likelihood = '30';
            $outcome2->save();

            foreach ($slide->story->meters()->get() as $meter) {
                $result = new OutcomeResult;
                $result->outcome_id = $outcome2->id;
                $result->meter_id = $meter->id;
                $result->change = rand(1, 100);
                $result->save();
            }
        } elseif ($request->input('choice-type') == 'specific') {
            $choice = new Choice;
            $choice->slide_id = $slide->id;
            $choice->order = count($currentChoices) + 1;
            $choice->meter_effect = 'specific';
            $choice->save();

            $outcome = new Outcome;
            $outcome->choice_id = $choice->id;
            $outcome->likelihood = '100';
            $outcome->save();

            foreach ($slide->story->meters()->get() as $meter) {
                $result = new OutcomeResult;
                $result->outcome_id = $outcome->id;
                $result->meter_id = $meter->id;
                $result->change = rand(1, 100);
                $result->save();
            }
        } elseif ($request->input('choice-type') == 'none') {
            $choice = new Choice;
            $choice->slide_id = $slide->id;
            $choice->order = count($currentChoices) + 1;
            $choice->meter_effect = 'none';
            $choice->save();

            $outcome = new Outcome;
            $outcome->choice_id = $choice->id;
            $outcome->likelihood = '100';
            $outcome->save();
        }

        return redirect('/slide/' . $id . '/edit');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $affectedRows  = Choice::where('id', '=', $id)->delete();
        if ($affectedRows > 0) {
            \Flash::info('The choice has been deleted permanently.');
        } else {
            \Flash::error('The choice could not be deleted.');
        }
        return $affectedRows;
    }
}
