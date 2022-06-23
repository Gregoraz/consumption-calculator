<?php

namespace App\Tests\Calculator\ConsumptionCalculator;

use App\Calculator\ConsumptionCalculator\ConsumptionCalculationInterface;
use App\Calculator\ConsumptionCalculator\ConsumptionCalculatorInterface;
use App\Calculator\ConsumptionUnit;
use App\Calculator\DriveType;
use App\Exception\NegativeNumberNotAllowedException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ConsumptionCalculatorTest extends KernelTestCase
{
    protected ConsumptionCalculatorInterface $consumptionCalculator;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->consumptionCalculator = static::getContainer()
            ->get(ConsumptionCalculatorInterface::class);
    }

    public function testNegativeInputForCalculator()
    {
        $this->expectException(NegativeNumberNotAllowedException::class);
        $this->consumptionCalculator->calculate(-15.34, -4.65);
    }

    public function testCalculatePetrolConsumptionFor100Kilometers()
    {
        $result = $this->consumptionCalculator->calculate(100, 6.8);

        $this->assertInstanceOf(ConsumptionCalculationInterface::class, $result);

        $this->assertEquals(6.8, $result->getCalculatedConsumption());
        $this->assertEquals(100, $result->getDistanceCalculationBasedOn());
        $this->assertEquals(6.8, $result->getConsumptionPerUnit());
        $this->assertEquals(ConsumptionUnit::LITRES_PER_HUNDRED_KILOMETER, $result->getConsumptionUnit());
        $this->assertEquals(DriveType::PETROL, $result->getDriveType());
    }

    public function testCalculatePetrolConsumptionFor70Kilometers()
    {
        $result = $this->consumptionCalculator->calculate(70, 6.8);

        $this->assertInstanceOf(ConsumptionCalculationInterface::class, $result);

        $this->assertEquals(4.76, $result->getCalculatedConsumption());
        $this->assertEquals(70, $result->getDistanceCalculationBasedOn());
        $this->assertEquals(6.8, $result->getConsumptionPerUnit());
        $this->assertEquals(ConsumptionUnit::LITRES_PER_HUNDRED_KILOMETER, $result->getConsumptionUnit());
        $this->assertEquals(DriveType::PETROL, $result->getDriveType());
    }

    public function testCalculatePetrolConsumptionFor480Kilometers()
    {
        $result = $this->consumptionCalculator->calculate(480, 6.8);

        $this->assertInstanceOf(ConsumptionCalculationInterface::class, $result);

        $this->assertEquals(32.64, $result->getCalculatedConsumption());
        $this->assertEquals(480, $result->getDistanceCalculationBasedOn());
        $this->assertEquals(6.8, $result->getConsumptionPerUnit());
        $this->assertEquals(ConsumptionUnit::LITRES_PER_HUNDRED_KILOMETER, $result->getConsumptionUnit());
        $this->assertEquals(DriveType::PETROL, $result->getDriveType());
    }

    public function testCalculateDieselConsumptionFor100Miles()
    {
        $result = $this->consumptionCalculator->calculate(100, 11.76, ConsumptionUnit::MILES_PER_GALLON, DriveType::DIESEL);

        $this->assertInstanceOf(ConsumptionCalculationInterface::class, $result);

        $this->assertEquals(11.76, $result->getCalculatedConsumption());
        $this->assertEquals(100, $result->getDistanceCalculationBasedOn());
        $this->assertEquals(11.76, $result->getConsumptionPerUnit());
        $this->assertEquals(DriveType::DIESEL, $result->getDriveType());
        $this->assertEquals(ConsumptionUnit::MILES_PER_GALLON, $result->getConsumptionUnit());
    }

    public function testCalculateDieselConsumptionFor70Miles()
    {
        $result = $this->consumptionCalculator->calculate(70, 11.76, ConsumptionUnit::MILES_PER_GALLON, DriveType::DIESEL);

        $this->assertInstanceOf(ConsumptionCalculationInterface::class, $result);

        $this->assertEquals(8.232, $result->getCalculatedConsumption());
        $this->assertEquals(70, $result->getDistanceCalculationBasedOn());
        $this->assertEquals(11.76, $result->getConsumptionPerUnit());
        $this->assertEquals(DriveType::DIESEL, $result->getDriveType());
        $this->assertEquals(ConsumptionUnit::MILES_PER_GALLON, $result->getConsumptionUnit());
    }

    public function testCalculateDieselConsumptionFor480Miles()
    {
        $result = $this->consumptionCalculator->calculate(480, 11.76, ConsumptionUnit::MILES_PER_GALLON, DriveType::DIESEL);

        $this->assertInstanceOf(ConsumptionCalculationInterface::class, $result);

        $this->assertEquals(56.448, $result->getCalculatedConsumption());
        $this->assertEquals(480, $result->getDistanceCalculationBasedOn());
        $this->assertEquals(11.76, $result->getConsumptionPerUnit());
        $this->assertEquals(DriveType::DIESEL, $result->getDriveType());
        $this->assertEquals(ConsumptionUnit::MILES_PER_GALLON, $result->getConsumptionUnit());
    }

    public function testCalculateElectricConsumptionFor100Kilometers()
    {
        $result = $this->consumptionCalculator->calculate(100, 17.5, ConsumptionUnit::KILOWATT_HOUR_PER_HUNDRED_KILOMETER, DriveType::ELECTRIC);

        $this->assertInstanceOf(ConsumptionCalculationInterface::class, $result);

        $this->assertEquals(17.5, $result->getCalculatedConsumption());
        $this->assertEquals(100, $result->getDistanceCalculationBasedOn());
        $this->assertEquals(17.5, $result->getConsumptionPerUnit());
        $this->assertEquals(DriveType::ELECTRIC, $result->getDriveType());
        $this->assertEquals(ConsumptionUnit::KILOWATT_HOUR_PER_HUNDRED_KILOMETER, $result->getConsumptionUnit());
    }

    public function testCalculateElectricConsumptionFor70Kilometers()
    {
        $result = $this->consumptionCalculator->calculate(70, 17.5, ConsumptionUnit::KILOWATT_HOUR_PER_HUNDRED_KILOMETER, DriveType::ELECTRIC);

        $this->assertInstanceOf(ConsumptionCalculationInterface::class, $result);

        $this->assertEquals(12.25, $result->getCalculatedConsumption());
        $this->assertEquals(70, $result->getDistanceCalculationBasedOn());
        $this->assertEquals(17.5, $result->getConsumptionPerUnit());
        $this->assertEquals(DriveType::ELECTRIC, $result->getDriveType());
        $this->assertEquals(ConsumptionUnit::KILOWATT_HOUR_PER_HUNDRED_KILOMETER, $result->getConsumptionUnit());
    }

    public function testCalculateElectricConsumptionFor480Kilometers()
    {
        $result = $this->consumptionCalculator->calculate(480, 17.5, ConsumptionUnit::KILOWATT_HOUR_PER_HUNDRED_KILOMETER, DriveType::ELECTRIC);

        $this->assertInstanceOf(ConsumptionCalculationInterface::class, $result);

        $this->assertEquals(84, $result->getCalculatedConsumption());
        $this->assertEquals(480, $result->getDistanceCalculationBasedOn());
        $this->assertEquals(17.5, $result->getConsumptionPerUnit());
        $this->assertEquals(DriveType::ELECTRIC, $result->getDriveType());
        $this->assertEquals(ConsumptionUnit::KILOWATT_HOUR_PER_HUNDRED_KILOMETER, $result->getConsumptionUnit());
    }
}
