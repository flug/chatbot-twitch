<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Domain\Command\Ping;
use App\Domain\Handler\DoPong as DoPongInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class DoPong implements DoPongInterface, MessageSubscriberInterface
{
    public function __invoke(Ping $ping): void
    {
        $ping->getClient()->pong();
    }

    public static function getHandledMessages(): iterable
    {
        yield Ping::class;
    }
}
