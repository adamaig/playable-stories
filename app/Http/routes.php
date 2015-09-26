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

// Introductions
Route::get('/story/{id}/introduction', 'IntroductionController@create');
Route::get('/story/{id}/introduction/edit', 'IntroductionController@edit');
Route::post('/story/{id}/introduction', 'IntroductionController@update');

// Slides
Route::get('/story/{id}/slide', 'SlideController@create');
Route::get('/slide/{id}/edit', 'SlideController@edit');
Route::post('/slide/{id}', 'SlideController@update');
Route::delete('/slide/{id}', 'SlideController@destroy');
Route::get('/slide/{id}/duplicate', 'SlideController@duplicate');
Route::get('/slide/{id}/shift/{direction}', 'SlideController@shift');

// Choices
Route::post('/slide/{id}/choice', 'ChoiceController@create');
Route::delete('/choice/{id}', 'ChoiceController@destroy');

// Meters
Route::get('/slide/{id}/meter', 'MeterController@create');

// Route::resource('outcome', 'OutcomeController');
// Route::resource('outcomeresults', 'OutcomeResultsController');
