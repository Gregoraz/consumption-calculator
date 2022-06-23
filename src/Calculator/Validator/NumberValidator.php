<?php

namespace App\Calculator\Validator;

class NumberValidator
{
    /**
     * Validates if every given number is bigger than 0
     *
     * @param float ...$numbers
     * @return bool
     */
    public function isEveryNumberGreaterThanZero(float ...$numbers): bool
    {
        foreach($numbers as $number) {
            if($number <= 0) {
                return false;
            }
        }

        return true;
    }
}
