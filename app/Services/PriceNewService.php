<?php


namespace App\Services;


use App\Models\PriceNew;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PriceNewService
{
    /** Метод пересборбки денормализованных данных
     *
     * @param PriceNew $price
     */
    public static function conversionData(PriceNew $price)
    {
        $pricesCollection = PriceNew::query()
                                ->where('position_id', $price->position_id)
                                ->whereDate('order_date_from', '<=', $price->order_date_from)
                                ->whereDate('delivery_date_from', '<=', $price->delivery_date_from)
                                ->get();

        foreach ($pricesCollection as $model)
        {
            $copyModel = new PriceNew();
            $model->order_date_to = Carbon::parse($price->order_date_from)->addDays(-1)->format("Y-m-d");
            $copyModel->delivery_date_from = $model->delivery_date_from;

            if(Carbon::parse($model->order_date_to) < Carbon::parse($model->order_date_from)) {
                $model->delete();
            }
            else {
                $model->delivery_date_from = $price->delivery_date_from;
                $model->save();
            }
            $copyModel->position_id = $model->position_id;
            $copyModel->price = $model->price;
            $copyModel->order_date_from = $model->order_date_from;
            $copyModel->delivery_date_to = Carbon::parse($price->delivery_date_from)->addDays(-1)->format("Y-m-d");
            $copyModel->save();
        }
    }

    /** Метод возвращает единственную цену по условию
     *
     * @param Request $request
     * @return float|mixed
     */
    public function getPrice(Request $request)
    {
        $positionId = $request->post("position_id");
        $orderDate = $request->post("order_date");
        $deliveryDate = $request->post("delivery_date");

        $priceNew = PriceNew::query()
            ->where('position_id', $positionId)
            ->whereDate('order_date_from', '<=', $orderDate)
            ->whereDate('delivery_date_from', '<=', $deliveryDate)
            ->where(function(Builder $q) use ($orderDate){
                $q->where(function(Builder $q){
                    $q->whereNull('order_date_to');
                })->orWhere(function(Builder $q) use ($orderDate){
                    $q->where('order_date_to', '>=', $orderDate);
                });
            })
            ->where(function(Builder $q) use ($deliveryDate){
                $q->where(function(Builder $q){
                    $q->whereNull('delivery_date_to');
                })->orWhere(function(Builder $q) use ($deliveryDate){
                    $q->where('delivery_date_to', '>=', $deliveryDate);
                });
            })
            ->orderBy('delivery_date_from', 'desc')
            ->limit(1)
            ->first();

        if (empty($priceNew))
        {
            return null;
        }

        return $priceNew->price;

    }
}