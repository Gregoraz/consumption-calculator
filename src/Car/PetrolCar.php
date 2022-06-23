<?php

namespace App\Car;

use App\Calculator\DriveType;

class PetrolCar extends AbstractCar
{
    public function __construct()
    {
        $this->driveType = DriveType::PETROL;
    }
}
