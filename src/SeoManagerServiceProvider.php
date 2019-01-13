<?php

namespace Lionix\SeoManager;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Lionix\SeoManager\Commands\GenerateSeoManagerData;

class SeoManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/seo-manager.php');
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadViewsFrom(__DIR__ . '/views', 'seo-manager');

        $this->publishes([
            __DIR__ . '/config/seo-manager.php' => config_path('seo-manager.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/assets' => public_path('vendor/lionix'),
        ], 'assets');

        $this->commands([
            GenerateSeoManagerData::class
        ]);

        $this->registerHelpers();
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', \Lionix\SeoManager\Middleware\ClearViewCache::class);

        if (config('seo-manager.shared_meta_data')) {
            $router->pushMiddlewareToGroup('web', \Lionix\SeoManager\Middleware\SeoManager::class);
        }

        // Blade Directives
        $this->registerBladeDirectives();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/seo-manager.php', 'seo-manager'
        );
        $this->app->bind('seomanager', function () {
            return new SeoManager();
        });
        $this->app->alias('seomanager', SeoManager::class);
    }

    /**
     * Register helpers file
     */
    public function registerHelpers()
    {
        // Load the helpers
        if (file_exists($file = __DIR__ . '/helpers/helpers.php')) {
            require $file;
        }
    }

    /**
     * Register Blade Directives
     */
    public function registerBladeDirectives()
    {

        Blade::directive('meta', function ($expression) {
            $meta = '';
            $expression = trim($expression, '\"\'');
            $metaData = metaData($expression);
            if (is_array($metaData)) {
                foreach ($metaData as $key => $og) {
                    $meta .= "<meta property='{$key}' content='{$og}'/>";
                }
            } else {
                $meta .= "<meta property='{$expression}' content='{$metaData}'/>";
            }
            return $meta;
        });
        Blade::directive('keywords', function () {
            return "<meta property='keywords' content='" . metaKeywords() . "'/>";
        });
        Blade::directive('url', function () {
            return "<meta property='url' content='" . metaUrl() . "'/>";
        });
        Blade::directive('author', function () {
            return "<meta property='author' content='" . metaAuthor() . "'/>";
        });
        Blade::directive('description', function () {
            return "<meta property='description' content='" . metaDescription() . "'/>";
        });
        Blade::directive('title', function () {
            return "<meta property='title' content='" . metaTitle() . "'/>";
        });
        Blade::directive('openGraph', function ($expression) {
            $expression = trim($expression, '\"\'');
            $meta = '';
            $metaOpenGraph = metaOpenGraph($expression);
            if (is_array($metaOpenGraph)) {
                foreach ($metaOpenGraph as $key => $og) {
                    $meta .= "<meta property='{$key}' content='{$og}'/>";
                }
            } else {
                $meta .= "<meta property='{$expression}' content='{$metaOpenGraph}'/>";
            }
            return $meta;
        });
        Blade::directive('titleDynamic', function () {
            return metaTitleDynamic();
        });
    }

}
