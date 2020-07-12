<?php
declare(strict_types=1);

namespace App\Application\Runtime;

use App\Domain\Command\Ping;
use App\Infrastructure\Twitch\Client as TwitchClient;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class Runner
{
    private const DEFAULT_TIME_TO_SLEEP = 5;
    /**
     * @var TwitchClient
     */
    private TwitchClient $client;
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $bus;
    private iterable $commands;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    
    public function __construct(TwitchClient $client, MessageBusInterface $bus, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->client->addLogger($logger);
        $this->bus = $bus;
        $this->logger = $logger;
    }
    
    public function run(StyleInterface $io)
    {
        do {
            $content = $this->client->read();
            switch (true) {
                case $this->client->isCommandType(TwitchClient::PING):
                    $this->bus->dispatch(new Ping($this->client, $content));
                    break;
                case $this->client->isCommandType(TwitchClient::PRIVATE_MESSAGE):
                    if ($content->isCommand()) {
                        foreach ($this->commands as $command) {
                            if (strstr($command, $content->getCommand())) {
                                $this->logger->notice('Command :  ' . $command);
                                $this->bus->dispatch(new $command($this->client, $content));
                                break;
                            }
                        }
                    }
                    break;
                default:
                    $io->text(trim((string)$content));
                    $this->logger->info(trim((string)$content));
            }
            sleep(self::DEFAULT_TIME_TO_SLEEP);
        } while (true);
    }
    
    public function setCommands(iterable $commands)
    {
        $this->commands = $commands;
    }
}
