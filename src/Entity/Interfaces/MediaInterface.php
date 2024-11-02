<?php

namespace App\Entity\Interfaces;

use App\Entity\Animal;
use App\Entity\Interfaces\Traits\TimestampableTraitInterface;
use Symfony\Component\HttpFoundation\File\File;

interface MediaInterface extends TimestampableTraitInterface
{
    public function getId(): ?int;

    public function getFile(): ?File;

    public function setFile(?File $file = null): void;

    public function getPath(): ?string;

    public function setPath(?string $path): static;
    
    public function getAbsolutePath(): ?string;

    public function setAbsolutePath(string $absolutePath): static;
    
    public function getPosition(): ?int;

    public function setPosition(?int $position): static;

    public function getAnimal(): ?Animal;

    public function setAnimal(?Animal $animal): static;
}
