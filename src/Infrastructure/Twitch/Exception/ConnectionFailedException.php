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

namespace App\Infrastructure\Twitch\Exception;

class ConnectionFailedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('The connection to the irc chan is failed!', 0, null);
    }
}
