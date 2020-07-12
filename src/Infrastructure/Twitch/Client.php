<?php

declare(strict_types=1);

namespace App\Infrastructure\Twitch;

use App\Infrastructure\Twitch\Exception\ConnectionFailedException;
use App\Infrastructure\Twitch\Message\Parser;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Client
{
    public const PING             = 'PING';
    public const PRIVATE_MESSAGE  = 'PRIVMSG';
    private const TWITCH_IRC_URI  = 'irc.chat.twitch.tv';
    private const TWITCH_IRC_PORT = 6667;
    /** @see https://discuss.dev.twitch.tv/t/missing-client-side-message-length-check/21316 */
    private const MAX_LINE = 512;
    private $socket;
    private LoggerInterface $logger;
    private string $nickname;
    private ?string $message;

    public function __construct(string $oauth, string $nickname)
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (false === socket_connect($this->socket, self::TWITCH_IRC_URI, self::TWITCH_IRC_PORT)) {
            throw new ConnectionFailedException();
        }
        $this->logger   = new NullLogger();
        $this->nickname = $nickname;
        $this->authentication($oauth, $nickname);
    }

    public function addLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    public function ping(): void
    {
        $this->send(sprintf('PING :tmi.twitch.tv'));
    }

    public function pong(): void
    {
        $this->send(sprintf('PONG :tmi.twitch.tv'));
    }

    public function isCommandType(string $commandType): bool
    {
        return (bool) strstr($this->message, $commandType);
    }

    public function sendMessage(string $message): void
    {
        $this->send(strtr('PRIVMSG #<channel> :<message>', [
            '<channel>' => $this->nickname,
            '<message>' => $message,
        ]));
    }

    public function send(string $message): void
    {
        if (!$this->isConnected()) {
            throw new ConnectionFailedException();
        }
        $this->logger->info('send octets '.socket_write($this->socket, $message." \r\n"));
    }

    public function read(): Parser\Message
    {
        if (!$this->isConnected()) {
            throw new ConnectionFailedException();
        }
        $receive = socket_read($this->socket, self::MAX_LINE);
        $this->logger->info('message : '.$receive);
        $this->message = $receive;

        return Parser::parse($receive);
    }

    public function getError()
    {
        return socket_last_error($this->socket);
    }

    private function authentication(string $oauth, string $nickname): void
    {
        $this->send(sprintf('PASS %s', $oauth));
        $this->send(sprintf('NICK %s', $nickname));
        $this->send(sprintf('JOIN #%s', $nickname));
    }

    private function isConnected(): bool
    {
        return null !== $this->socket;
    }
}
