<?php

namespace App\Calculator;

abstract class CalculationStruct implements \JsonSerializable
{
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
