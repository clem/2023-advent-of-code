<?php

declare(strict_types=1);

namespace App\UseCase\Day08;

final class WastelandSequenceHandler
{
    private array $sequence;

    public function parse(string $input): array
    {
        $lines = explode("\n", $input);
        $sequenceLine = array_shift($lines);
        unset($lines);

        $this->sequence = $this->parseSequence($sequenceLine);

        return $this->sequence;
    }

    public function getDirectionAtIndex(int $index): string
    {
        if (isset($this->sequence[$index])) {
            return $this->sequence[$index];
        }

        $predictedIndex = $index % count($this->sequence);

        return $this->sequence[$predictedIndex];
    }

    private function parseSequence(string $line): array
    {
        if (empty($line) || preg_replace('/L*R*/', '', $line) !== '') {
            return [];
        }

        return str_split($line);
    }
}
