<?php

namespace App\Calculator\ConsumptionCalculator;

use App\Calculator\AbstractCalculator;
use App\Calculator\ConsumptionUnit;
use App\Calculator\DriveType;
use App\Exception\NegativeNumberNotAllowedException;

class ConsumptionCalculator extends AbstractCalculator implements ConsumptionCalculatorInterface
{
    public function calculate(float           $distance,
                              float           $consumptionPerUnit,
                              ConsumptionUnit $unit = ConsumptionUnit::LITRES_PER_HUNDRED_KILOMETER,
                              DriveType       $driveType = DriveType::PETROL): ConsumptionCalculationInterface
    {
        if(!$this->numberValidator->isEveryNumberGreaterThanZero($distance, $consumptionPerUnit)) {
            throw new NegativeNumberNotAllowedException($distance, $consumptionPerUnit);
        }

        return (new ConsumptionCalculation())
            ->setCalculatedConsumption(($distance * $consumptionPerUnit) / 100)
            ->setDistanceCalculationBasedOn($distance)
            ->setConsumptionPerUnit($consumptionPerUnit)
            ->setConsumptionUnit($unit)
            ->setDriveType($driveType);
    }

}
