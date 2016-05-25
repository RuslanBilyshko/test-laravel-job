<?php

Route::get('/', ['as' => 'home', 'uses' => 'WelcomeController@index']);

Route::group(['prefix' => 'user'], function(){
  get('login/{token?}', ['as' => 'getLogin', 'uses' => 'Auth\AuthController@getLogin']);
  post('login', ['as' => 'postLogin', 'uses' => 'Auth\AuthController@postLogin']);
  get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
  get('register', ['as' => 'getRegister', 'uses' => 'Auth\AuthController@getRegister']);
  post('register', ['as' => 'postRegister', 'uses' => 'Auth\AuthController@postRegister']);

  Route::group(['middleware' => ['auth','status'],'where' => ['id' => '[0-9]+']], function(){
    get('{id}', ['as' => 'account', 'uses' => 'UserController@index']);
    get('edit', ['as' => 'accountEdit', 'uses' => 'UserController@edit']);
    post('edit', ['as' => 'accountUpdate', 'uses' => 'UserController@update']);
    //Password Replace
    get('password/set', ['as' => 'passwordSet', 'uses' => 'PasswordReplaceController@set']);
    post('password/send', ['as' => 'passwordSend', 'uses' => 'PasswordReplaceController@send']);
    get('password/replace/{token}', ['as' => 'passwordReplace', 'uses' => 'PasswordReplaceController@replace']);
  });
});

