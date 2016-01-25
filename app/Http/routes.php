<?php

Route::get('/', 'StoryController@index');
Route::get('/home', function()
{
    return Redirect::to('/');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Stories
Route::resource('story', 'StoryController');
Route::get('/story/{id}/{order}', 'SlideController@show')->where('order', '[0-9]+');
Route::get('/story/{id}/{order}/choice/{choiceId}', 'SlideController@choose')->where('order', '[0-9]+');
Route::get('/story/{id}/end', 'SlideController@end');

// Introductions
Route::get('/story/{id}/introduction', 'IntroductionController@create');
Route::get('introduction/{id}', 'IntroductionController@show');
Route::get('/story/{id}/introduction/edit', 'IntroductionController@edit');
Route::post('/story/{id}/introduction', 'IntroductionController@update');
Route::delete('/introduction/{id}', 'IntroductionController@destroy');
Route::get('/introduction/{id}/remove/photo', 'IntroductionController@removePhoto');

// Slides
Route::get('/story/{id}/slide', 'SlideController@create');
Route::get('/slide/{id}/edit', 'SlideController@edit');
Route::post('/slide/{id}', 'SlideController@update');
Route::delete('/slide/{id}', 'SlideController@destroy');
Route::get('/slide/{id}/duplicate', 'SlideController@duplicate');
Route::get('/slide/{id}/shift/{direction}', 'SlideController@shift');
Route::get('/slide/{id}/remove/image', 'SlideController@removeImage');

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

// Groups
Route::post('/group/update/{id}', 'GroupController@update');
Route::get('/group/{id}/remove/photo', 'GroupController@removePhoto');
Route::get('/group/create', 'GroupController@create');
Route::get('/group/{id}/edit', 'GroupController@edit');
Route::get('/group/{id}', 'GroupController@show');
Route::post('/group/create', 'GroupController@store');
Route::delete('/group/{id}', 'GroupController@destroy');
