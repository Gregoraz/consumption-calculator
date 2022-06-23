<?php

namespace App\Car;

use App\Calculator\DriveType;

class ElectricCar extends AbstractCar
{
    public function __construct()
    {
        $this->driveType = DriveType::ELECTRIC;
    }
}
