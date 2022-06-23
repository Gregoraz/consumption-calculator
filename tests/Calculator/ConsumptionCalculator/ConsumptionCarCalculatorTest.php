<?php

namespace App\Tests\Calculator\ConsumptionCalculator;

use App\Calculator\ConsumptionCalculator\ConsumptionCalculationInterface;
use App\Calculator\ConsumptionCalculator\ConsumptionCalculatorInterface;
use App\Calculator\ConsumptionCalculator\ConsumptionCarCalculatorInterface;
use App\Calculator\ConsumptionUnit;
use App\Calculator\DriveType;
use App\Car\CarFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ConsumptionCarCalculatorTest extends KernelTestCase
{
    protected ConsumptionCalculatorInterface $consumptionCalculator;
    protected ConsumptionCarCalculatorInterface $consumptionCarCalculator;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->consumptionCalculator = static::getContainer()
            ->get(ConsumptionCalculatorInterface::class);

        $this->consumptionCarCalculator = static::getContainer()
            ->get(ConsumptionCarCalculatorInterface::class);
    }

    public function testResultConsumptionCalculatorPetrolCar()
    {
        $petrolCar = CarFactory::create(
            DriveType::PETROL,
            'Audi A6 2.4',
            9,
            ConsumptionUnit::LITRES_PER_HUNDRED_KILOMETER
        );

        $carCalculation = $this->consumptionCarCalculator->calculate($petrolCar, 426);
        $calculation = $this->consumptionCalculator->calculate(
            426,
            9,
            ConsumptionUnit::LITRES_PER_HUNDRED_KILOMETER,
            DriveType::PETROL
        );

        $this->assertInstanceOf(ConsumptionCalculationInterface::class, $carCalculation);
        $this->assertInstanceOf(ConsumptionCalculationInterface::class, $calculation);
        $this->assertEquals($carCalculation->getConsumptionUnit(), $calculation->getConsumptionUnit());
        $this->assertEquals($carCalculation->getDriveType(), $calculation->getDriveType());
        $this->assertEquals($carCalculation->getDistanceCalculationBasedOn(), $calculation->getDistanceCalculationBasedOn());
        $this->assertEquals($carCalculation->getConsumptionPerUnit(), $calculation->getConsumptionPerUnit());
        $this->assertEquals($carCalculation->getCalculatedConsumption(), $calculation->getCalculatedConsumption());
    }

    public function testResultConsumptionCalculatorDieselCar()
    {
        $dieselCar = CarFactory::create(
            DriveType::DIESEL,
            'Audi A6 1.9 TDI',
            6.5,
            ConsumptionUnit::MILES_PER_GALLON
        );

        $carCalculation = $this->consumptionCarCalculator->calculate($dieselCar, 73);
        $calculation = $this->consumptionCalculator->calculate(
            73,
            6.5,
            ConsumptionUnit::MILES_PER_GALLON,
            DriveType::DIESEL
        );

        $this->assertInstanceOf(ConsumptionCalculationInterface::class, $carCalculation);
        $this->assertInstanceOf(ConsumptionCalculationInterface::class, $calculation);
        $this->assertEquals($carCalculation->getConsumptionUnit(), $calculation->getConsumptionUnit());
        $this->assertEquals($carCalculation->getDriveType(), $calculation->getDriveType());
        $this->assertEquals($carCalculation->getDistanceCalculationBasedOn(), $calculation->getDistanceCalculationBasedOn());
        $this->assertEquals($carCalculation->getConsumptionPerUnit(), $calculation->getConsumptionPerUnit());
        $this->assertEquals($carCalculation->getCalculatedConsumption(), $calculation->getCalculatedConsumption());
    }

    public function testResultConsumptionCalculatorElectricCar()
    {
        $electricCar = CarFactory::create(
            DriveType::ELECTRIC,
            'Tesla Model S',
            14.5,
            ConsumptionUnit::KILOWATT_HOUR_PER_HUNDRED_KILOMETER
        );

        $carCalculation = $this->consumptionCarCalculator->calculate($electricCar, 100);
        $calculation = $this->consumptionCalculator->calculate(
            100,
            14.5,
            ConsumptionUnit::KILOWATT_HOUR_PER_HUNDRED_KILOMETER,
            DriveType::ELECTRIC
        );

        $this->assertInstanceOf(ConsumptionCalculationInterface::class, $carCalculation);
        $this->assertInstanceOf(ConsumptionCalculationInterface::class, $calculation);
        $this->assertEquals($carCalculation->getConsumptionUnit(), $calculation->getConsumptionUnit());
        $this->assertEquals($carCalculation->getDriveType(), $calculation->getDriveType());
        $this->assertEquals($carCalculation->getDistanceCalculationBasedOn(), $calculation->getDistanceCalculationBasedOn());
        $this->assertEquals($carCalculation->getConsumptionPerUnit(), $calculation->getConsumptionPerUnit());
        $this->assertEquals($carCalculation->getCalculatedConsumption(), $calculation->getCalculatedConsumption());
    }

}
