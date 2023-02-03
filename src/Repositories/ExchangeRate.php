<?php

namespace Himelali\CommissionTask\Repositories;

use Himelali\CommissionTask\Interfaces\ExchangeRateContract;
use function Symfony\Component\Translation\t;

class ExchangeRate implements ExchangeRateContract
{
    private $url = 'https://developers.paysera.com/tasks/api/currency-exchange-rates';
    protected $response = null;
    protected $rate = null;
    public function pull()
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $this->url);
            $result = curl_exec($ch);
            curl_close($ch);
            $this->response = json_decode($result, true);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    public function convert($amount, $currency)
    {
        $this->rate = $this->response['rates'][strtoupper($currency)] ?? null;
        if (!$this->rate) {
            throw new \Exception('Sorry exchange rate not found');
        }
        return $amount / $this->rate;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function revert($amount)
    {
        return $amount * $this->rate ;
    }
}