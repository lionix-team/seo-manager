<?php
$web = ['web'];
$middleware = array_merge($web, config('seo-manager.middleware'));
Route::group([
    'middleware' => $middleware,
    'prefix' => config('seo-manager.route'),
    'as' => 'seo-manager.',
    'namespace' => 'Lionix\SeoManager'
], function () {
    Route::get('/', [ManagerController::class,'index'])->name('home');
    Route::get('get-routes', [ManagerController::class,'getRoutes'])->name('get-routes');
    Route::get('import-routes', [ImportController::class])->name('import');
    Route::get('get-models', [ManagerController::class,'getModels'])->name('get-models');

    Route::group(['prefix' => 'locales', 'as' => 'locales.'], function () {
        Route::get('get-locales', [LocalesController::class,'getLocales'])->name('get');
    });
});
Route::group([
    'middleware' => config('seo-manager.middleware'),
    'prefix' => config('seo-manager.route'),
    'as' => 'seo-manager.',
    'namespace' => 'Lionix\SeoManager'
], function () {
    Route::post('delete-route', [ManagerController::class,'deleteRoute'])->name('delete-route');
    Route::post('get-model-columns', [ManagerController::class,'getModelColumns'])->name('get-model-columns');
    Route::post('store-data',[ ManagerController::class,'storeData'])->name('store-data');
    Route::post('get-example-title', [ManagerController::class,'getExampleTitle'])->name('get-example-title');
    Route::post('sharing-preview', [ManagerController::class,'sharingPreview'])->name('sharing-preview');

    Route::group(['prefix' => 'locales', 'as' => 'locales.'], function () {
        Route::post('add-locale', [LocalesController::class,'addLocale'])->name('add');
    });
});
