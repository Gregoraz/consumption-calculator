<?php

namespace App\Car;

use App\Calculator\DriveType;

class DieselCar extends AbstractCar
{
    public function __construct()
    {
        $this->driveType = DriveType::DIESEL;
    }
}
