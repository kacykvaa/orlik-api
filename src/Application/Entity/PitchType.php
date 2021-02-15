<?php

declare(strict_types=1);

namespace App\Application\Entity;

use App\Common\Doctrine\GeneratedIdColumn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Application\Repository\PitchTypeRepository")
 * @ORM\Table(name="pitch_type")
 */
class PitchType
{
    use GeneratedIdColumn;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function updateName(string $name): void
    {
        $this->name = $name;
    }
}