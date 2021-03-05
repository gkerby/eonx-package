<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Contracts\Entity;

interface CustomerDTOInterface
{
    public function getFirstName(): ?string;

    public function getLastName(): ?string;

    public function getEmail(): ?string;

    public function getCountry(): ?string;

    public function getGender(): ?string;

    public function getCity(): ?string;

    public function getPhone(): ?string;

    public function getUsername(): ?string;

    public function setFirstName(?string $value): self;

    public function setLastName(?string $value): self;

    public function setEmail(?string $value): self;

    public function setCountry(?string $value): self;

    public function setGender(?string $value): self;

    public function setCity(?string $value): self;

    public function setPhone(?string $value): self;

    public function setUsername(?string $value): self;
}
