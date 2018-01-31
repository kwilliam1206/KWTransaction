<?php

namespace KW\Transactions\Console\Commands;

use Faker\Provider\zh_TW\DateTime;
use Illuminate\Console\Command;
use KW\Transactions\Models\Currency;
use KW\Transactions\Models\CurrencyConversion;
use KW\Transactions\Services\CurrencyConversionService;

class ConvertCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fd:convert-currencies {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var CurrencyConversionService
     */
    protected $converter;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CurrencyConversionService $converter)
    {
        parent::__construct();

        $this->converter = $converter;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $historicDate = $this->argument('date');

        $currencies = Currency::all();

        $bar = $this->output->createProgressBar(pow(count($currencies), 2) - count($currencies));

        foreach ($currencies as $from) {
            foreach ($currencies as $to) {
                if ($from != $to) {
                    if ($historicDate) {
                        $res = $this->converter->historicRate($from->code, $to->code, $historicDate);
                    } else {
                        $res = $this->converter->convertFrom($from->code, $to->code);
                    }

                    $date = new \DateTime($res->timestamp);
                    $rate = $res->to[0]->mid;

                    $conversion = CurrencyConversion::where('from_currency_id', '=', $from->id)
                        ->where('to_currency_id', '=', $to->id)
                        ->where('conversion_date', '=', $date)
                        ->first();

                    if (!$conversion) {
                        $conversion = new CurrencyConversion();
                        $conversion->from_currency_id = $from->id;
                        $conversion->to_currency_id = $to->id;
                        $conversion->conversion_date = $date;
                    }
                    $conversion->rate = $rate;
                    $conversion->save();

                    $bar->advance();
                }
            }
        }

        $bar->finish();
        $this->output->newLine(2);
    }
}
