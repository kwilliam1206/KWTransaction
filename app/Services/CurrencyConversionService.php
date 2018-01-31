<?php
namespace KW\Transactions\Services;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;


class CurrencyConversionService
{
    private $client;

    public function __construct()
    {
        $config = config('services.xecd');
        $this->client = new GuzzleHttpClient([
            'base_uri' => $config['base_url'],
            'auth' => [ $config['auth_user'], $config['auth_pwd'] ]
        ]);
    }

    private function _getRequest($uri, array $query)
    {
        try {
            $apiRequest = $this->client->get($uri, [
                'query' => $query
            ]);

            $content = json_decode($apiRequest->getBody()->getContents());

            return $content;

        } catch (RequestException $re) {
            throw $re;
        }
    }

    /**
     * @param string $from
     * @param string $to comma-separated values
     * @param string $date
     * @return mixed
     */
    public function historicRate($from, $to, $date)
    {
        return $this->_getRequest('historic_rate', [
            'from' => $from,
            'to' => $to,
            'date' => $date
        ]);
    }

    /**
     * @param string $from
     * @param string $to comma-separated values
     * @return mixed
     */
    public function convertFrom($from, $to)
    {
        return $this->_getRequest('convert_from', [
            'from' => $from,
            'to' => $to
        ]);
    }

    /**
     * @param string $from comma-separated values
     * @param string $to
     * @return mixed
     */
    public function convertTo($from, $to)
    {
        return $this->_getRequest('convert_to', [
            'from' => $from,
            'to' => $to
        ]);
    }

}
