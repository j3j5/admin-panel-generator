<?php

Route::get('/admin/{modelName}', 'VivifyIdeas\AdminPanelGenerator\Http\Controllers\MainController@index');
Route::get('/admin/{modelName}/create', 'VivifyIdeas\AdminPanelGenerator\Http\Controllers\MainController@create');
Route::get('/admin/{modelName}/edit/{id}', 'VivifyIdeas\AdminPanelGenerator\Http\Controllers\MainController@edit');
Route::put('/admin/{modelName}/{id}', 'VivifyIdeas\AdminPanelGenerator\Http\Controllers\MainController@update');
Route::post('/admin/{modelName}', 'VivifyIdeas\AdminPanelGenerator\Http\Controllers\MainController@store');
Route::get('/admin/{modelName}/delete/{id}', 'VivifyIdeas\AdminPanelGenerator\Http\Controllers\MainController@delete');
