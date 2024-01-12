<?php
declare(strict_types=1);

namespace App\Tests\UseCase\Day08;

use App\UseCase\Day08\WastelandMap;
use App\UseCase\Day08\WastelandMapsParser;
use PHPUnit\Framework\TestCase;

class WastelandMapsParserTest extends TestCase
{
    private WastelandMapsParser $parser;

    /**
     * @dataProvider getParseData
     */
    public function testParse(string $line, array $expected): void
    {
        $this->assertEquals($expected, $this->parser->parse($line));
    }

    public static function getParseData(): iterable
    {
        yield [
            'line' => '',
            'expected' => [],
        ];

        yield [
            'line' => 'LR',
            'expected' => [],
        ];

        yield [
            'line' => 'AAA = (BBB, CCC)',
            'expected' => [
                'AAA' => new WastelandMap('AAA', 'BBB', 'CCC'),
            ],
        ];

        yield [
            'line' => 'XXH = (KVH, KSM)',
            'expected' => [
                'XXH' => new WastelandMap('XXH', 'KVH', 'KSM'),
            ],
        ];
    }

    protected function setUp(): void
    {
        $this->parser = new WastelandMapsParser();
    }
}
