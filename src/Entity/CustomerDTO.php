<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Entity;

use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOInterface;

class CustomerDTO implements CustomerDTOInterface
{
    private ?string $firstName;
    private ?string $lastName;
    private ?string $email;
    private ?string $country;
    private ?string $gender;
    private ?string $city;
    private ?string $phone;
    private ?string $username;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setFirstName(?string $value): self
    {
        $this->firstName = $value;

        return $this;
    }

    public function setLastName(?string $value): self
    {
        $this->lastName = $value;

        return $this;
    }

    public function setEmail(?string $value): self
    {
        $this->email = $value;

        return $this;
    }

    public function setCountry(?string $value): self
    {
        $this->country = $value;

        return $this;
    }

    public function setGender(?string $value): self
    {
        $this->gender = $value;

        return $this;
    }

    public function setCity(?string $value): self
    {
        $this->city = $value;

        return $this;
    }

    public function setPhone(?string $value): self
    {
        $this->phone = $value;

        return $this;
    }

    public function setUsername(?string $value): self
    {
        $this->username = $value;

        return $this;
    }
}
