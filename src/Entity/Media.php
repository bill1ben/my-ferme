<?php

namespace App\Entity;

use App\Entity\Interfaces\MediaInterface;
use App\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
#[Vich\Uploadable]
#[HasLifecycleCallbacks]
#[ApiResource(
    normalizationContext: ['groups' => ['media:read']],
)]

class Media implements MediaInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'animal_media', fileNameProperty: 'path')]
    #[Assert\File(
        maxSize: '1024M',
        mimeTypes: ['image/jpeg', 'image/png'],
        mimeTypesMessage: 'Veuillez uploader une image au format JPEG ou PNG'
    )]
    private ?File $file = null;

    #[ORM\Column(length: 255)]
    #[Groups(['media:read'])]
    private ?string $path = null;

    #[ORM\Column(length: 255)]
    private ?string $absolutePath = null;

    #[ORM\Column]
    #[Gedmo\SortablePosition]
    #[Groups(['media:read'])]
    private ?int $position = null;

    #[ORM\ManyToOne(inversedBy: 'medias')]
    #[Gedmo\SortableGroup]
    private ?Animal $animal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter for file
    public function getFile(): ?File
    {
        return $this->file;
    }

    // Setter for file
    public function setFile(?File $file = null): void
    {
        $this->file = $file;
        if ($file) {
            $this->updatedAt = new \DateTime();
        }
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): static
    {
        $this->path = $path;
        $this->setAbsolutePath($_ENV["UPLOAD_DESTINATION"]. '/' .$path);
        return $this;
    }

    public function getAbsolutePath(): ?string
    {
        return $this->absolutePath;
    }

    public function setAbsolutePath(string $absolutePath): static
    {
        $this->absolutePath = $absolutePath;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }
}
