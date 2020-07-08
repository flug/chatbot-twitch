<?php
declare(strict_types=1);

namespace App\Infrastructure\Twitch\Exception;

class ConnectionFailedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('The connection to the irc chan is failed!', 0, null);
    }
}
