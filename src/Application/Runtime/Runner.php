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

namespace App\Application\Runtime;

use App\Domain\Command\Ping;
use App\Infrastructure\Twitch\Client as TwitchClient;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class Runner
{
    private const DEFAULT_TIME_TO_SLEEP = 5;

    private TwitchClient $client;

    private MessageBusInterface $bus;
    private iterable $commands;

    private LoggerInterface $logger;

    public function __construct(TwitchClient $client, MessageBusInterface $bus, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->client->addLogger($logger);
        $this->bus    = $bus;
        $this->logger = $logger;
    }

    public function setCommands(iterable $commands): void
    {
        $this->commands = $commands;
    }

    public function run(StyleInterface $io): void
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
                                $this->logger->notice('Command :  '.$command);
                                $this->bus->dispatch(new $command($this->client, $content));

                                break;
                            }
                        }
                    }

                    break;
                default:
                    $io->text(trim((string) $content));
                    $this->logger->info(trim((string) $content));
            }
            sleep(self::DEFAULT_TIME_TO_SLEEP);
        } while (true);
    }
}
