<?php


namespace App\Observers;


use App\Models\PriceNew;
use App\Services\PriceNewService;

class PriceNewObserver
{
    public function creating(PriceNew $price)
    {
       PriceNewService::conversionData($price);

    }
}