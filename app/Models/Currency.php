<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';

    protected $fillable = [
        'reserved_id',
        'name',
        'symbol',
        'rank'
    ];

    /**
     *
     */
    public function history()
    {
        $this->hasMany(\App\Models\History::class, 'currency_id');
    }

    /**
     * @param $item
     * @return array
     */
    public static function parse($item)
    {
        return [
            'reserved_id' => $item->id,
            'name'        => $item->name,
            'symbol'      => $item->symbol,
            'rank'        => $item->rank,
        ];
    }
}
