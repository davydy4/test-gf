<?php


namespace App\Services;


use App\Models\PriceOld;
use Illuminate\Http\Request;

class PriceOldService
{
    /**
     * @param Request $request
     * @return float|mixed
     */
    public function getPrice(Request $request)
    {
        $positionId = $request->post("position_id");
        $orderDate = $request->post("order_date");
        $deliveryDate = $request->post("delivery_date");

        $priceOld = PriceOld::query()
            ->where('position_id', $positionId)
            ->where('order_date_from', '<=', $orderDate)
            ->where('delivery_date_from', '<=', $deliveryDate)
            ->orderBy('delivery_date_from', 'desc')
            ->limit(1)
            ->first();

        if (empty($priceOld))
        {
            return null;
        }

        return $priceOld->price;

    }
}