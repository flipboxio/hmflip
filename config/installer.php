<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PHP version requirement
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel PHP requirement, you can change
    | it if your application require.
    |
    */
    'core' => [
        'minimumPhpVersion' => '8.0.2'
    ],
    'requirements' => [
        'php' => [
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'JSON',
            'cURL',
            //'mcrypt',
        ],
        'apache' => [
            'mod_rewrite',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Folders Permissions
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel folders permissions, if your application
    | requires more permissions just add them to the array list bellow.
    |
    */
    'permissions' => [
        'storage/app/'           => '775',
        'storage/framework/'     => '775',
        'storage/logs/'          => '775',
        'bootstrap/cache/'       => '775',
    ],

    /*
    |--------------------------------------------------------------------------
    | Publish application
    |--------------------------------------------------------------------------
    |
    | Set path to application to publish or null if nothing to publish
    |
    */
    'publish-path' => null,

    /*
    |--------------------------------------------------------------------------
    | Administrator creator
    |--------------------------------------------------------------------------
    |
    | Set true if you want administrator creation
    |
    */
    'administrator' => true,

    /*
    |--------------------------------------------------------------------------
    | Validation for administrator creator
    |--------------------------------------------------------------------------
    |
    | Set name of form request if validator method of AuthController is not used
    | Set full name space, for example : App\Http\Requests\UserCreateRequest
    |
    */
    'validator' => null,

    /*
    |--------------------------------------------------------------------------
    | Administrator fields
    |--------------------------------------------------------------------------
    |
    | Set all fields as setted in create method of AuthController
    | Or in rules of form request
    |
    */
    'fields' => [
        'username' => 'text',
        'email' => 'email',
        'password' => 'text',
    ],

    /*
    |--------------------------------------------------------------------------
    | Method for administrator creation
    |--------------------------------------------------------------------------
    |
    | Set class and method for administrator creation there if it's not default create of AuthController
    | Set full name space, for example : App\Repositories\UserRepository
    |
    */
    'creator' => [
        'class' => 'App\Http\Controllers\Admin\AdminController',
        'method' => 'installer_create',
    ],

    /*
    |--------------------------------------------------------------------------
    | Login url
    |--------------------------------------------------------------------------
    |
    | Set the login url for button at the end of installation
    |
    */
    'login-url' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Id of the product
    |--------------------------------------------------------------------------
    |
    |
    */
    'item_id' => 'kjg87ugfdfg'

];
