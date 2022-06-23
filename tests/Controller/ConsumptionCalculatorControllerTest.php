<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ConsumptionCalculatorControllerTest extends WebTestCase
{
    protected KernelBrowser $client;
    protected string $calculateConsumptionPath;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->calculateConsumptionPath = '/calculator/calculate-consumption/';
    }

    public function testGetIsNotAllowed(): void
    {
        $this->client->jsonRequest('GET', $this->calculateConsumptionPath);
        $this->assertResponseStatusCodeSame(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testOnlyApplicationJsonAllowed(): void
    {
        $this->client->request('POST', $this->calculateConsumptionPath);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testNoParameters(): void
    {
        $this->client->jsonRequest('POST', $this->calculateConsumptionPath);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJson($this->client->getResponse()->getContent());
        $responseJson = json_decode($this->client->getResponse()->getContent());
        $this->assertTrue(isset($responseJson->message));
        $this->assertEquals('distance and consumptionPerUnit parameters are required', $responseJson->message);
    }

    public function testOnlyRequiredParameters(): void
    {
        $this->client->jsonRequest('POST', $this->calculateConsumptionPath,
            [
                'distance' => 230,
                'consumptionPerUnit' => 6.7
            ]
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testAllParameters(): void
    {
        $this->client->jsonRequest('POST', $this->calculateConsumptionPath,
            [
                'distance' => 230,
                'consumptionPerUnit' => 6.7,
                'consumptionUnit' => 'litres_per_hundred_kilometer',
                'driveType' => 'petrol'
            ]
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testWrongDistanceType(): void
    {
        $this->client->jsonRequest('POST', $this->calculateConsumptionPath,
            [
                'distance' => 'wrong_value',
                'consumptionPerUnit' => 6.7,
                'consumptionUnit' => 'litres_per_hundred_kilometer',
                'driveType' => 'petrol'
            ]
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testConsumptionPerUnitType(): void
    {
        $this->client->jsonRequest('POST', $this->calculateConsumptionPath,
            [
                'distance' => 230,
                'consumptionPerUnit' => 'wrong_type',
                'consumptionUnit' => 'litres_per_hundred_kilometer',
                'driveType' => 'petrol'
            ]
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testWrongConsumptionUnitEnumValue(): void
    {
        $this->client->jsonRequest('POST', $this->calculateConsumptionPath,
            [
                'distance' => 230,
                'consumptionPerUnit' => 6.7,
                'consumptionUnit' => 'invalid_enum_value',
                'driveType' => 'petrol'
            ]
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJson($this->client->getResponse()->getContent());
        $responseJson = json_decode($this->client->getResponse()->getContent());
        $this->assertTrue(isset($responseJson->message));

        //probably it's not good, to check for the message, while in the future code could be changed and the test will need to be changed as well
        $this->assertEquals(
            'Value invalid_enum_value is not valid enum type for consumptionUnit. Valid values: [litres_per_hundred_kilometer, miles_per_gallon, kilowatt_hour_per_hundred_kilometer].',
            $responseJson->message
        );
    }

    public function testWrongDriveTypeEnumValue(): void
    {
        $this->client->jsonRequest('POST', $this->calculateConsumptionPath,
            [
                'distance' => 230,
                'consumptionPerUnit' => 6.7,
                'consumptionUnit' => 'litres_per_hundred_kilometer',
                'driveType' => 'invalid_enum_value'
            ]
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJson($this->client->getResponse()->getContent());
        $responseJson = json_decode($this->client->getResponse()->getContent());
        $this->assertTrue(isset($responseJson->message));

        //probably it's not good, to check for the message, while in the future code could be changed and the test will need to be changed as well
        $this->assertEquals(
            'Value invalid_enum_value is not valid enum type for driveType. Valid values: [diesel, petrol, electric].',
            $responseJson->message
        );
    }
}
