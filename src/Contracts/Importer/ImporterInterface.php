<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Contracts\Importer;

use Kerby\EonxTestTask\Contracts\DataProvider\FetcherFilterInterface;

interface ImporterInterface
{
    public function import(?FetcherFilterInterface $filter = null): void;
}
