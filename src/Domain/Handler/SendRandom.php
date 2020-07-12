<?php

declare(strict_types=1);

namespace App\Domain\Handler;

use App\Domain\Command\Random;

interface SendRandom
{
    public function __invoke(Random $random);
}
