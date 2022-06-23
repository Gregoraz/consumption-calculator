<?php

namespace App\Calculator\ConsumptionCalculator;

use App\Calculator\AbstractCalculator;
use App\Calculator\Validator\NumberValidator;
use App\Car\CarInterface;

class ConsumptionCarCalculator extends AbstractCalculator implements ConsumptionCarCalculatorInterface
{
    public function __construct(
        NumberValidator $numberValidator,
        protected ConsumptionCalculatorInterface $consumptionCalculator
    ){
        parent::__construct($numberValidator);
    }

    public function calculate(CarInterface $car, float $distance): ConsumptionCalculationInterface
    {
        return $this->consumptionCalculator->calculate(
            $distance,
            $car->getConsumption(),
            $car->getConsumptionUnit(),
            $car->getDriveType()
        );
    }
}
