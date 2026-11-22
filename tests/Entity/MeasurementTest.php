<?php

namespace App\Tests\Entity;

use App\Entity\Measurement;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    public static function dataGetFahrenheit(): array
    {
        return [
            ['0', '32'],
            ['-100', '-148'],
            ['100', '212'],
            ['1', '34'],
            ['-1', '30'],
            ['20', '68'],
            ['-20', '-4'],
            ['37', '99'],
            ['-40', '-40'],
            ['12', '54'],
        ];
    }

    #[DataProvider('dataGetFahrenheit')]
    public function testGetFahrenheit(string $celsius, string $expectedFahrenheit): void
    {
        $measurement = new Measurement();
        $measurement->setTemperature($celsius);

        $this->assertEquals($expectedFahrenheit, $measurement->getTemperatureInFahrenheit());
    }
}
