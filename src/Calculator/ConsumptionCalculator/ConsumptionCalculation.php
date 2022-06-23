<?php

namespace App\Calculator\ConsumptionCalculator;

use App\Calculator\CalculationStruct;
use App\Calculator\ConsumptionUnit;
use App\Calculator\DriveType;

class ConsumptionCalculation extends CalculationStruct implements ConsumptionCalculationInterface
{
    protected float $calculatedConsumption;
    protected float $distanceCalculationBasedOn;
    protected ConsumptionUnit $consumptionUnit;
    protected float $consumptionPerUnit;
    protected DriveType $driveType;

    public function getCalculatedConsumption(): float
    {
        return $this->calculatedConsumption;
    }

    public function setCalculatedConsumption(float $calculatedConsumption): self
    {
        $this->calculatedConsumption = $calculatedConsumption;
        return $this;
    }

    public function getDistanceCalculationBasedOn(): float
    {
        return $this->distanceCalculationBasedOn;
    }

    public function setDistanceCalculationBasedOn(float $distanceCalculationBasedOn): self
    {
        $this->distanceCalculationBasedOn = $distanceCalculationBasedOn;
        return $this;
    }

    /**
     * @return ConsumptionUnit
     */
    public function getConsumptionUnit(): ConsumptionUnit
    {
        return $this->consumptionUnit;
    }

    public function setConsumptionUnit(ConsumptionUnit $consumptionUnit): self
    {
        $this->consumptionUnit = $consumptionUnit;
        return $this;
    }

    public function getConsumptionPerUnit(): float
    {
        return $this->consumptionPerUnit;
    }

    public function setConsumptionPerUnit(float $consumptionPerUnit): self
    {
        $this->consumptionPerUnit = $consumptionPerUnit;
        return $this;
    }

    public function getDriveType(): DriveType
    {
        return $this->driveType;
    }

    public function setDriveType(DriveType $driveType): self
    {
        $this->driveType = $driveType;
        return $this;
    }
}
