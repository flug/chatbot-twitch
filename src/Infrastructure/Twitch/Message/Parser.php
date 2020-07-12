<?php

declare(strict_types=1);

namespace App\Infrastructure\Twitch\Message;

use App\Infrastructure\Twitch\Message\Parser\Message;
use function Symfony\Component\String\u;

class Parser
{
    public static function parse(string $message): Message
    {
        $partsOfMessage = explode(':', $message, 3);
        $nickname       = explode('!', $partsOfMessage[1])[0];
        $command        = null;
        if ('!' === $partsOfMessage[2][0]) {
            $command = self::parseCommand($partsOfMessage[2]);
        }

        return new Message(
            $partsOfMessage[2],
            $command,
            $nickname
        );
    }

    private static function parseCommand(string $message)
    {
        $cmd = explode(' ', substr($message, 1));

        return (string) u($cmd[0])->camel()->title();
    }
}
