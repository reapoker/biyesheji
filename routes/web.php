<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/asd','AdminController@asd');


$router->get('/Admin[/{tpl}]', 'AdminController@show');
$router->get('/Admin/{tpl}/{param}','AdminController@showParam');

// 使用 auth:api 中间件
$router->group(['middleware' => 'auth:api'], function($router)
{
    $router->get('/api/admin/components','ComponentApiController@handle');
    $router->post('/api/admin/components','ComponentApiController@handle');

});

$router->group(['middleware'=>['beforeHandle','behindHandle']],function ($router){

    $router->get('/api/components','ComponentApiController@webHandle');
    $router->post('/api/components','ComponentApiController@webHandle');

});

$router->post('/api/upload','ComponentApiController@upload');


