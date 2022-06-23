<?php

namespace App\Car;

use App\Calculator\ConsumptionUnit;
use App\Calculator\DriveType;

interface CarInterface
{
    public function getName(): string;
    public function getConsumption(): float;
    public function getConsumptionUnit(): ConsumptionUnit;
    public function getDriveType(): DriveType;
}
