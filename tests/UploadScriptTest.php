<?php

use Himelali\CommissionTask\Parsers\CsvParser;
use Himelali\CommissionTask\Services\CommissionCalculation;
use PHPUnit\Framework\TestCase;

class UploadScriptTest extends TestCase
{
    /** @test */
    public function user_should_be_able_to_upload_csv_file()
    {
        $name = __DIR__.'/../input.csv';
        $service = new CommissionCalculation(new CsvParser, $name);
        $service->calculate();
        $result = $service->output();
        $this->assertEquals([0.6,3,0,0.06,1.5,0,0,0.3,0.3,3,3.00,0.00,8607.4], $result);
    }
}
