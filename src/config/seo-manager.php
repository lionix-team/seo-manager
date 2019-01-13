<?php

return [
    /**
     * Database table name where your manager data will be stored
     */
    'database' => [
        'table' => 'seo_manager',
        'locales_table' => 'seo_manager_locales',
        'translates_table' => 'seo_manager_translates'
    ],

    /**
     * Set default locale,
     * It will be added as default locale
     * when locales table migrated
     */
    'locale' => 'en',

    /**
     * Path where your eloquent models are
     * Leave this config empty if you want to look for models in whole project
     */
    'models_path' => '',

    /**
     * Route from which your Dashboard will be available
     */
    'route' => 'seo-manager',

    /**
     * Middleware array for dashboard
     * to prevent unauthorized users visit the manager
     */
    'middleware' => [
        //  'auth',
    ],

    /**
     * Routes which shouldn't be imported to seo manager
     */
    'except_routes' => [
        'seo-manager',
        'admin'
        //
    ],

    /**
     * Columns which shouldn't be used ( in mapping )
     */
    'except_columns' => [
        // "created_at",
        // "updated_at",
    ],

    /**
     * Set this parameter to true
     * if you want to have "$metaData" variable
     * shared between all views in "web" middleware group
     */
    'shared_meta_data' => false
];
