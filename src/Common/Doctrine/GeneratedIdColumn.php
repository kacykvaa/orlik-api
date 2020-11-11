<?php declare(strict_types=1);

namespace App\Common\Doctrine;

use Doctrine\ORM\Mapping as ORM;

trait GeneratedIdColumn
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    public function id(): int
    {
        return $this->id;
    }
}