<?php

Route::get('/', 'StoryController@index');

// Stories
Route::resource('story', 'StoryController');

// Introduction Slides
Route::get('/story/{id}/introduction', 'IntroductionController@create');
Route::get('/story/{id}/introduction/edit', 'IntroductionController@edit');
Route::post('/story/{id}/introduction', 'IntroductionController@update');

// Route::resource('meter', 'MeterController');
// Route::resource('slide', 'SlideController');
// Route::resource('choice', 'ChoiceController');
// Route::resource('outcome', 'OutcomeController');
// Route::resource('outcomeresults', 'OutcomeResultsController');
