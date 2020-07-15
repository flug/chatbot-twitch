<?php
declare(strict_types=1);

namespace App\Application\Handler;

use App\Domain\Command\Troll;
use App\Domain\Handler\DoTrolling as DoTrollingInterface;
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
            '{"duration": 3000 , "audio": {"path": "https://www.soundboard.com/handler/DownLoadTrack.ashx?cliptitle=Troll+Song+&filename=23/238733-ce078a96-98ef-407d-8ffa-b37526f861d3.mp3"}, "image" : {"path" :   "https://i.kym-cdn.com/entries/icons/facebook/000/000/091/TrollFace.jpg"}}'
        );
        $publisher($update);
    }
    
    public static function getHandledMessages(): iterable
    {
        yield Troll::class;
    }
}
