<?php

namespace Himelali\CommissionTask\Clients;

use Himelali\CommissionTask\Interfaces\AccountContract;

class BusinessClient implements AccountContract
{
    use ClientTrait;

    protected $withdrawCommissionFee = 0.50;

    public function withdraw($amount)
    {
        $this->fee = ($amount * $this->withdrawCommissionFee / 100);
    }
}
