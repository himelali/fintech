<?php

namespace Himelali\CommissionTask\Interfaces;

interface ParseContract
{
    public function parse($file);

    public function getJson();

    public function getArray();

    public function getObject();
}