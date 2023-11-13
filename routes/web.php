<?php
$router->get('/', function () use ($router) {
    header('Location:https://documenter.getpostman.com/view/3220389/2s9YXiY1dc#e10b7f6f-40c8-4cd9-9e54-4a766da41243');
});
$router->get('track/{proyect}/{key}', 'AuthController@track');

$router->post('login', 'AuthController@login');
$router->post('register', 'AuthController@register');

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->post('user', 'AuthController@me');
    $router->post('editUser', 'AuthController@editUser');

    //CIUDAD
    $router->post('city/insert', 'CityController@insert');
    $router->post('city/get_all', 'CityController@get_all');
    $router->get('city/get_by_id/{id}', 'CityController@get_by_id');
    $router->post('city/update', 'CityController@update_by_id');
    $router->get('city/delete/{id}', 'CityController@delete_by_id');

    //EVENT
    $router->post('event/insert', 'EventController@insert');
    $router->post('event/get_all', 'EventController@get_all');
    $router->get('event/get_by_id/{id}', 'EventController@get_by_id');
    $router->post('event/update', 'EventController@update_by_id');
    $router->get('event/delete/{id}', 'EventController@delete_by_id');

    //FAVS
    $router->post('favs/insert', 'FavsController@insert');
    $router->post('favs/get_all', 'FavsController@get_all');
    $router->get('favs/get_by_user/{id_user}', 'FavsController@get_by_user');
    $router->post('favs/update', 'FavsController@update_by_id');
    $router->get('favs/delete/{id}', 'FavsController@delete_by_id');
    
    //USER_CONFIRMATION
    $router->post('user_confirmation/insert', 'User_confirmationController@insert');
    $router->post('user_confirmation/get_all', 'User_confirmationController@get_all');
    $router->get('user_confirmation/get_by_id/{id}', 'User_confirmationController@get_by_id');
    $router->post('user_confirmation/update', 'User_confirmationController@update_by_id');
    $router->get('user_confirmation/delete/{id}', 'User_confirmationController@delete_by_id');

    //CHAT
    $router->post('chat/insert', 'ChatController@insert');
    $router->post('chat/get_all', 'ChatController@get_all');
    $router->get('chat/get_by_id/{id}', 'ChatController@get_by_id');
    $router->post('chat/update', 'ChatController@update_by_id');
    $router->get('chat/delete/{id}', 'ChatController@delete_by_id');

    //STATICS_TEXTS
    $router->post('statics_texts/insert', 'Statics_textsController@insert');
    $router->post('statics_texts/get_all', 'Statics_textsController@get_all');
    $router->get('statics_texts/get_by_id/{id}', 'Statics_textsController@get_by_id');
    $router->post('statics_texts/update', 'Statics_textsController@update_by_id');
    $router->get('statics_texts/delete/{id}', 'Statics_textsController@delete_by_id');
});
