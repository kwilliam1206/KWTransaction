<?php
/**
 * Service to provide locale vars for view scripts.
 */
namespace KW\Transactions\Services;
use Auth;
class LocaleService
{
    public $date_format;
    public $language_code;
    public $currency_code;
    public function __construct()
    {
        $this->date_format = $this->setDateFormat();
        $this->language_code = $this->setLanguageCode();
        $this->currency_code = $this->setCurrencyCode();
    }

    /**
     * Convert PHP IntlDateFormatter format to js date format
     * @return string
     */
    private function setDateFormat(){
        $i = new \IntlDateFormatter(setlocale(LC_TIME,0),\IntlDateFormatter::SHORT,\IntlDateFormatter::NONE);
        return str_replace(['yy','M','d'],['yyyy','mm','dd'],$i->getPattern());
    }

    /**
     * @return return the base currency code
     */
    private function setCurrencyCode(){
        if(Auth::check())
            return strtoupper(Auth::user()->currency->code);
    }

    /**
     * @return return the base language code for JS plugins
     */
    private function setLanguageCode(){
        if(Auth::check())
            return substr(Auth::user()->locale->code,0,2);
    }
}
