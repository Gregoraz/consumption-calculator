<?php

namespace App\Calculator;

enum ConsumptionUnit: string
{
    case LITRES_PER_HUNDRED_KILOMETER = 'litres_per_hundred_kilometer';
    case MILES_PER_GALLON = 'miles_per_gallon';
    case KILOWATT_HOUR_PER_HUNDRED_KILOMETER = 'kilowatt_hour_per_hundred_kilometer';
}
