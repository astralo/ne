<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\History;
use CoinMarketCap\Base;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ParseTickerData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticker:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $cap;

    protected $currencies;
    protected $loaded;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->cap = new Base();

        $this->loaded = collect($this->cap->getTicker());

        // сохраненная валюта
        $this->currencies = Currency::all();

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // последние данные по каждой валюте
        $history = History::orderBy('last_updated', 'desc')->get()->unique('currency_id');

        // коллекция новых исторических данныз для единовременного запроса
        $newHistory = collect();
        foreach ($this->loaded as $item) {

            $currency = $this->getCurrency($item);

            // добавляем в базу только обновленные данные
            $history_in_base = $history->where('currency_id', $currency->id)
                ->filter(function ($o) use ($item) {
                    return $o->last_updated >= (int)$item->last_updated;
                })->all();

            if (!count($history_in_base)) {
                $newHistory->push(History::parse($item, $currency));
            }
        }

        try {
            History::insert($newHistory->toArray());
        } catch (\Exception $e) {
            return abort(503);
        }

        echo "ok\n";
    }

    /**
     * @param object $item
     */
    public function getCurrency($item)
    {
        $currency = $this->currencies->where('reserved_id', $item->id)->first();

        if (!$currency) {
            $currency = Currency::create(Currency::parse($item));
        }

        return $currency;
    }
}
