<?php

namespace App\Http\Controllers;

use App\Models\PriceNew;
use App\Models\PriceOld;
use App\Services\PriceOldService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PriceOldController extends Controller
{
    protected $priceRepo;

    public function __construct()
    {
        $this->priceRepo = new PriceOldService();
    }


    /**
     * /api/conversion
     *
     * @param Request $request
     * @return PriceNew[]|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse
     */
    public function conversion(Request $request)
    {
        $rules = [
            "data"    => ['required','array'],
            'data.*.position_id' => ['required','integer'],
            'data.*.order_date_from' => ['required','date_format:"Y-m-d"'],
            'data.*.delivery_date_from' => ['required','date_format:"Y-m-d"','valid_date_range:data'],
            'data.*.price' => ['required','numeric'],
        ];

        $messages = [
            'date.required' => 'A date is required',
            'date.date_format'  => 'A date must be in format: Y-m-d',
            'date.numeric'  => 'A date must be in numeric',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }


        $data = $request->post('data');

        $priceNew = [];
        PriceNew::query()->delete();
        PriceOld::query()->delete();
        foreach ($data as $key => $value)
        {
            PriceOld::query()->create($value);
        }

        $priceOld = PriceOld::query()->orderBy('order_date_from')->get();
        foreach ($priceOld as $price)
        {
            PriceNew::query()->create($price->getAttributes());
        }

        $priceNew = PriceNew::all();

        return $priceNew;
    }

    /**
     * /api/check-price-old
     *
     * @param Request $request
     * @return float|\Illuminate\Http\JsonResponse|mixed
     */
    public function checkPriceOld(Request $request)
    {
        $rules = [
            'position_id' => 'required|integer',
            'order_date' => 'required|date_format:Y-m-d',
            'delivery_date' => 'required|date_format:Y-m-d|valid_date_range_price:order_date'
        ];

        $messages = [
            'date.required' => 'A date is required',
            'date.date_format'  => 'A date must be in format: Y-m-d',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }



        return $this->priceRepo->getPrice($request);
    }


}
