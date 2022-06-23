<?php

namespace App\Exception;

class NegativeNumberNotAllowedException extends \Exception
{
    public function __construct(float ...$number)
    {
        parent::__construct(
            sprintf('Number has to be bigger than 0. Got: [%s]', implode(', ', $number)),
            400
        );
    }
}
