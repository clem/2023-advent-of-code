<?php

declare(strict_types=1);

namespace App\UseCase\Day06;

final class ToyBoatRaceParser
{
    public function parseRacesFromInput(string $input): array
    {
        $times = $this->parseTimesFromInput($input);
        $distances = $this->parseDistancesFromInput($input);

        return $this->convertTimesAndDistancesToRaces($times, $distances);
    }

    private function parseTimesFromInput(string $input): array
    {
        return $this->parseDataFromInput($input, 'Time');
    }

    private function parseDistancesFromInput(string $input): array
    {
        return $this->parseDataFromInput($input, 'Distance');
    }

    private function parseDataFromInput(string $input, string $name): array
    {
        $lines = explode("\n", $input);
        $datasLines = array_filter(
            $lines,
            static fn($line) => str_contains($line, $name . ':')
        );

        $dataLine = array_shift($datasLines);
        $dataLine = str_replace($name.':', '', $dataLine);

        return $this->parseDataLine($dataLine);
    }

    private function parseDataLine(string $line): array
    {
        $datas = array_filter(
            explode(' ', $line),
            static fn ($data) => !empty($data)
        );

        return array_map('intval', array_values($datas));
    }

    private function convertTimesAndDistancesToRaces(array $times, array $distances): array
    {
        if (count($times) !== count($distances)) {
            throw new \RuntimeException('Times and distances must have the same length!');
        }

        $races = [];
        foreach ($times as $index => $time) {
            $races[] = new ToyBoatRace((int) $time, (int) $distances[$index]);
        }

        return $races;
    }
}
