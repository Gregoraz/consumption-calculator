<?php

namespace App\Tests\Car;

use App\Calculator\ConsumptionUnit;
use App\Calculator\DriveType;
use App\Car\CarFactory;
use App\Car\DieselCar;
use App\Car\ElectricCar;
use App\Car\PetrolCar;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CarFactoryTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
    }

    public function testPetrolType(): void
    {
        $petrolCar = CarFactory::create(
            DriveType::PETROL,
            'Petrol Car',
            7,
            ConsumptionUnit::LITRES_PER_HUNDRED_KILOMETER
        );

        $this->assertInstanceOf(PetrolCar::class, $petrolCar);
        $this->assertEquals('Petrol Car', $petrolCar->getName());
        $this->assertEquals(7, $petrolCar->getConsumption());
        $this->assertInstanceOf(ConsumptionUnit::class, $petrolCar->getConsumptionUnit());
        $this->assertEquals(ConsumptionUnit::LITRES_PER_HUNDRED_KILOMETER, $petrolCar->getConsumptionUnit());
    }

    public function testDieselType(): void
    {
        $dieselCar = CarFactory::create(
            DriveType::DIESEL,
            'Diesel Car',
            8,
            ConsumptionUnit::MILES_PER_GALLON
        );

        $this->assertInstanceOf(DieselCar::class, $dieselCar);
        $this->assertEquals('Diesel Car', $dieselCar->getName());
        $this->assertEquals(8, $dieselCar->getConsumption());
        $this->assertInstanceOf(ConsumptionUnit::class, $dieselCar->getConsumptionUnit());
        $this->assertEquals(ConsumptionUnit::MILES_PER_GALLON, $dieselCar->getConsumptionUnit());
    }

    public function testElectricType(): void
    {
        $electricCar = CarFactory::create(
            DriveType::ELECTRIC,
            'Electric Car',
            14.5,
            ConsumptionUnit::KILOWATT_HOUR_PER_HUNDRED_KILOMETER
        );

        $this->assertInstanceOf(ElectricCar::class, $electricCar);
        $this->assertEquals('Electric Car', $electricCar->getName());
        $this->assertEquals(14.5, $electricCar->getConsumption());
        $this->assertInstanceOf(ConsumptionUnit::class, $electricCar->getConsumptionUnit());
        $this->assertEquals(ConsumptionUnit::KILOWATT_HOUR_PER_HUNDRED_KILOMETER, $electricCar->getConsumptionUnit());
    }
}
