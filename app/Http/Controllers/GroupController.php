<?php

namespace PlayableStories\Http\Controllers;

use Illuminate\Http\Request;

use PlayableStories\Http\Requests;
use PlayableStories\Http\Controllers\Controller;
use PlayableStories\Group;
use PlayableStories\Story;
use Auth;
use Flash;
use File;
use Config;

class GroupController extends Controller
{
    /**
     * Instantiate a new GroupController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stories = Auth::user()->stories;

        return view('group.create')->withStories($stories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'stories' => 'required|array',
        ]);

        foreach ($request->input('stories') as $id) {
            $story = Story::findOrFail($id);

            // Make sure they aren't trying to add someone else's story to their group
            if ($story->author !== Auth::id()) {
                Flash::error('You don\'t own one or more of these stories.');
                return redirect('/');
            }
        }

        $group = new Group;
        $group->name = $request->input('name');
        $group->user_id = Auth::id();

        $group->message = $request->input('message');
        $group->text_alignment = $request->input('text-alignment');
        $group->background_color = $request->input('background-color');
        $group->photo_type = $request->input('photo-type');
        $group->background_placement = $request->input('background-placement');

        $group->save();

        // Save photo
        if ($request->file('photo')) {
            $photoName = $group->id . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(base_path() . '/public/img/group-photos/', $photoName);
            $group->photo = $photoName;
        }

        $group->save();

        $group->stories()->sync(array());

        foreach ($request->input('stories') as $key => $id) {
            $group->stories()->attach(array($request->input('stories')[$key] => array('button_name' => $request->input('button-name')[$key])));
        }

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::findOrFail($id);
        $story = $group->stories->first();
        $paths = $group->stories;

        $googleFontList = Config::get('fonts');

        return view('group.show')->withGroup($group)->withFonts($googleFontList)->withStory($story)->withPaths($paths);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::findOrFail($id);
        $stories = Auth::user()->stories;
        $selectedStories = $group->stories()->lists('button_name', 'id')->toArray();

        if ($group->user_id != Auth::id()) {
            return redirect('/');
        }

        return view('group.edit')->withGroup($group)->withStories($stories)->with('selectedStories', $selectedStories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'name' => 'required|max:255',
            'stories' => 'required|array',
            'text-alignment' => 'required|in:left,right,center',
            'message' => 'required',
            'background-color' => 'required|hex',
            'photo' => 'image',
            'photo-type' => 'required|in:above,below,background',
            'background-placement' => 'required|in:left_top,center_top,tile,fill',
        );

        $this->validate($request, $rules);

        $group = Group::findOrFail($id);

        foreach ($request->input('stories') as $id) {
            $story = Story::findOrFail($id);

            // Make sure they aren't trying to add someone else's story to their group
            if ($story->author !== Auth::id()) {
                Flash::error('You don\'t own one or more of these stories.');
                return redirect('/');
            }
        }

        $group->name = $request->input('name');
        $group->message = $request->input('message');
        $group->text_alignment = $request->input('text-alignment');
        $group->background_color = $request->input('background-color');
        $group->photo_type = $request->input('photo-type');
        $group->background_placement = $request->input('background-placement');

        // Save photo
        if ($request->file('photo')) {
            $photoName = $group->id . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(base_path() . '/public/img/group-photos/', $photoName);
            $group->photo = $photoName;
        }

        $group->save();

        $group->stories()->sync(array());

        foreach ($request->input('stories') as $key => $id) {
            $group->stories()->attach(array($request->input('stories')[$key] => array('button_name' => $request->input('button-name')[$key])));
        }

        Flash::success('Your changes have been saved');

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);

        if ($group->user_id != Auth::id()) {
            return redirect('/');
        }

        $group->stories()->sync(array());

        $affectedRows = Group::where('id', '=', $id)->delete();

        if ($affectedRows > 0) {
            \Flash::info('The group has been deleted permanently.');
        } else {
            \Flash::error('The group could not be deleted.');
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
        $group = Group::findOrFail($id);

        if ($group->user_id != Auth::id()) {
            return redirect('/');
        }

        File::delete('img/group-photos/' . $group->photo);

        $group->photo = null;
        $group->save();

        return redirect('group/'.$group->id.'/edit');
    }
}
