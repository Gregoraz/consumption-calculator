<?php

namespace App\Calculator\ConsumptionCalculator;

use App\Car\CarInterface;
use App\Exception\NegativeNumberNotAllowedException;

interface ConsumptionCarCalculatorInterface
{
    /**
     *  Calculates consumption of specific car for a specific distance
     *
     * @throws NegativeNumberNotAllowedException
     */
    public function calculate(CarInterface $car, float $distance): ConsumptionCalculationInterface;
}
