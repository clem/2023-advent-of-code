<?php

declare(strict_types=1);

namespace App\UseCase\Day202202;

use App\UseCase\DayProcessorInterface;

final class Day202202Processor implements DayProcessorInterface
{
    public function processPartOne(string $input): int
    {
        return array_sum(
            array_map(
                static function (string $round) {
                    if (empty($round)) {
                        return 0;
                    }

                    list($elfMove, $userMove) = explode(' ', $round);

                    return RockPaperScissorsGameHandler::handleRoundMoves($elfMove, $userMove);
                },
                explode("\n", $input)
            )
        );
    }

    public function processPartTwo(string $input): mixed
    {
        return array_sum(
            array_map(
                static function (string $round) {
                    if (empty($round)) {
                        return 0;
                    }

                    list($elfMove, $roundEnd) = explode(' ', $round);

                    return RockPaperScissorsGameHandler::handleRoundEnd($elfMove, $roundEnd);
                },
                explode("\n", $input)
            )
        );
    }
}
