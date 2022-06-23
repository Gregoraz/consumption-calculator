<?php

namespace App\Calculator\ConsumptionCalculator;

use App\Calculator\ConsumptionUnit;
use App\Calculator\DriveType;

interface ConsumptionCalculationInterface
{
    /**
     * Gets calculation from the calculator of consumption
     * @return float
     */
    public function getCalculatedConsumption(): float;

    /**
     * Gets the distance used for the calculation
     * @return float
     */
    public function getDistanceCalculationBasedOn(): float;

    /**
     * Gets consumption unit enum type used for the calculation
     * @return ConsumptionUnit
     */
    public function getConsumptionUnit(): ConsumptionUnit;

    /**
     * Gets the consumption per unit, used for the calculation
     * @return float
     */
    public function getConsumptionPerUnit(): float;

    /**
     * Gets drive type enum type, used for the calculation
     * @return DriveType
     */
    public function getDriveType(): DriveType;
}
