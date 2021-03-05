<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Tests\Unit;

use Closure;
use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOInterface;
use Kerby\EonxTestTask\DataProvider\GenericCustomerValidator;
use Kerby\EonxTestTask\Entity\CustomerDTO;
use Kerby\EonxTestTask\Exception\InvalidRemoteCustomerDataException;
use Kerby\EonxTestTask\Tests\TestCase;

class GenericValidatorTest extends TestCase
{
    public function testValidationPassesWhenAllDataIsFilled(): void
    {
        $validator = new GenericCustomerValidator();
        $customer = $this->makeDefaultCustomer();

        $validator->validate($customer);

        self::assertTrue(true);
    }

    public function testValidationFailsWhenEmailIsEmpty(): void
    {
        $this->helperTestEmptyField(
            static function (CustomerDTOInterface $customer) {
                $customer->setEmail('');
            }
        );
    }

    public function testValidationFailsWhenLastNameIsEmpty(): void
    {
        $this->helperTestEmptyField(
            static function (CustomerDTOInterface $customer) {
                $customer->setLastName('');
            }
        );
    }

    private function helperTestEmptyField(Closure $modify): void
    {
        $validator = new GenericCustomerValidator();
        $customer = $this->makeDefaultCustomer();

        $this->expectException(InvalidRemoteCustomerDataException::class);

        $modify($customer);

        $validator->validate($customer);
    }

    /**
     * @return CustomerDTO
     */
    protected function makeDefaultCustomer(): CustomerDTO
    {
        $customer = new CustomerDTO();

        $customer
            ->setFirstName('test')
            ->setLastName('test')
            ->setGender('male')
            ->setCountry('au')
            ->setCity('Melbourne')
            ->setPhone('123123123123')
            ->setUsername('some')
            ->setEmail('test@test.test');
        return $customer;
    }
}
