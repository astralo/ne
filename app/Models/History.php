<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';

    protected $fillable = [
        'currency_id',
        'price_usd',
        'price_btc',
        'volume_usd_24h',
        'market_cap_usd',
        'available_supply',
        'total_supply',
        'percent_change_1h',
        'percent_change_24h',
        'percent_change_7d',
        'last_updated'
    ];

    protected $casts = [
        'percent_change_1h'  => 'double',
        'percent_change_7d'  => 'double',
        'percent_change_24h' => 'double',
    ];

    public function currency()
    {
        return $this->belongsTo(\App\Models\Currency::class);
    }

    /**
     * @param $data
     * @param Currency $currency
     * @return array
     */
    public static function parse($data, Currency $currency)
    {
        $result = [
            'currency_id'        => $currency->id,
            'price_usd'          => $data->price_usd,
            'price_btc'          => $data->price_btc,
            'market_cap_usd'     => $data->market_cap_usd,
            'available_supply'   => $data->available_supply,
            'total_supply'       => $data->total_supply,
            'percent_change_1h'  => $data->percent_change_1h,
            'percent_change_24h' => $data->percent_change_24h,
            'percent_change_7d'  => $data->percent_change_7d,
            'last_updated'       => $data->last_updated
        ];

        $data = json_decode(json_encode($data), true);
        $result['volume_usd_24h'] = $data['24h_volume_usd'];

        return $result;
    }
}
