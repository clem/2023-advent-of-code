<?php
declare(strict_types=1);

namespace App\Tests\UseCase\Day03;

use App\UseCase\Day03\Day03Processor;
use App\UseCase\DayProcessorInterface;
use PHPUnit\Framework\TestCase;

class Day03ProcessorTest extends TestCase
{
    private const string INPUT = <<<EOF
467..114..
...*......
..35..633.
......#...
617*......
.....+.58.
..592.....
......755.
...$.*....
.664.598..
EOF;


    private DayProcessorInterface $processor;

    public function testProcessPartOne(): void
    {
        $this->assertEquals(4361, $this->processor->processPartOne(self::INPUT));
    }

    public function testProcessPartTwo(): void
    {
        $this->assertEquals(467835, $this->processor->processPartTwo(self::INPUT));
    }

    protected function setUp(): void
    {
        $this->processor = new Day03Processor();
    }
}
