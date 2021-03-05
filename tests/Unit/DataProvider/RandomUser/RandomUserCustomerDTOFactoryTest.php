<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Tests\Unit\DataProvider\RandomUser;

use JsonException;
use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOInterface;
use Kerby\EonxTestTask\DataProvider\GenericCustomerValidator;
use Kerby\EonxTestTask\DataProvider\RandomUser\RandomUserCustomerDTOFactory;
use Kerby\EonxTestTask\Exception\InvalidRemoteCustomerDataException;
use Kerby\EonxTestTask\Tests\TestCase;

class RandomUserCustomerDTOFactoryTest extends TestCase
{
    /**
     * Static props to hold immutable sample data between tests
     */
    private static ?array $sampleItem = null;

    /**
     * @throws JsonException
     */
    public static function setUpBeforeClass(): void
    {
        self::$sampleItem = json_decode(file_get_contents(__DIR__ . '/data/sampleDataItem.json'), true, 512, JSON_THROW_ON_ERROR);
    }

    public function testFactoryMakesCorrectObjectWithCorrectData(): void
    {
        $customer = (new RandomUserCustomerDTOFactory(new GenericCustomerValidator()))->make(self::$sampleItem);

        $comparer = new RandomUserComparer();

        $comparer->compareCustomerData($this, self::$sampleItem, $customer);
    }

    public function testFactoryFailsWhenIncorrectDataIsGiven(): void
    {
        $this->expectException(InvalidRemoteCustomerDataException::class);

        (new RandomUserCustomerDTOFactory(new GenericCustomerValidator()))->make([]);

        self::assertNotNull($this->getExpectedException()->getCustomer());
    }

    public function testInvalidDataExceptionHasCustomerInstance(): void
    {
        try {
            (new RandomUserCustomerDTOFactory(new GenericCustomerValidator()))->make([]);
        } catch (InvalidRemoteCustomerDataException $exception) {
            self::assertInstanceOf(CustomerDTOInterface::class, $exception->getCustomer());
        }
    }
}
