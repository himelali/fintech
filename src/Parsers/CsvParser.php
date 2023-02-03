<?php

namespace Himelali\CommissionTask\Parsers;

use Himelali\CommissionTask\Interfaces\ParseContract;

class CsvParser implements ParseContract
{
    private $data = [];
    public function parse($file)
    {
        try {
            $handle = fopen($file, 'r');
            for ($i = 0; $row = fgetcsv($handle); ++$i) {
                $this->data[] = [
                    'date' => $row[0] ?? null,
                    'user_id' => $row[1] ?? null,
                    'client' => $row[2] ?? null,
                    'type' => $row[3] ?? null,
                    'amount' => $row[4] ?? null,
                    'currency' => $row[5] ?? null
                ];
            }
            fclose($handle);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getJson()
    {
        return json_encode($this->data);
    }

    public function getArray()
    {
        return $this->data;
    }

    public function getObject()
    {
        return json_decode($this->getJson());
    }
}