<?php

namespace Himelali\CommissionTask\Interfaces;

interface ExchangeRateContract
{
    public function pull();
    public function getResponse();
    public function convert($amount, $currency);
    public function revert($amount);
}
