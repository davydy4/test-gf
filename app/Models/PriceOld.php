<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PriceOld
 *
 * @property int $id
 * @property int $position_id
 * @property string $order_date_from
 * @property string $delivery_date_from
 * @property float $price
 * @method static \Illuminate\Database\Eloquent\Builder|PriceOld newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceOld newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceOld query()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceOld whereDeliveryDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceOld whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceOld whereOrderDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceOld wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceOld wherePrice($value)
 * @mixin \Eloquent
 */
class PriceOld extends Model
{
    use HasFactory;

    protected $table = 'price_olds';

    public $timestamps = false;

    protected $fillable = [
        'position_id',
        'order_date_from',
        'delivery_date_from',
        'price'
        ];



}
