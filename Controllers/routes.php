<?php

// Authentication
Route::get(		'/login', 					['as' => '_auth.login', 				'uses' => 'AuthController@GET_loginForm']);
Route::post(	'/login', 					['as' => '_auth.login.post', 			'uses' => 'AuthController@GET_loginUser']);
Route::get(		'/logout', 					['as' => '_auth.logout', 				'uses' => 'AuthController@GET_logoutUser']);
// Error controller
Route::get(		'/error', 					['as' => '_error', 						'uses' => 'ErrorController@GET_error']);
// Home
Route::get(		'/', 						['as' => 'home', 						'uses' => 'HomeController@GET_index']);
Route::get(		'/how-to-encrypt',    		['as' => 'how.to',       				'uses' => 'HomeController@GET_how_to']);
Route::get(		'/encrypt', 				['as' => 'encrypt', 					'uses' => 'HomeController@GET_encrypt']);
Route::post(	'/encrypt', 				['as' => 'encrypt.it', 					'uses' => 'HomeController@POST_encrypt_it']);
Route::get(		'/decrypt/{url}', 		    ['as' => 'decrypt', 					'uses' => 'HomeController@GET_decrypt']);
Route::post(	'/decrypt', 				['as' => 'decrypt.it', 					'uses' => 'HomeController@POST_decrypt_it']);
Route::post(    '/send',                    'HomeController@send');

