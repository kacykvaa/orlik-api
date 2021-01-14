<?php

declare(strict_types=1);

namespace App\Application\Entity;

use App\Application\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $filename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $path;

    /**
     * @ORM\ManyToOne(targetEntity=Facility::class, inversedBy="image")
     */

    private Facility $facility;

    public function __construct(string $filename, string $path)
    {
        $this->filename = $filename;
        $this->path = $path;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getFacility(): Facility
    {
        return $this->facility;
    }
}
