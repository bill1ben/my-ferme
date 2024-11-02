<?php

namespace App\Entity\Interfaces;

use App\Entity\Interfaces\Traits\TimestampableTraitInterface;
use App\Entity\Media;
use Doctrine\Common\Collections\Collection;

interface AnimalInterface extends TimestampableTraitInterface
{
    public const TYPES_AND_BREED = [
        'Bœuf' => ['Charolais', 'Limousin', 'Salers', 'Aubrac'],
        'Vache' => ['Holstein', 'Normande', 'Montbéliarde', 'Tarentaise'],
        'Mouton' => ['Suffolk', 'Texel', 'Mérinos', 'Charmoise'],
        'Cheval' => ['Pur-sang', 'Arabe', 'Quarter Horse', 'Appaloosa'],
        'Poule' => ['Leghorn', 'Sussex', 'Marans', 'Poule Soie']
    ];
    
    public function getId(): ?int;

    public function getName(): ?string;

    public function setName(string $name): static;

    public function getAge(): ?int;

    public function setAge(int $age): static;

    public function getType(): ?string;

    public function setType(string $type): static;

    public function getBreed(): ?string;

    public function setBreed(string $breed): static;

    public function getDescription(): ?string;

    public function setDescription(?string $description): static;

    public function getPriceTTC(): ?string;

    public function setPriceTTC(string $priceTTC): static;

    public function getPriceHT(): ?string;

    public function setPriceHT(string $priceHT): static;

    public function getMedias(): Collection;

    public function addMedia(Media $medium): static;

    public function removeMedia(Media $medium): static;
}
