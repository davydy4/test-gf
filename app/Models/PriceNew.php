<?php

namespace App\Models;

use App\Observers\PriceNewObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PriceNew
 *
 * @property int $id
 * @property int $position_id
 * @property string $order_date_from
 * @property string $delivery_date_from
 * @property string $order_date_to
 * @property string $delivery_date_to
 * @property float $price
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|PriceNew newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceNew newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceNew query()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceNew whereDeliveryDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceNew whereDeliveryDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceNew whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceNew whereOrderDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceNew whereOrderDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceNew wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceNew wherePrice($value)
 */
class PriceNew extends Model
{
    use HasFactory;

    protected $table = 'price_news';

    public $timestamps = false;

    protected $fillable = [
        'position_id',
        'order_date_from',
        'order_date_to',
        'delivery_date_from',
        'delivery_date_to',
        'price'
    ];

    protected static function boot()
    {
        parent::boot();
        parent::observe(PriceNewObserver::class);
    }
}
