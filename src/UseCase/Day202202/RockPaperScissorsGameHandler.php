<?php

declare(strict_types=1);

namespace App\UseCase\Day202202;

final class RockPaperScissorsGameHandler
{
    public static function handleRoundMoves(string $elfMove, string $userMove): int
    {
        if (self::isRoundDraw($userMove, $elfMove)) {
            return RockPaperScissorsGame::SCORE_DRAW + self::getMoveScore($userMove);
        }

        if ($userMove === RockPaperScissorsGame::USER_ROCK) {
            return RockPaperScissorsGame::SCORE_ROCK +
                ($elfMove === RockPaperScissorsGame::ELF_SCISSORS
                    ? RockPaperScissorsGame::SCORE_WIN
                    : RockPaperScissorsGame::SCORE_LOSE);
        }

        if ($userMove === RockPaperScissorsGame::USER_PAPER) {
            return RockPaperScissorsGame::SCORE_PAPER +
                ($elfMove === RockPaperScissorsGame::ELF_ROCK
                    ? RockPaperScissorsGame::SCORE_WIN
                    : RockPaperScissorsGame::SCORE_LOSE);
        }

        if ($userMove === RockPaperScissorsGame::USER_SCISSORS) {
            return RockPaperScissorsGame::SCORE_SCISSORS +
                ($elfMove === RockPaperScissorsGame::ELF_PAPER
                        ? RockPaperScissorsGame::SCORE_WIN
                        : RockPaperScissorsGame::SCORE_LOSE);
        }

        throw new \InvalidArgumentException('Invalid move!');
    }

    public static function handleRoundEnd(string $elfMove, string $roundEnd): int
    {
        return match (true) {
            $roundEnd === RockPaperScissorsGame::END_LOSE
                => self::handleRoundMoves($elfMove, self::getLosingMoveOver($elfMove)),
            $roundEnd === RockPaperScissorsGame::END_DRAW
                => self::handleRoundMoves($elfMove, self::getDrawMoveOver($elfMove)),
            $roundEnd === RockPaperScissorsGame::END_WIN
                => self::handleRoundMoves($elfMove, self::getWinningMoveOver($elfMove)),
            default => throw new \InvalidArgumentException('Invalid round end'),
        };
    }

    private static function isRoundDraw(string $userMove, string $elfMove): bool
    {
        return ($userMove === RockPaperScissorsGame::USER_ROCK && $elfMove === RockPaperScissorsGame::ELF_ROCK)
            || ($userMove === RockPaperScissorsGame::USER_PAPER && $elfMove === RockPaperScissorsGame::ELF_PAPER)
            || ($userMove === RockPaperScissorsGame::USER_SCISSORS && $elfMove === RockPaperScissorsGame::ELF_SCISSORS)
        ;
    }

    private static function getMoveScore(string $move): int
    {
        return match (true) {
            self::isMoveRock($move) => RockPaperScissorsGame::SCORE_ROCK,
            self::isMovePaper($move) => RockPaperScissorsGame::SCORE_PAPER,
            self::isMoveScissors($move) => RockPaperScissorsGame::SCORE_SCISSORS,
            default => throw new \InvalidArgumentException('Invalid move!'),
        };
    }

    private static function isMoveRock(string $move): bool
    {
        return $move === RockPaperScissorsGame::USER_ROCK || $move === RockPaperScissorsGame::ELF_ROCK;
    }

    private static function isMovePaper(string $move): bool
    {
        return $move === RockPaperScissorsGame::USER_PAPER || $move === RockPaperScissorsGame::ELF_PAPER;
    }

    private static function isMoveScissors(string $move): bool
    {
        return $move === RockPaperScissorsGame::USER_SCISSORS || $move === RockPaperScissorsGame::ELF_SCISSORS;
    }

    private static function getLosingMoveOver(string $move): string
    {
        return match (true) {
            self::isMoveRock($move) => RockPaperScissorsGame::USER_SCISSORS,
            self::isMovePaper($move) => RockPaperScissorsGame::USER_ROCK,
            self::isMoveScissors($move) => RockPaperScissorsGame::USER_PAPER,
            default => throw new \InvalidArgumentException('Invalid move!'),
        };
    }

    private static function getDrawMoveOver(string $move): string
    {
        return match (true) {
            self::isMoveRock($move) => RockPaperScissorsGame::USER_ROCK,
            self::isMovePaper($move) => RockPaperScissorsGame::USER_PAPER,
            self::isMoveScissors($move) => RockPaperScissorsGame::USER_SCISSORS,
            default => throw new \InvalidArgumentException('Invalid move!'),
        };
    }

    private static function getWinningMoveOver(string $move): string
    {
        return match (true) {
            self::isMoveRock($move) => RockPaperScissorsGame::USER_PAPER,
            self::isMovePaper($move) => RockPaperScissorsGame::USER_SCISSORS,
            self::isMoveScissors($move) => RockPaperScissorsGame::USER_ROCK,
            default => throw new \InvalidArgumentException('Invalid move!'),
        };
    }
}
