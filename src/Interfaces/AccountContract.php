<?php

namespace Himelali\CommissionTask\Interfaces;

interface AccountContract
{
    public function setUserId($id);
    public function deposit($amount);
    public function withdraw($amount);
    public function getFee();
    public function setWeekNumber($number);
}
