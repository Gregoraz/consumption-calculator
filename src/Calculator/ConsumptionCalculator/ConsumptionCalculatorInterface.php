<?php

namespace App\Calculator\ConsumptionCalculator;

use App\Calculator\ConsumptionUnit;
use App\Calculator\DriveType;
use App\Exception\NegativeNumberNotAllowedException;

interface ConsumptionCalculatorInterface
{
    /**
     * Calculates consumption for a specific distance,
     * distance, consumptionPerUnit are required
     * unit, driveType are optional
     *
     * @throws NegativeNumberNotAllowedException
     */
    public function calculate(
        float                                      $distance,
        float                                      $consumptionPerUnit,
        ConsumptionUnit $unit = ConsumptionUnit::LITRES_PER_HUNDRED_KILOMETER,
        DriveType       $driveType = DriveType::PETROL
    ): ConsumptionCalculationInterface;
}
