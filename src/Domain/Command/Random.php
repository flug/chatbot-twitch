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
