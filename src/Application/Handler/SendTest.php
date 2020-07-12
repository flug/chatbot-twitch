<?php
declare(strict_types=1);

namespace App\Application\Handler;

use App\Domain\Command\Test;
use App\Domain\Handler\SendTest as SendTestInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class SendTest implements SendTestInterface, MessageSubscriberInterface
{
    public function __invoke(Test $test): void
    {
        $client = $test->getClient();
        $client->sendMessage(strtr('Test reçu 5 sur 5, merci <nickname>!',
            ['<nickname>' => $test->getMessage()->getNickname()]
        ));
        
    }
    
    public static function getHandledMessages(): iterable
    {
        yield Test::class;
    }
}
