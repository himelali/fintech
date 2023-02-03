<?php

use Himelali\CommissionTask\Exceptions\NotFoundException;
use Himelali\CommissionTask\Parsers\CsvParser;
use Himelali\CommissionTask\Services\CommissionCalculation;

require __DIR__.'/vendor/autoload.php';

$name = $argv[1] ?? null;
$path = __DIR__.'/'.$name;

if (is_null($name) || !file_exists($path)) {
    throw new NotFoundException($name);
}

$service = new CommissionCalculation(new CsvParser, $name);
$service->calculate();
$result = $service->output();

foreach ($result as $item) {
    echo $item.PHP_EOL;
}
