<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Contracts\DataProvider;

interface FetcherFilterInterface
{
    public function getResultsNumber(): ?int;

    public function getNationality(): ?string;

    public function setResultsNumber(?int $number): self;

    public function setNationality(?string $nationality): self;
}
