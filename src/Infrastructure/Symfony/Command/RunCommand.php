<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use App\Application\Runtime\Runner;
use App\Domain\Command\Random;
use App\Domain\Command\Test;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RunCommand extends Command
{
    protected static $defaultName = 'chatbot:run';

    private Runner $runner;

    public function __construct(Runner $runner)
    {
        parent::__construct(null);
        $this->runner = $runner;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $this->runner->setCommands([
            Test::class,
            Random::class,
        ]);
        $this->runner->run($io);

        return 1;
    }
}
