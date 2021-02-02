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
        $names = [
            'keywords',
            'url',
            'author',
            'description',
            'title',
        ];

        Blade::directive('meta', function ($expression) use ($names) {
            $meta = '';
            $expression = trim($expression, '\"\'');
            $metaData = metaData($expression);
            $type = in_array($expression, $names) ? "name" : "property";

            if (is_array($metaData)) {
                foreach ($metaData as $key => $og) {
                    $type = in_array($key, $names) ? "name" : "property";

                    $meta .= "<meta {$type}='{$key}' content='{$og}'/>\n";
                }
            } else {
                $meta .= "<meta {$type}='{$expression}' content='{$metaData}'/>\n";
            }
            return $meta;
        });
        Blade::directive('keywords', function () {
            return "<meta name='keywords' content='" . metaKeywords() . "'/>\n";
        });
        Blade::directive('url', function () {
            return "<meta name='url' content='" . metaUrl() . "'/>\n";
        });
        Blade::directive('author', function () {
            return "<meta name='author' content='" . metaAuthor() . "'/>\n";
        });
        Blade::directive('description', function () {
            return "<meta name='description' content='" . metaDescription() . "'/>\n";
        });
        Blade::directive('title', function () {
            return "<meta name='title' content='" . metaTitle() . "'/>\n";
        });
        Blade::directive('openGraph', function ($expression) {
            $expression = trim($expression, '\"\'');
            $meta = '';
            $metaOpenGraph = metaOpenGraph($expression);
            if (is_array($metaOpenGraph)) {
                foreach ($metaOpenGraph as $key => $og) {
                    $meta .= "<meta property='{$key}' content='{$og}'/>\n";
                }
            } else {
                $meta .= "<meta property='{$expression}' content='{$metaOpenGraph}'/>\n";
            }
            return $meta;
        });
        Blade::directive('titleDynamic', function () {
            return metaTitleDynamic();
        });
    }

}
