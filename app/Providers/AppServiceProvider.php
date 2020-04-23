<?php

namespace App\Providers;

use App\Services\Registrar\RegistrarService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Validator::extend('phone', function($attribute, $value, $parameters, $validator) {
            return preg_match('%^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$%i', $value) && strlen($value) >=12;
        });
        //repalce the phone attribute with the newly created phone number attribute format
        Validator::replacer('phone', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute',$attribute, ':attribute is an invalid phone number');
        });
        //the regular expression to strictly allow student email address as provided by the ICT office at Masinde Muliro
        Validator::extend('domain_email', function($attribute, $value, $parameters, $validator){
            return preg_match('/^([a-zA-Z0-9\.-]+)@(student.mmust.ac.ke)|(STUDENT.MMUST.AC.KE)$/', $value);
        });
        //replace the email attribute wiith the newly created domain email address
        Validator::replacer('domain_email', function($message, $attribute, $rule, $parameters){
            return str_replace(':attribute',$attribute,'This :attribute is an invalid email address');
        });

        $this->app->bind('RegistrarService',RegistrarService::class);
    }
}
