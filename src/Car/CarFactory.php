<?php

namespace App\Car;

use App\Calculator\ConsumptionUnit;
use App\Calculator\DriveType;

final class CarFactory
{
    public static function create(DriveType $driveType,
                           string $name,
                           float $consumption,
                           ConsumptionUnit $consumptionUnit): AbstractCar
    {
        $car = match ($driveType) {
            DriveType::PETROL => new PetrolCar(),
            DriveType::DIESEL => new DieselCar(),
            DriveType::ELECTRIC => new ElectricCar()
        };

        $car
            ->setName($name)
            ->setConsumption($consumption)
            ->setConsumptionUnit($consumptionUnit);

        return $car;
    }
}
