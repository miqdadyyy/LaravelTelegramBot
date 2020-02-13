<?php

namespace Miqdadyyy\LaravelTelegramBot;

use Illuminate\Support\ServiceProvider;
use Miqdadyyy\LaravelTelegramBot\Commands\RegisterWebhookCommand;

class LaravelTelegramBotServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'miqdadyyy');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'miqdadyyy');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laraveltelegrambot.php', 'laraveltelegrambot');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        if ($this->app->runningInConsole()) {
            $this->commands([
                RegisterWebhookCommand::class
            ]);
        }
        $this->publishes([
            __DIR__.'/TelegramBot/' => app_path('Http/Controllers/TelegramBot')
        ], 'telegrambot-webhook');

        // Register the service the package provides.
        $this->app->singleton('laraveltelegrambot', function ($app) {
            return new LaravelTelegramBot;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laraveltelegrambot'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laraveltelegrambot.php' => config_path('laraveltelegrambot.php'),
        ], 'laraveltelegrambot.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/miqdadyyy'),
        ], 'laraveltelegrambot.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/miqdadyyy'),
        ], 'laraveltelegrambot.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/miqdadyyy'),
        ], 'laraveltelegrambot.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
