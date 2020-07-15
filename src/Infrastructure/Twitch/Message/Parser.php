<?php

/*
 * This file is part of the Chatbot project.
 *
 * (c) Lemay Marc <flugv1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Twitch\Message;

use App\Infrastructure\Twitch\Message\Parser\Message;
use function Symfony\Component\String\u;

class Parser
{
    public static function parse(string $message): Message
    {
        $partsOfMessage = explode(':', $message, 3);
        $nickname ='';
        $command        = null;

        if(count($partsOfMessage) > 1){
                $nickname       = explode('!', $partsOfMessage[1])[0];
        }

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
