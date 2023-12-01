<?php

declare(strict_types=1);

namespace App\UseCase\Day202201;

final class NumbersGroupMaker
{
    public static function groupNumbers(string $numbersInput, string $groupSeparator = "\n\n"): array
    {
        return array_map(
            static fn (string $elfCalories) => array_sum(
                array_map('intval', explode("\n", $elfCalories))
            ),
            explode($groupSeparator, $numbersInput)
        );
    }
}
