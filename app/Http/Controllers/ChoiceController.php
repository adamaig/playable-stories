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

        return redirect('/choice/' . $choice->id . '/edit');
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
        $choice = Choice::findOrFail($id);
        $meters = $choice->slide->story->meters()->get();

        return view('choice.edit')->withChoice($choice)->withMeters($meters);
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
        $choice = Choice::findOrFail($id);

        $choice->text = $request->input('choice-text');
        $choice->save();

        if ($choice->meter_effect == 'chance') {
            foreach ($choice->outcomes()->get() as $key => $outcome) {
                $outcome->likelihood = $request->input('likelihood-'.($key+1));
                $outcome->vignette = $request->input('vignette-'.($key+1));
                $outcome->save();

                foreach ($outcome->results()->get() as $resultKey => $result) {
                    $result->change = $request->input('meter-'.($resultKey+1).'-outcome-'.($key+1));
                    $result->save();
                }
            }
        } elseif ($choice->meter_effect == 'specific') {
            foreach ($choice->outcomes()->get() as $key => $outcome) {
                $outcome->likelihood = 100;
                $outcome->vignette = $request->input('vignette');
                $outcome->save();

                foreach ($outcome->results()->get() as $resultKey => $result) {
                    $result->change = $request->input('meter-'.($resultKey+1).'-outcome-'.($key+1));
                    $result->save();
                }
            }
        } elseif ($choice->meter_effect == 'none') {
            foreach ($choice->outcomes()->get() as $key => $outcome) {
                $outcome->likelihood = 100;
                $outcome->vignette = $request->input('vignette');
                $outcome->save();
            }
        }

        \Flash::success('Your choice has been updated!');

        return redirect('/slide/' . $choice->slide_id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $choice = Choice::findOrFail($id);

        $affectedRows  = Choice::where('id', '=', $id)->delete();

        if ($affectedRows > 0) {
            foreach (Choice::where('slide_id', $choice->slide_id)->orderBy('order', 'ASC')->get() as $key => $choice) {
                $choice->order = $key+1;
                $choice->save();
            }
            \Flash::info('The choice has been deleted permanently.');
        } else {
            \Flash::error('The choice could not be deleted.');
        }
        return $affectedRows;
    }
}
