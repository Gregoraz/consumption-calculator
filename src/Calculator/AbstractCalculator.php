<?php

namespace App\Calculator;

use App\Calculator\Validator\NumberValidator;

abstract class AbstractCalculator
{
    public function __construct(
        protected NumberValidator $numberValidator
    ){}
}
