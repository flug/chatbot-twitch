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

namespace App\Application\Handler;

use App\Domain\Command\Random;
use App\Domain\Handler\SendRandom as SendRandomInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class SendRandom implements MessageSubscriberInterface, SendRandomInterface
{
    public function __invoke(Random $random): void
    {
        if (\is_bool(strpos($random->getMessage()->getMessage(), '-'))) {
            $random->getClient()->sendMessage('Mauvaise écriture de la commande "!random <debut>-<fin>"');

            return;
        }
        $range  = explode('-', $random->getMessage()->getMessage());
        $client = $random->getClient();
        $client->sendMessage(strtr('<nickname> jette des graines et <randomScore> retombes dans le sceau !', [
            '<nickname>'    => $random->getMessage()->getNickname(),
            '<randomScore>' => random_int((int) $range[0], (int) $range[1]),
        ]));
    }

    public static function getHandledMessages(): iterable
    {
        yield Random::class;
    }
}
