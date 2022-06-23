<?php

namespace App\Car;

use App\Calculator\ConsumptionUnit;
use App\Calculator\DriveType;

abstract class AbstractCar implements CarInterface
{
    protected string $name;
    protected float $consumption;
    protected ConsumptionUnit $consumptionUnit;
    protected DriveType $driveType;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getConsumption(): float
    {
        return $this->consumption;
    }

    public function setConsumption(float $consumption): self
    {
        $this->consumption = $consumption;
        return $this;
    }

    public function getConsumptionUnit(): ConsumptionUnit
    {
        return $this->consumptionUnit;
    }

    public function setConsumptionUnit(ConsumptionUnit $consumptionUnit): self
    {
        $this->consumptionUnit = $consumptionUnit;
        return $this;
    }

    public function getDriveType(): DriveType
    {
        return $this->driveType;
    }
}
