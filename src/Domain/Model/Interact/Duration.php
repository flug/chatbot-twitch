<?php
declare(strict_types=1);

namespace App\Domain\Model\Interact;

class Duration implements \JsonSerializable, Interaction
{
    private int $timeToDuration;
    
    public function __construct(int $timeToDuration)
    {
        $this->timeToDuration = $timeToDuration;
    }
    
    public function jsonSerialize()
    {
        return [
            'time' => $this->timeToDuration,
        ];
    }
    
    public function getName(): string
    {
        return 'duration';
    }
}
