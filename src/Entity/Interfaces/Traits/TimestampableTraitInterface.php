<?php
namespace App\Entity\Interfaces\Traits;

interface TimestampableTraitInterface
{
    public function setCreatedAtValue(): void;

    public function getCreatedAt(): ?\DateTimeImmutable;

    public function setUpdatedAtValue(): void;

    public function getUpdatedAt(): ?\DateTime;
}
