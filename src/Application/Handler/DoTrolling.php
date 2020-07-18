<?php
declare(strict_types=1);

namespace App\Application\Handler;

use App\Domain\Command\Troll;
use App\Domain\Handler\DoTrolling as DoTrollingInterface;
use App\Domain\Model\Interact;
use Symfony\Component\Mercure\PublisherInterface as MercurePublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class DoTrolling implements DoTrollingInterface, MessageSubscriberInterface
{
    private MercurePublisherInterface $publisher;
    
    public function __construct(MercurePublisherInterface $publisher)
    {
        $this->publisher = $publisher;
    }
    
    public function __invoke(Troll $troll)
    {
        $publisher = $this->publisher;
        $update = new Update(
            ['/interact'],
            json_encode(new Interact([
                new Interact\Audio('https://www.soundboard.com/handler/DownLoadTrack.ashx?cliptitle=Troll+Song+&filename=23/238733-ce078a96-98ef-407d-8ffa-b37526f861d3.mp3'),
                new Interact\Duration(10000),
                new Interact\Image('https://i.kym-cdn.com/entries/icons/facebook/000/000/091/TrollFace.jpg'),
            ]))
        );
        $publisher($update);
    }
    
    public static function getHandledMessages(): iterable
    {
        yield Troll::class;
    }
}
