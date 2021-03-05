<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Tests\Unit;

use Kerby\EonxTestTask\DataProvider\GenericFetcherFilter;
use Kerby\EonxTestTask\Tests\TestCase;

class GenericFilterTest extends TestCase
{
    public function testSetterAndGettersWorksCorrectly(): void
    {
        $filter=new GenericFetcherFilter();

        $filter->setResultsNumber(11);
        self::assertEquals(11, $filter->getResultsNumber());

        $filter->setResultsNumber(15);
        self::assertEquals(15, $filter->getResultsNumber());

        $filter->setNationality('test');
        self::assertEquals('test', $filter->getNationality());

        $filter->setNationality('another');
        self::assertEquals('another', $filter->getNationality());
    }
}
