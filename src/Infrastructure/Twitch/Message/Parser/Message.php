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

namespace App\Infrastructure\Twitch\Message\Parser;

class Message
{
    private string $message;
    private string $nickname;
    private ?string $command;

    public function __construct(string $message, ?string $command, string $nickname)
    {
        $this->message  = $message;
        $this->command  = $command;
        $this->nickname = $nickname;
    }

    public function __toString()
    {
        return $this->getMessage().' '.$this->getNickname();
    }

    public function getMessage(): string
    {
        return trim($this->message);
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getCommand(): ?string
    {
        return $this->command;
    }

    public function isCommand(): bool
    {
        return null !== $this->command;
    }
}
