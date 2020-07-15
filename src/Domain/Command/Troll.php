<?php
declare(strict_types=1);

namespace App\Domain\Command;

use App\Infrastructure\Twitch\Client as TwitchClient;
use App\Infrastructure\Twitch\Message\Parser\Message;

class Troll
{
    public function __construct(TwitchClient $client, Message $message)
    {
        $this->client = $client;
        $this->message = $message;
    }
    
    /**
     * @return TwitchClient
     */
    public function getClient(): TwitchClient
    {
        return $this->client;
    }
    
    /**
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
    }
}
