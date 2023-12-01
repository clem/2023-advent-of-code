<?php
declare(strict_types=1);

namespace App\Tests\UseCase\Day202201;

use App\UseCase\Day202201\NumbersGroupMaker;
use PHPUnit\Framework\TestCase;

class NumbersGroupMakerTest extends TestCase
{
    public function testGroupNumbers()
    {
        $input = <<<EOF
1000
2000
3000

4000

5000
6000

7000
8000
9000

10000
EOF;

        $this->assertEquals(
            [6000, 4000, 11000, 24000, 10000],
            NumbersGroupMaker::groupNumbers($input)
        );
    }
}
