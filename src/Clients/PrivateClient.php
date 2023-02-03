<?php

namespace Himelali\CommissionTask\Clients;

use Himelali\CommissionTask\Interfaces\AccountContract;

class PrivateClient implements AccountContract
{
    use ClientTrait;

    private static $weekly_limit_count = 3;
    private static $weekly_limit_amount = 1000;
    private static $limit_currency = 'EUR';
    protected $withdrawCommissionFee = 0.30;
    private $items = [];

    public function withdraw($amount)
    {
        $this->fee = 0;
        $count = isset($this->items[$this->weekNumber]) ? $this->items[$this->weekNumber]['weekly_count'] : 0;
        $balance = isset($this->items[$this->weekNumber]) ? $this->items[$this->weekNumber]['withdraw_amount'] : 0;
        $finisLimit = isset($this->items[$this->weekNumber]) && $this->items[$this->weekNumber]['finish_limit'];

        $total = $balance + $amount;
        $convertedAmount = $amount;

        if (self::$limit_currency != $this->currency) {
            $total =  $this->exchangeRate->convert($total, $this->currency);
            $convertedAmount = $this->exchangeRate->convert($amount, $this->currency);
        }

        $this->items[$this->weekNumber] = [
            'weekly_count' => $count + 1,
            'withdraw_amount' => $total,
            'finish_limit' => $finisLimit,
        ];

        if ($count > self::$weekly_limit_count || $total > self::$weekly_limit_amount) {
            if ($count < self::$weekly_limit_count && $total > self::$weekly_limit_amount) {
                $feeAbleAmount = $convertedAmount - self::$weekly_limit_amount;
                if ($finisLimit) {
                    $feeAbleAmount = $convertedAmount;
                }
                $this->fee = ($feeAbleAmount * $this->withdrawCommissionFee / 100);
            } else {
                $this->fee = ($convertedAmount * $this->withdrawCommissionFee / 100);
            }
            if (self::$limit_currency != $this->currency) {
                $this->fee = $this->exchangeRate->revert($this->fee);
            }
            $this->items[$this->weekNumber]['finish_limit'] = true;
        }
    }
}
