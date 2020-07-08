<?php
declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use App\Infrastructure\Twitch\Client as TwitchClient;
use App\Infrastructure\Twitch\Message\Parser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RunCommand extends Command
{
    protected static $defaultName = 'chatbot:run';
    private TwitchClient $client;
    
    public function __construct(TwitchClient $client)
    {
        parent::__construct(null);
        $this->client = $client;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->client->ping();
        $io = new SymfonyStyle($input, $output);
        while (true) {
            $content = $this->client->read();
            if (strstr($content, TwitchClient::PING)) {
                $this->client->pong();
                continue;
            }
            if (strstr($content, TwitchClient::PRIVATE_MESSAGE)) {
                $parts = Parser::parse($content);
                $io->success(trim($parts['nickname'] . ' : ' . $parts['message']));
                continue;
            }
            sleep(5);
        }
        
        return 1;
    }
}
