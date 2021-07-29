<?php

namespace App\Http\Controllers;

use App\Models\PriceNew;
use App\Services\PriceNewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PriceNewController extends Controller
{
    protected $priceRepo;

    public function __construct()
    {
        $this->priceRepo = new PriceNewService();
    }

    /** /api/check-price-new
     *
     * @param Request $request
     * @return float|\Illuminate\Http\JsonResponse|mixed
     */
    public function checkPriceNew(Request $request)
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
