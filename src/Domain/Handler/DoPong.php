<?php
declare(strict_types=1);

namespace App\Domain\Handler;

use App\Domain\Command\Ping;

interface DoPong
{
    public function __invoke(Ping $ping);
}
