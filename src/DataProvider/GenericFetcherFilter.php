<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\DataProvider;

use Kerby\EonxTestTask\Contracts\DataProvider\FetcherFilterInterface;

class GenericFetcherFilter implements FetcherFilterInterface
{
    private ?int $number = 100;
    private ?string $nationality = 'au';

    public function getResultsNumber(): ?int
    {
        return $this->number;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setResultsNumber(?int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function setNationality(?string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }
}
