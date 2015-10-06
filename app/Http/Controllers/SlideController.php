<?php

namespace PlayableStories\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use PlayableStories\Http\Requests;
use PlayableStories\Http\Controllers\Controller;

use PlayableStories\Story;
use PlayableStories\Slide;
use PlayableStories\Choice;
use PlayableStories\Outcome;
use PlayableStories\OutcomeResult;

class SlideController extends Controller
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
        $currentSlideCount = count(Slide::where('story_id', '=', $id)->get());

        $slide = new Slide;
        $slide->story_id = $id;
        $slide->order = $currentSlideCount + 1;
        $slide->save();

        return redirect('/slide/' . $slide->id . '/edit');
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
    public function show($id, $order)
    {
        $story = Story::findOrFail($id);
        $slide = Slide::where('story_id', $story->id)->where('order', $order)->first();

        $googleFontList = array(
            "Aclonica" => "Aclonica",
            "Allan" => "Allan",
            "Annie+Use+Your+Telescope" => "Annie Use Your Telescope",
            "Anonymous+Pro" => "Anonymous Pro",
            "Allerta+Stencil" => "Allerta Stencil",
            "Allerta" => "Allerta",
            "Amaranth" => "Amaranth",
            "Anton" => "Anton",
            "Architects+Daughter" => "Architects Daughter",
            "Arimo" => "Arimo",
            "Artifika" => "Artifika",
            "Arvo" => "Arvo",
            "Asset" => "Asset",
            "Astloch" => "Astloch",
            "Bangers" => "Bangers",
            "Bentham" => "Bentham",
            "Bevan" => "Bevan",
            "Bigshot+One" => "Bigshot One",
            "Bowlby+One" => "Bowlby One",
            "Bowlby+One+SC" => "Bowlby One SC",
            "Brawler" => "Brawler ",
            "Buda:300" => "Buda",
            "Cabin" => "Cabin",
            "Calligraffitti" => "Calligraffitti",
            "Candal" => "Candal",
            "Cantarell" => "Cantarell",
            "Cardo" => "Cardo",
            "Carter One" => "Carter One",
            "Caudex" => "Caudex",
            "Cedarville+Cursive" => "Cedarville Cursive",
            "Cherry+Cream+Soda" => "Cherry Cream Soda",
            "Chewy" => "Chewy",
            "Coda" => "Coda",
            "Coming+Soon" => "Coming Soon",
            "Copse" => "Copse",
            "Corben:700" => "Corben",
            "Cousine" => "Cousine",
            "Covered+By+Your+Grace" => "Covered By Your Grace",
            "Crafty+Girls" => "Crafty Girls",
            "Crimson+Text" => "Crimson Text",
            "Crushed" => "Crushed",
            "Cuprum" => "Cuprum",
            "Damion" => "Damion",
            "Dancing+Script" => "Dancing Script",
            "Dawning+of+a+New+Day" => "Dawning of a New Day",
            "Didact+Gothic" => "Didact Gothic",
            "Droid+Sans" => "Droid Sans",
            "Droid+Sans+Mono" => "Droid Sans Mono",
            "Droid+Serif" => "Droid Serif",
            "EB+Garamond" => "EB Garamond",
            "Expletus+Sans" => "Expletus Sans",
            "Fontdiner+Swanky" => "Fontdiner Swanky",
            "Forum" => "Forum",
            "Francois+One" => "Francois One",
            "Geo" => "Geo",
            "Give+You+Glory" => "Give You Glory",
            "Goblin+One" => "Goblin One",
            "Goudy+Bookletter+1911" => "Goudy Bookletter 1911",
            "Gravitas+One" => "Gravitas One",
            "Gruppo" => "Gruppo",
            "Hammersmith+One" => "Hammersmith One",
            "Holtwood+One+SC" => "Holtwood One SC",
            "Homemade+Apple" => "Homemade Apple",
            "Inconsolata" => "Inconsolata",
            "Indie+Flower" => "Indie Flower",
            "IM+Fell+DW+Pica" => "IM Fell DW Pica",
            "IM+Fell+DW+Pica+SC" => "IM Fell DW Pica SC",
            "IM+Fell+Double+Pica" => "IM Fell Double Pica",
            "IM+Fell+Double+Pica+SC" => "IM Fell Double Pica SC",
            "IM+Fell+English" => "IM Fell English",
            "IM+Fell+English+SC" => "IM Fell English SC",
            "IM+Fell+French+Canon" => "IM Fell French Canon",
            "IM+Fell+French+Canon+SC" => "IM Fell French Canon SC",
            "IM+Fell+Great+Primer" => "IM Fell Great Primer",
            "IM+Fell+Great+Primer+SC" => "IM Fell Great Primer SC",
            "Irish+Grover" => "Irish Grover",
            "Irish+Growler" => "Irish Growler",
            "Istok+Web" => "Istok Web",
            "Josefin+Sans" => "Josefin Sans Regular 400",
            "Josefin+Slab" => "Josefin Slab Regular 400",
            "Judson" => "Judson",
            "Jura" => " Jura Regular",
            "Jura:500" => " Jura 500",
            "Jura:600" => " Jura 600",
            "Just+Another+Hand" => "Just Another Hand",
            "Just+Me+Again+Down+Here" => "Just Me Again Down Here",
            "Kameron" => "Kameron",
            "Kenia" => "Kenia",
            "Kranky" => "Kranky",
            "Kreon" => "Kreon",
            "Kristi" => "Kristi",
            "La+Belle+Aurore" => "La Belle Aurore",
            "Lato:100" => "Lato 100",
            "Lato:100italic" => "Lato 100 (plus italic)",
            "Lato:300" => "Lato Light 300",
            "Lato" => "Lato",
            "Lato:bold" => "Lato Bold 700",
            "Lato:900" => "Lato 900",
            "League+Script" => "League Script",
            "Lekton" => " Lekton ",
            "Limelight" => " Limelight ",
            "Lobster" => "Lobster",
            "Lobster Two" => "Lobster Two",
            "Lora" => "Lora",
            "Love+Ya+Like+A+Sister" => "Love Ya Like A Sister",
            "Loved+by+the+King" => "Loved by the King",
            "Luckiest+Guy" => "Luckiest Guy",
            "Maiden+Orange" => "Maiden Orange",
            "Mako" => "Mako",
            "Maven+Pro" => " Maven Pro",
            "Maven+Pro:500" => " Maven Pro 500",
            "Maven+Pro:700" => " Maven Pro 700",
            "Maven+Pro:900" => " Maven Pro 900",
            "Meddon" => "Meddon",
            "MedievalSharp" => "MedievalSharp",
            "Megrim" => "Megrim",
            "Merriweather" => "Merriweather",
            "Metrophobic" => "Metrophobic",
            "Michroma" => "Michroma",
            "Miltonian Tattoo" => "Miltonian Tattoo",
            "Miltonian" => "Miltonian",
            "Modern Antiqua" => "Modern Antiqua",
            "Monofett" => "Monofett",
            "Molengo" => "Molengo",
            "Mountains of Christmas" => "Mountains of Christmas",
            "Muli:300" => "Muli Light",
            "Muli" => "Muli Regular",
            "Neucha" => "Neucha",
            "Neuton" => "Neuton",
            "News+Cycle" => "News Cycle",
            "Nixie+One" => "Nixie One",
            "Nobile" => "Nobile",
            "Nova+Cut" => "Nova Cut",
            "Nova+Flat" => "Nova Flat",
            "Nova+Mono" => "Nova Mono",
            "Nova+Oval" => "Nova Oval",
            "Nova+Round" => "Nova Round",
            "Nova+Script" => "Nova Script",
            "Nova+Slim" => "Nova Slim",
            "Nova+Square" => "Nova Square",
            "Nunito:light" => " Nunito Light",
            "Nunito" => " Nunito Regular",
            "OFL+Sorts+Mill+Goudy+TT" => "OFL Sorts Mill Goudy TT",
            "Old+Standard+TT" => "Old Standard TT",
            "Open+Sans:300" => "Open Sans light",
            "Open+Sans" => "Open Sans regular",
            "Open+Sans:600" => "Open Sans 600",
            "Open+Sans:800" => "Open Sans bold",
            "Open+Sans+Condensed:300" => "Open Sans Condensed",
            "Orbitron" => "Orbitron Regular (400)",
            "Orbitron:500" => "Orbitron 500",
            "Orbitron:700" => "Orbitron Regular (700)",
            "Orbitron:900" => "Orbitron 900",
            "Oswald" => "Oswald",
            "Over+the+Rainbow" => "Over the Rainbow",
            "Reenie+Beanie" => "Reenie Beanie",
            "Pacifico" => "Pacifico",
            "Patrick+Hand" => "Patrick Hand",
            "Paytone+One" => "Paytone One",
            "Permanent+Marker" => "Permanent Marker",
            "Philosopher" => "Philosopher",
            "Play" => "Play",
            "Playfair+Display" => " Playfair Display ",
            "Podkova" => " Podkova ",
            "PT+Sans" => "PT Sans",
            "PT+Sans+Narrow" => "PT Sans Narrow",
            "PT+Sans+Narrow:regular,bold" => "PT Sans Narrow (plus bold)",
            "PT+Serif" => "PT Serif",
            "PT+Serif Caption" => "PT Serif Caption",
            "Puritan" => "Puritan",
            "Quattrocento" => "Quattrocento",
            "Quattrocento+Sans" => "Quattrocento Sans",
            "Radley" => "Radley",
            "Raleway:100" => "Raleway",
            "Redressed" => "Redressed",
            "Rock+Salt" => "Rock Salt",
            "Rokkitt" => "Rokkitt",
            "Ruslan+Display" => "Ruslan Display",
            "Schoolbell" => "Schoolbell",
            "Shadows+Into+Light" => "Shadows Into Light",
            "Shanti" => "Shanti",
            "Sigmar+One" => "Sigmar One",
            "Six+Caps" => "Six Caps",
            "Slackey" => "Slackey",
            "Smythe" => "Smythe",
            "Sniglet:800" => "Sniglet",
            "Special+Elite" => "Special Elite",
            "Stardos+Stencil" => "Stardos Stencil",
            "Sue+Ellen+Francisco" => "Sue Ellen Francisco",
            "Sunshiney" => "Sunshiney",
            "Swanky+and+Moo+Moo" => "Swanky and Moo Moo",
            "Syncopate" => "Syncopate",
            "Tangerine" => "Tangerine",
            "Tenor+Sans" => " Tenor Sans ",
            "Terminal+Dosis+Light" => "Terminal Dosis Light",
            "The+Girl+Next+Door" => "The Girl Next Door",
            "Tinos" => "Tinos",
            "Ubuntu" => "Ubuntu",
            "Ultra" => "Ultra",
            "Unkempt" => "Unkempt",
            "UnifrakturCook:bold" => "UnifrakturCook",
            "UnifrakturMaguntia" => "UnifrakturMaguntia",
            "Varela" => "Varela",
            "Varela Round" => "Varela Round",
            "Vibur" => "Vibur",
            "Vollkorn" => "Vollkorn",
            "VT323" => "VT323",
            "Waiting+for+the+Sunrise" => "Waiting for the Sunrise",
            "Wallpoet" => "Wallpoet",
            "Walter+Turncoat" => "Walter Turncoat",
            "Wire+One" => "Wire One",
            "Yanone+Kaffeesatz" => "Yanone Kaffeesatz",
            "Yanone+Kaffeesatz:300" => "Yanone Kaffeesatz:300",
            "Yanone+Kaffeesatz:400" => "Yanone Kaffeesatz:400",
            "Yanone+Kaffeesatz:700" => "Yanone Kaffeesatz:700",
            "Yeseva+One" => "Yeseva One",
            "Zeyada" => "Zeyada",
        );

        return view('slide.show')->withStory($story)->withSlide($slide)->withFonts($googleFontList);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $slide = Slide::findOrFail($id);
        $meters = $slide->story->meters()->get();
        $meters = $meters->toArray();
        return view('slide.edit')->withSlide($slide)->withMeters($meters);
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
            'name' => 'required',
            'image' => 'image',
            'content' => 'required',
            'text-placement' => 'required|in:overlay,under',
            'text-alignment' => 'required|in:left,right,center,justify',
        );

        $this->validate($request, $rules);

        $slide = Slide::findOrFail($id);
        $slide->name = $request->input('name');
        $slide->content = $request->input('content');
        $slide->text_placement = $request->input('text-placement');
        $slide->text_alignment = $request->input('text-alignment');

        // Save photo
        if ($request->file('image')) {
            $imageName = $slide->id . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(base_path() . '/public/img/slide-photos/', $imageName);
            $slide->image = $imageName;
        }

        $slide->save();

        \Flash::success('Your slide has been updated!');

        return redirect('/slide/' . $slide->id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $slide = Slide::find($id);

        $affectedRows = Slide::destroy($id);

        foreach (Slide::where('story_id', '=', $slide->story->id)->where('order', '>', $slide->order)->get() as $slide) {
            $slide->order = ($slide->order - 1);
            $slide->save();
        }

        if ($affectedRows > 0) {
            \Flash::info('The slide has been deleted permanently.');
        } else {
            \Flash::error('The slide could not be deleted.');
        }

        return $affectedRows;
    }

    /**
     * Duplicate the specified slide within the story.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id)
    {
        $slide = Slide::find($id);

        $currentSlideCount = count(Slide::where('story_id', '=', $slide->story->id)->get());

        $newSlide = new Slide;
        $newSlide->story_id = $slide->story_id;
        $newSlide->order = $currentSlideCount + 1;
        $newSlide->name = $slide->name;
        $newSlide->image = $slide->image;
        $newSlide->content = $slide->content;
        $newSlide->text_placement = $slide->text_placement;
        $newSlide->text_alignment = $slide->text_alignment;
        $newSlide->save();

        \Flash::success('The slide has been duplicated and added to the end of your story.');

        return redirect('/story/' . $slide->story->id . '/edit');
    }

    /**
     * Shift the order of the specified slide up or down.
     *
     * @param  int  $id
     * @return Response
     */
    public function shift($id, $direction)
    {
        $slide = Slide::findOrFail($id);

        $originalSlideOrder = $slide->order;

        if ($direction == 'down') {
            $slide->order = ($slide->order - 1);
        } elseif ($direction == 'up') {
            $slide->order = ($slide->order + 1);
        }
        $slide->save();

        $adjacentSlide = Slide::where('order', '=', $slide->order)->where('id', '<>', $id)->first();
        $adjacentSlide->order = ($originalSlideOrder);
        $adjacentSlide->save();

        return redirect('/story/' . $slide->story->id . '/edit');
    }

    /**
     * Process the user's choice and advance them to the next slide.
     *
     * @param  int  $id
     * @return Response
     */
    public function choose($id, $order, $choiceId)
    {
        $story = Story::findOrFail($id);
        $choice = Choice::findOrFail($choiceId);
        $slide = Slide::where('story_id', $story->id)->where('order', $order)->first();
        $vignette = null;

        if ($choice->meter_effect == 'none') {
            if (count($story->slides()->get()) == $order) {
                return view('slide.end')->withText($story->success_content)->withHeading($story->success_heading)->withSlide($slide)->withStory($story);
            }

            $outcome = Outcome::where('choice_id', $choice->id)->first();
            $vignette = $outcome->vignette;

            return redirect('/story/' . $story->id . '/' . ($order+1))->with('vignette', $vignette);;
        } elseif ($choice->meter_effect == 'specific') {
            $outcome = Outcome::where('choice_id', $choiceId)->first();
            $vignette = $outcome->vignette;

            foreach ($outcome->results()->get() as $key => $result) {
                $newMeterValue = (Session::get('story-'.$story->id.'-meter-'.($key+1).'-value') + $result->change);
                Session::put('story-'.$story->id.'-meter-'.($key+1).'-value', $newMeterValue);
            }

            foreach ($story->meters()->get() as $key => $meter) {
                if (Session::get('story-'.$story->id.'-meter-'.($key+1).'-value') <= $meter->min_value && $meter->min_value !== null) {
                    return view('slide.end')->withText($meter->min_value_text)->withHeading($meter->min_value_header)->withSlide($slide)->withStory($story);
                }

                if (Session::get('story-'.$story->id.'-meter-'.($key+1).'-value') >= $meter->max_value && $meter->max_value !== null) {
                    return view('slide.end')->withText($meter->max_value_text)->withHeading($meter->max_value_header)->withSlide($slide)->withStory($story);
                }
            }

            if (count($story->slides()->get()) == $order) {
                return view('slide.end')->withText($story->success_content)->withHeading($story->success_heading)->withSlide($slide)->withStory($story);
            }

            return redirect('/story/' . $story->id . '/' . ($order+1))->with('vignette', $vignette);;
        } elseif ($choice->meter_effect == 'chance') {
            $outcome = Outcome::where('choice_id', $choiceId)->first();
            $vignette = $outcome->vignette;

            if ($outcome->likelihood <= rand(1,100)) {
                foreach ($outcome->results()->get() as $key => $result) {
                    $newMeterValue = (Session::get('story-'.$story->id.'-meter-'.($key+1).'-value') + $result->change);
                    Session::put('story-'.$story->id.'-meter-'.($key+1).'-value', $newMeterValue);
                }
            } else {
                $outcome = Outcome::where('choice_id', $choiceId)->orderBy('id', 'desc')->first();
                $vignette = $outcome->vignette;

                foreach ($outcome->results()->get() as $key => $result) {
                    $newMeterValue = (Session::get('story-'.$story->id.'-meter-'.($key+1).'-value') + $result->change);
                    Session::put('story-'.$story->id.'-meter-'.($key+1).'-value', $newMeterValue);
                }
            }

            foreach ($story->meters()->get() as $key => $meter) {
                if (Session::get('story-'.$story->id.'-meter-'.($key+1).'-value') <= $meter->min_value && $meter->min_value !== null) {
                    return view('slide.end')->withText($meter->min_value_text)->withHeading($meter->min_value_header)->withSlide($slide)->withStory($story);
                }

                if (Session::get('story-'.$story->id.'-meter-'.($key+1).'-value') >= $meter->max_value && $meter->max_value !== null) {
                    return view('slide.end')->withText($meter->max_value_text)->withHeading($meter->max_value_header)->withSlide($slide)->withStory($story);
                }
            }

            if (count($story->slides()->get()) == $order) {
                return view('slide.end')->withText($story->success_content)->withHeading($story->success_heading)->withSlide($slide)->withStory($story);
            }

            return redirect('/story/' . $story->id . '/' . ($order+1))->with('vignette', $vignette);;
        }
    }
}
