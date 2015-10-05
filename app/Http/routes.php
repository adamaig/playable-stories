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
Route::get('/story/{id}/{order}', 'SlideController@show')->where('order', '[0-9]+');
Route::get('/story/{id}/{order}/choice/{choiceId}', 'SlideController@choose')->where('order', '[0-9]+');

// Introductions
Route::get('/story/{id}/introduction', 'IntroductionController@create');
Route::get('introduction/{id}', 'IntroductionController@show');
Route::get('/story/{id}/introduction/edit', 'IntroductionController@edit');
Route::post('/story/{id}/introduction', 'IntroductionController@update');
Route::delete('/introduction/{id}', 'IntroductionController@destroy');

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
Route::get('/choice/{id}/edit', 'ChoiceController@edit');
Route::post('/choice/{id}/edit', 'ChoiceController@update');

// Meters
Route::get('/slide/{id}/meter', 'MeterController@create');
Route::get('/meter/{id}/edit', 'MeterController@edit');
Route::post('/meter/{id}', 'MeterController@update');
Route::delete('/meter/{id}', 'MeterController@destroy');
