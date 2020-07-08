<?php
declare(strict_types=1);

namespace App\Infrastructure\Twitch;

use App\Infrastructure\Twitch\Exception\ConnectionFailedException;
use Psr\Log\LoggerInterface;

class Client
{
    private const TWITCH_IRC_URI = "irc.chat.twitch.tv";
    private const TWITCH_IRC_PORT = 6667;
    // @see https://discuss.dev.twitch.tv/t/missing-client-side-message-length-check/21316
    private const MAX_LINE = 512;
    private $socket;
    public const PING = 'PING';
    public const PRIVATE_MESSAGE = 'PRIVMSG';
    
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    
    public function __construct(string $oauth, string $nickname, LoggerInterface $logger)
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (socket_connect($this->socket, self::TWITCH_IRC_URI, self::TWITCH_IRC_PORT) === false) {
            throw new ConnectionFailedException();
        }
        $this->logger = $logger;
        $this->authentication($oauth, $nickname);
    }
    
    private function authentication(string $oauth, string $nickname): void
    {
        $this->send(sprintf('PASS %s', $oauth));
        $this->send(sprintf('NICK %s', $nickname));
        $this->send(sprintf('JOIN #%s', $nickname));
    }
    
    public function ping()
    {
        $this->send(sprintf('PING :tmi.twitch.tv'));
    }
    
    public function pong()
    {
        $this->send(sprintf('PONG :tmi.twitch.tv'));
    
    }
    
    public function send(string $message)
    {
        if (!$this->isConnected()) {
            throw new ConnectionFailedException();
        }
        $this->logger->info('send octets ' . socket_write($this->socket, $message . " \r\n"));
    }
    
    private function isConnected(): bool
    {
        return $this->socket !== null;
    }
    
    public function read()
    {
        if (!$this->isConnected()) {
            throw new ConnectionFailedException();
        }
        $receive = socket_read($this->socket, self::MAX_LINE);
        $this->logger->info('message : ' . $receive);
        
        return $receive;
        
    }
    
    public function getError()
    {
        return socket_last_error($this->socket);
    }
}