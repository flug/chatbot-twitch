<?php
declare(strict_types=1);

namespace App\Application\Handler;

use App\Domain\Command\Random;
use App\Domain\Handler\SendRandom as SendRandomInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class SendRandom implements SendRandomInterface, MessageSubscriberInterface
{
    public function __invoke(Random $random)
    {
        if (is_bool(strpos($random->getMessage()->getMessage(), '-'))) {
            $random->getClient()->sendMessage('Mauvaise écriture de la commande "!random <debut>-<fin>"');
            
            return;
        }
        $range = explode('-', $random->getMessage()->getMessage());
        $client = $random->getClient();
        $client->sendMessage(strtr('<nickname> jette des graines et <randomScore> retombes dans le sceau !', [
            '<nickname>' => $random->getMessage()->getNickname(),
            '<randomScore>' => mt_rand((int)$range[0], (int)$range[1]),
        ]));
        
    }
    
    public static function getHandledMessages(): iterable
    {
        yield Random::class;
    }
}
