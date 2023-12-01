<?php

declare(strict_types=1);

namespace App\Exception;

final class DayNotFoundException extends \InvalidArgumentException
{
    public function __construct(int $day)
    {
        $message = 'Day not implemented yet!';

        if ($day < 1 || $day > 24) {
            $message = sprintf('Day `%d` does not exists in an Advent Calendar!', $day);
        }

        parent::__construct($message);
    }
}
