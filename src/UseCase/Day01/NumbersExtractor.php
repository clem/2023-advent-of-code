<?php

declare(strict_types=1);

namespace App\UseCase\Day01;

final class NumbersExtractor
{
    public static function extractFirstAndLastNumbersFromString(string $input): int
    {
        if (empty($input)) {
            return 0;
        }

        $numbers = filter_var($input, FILTER_SANITIZE_NUMBER_INT);

        return $numbers[0] * 10 + $numbers[strlen($numbers) - 1];
    }
}
