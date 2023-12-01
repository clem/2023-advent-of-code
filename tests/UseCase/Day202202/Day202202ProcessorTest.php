<?php
declare(strict_types=1);

namespace App\Tests\UseCase\Day202202;

use App\UseCase\Day202202\Day202202Processor;
use App\UseCase\DayProcessorInterface;
use PHPUnit\Framework\TestCase;

class Day202202ProcessorTest extends TestCase
{
    private DayProcessorInterface $processor;

    public function testProcessPartTwo(): void
    {
        $input = <<<EOF
A Y
B X
C Z
EOF;

        $this->assertEquals(15, $this->processor->processPartOne($input));
    }

    public function testProcessPartOne(): void
    {

        $input = <<<EOF
A Y
B X
C Z
EOF;

        $this->assertEquals(12, $this->processor->processPartTwo($input));
    }

    protected function setUp(): void
    {
        $this->processor = new Day202202Processor();
    }
}
