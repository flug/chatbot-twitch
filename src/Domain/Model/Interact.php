<?php
declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Model\Interact\Interaction;

class Interact implements \JsonSerializable
{
    private iterable $interactions;
    
    public function __construct(iterable $interactions)
    {
        $this->interactions = $interactions;
    }
    
    public function jsonSerialize()
    {
        $json = [];
        foreach ($this->interactions as $interact) {
            if (!$interact instanceof \JsonSerializable && !$interact instanceof Interaction) {
                continue;
            }
            $json[$interact->getName()] = $interact->jsonSerialize();
        }
        
        return $json;
    }
}
