<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
    public function getData(Request $request)
    {
        $items = History::with('currency')->orderBy('last_updated', 'desc')
            ->get();

        $result = $items->unique('currency_id');
        $result->map(function ($item) {

            $two = History::where('currency_id', $item->currency_id)->orderBy('last_updated', 'desc')
                ->take(2)->get();

            $item->price_dir = 0;
            $item->percent_dir = 0;
            if ($two->count() > 1) {

                if ($two->first()->price_usd > $two->last()->price_usd) $item->price_dir = 1;
                if ($two->first()->price_usd < $two->last()->price_usd) $item->price_dir = -1;

                if ($two->first()->percent_change_1h > $two->last()->percent_change_1h) $item->percent_dir = 1;
                if ($two->first()->percent_change_1h < $two->last()->percent_change_1h) $item->percent_dir = -1;
            }

            return $item;
        });

        return response()->json([
            'results' => array_values($result->toArray())
        ]);
    }
}
