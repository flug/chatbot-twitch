<?php
declare(strict_types=1);

namespace App\Infrastructure\Twitch\Message;

class Parser
{
    public static function parse(string $message)
    {
        
        $partsOfMessage = explode(':', $message, 3);
        $nickname = explode('!', $partsOfMessage[1])[0];
        
        return [
            'nickname' => $nickname,
            'message' => $partsOfMessage[2],
        ];
        
    }
}
