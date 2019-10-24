<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::resource(
//     'user', 'Api\UserController'
// );

Route::apiResources([
    'user' => 'Api\UserController'
]);