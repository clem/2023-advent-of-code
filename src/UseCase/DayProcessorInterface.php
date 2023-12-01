<?php

declare(strict_types=1);

namespace App\UseCase;

interface DayProcessorInterface
{
    public function processPartOne(string $input): mixed;

    public function processPartTwo(string $input): mixed;
}
