<?php

declare(strict_types=1);

namespace App\UseCase\Day202201;

use App\UseCase\DayProcessorInterface;

final class Day202201Processor implements DayProcessorInterface
{
    public function processPartOne(string $input): int
    {
        return max($this->getElvesCalories($input));
    }

    public function processPartTwo(string $input): int
    {
        $elvesCalories = $this->getElvesCalories($input);

        rsort($elvesCalories);

        return array_sum(array_splice($elvesCalories, 0, 3));
    }

    /**
     * @return int[]
     */
    private function getElvesCalories(string $input): array
    {
        return NumbersGroupMaker::groupNumbers($input);
    }
}
