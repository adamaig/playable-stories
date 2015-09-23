<?php

// Template designs
Route::get('/intro', function() {
    return view('templates/intro');
});

Route::get('/outro', function() {
    return view('templates/outro');
});

Route::get('/slide', function() {
    return view('templates/slide');
});

Route::get('/vignette', function() {
    return view('templates/vignette');
});

Route::get('/', 'StoryController@index');

// Stories
Route::resource('story', 'StoryController');

// Introduction Slides
Route::get('/story/{id}/introduction', 'IntroductionController@create');
Route::get('/story/{id}/introduction/edit', 'IntroductionController@edit');
Route::post('/story/{id}/introduction', 'IntroductionController@update');

// Story Slides
Route::get('/story/{id}/slide', 'SlideController@create');
Route::get('/slide/{id}/edit', 'SlideController@edit');
Route::post('/slide/{id}', 'SlideController@update');
Route::delete('/slide/{id}', 'SlideController@destroy');
Route::get('/slide/{id}/duplicate', 'SlideController@duplicate');
Route::get('/slide/{id}/shift/{direction}', 'SlideController@shift');

// Route::resource('meter', 'MeterController');
// Route::resource('choice', 'ChoiceController');
// Route::resource('outcome', 'OutcomeController');
// Route::resource('outcomeresults', 'OutcomeResultsController');
