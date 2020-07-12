<?php

declare(strict_types=1);

namespace App\Domain\Command;

use App\Infrastructure\Twitch\Client as TwitchClient;
use App\Infrastructure\Twitch\Message\Parser\Message;

class Random
{
    private TwitchClient $client;

    private Message $message;

    public function __construct(TwitchClient $client, Message $message)
    {
        $this->client  = $client;
        $this->message = $message;
    }

    public function getClient(): TwitchClient
    {
        return $this->client;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }
}
