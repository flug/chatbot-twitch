<?php
declare(strict_types=1);

namespace App\Domain\Handler;

use App\Domain\Command\Troll;

interface DoTrolling
{
    public function __invoke(Troll $troll);
}
