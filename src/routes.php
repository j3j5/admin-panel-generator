<?php

$prefix = packageConfig('prefix');

Route::get($prefix . '/{modelName}', 'VivifyIdeas\AdminPanelGenerator\Http\Controllers\MainController@index');
Route::get($prefix . '/{modelName}/create', 'VivifyIdeas\AdminPanelGenerator\Http\Controllers\MainController@create');
Route::get($prefix . '/admin/{modelName}/edit/{id}', 'VivifyIdeas\AdminPanelGenerator\Http\Controllers\MainController@edit');
Route::put($prefix . '/{modelName}/{id}', 'VivifyIdeas\AdminPanelGenerator\Http\Controllers\MainController@update');
Route::post($prefix . '/{modelName}', 'VivifyIdeas\AdminPanelGenerator\Http\Controllers\MainController@store');
Route::get($prefix . '/{modelName}/delete/{id}', 'VivifyIdeas\AdminPanelGenerator\Http\Controllers\MainController@delete');
