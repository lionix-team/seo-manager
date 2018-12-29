<?php

return [
    // Specify database configs
    'database' => [
        'table' => 'seo_manager'
    ],

    // specify the path where your eloquent models are
    'models_path' => '',

    // route for seo-manager dashboard
    'route' => 'seo-manager',

    // you can define middleware here
    // to prevent unauthorized users visit the manager
    'middleware' => [
//        'auth',
    ],

    // specify the routes
    // which shouldn't be imported to seo manager
    'except_routes' => [
        'seo-manager',
        'admin'
        //
    ],
    // specify columns which shouldn't be used
    'except_columns' => [
//        "created_at",
//        "updated_at",
    ],
    // set this parameter to true
    // if you want to have "$metaData" variable
    // shared between all views in "web" middleware group
    'shared_meta_data' => false
];
