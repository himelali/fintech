<?php

namespace Himelali\CommissionTask\Clients;

use Himelali\CommissionTask\Interfaces\ExchangeRateContract;

trait ClientTrait
{
    protected $fee = 0;
    protected $user_id = null;
    protected $currency = null;
    protected $weekNumber = null;
    protected $depositCommissionFee = 0.03;
    protected $exchangeRate;

    public function __construct(ExchangeRateContract $exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;
    }

    public function deposit($amount)
    {
        $this->fee = ($amount * $this->depositCommissionFee / 100);
    }

    public function setUserId($id)
    {
        return $this->user_id = $id;
    }

    public function setCurrency($currency)
    {
        return $this->currency = $currency;
    }

    public function setWeekNumber($number)
    {
        $this->weekNumber = $number;
    }

    public function getFee()
    {
        return roundUp($this->fee, 2);
    }
}