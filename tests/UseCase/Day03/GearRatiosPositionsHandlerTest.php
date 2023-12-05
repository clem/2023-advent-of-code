<?php
declare(strict_types=1);

namespace App\Tests\UseCase\Day03;

use App\UseCase\Day03\GearNumber;
use App\UseCase\Day03\GearRatiosPositionsHandler;
use App\UseCase\Day03\GearSymbol;
use PHPUnit\Framework\TestCase;

class GearRatiosPositionsHandlerTest extends TestCase
{
    /**
     * @dataProvider provideGearRatios
     */
    public function testNumberIsAdjacentToSymbol(GearNumber $number, GearSymbol $symbol): void
    {
        $this->assertTrue(GearRatiosPositionsHandler::isNumberAdjacentToSymbol($number, $symbol));
    }

    public static function provideGearRatios(): iterable
    {
        yield [
            'number' => new GearNumber(467, 0, 0),
            'symbol' => new GearSymbol('*', 1, 3),
        ];

        yield [
            'number' => new GearNumber(35, 2, 2),
            'symbol' => new GearSymbol('*', 1, 3),
        ];

        yield [
            'number' => new GearNumber(633, 2, 6),
            'symbol' => new GearSymbol('#', 3, 6),
        ];

        yield [
            'number' => new GearNumber(617, 4, 0),
            'symbol' => new GearSymbol('*', 4, 3),
        ];
    }
}
