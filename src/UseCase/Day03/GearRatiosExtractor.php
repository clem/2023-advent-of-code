<?php

declare(strict_types=1);

namespace App\UseCase\Day03;

final class GearRatiosExtractor
{
    public function extract(string $input): array
    {
        $inputLines = explode("\n", $input);
        $lines = [];

        foreach ($inputLines as $index => $inputLine) {
            $inputLine = trim($inputLine);

            if (empty($inputLine)) {
                continue;
            }

            $lines[$index] = $this->extractLine($index, $inputLine);
        }

        return $lines;
    }

    public function extractLine(int $index, string $inputLine): array
    {
        $lineParts = $this->extractLineParts($inputLine);
        $lineContents = [];
        $lastPosX = 0;

        foreach ($lineParts as $linePart) {
            if (empty($linePart)) {
                continue;
            }

            $posX = strpos($inputLine, $linePart, $lastPosX);
            $gearInfo = $this->convertLinePartToGearInfo($linePart, $index, $posX);
            $lineContents[] = $gearInfo;
            $lastPosX = $posX + $gearInfo->size;
        }

        return $lineContents;
    }

    private function extractLineParts(string $inputLine): array
    {
        $extractedLineParts = array_filter(
            explode('.', $inputLine),
            static fn ($linePart) => !empty($linePart) && $linePart !== '.'
        );

        $lineParts = [];
        foreach ($extractedLineParts as $extractedLinePart) {
            $lineParts = array_merge($lineParts, $this->extractLinePart($extractedLinePart));
        }

        return $lineParts;
    }

    public function extractLinePart(string $extractedLinePart): array
    {
        if (ctype_digit($extractedLinePart) || strlen($extractedLinePart) === 1) {
            return [$extractedLinePart];
        }

        $numbers = $this->extractNumbersFromLinePart($extractedLinePart);
        $symbols = $this->extractSymbolsFromLinePart($extractedLinePart);

        $parts = $numbers + $symbols;
        ksort($parts);

        return $parts;
    }

    private function extractNumbersFromLinePart(string $extractedLinePart): array
    {
        return $this->extractGearInfoFromLinePart($extractedLinePart, '/(\d+)/');
    }

    private function extractSymbolsFromLinePart(string $extractedLinePart): array
    {
        return $this->extractGearInfoFromLinePart($extractedLinePart, '/([^\d|.]+)/');
    }

    private function extractGearInfoFromLinePart(string $linePart, string $pattern): array
    {
        preg_match_all($pattern, $linePart, $matches);
        $gearInfos = [];
        $lastPos = 0;

        foreach ($matches[1] as $match) {
            $pos = strpos($linePart, $match, $lastPos);
            $lastPos = $pos;

            $gearInfos[$pos] = $match;
        }

        return $gearInfos;
    }

    private function convertLinePartToGearInfo(string $linePart, int $posY, int $posX): AbstractGearInfo
    {
        if (is_numeric($linePart)) {
            return new GearNumber(
                (int) $linePart,
                $posY,
                $posX
            );
        }

        return new GearSymbol(
            $linePart,
            $posY,
            $posX
        );
    }
}
