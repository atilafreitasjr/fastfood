<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('formato_cpf', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/', $value);
        });

        Validator::replacer('formato_cpf', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'O campo :attribute deve estar no formato 999.999.999-99');
        });
    }
}
