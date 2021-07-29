<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use phpDocumentor\Reflection\File;

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
        Validator::extend('valid_date_range', function ($attribute, $value, $parameters, $validator) {
            $data = request()->post($parameters[0]);

            $index = explode('.', $attribute)[1];
            if (empty($data[$index]['order_date_from']))
            {
                return false;
            }

            $orderDateFrom =  $data[$index]['order_date_from'];
            $orderFrom = Carbon::parse($orderDateFrom);
            $deliveryFrom = Carbon::parse($value);

            return $deliveryFrom >= $orderFrom ;
        }, 'Error in delivery_date_from value');

        Validator::extend('valid_date_range_price', function ($attribute, $value, $parameters, $validator) {
            $data = request()->post($parameters[0]);
            $orderFrom = Carbon::parse($data);
            $deliveryFrom = Carbon::parse($value);

            return $deliveryFrom >= $orderFrom ;
        }, 'Error in delivery_date value');
    }
}
