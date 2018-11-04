<?php

namespace Ptuchik\Recaptcha;

use Illuminate\Support\ServiceProvider;
use ReCaptcha\ReCaptcha;

/**
 * Class RecaptchaServiceProvider
 * @package Ptuchik\Recaptcha
 */
class RecaptchaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $app = $this->app;
        $this->bootConfig();
        $app['validator']->extend('recaptcha', function ($attribute, $value, $parameters, $validator) use ($app) {

            $recaptcha = $app['recaptcha']->setExpectedHostname($app['request']->getHttpHost());

            if (is_array($parameters) && !empty($parameters[0])) {
                $recaptcha->setExpectedAction($parameters[0]);
            }

            dd($recaptcha->verify($value, $app['request']->getClientIp()));

            return $recaptcha->verify($value, $app['request']->getClientIp())->isSuccess();
        });
    }

    /**
     * Booting configure.
     */
    protected function bootConfig()
    {
        $path = __DIR__.'/config/recaptcha.php';
        $this->mergeConfigFrom($path, 'recaptcha');
        if (function_exists('config_path')) {
            $this->publishes([$path => config_path('recaptcha.php')]);
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('recaptcha', function ($app) {
            return new ReCaptcha($app['config']['recaptcha.secret']);
        });
    }

    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides()
    {
        return ['recaptcha'];
    }
}