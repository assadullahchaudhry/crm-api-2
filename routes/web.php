<?php

use App\Models\User;

$router->get('/', function () use ($router) {
    return response()->json([
        'user' => User::first()
    ]);
    return url('/v1/oauth/token');
    return $router->app->version();
});

// $router->options('/{any:.*}', function () {
//     return response(['status' => 'success']);
// });



// api routes
$router->group(['prefix' => 'api/v1'], function () use ($router) {

    // auth
    $router->post('/login', 'Auth\AuthController@login');
    $router->post('/password/email', 'Auth\ForgotPasswordController@sendPasswordResetLink');
    $router->put('/reset/password', 'Auth\ForgotPasswordController@resetPassword');




    $router->group(['middleware' => 'auth'], function () use ($router) {

        //Auth
        $router->post('/logout', 'Auth\AuthController@logout');
        $router->post('/auth', 'UserController@getCurrentlyLoggedInUser');

        // Roles
        $router->get('/roles', 'RoleController@index');

        //Profile
        $router->post('/profile/avatar', 'ProfileController@avatarUpdate');
        $router->post('/profile/password', 'ProfileController@updatePassword');
        $router->post('/profile', 'ProfileController@update');

        // To Dos
        $router->get('/todos', 'TodoController@index');
        $router->post('/todos', 'TodoController@store');
        $router->put('/todos/{id}', 'TodoController@update');
        $router->delete('/todos/{id}', 'TodoController@destroy');

        // tickets
        $router->get('/tickets', 'TicketController@index');
        $router->post('/tickets', 'TicketController@store');
        $router->get('/tickets/{id}', 'TicketController@show');
        $router->put('/tickets/{id}', 'TicketController@update');
        $router->delete('/tickets/{id}', 'TicketController@destroy');

        //users
        $router->get('/users', 'UserController@index');
        $router->get('/users/{id}', 'UserController@show');
        $router->post('/users', 'UserController@store');
        $router->delete('/users/{id}', 'UserController@destroy');
        $router->put('/users/{id}', 'UserController@update');

        //prospects
        $router->get('/prospects/refs', 'ProspectController@refs');
        $router->get('/prospects', 'ProspectController@index');
        $router->post('/prospects', 'ProspectController@store');
        $router->get('/prospects/{id}', 'ProspectController@show');
        $router->put('/prospects/{id}', 'ProspectController@update');
        $router->delete('/prospects/{id}', 'ProspectController@destroy');

        //chat routes
        $router->get('/inbox/chat/{chatId}/attachments/{attachmentId}', 'InboxController@downloadAttachment');
        $router->get('/inbox/contacts', 'InboxController@contacts');
        $router->get('/inbox/{id}', 'InboxController@show');
        $router->post('/inbox', 'InboxController@store');

        // $router->post('/chat/initiate', 'ChatController@initiate');
        // $router->post('/chat/conversations', 'ChatController@conversations');

        //contacts
        $router->get('/contacts/refs', 'ContactController@refs');
        $router->get('/contacts', 'ContactController@index');
        $router->post('/contacts', 'ContactController@store');
        $router->get('/contacts/{id}', 'ContactController@show');
        $router->put('/contacts/{id}', 'ContactController@update');
        $router->delete('/contacts/{id}', 'ContactController@destroy');

        //roles
        $router->get('roles', 'RoleController@index');

        // To Dos
        $router->get('/todos', 'TodoController@index');
        $router->post('/todos', 'TodoController@store');
        $router->put('/todos/{id}', 'TodoController@update');
        $router->delete('/todos/{id}', 'TodoController@destroy');


        //Groups
        $router->get('/groups', 'GroupController@index');
        $router->get('/groups/{id}', 'GroupController@show');
        $router->post('/groups', 'GroupController@store');
        $router->delete('/groups/{id}', 'GroupController@destroy');
        $router->put('/groups/{id}', 'GroupController@update');

        //Companies
        $router->get('/companies/refs', 'CompanyController@refs');
        $router->get('/companies', 'CompanyController@index');
        $router->get('/companies/{id}', 'CompanyController@show');
        $router->post('/companies', 'CompanyController@store');
        $router->delete('/companies/{id}', 'CompanyController@destroy');
        $router->put('/companies/{id}', 'CompanyController@update');

        //Affiliates
        $router->get('/affiliates', 'AffiliateController@index');
        $router->get('/affiliates/{id}', 'AffiliateController@show');
        $router->post('/affiliates', 'AffiliateController@store');
        $router->delete('/affiliates/{id}', 'AffiliateController@destroy');
        $router->put('/affiliates/{id}', 'AffiliateController@update');

        //Tasks
        $router->get('/tasks/all', 'TaskController@all');
        $router->get('/tasks/refs', 'TaskController@refs');
        $router->get('/tasks', 'TaskController@index');
        $router->get('/tasks/{id}', 'TaskController@show');
        $router->post('/tasks', 'TaskController@store');
        $router->delete('/tasks/{id}', 'TaskController@destroy');
        $router->put('/tasks/{id}', 'TaskController@update');

        //Documents
        $router->get('documents', 'DocumentController@index');
        $router->get('documents/{id}', 'DocumentController@show');
        $router->post('documents', 'DocumentController@store');
        $router->delete('documents/{id}', 'DocumentController@destroy');


        //Common 
        $router->get('/location/countries/{id}/refs', 'LocationController@getStatesCities');
        $router->get('/location/states/{id}/refs', 'LocationController@getCities');
        $router->get('/location/refs', 'LocationController@index');
    });
});
