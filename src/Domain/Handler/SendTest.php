<?php
declare(strict_types=1);

namespace App\Domain\Handler;

use App\Domain\Command\Test;

interface SendTest
{
    
    public function __invoke(Test $test): void;
}
