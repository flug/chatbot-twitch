<?php
declare(strict_types=1);

namespace App\Domain\Model\Interact;

class Image implements \JsonSerializable, Interaction
{
    private string $path;
    
    public function __construct(string $path)
    {
        
        $this->path = $path;
    }
    
    public function jsonSerialize()
    {
        return [
            'path' => $this->path,
        ];
    }
    
    public function getName(): string
    {
        return 'image';
    }
}
