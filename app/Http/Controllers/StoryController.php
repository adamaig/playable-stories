<?php

namespace PlayableStories\Http\Controllers;

use Illuminate\Http\Request;
use Session;

use PlayableStories\Http\Requests;
use PlayableStories\Http\Controllers\Controller;

use PlayableStories\Story;
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

            Session::put('story-'.$story->id.'-meter-'.($key+1).'-value', $meter->start_value);
            Session::put('story-'.$story->id.'-meter-'.($key+1).'-name', $meter->name);
        }

        if (count($story->introductions()->get()) == 0) {
            $firstSlide = Slide::where('story_id', $story->id)->orderBy('order', 'ASC')->first();
            return redirect('/slide/'.$firstSlide->id);
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

        // Meters tab
        foreach ($request->get('meter-name') as $key => $val) {
            $rules['meter-name.'.$key] = 'required';
            $rules['meter-type.'.$key] = 'required|in:currency,percentage,number';
            $rules['meter-start-value.'.$key] = 'required|numeric';
            $rules['meter-no-min.'.$key] = 'in:true';
            $rules['meter-min-value.'.$key] = 'required_without:meter-no-min.'.$key.'|numeric';
            $rules['meter-no-max.'.$key] = 'in:true';
            $rules['meter-max-value.'.$key] = 'required_without:meter-no-max.'.$key.'|numeric';
            // $rules['meter-min-value-header.'.$key] = 'required_without:meter-no-min.'.$key;
            // $rules['meter-min-value-text.'.$key] = 'required_without:meter-no-min.'.$key;
            // $rules['meter-max-value-header.'.$key] = 'required_without:meter-no-max.'.$key;
            // $rules['meter-max-value-text.'.$key] = 'required_without:meter-no-max.'.$key;

            $messages['meter-name.'.$key.'.required'] = 'Your meter (' . ($key+1) . ') must have a name.';
            $messages['meter-start-value.'.$key.'.required'] = 'Your meter (' . ($key+1) . ') must have a start value.';
            $messages['meter-min-value.'.$key.'.required_without'] = 'Your meter (' . ($key+1) . ') must have a minimum value.';
            $messages['meter-max-value.'.$key.'.required_without'] = 'Your meter (' . ($key+1) . ') must have a maximum value.';
            $messages['meter-min-value-header.'.$key.'.required_without'] = 'Your meter (' . ($key+1) . ') must have a "Min. Value Header" if a minimum value is present.';
            $messages['meter-min-value-text.'.$key.'.required_without'] = 'Your meter (' . ($key+1) . ') must have a "Min. Value Text" message if a minimum value is present.';
            $messages['meter-max-value-header.'.$key.'.required_without'] = 'Your meter (' . ($key+1) . ') must have a "Max Value Header" if a maximum value is present.';
            $messages['meter-max-value-text.'.$key.'.required_without'] = 'Your meter (' . ($key+1) . ') must have a "Max Value Text" message if a maximum value is present.';
        }

        $this->validate($request, $rules, $messages);

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

        // Loop through each meter and save them after deleting any old meters.
        Meter::where('story_id', '=', $story->id)->delete();

        foreach ($request->get('meter-name') as $key => $val) {
            $meter = new Meter;

            $meter->story_id = $story->id;
            $meter->order = $key+1;
            $meter->name = $request->input('meter-name.'.$key);
            $meter->type = $request->input('meter-type.'.$key);
            $meter->start_value = $request->input('meter-start-value.'.$key);
            if ($request->input('meter-no-min.'.$key) != 'true') {
                $meter->min_value = $request->input('meter-min-value.'.$key); 
            } else {
                $meter->min_value = null; 
            }
            $meter->min_value_header = $request->input('meter-min-value-header.'.$key);
            $meter->min_value_text = $request->input('meter-min-value-text.'.$key);
            if ($request->input('meter-no-max.'.$key) != 'true') {
                $meter->max_value = $request->input('meter-max-value.'.$key);
            } else {
                $meter->max_value = null; 
            }
            $meter->max_value_header = $request->input('meter-max-value-header.'.$key);
            $meter->max_value_text = $request->input('meter-max-value-text.'.$key);

            $meter->save();
        }

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
