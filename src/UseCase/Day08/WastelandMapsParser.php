<?php

declare(strict_types=1);

namespace App\UseCase\Day08;

final class WastelandMapsParser
{
    public function parse(string $input): array
    {
        $lines = explode("\n", $input);

        $maps = [];
        foreach ($lines as $line) {
            if (empty($line) || !str_contains($line, '=')) {
                continue;
            }

            $map = $this->parseLine($line);
            $maps[$map->start] = $map;
        }

        return $maps;
    }

    private function parseLine(string $line): WastelandMap
    {
        $line = str_replace(' ', '', $line);
        list($start, $directions) = explode('=', $line);

        $directions = str_replace(['(', ')'], '', $directions);
        list($left, $right) = explode(',', $directions);

        return new WastelandMap($start, $left, $right);
    }
}
