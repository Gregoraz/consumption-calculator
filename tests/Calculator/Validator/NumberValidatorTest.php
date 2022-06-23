<?php

namespace App\Tests\Calculator\Validator;

use App\Calculator\Validator\NumberValidator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NumberValidatorTest extends KernelTestCase
{
    protected NumberValidator $numberValidator;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->numberValidator = static::getContainer()
            ->get(NumberValidator::class);
    }

    public function testNumberGreaterThanZero()
    {
        $this->assertFalse($this->numberValidator->isEveryNumberGreaterThanZero(-5));
        $this->assertFalse($this->numberValidator->isEveryNumberGreaterThanZero(0));
        $this->assertFalse($this->numberValidator->isEveryNumberGreaterThanZero(5, -4));
        $this->assertFalse($this->numberValidator->isEveryNumberGreaterThanZero(5, 5, -4));
        $this->assertFalse($this->numberValidator->isEveryNumberGreaterThanZero(-5, 5, -4));
        $this->assertFalse($this->numberValidator->isEveryNumberGreaterThanZero(5, 0, 4));

        $this->assertTrue($this->numberValidator->isEveryNumberGreaterThanZero(5));
        $this->assertTrue($this->numberValidator->isEveryNumberGreaterThanZero(2, 4));
        $this->assertTrue($this->numberValidator->isEveryNumberGreaterThanZero(2, 6, 8));
    }


}
