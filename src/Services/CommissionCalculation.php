<?php

namespace Himelali\CommissionTask\Services;

use DateInterval;
use DatePeriod;
use DateTime;
use Himelali\CommissionTask\Clients\BusinessClient;
use Himelali\CommissionTask\Clients\PrivateClient;
use Himelali\CommissionTask\Interfaces\ParseContract;
use Himelali\CommissionTask\Repositories\ExchangeRate;

class CommissionCalculation
{
    private $data;
    private $result;
    private $weeks;

    /**
     * @throws \Exception
     */
    public function __construct(ParseContract $parser, $file)
    {
        $parser->parse($file);
        $this->data = $parser->getObject();
        $this->generateWeekNumber();
    }

    public function calculate()
    {
        $exchange = new ExchangeRate();
        $exchange->pull();
        $businessClient = new BusinessClient($exchange);
        $privateClient = new PrivateClient($exchange);

        foreach ($this->data as $item) {
            if ($item->client == 'private') {
                $client = $privateClient;
            } else {
                $client = $businessClient;
            }
            $client->setUserId($item->user_id);
            $client->setWeekNumber($this->weeks[$item->date]);
            $client->setCurrency($item->currency);
            $client->{$item->type}($item->amount);
            $this->result[] = $client->getFee();
        }
    }

    public function output()
    {
        return $this->result;
    }

    private function generateWeekNumber()
    {
        $dates = [];
        foreach ($this->data as $item) {
            $dates[] = $item->date;
        }
        $dates = array_unique($dates);
        sort($dates);
        $interval = new DateInterval('P1D');
        $realEnd = new DateTime(end($dates));
        $realEnd->add($interval);
        $period = new DatePeriod(
            new DateTime($dates[0]),
            $interval,
            $realEnd
        );
        $start = 1;
        foreach ($period as $key => $value) {
            if ($value->format('w') == 1 && $key>0) {
                $start += 1;
            }
            $this->weeks[$value->format('Y-m-d')] = $start;
        }
    }
}
