<?php
use PHPUnit\Framework\TestCase;

class MoneyTest
	extends TestCase
{
	/**
	 * @test
	 */
	public function testEquality (): void
	{
		$this->assertTrue((Money::dollar(5))->equals(Money::dollar(5)));
		$this->assertFalse((Money::dollar(5))->equals(Money::dollar(6)));
		$this->assertFalse((Money::franc(5))->equals(Money::dollar(5)));
	}

	/**
	 * @test
	 * @depends testEquality
	 */
	public function testMultiplication (): void
	{
		$five = Money::dollar(5);
		$this->assertTrue((Money::dollar(10))->equals($five->times(2)));
		$this->assertTrue((Money::dollar(15))->equals($five->times(3)));
	}

	/**
	 * @test
	 */
	public function testCurrency (): void
	{
		$this->assertEquals('USD', Money::dollar(1)->currency());
		$this->assertEquals('CHF', Money::franc(1)->currency());
	}

	/**
	 * @test
	 */
	public function testSimpleAddition (): void
	{
		$five = Money::dollar(5);
		$sum = $five->plus($five);
		$bank = new Bank();
		$reduced = $bank->reduce($sum, 'USD');
		$this->assertTrue((Money::dollar(10))->equals($reduced));
	}

	/**
	 * @test
	 */
	public function testPlusReturnsSum (): void
	{
		$five = Money::dollar(5);
		$sum = $five->plus($five);
		$this->assertEquals($five, $sum->augend);
		$this->assertEquals($five, $sum->addend);
	}

	/**
	 * @test
	 */
	public function testReduceSum (): void
	{
		$sum = new Sum(Money::dollar(3), Money::dollar(4));
		$bank = new Bank();
		$this->assertTrue(Money::dollar(7)->equals($bank->reduce($sum, 'USD')));
	}

	/**
	 * @test
	 * @depends testIdentityRate
	 */
	public function testReduceMoney (): void
	{
		$bank = new Bank();
		$result = $bank->reduce(Money::dollar(1), 'USD');
		$this->assertTrue(Money::dollar(1)->equals($result));
	}

	/**
	 * @test
	 * @depends testReduceMoney
	 */
	public function testReduceMoneyDifferentCurrency (): void
	{
		$bank = new Bank();
		$bank->addRate('CHF', 'USD', 2);
		$result = $bank->reduce(Money::franc(2), 'USD');
		$this->assertTrue(Money::dollar(1)->equals($result));
	}

	/**
	 * @test
	 */
	public function testIdentityRate (): void
	{
		$bank = new Bank();
		$this->assertEquals(1, $bank->rate('USD', 'USD'));
	}

	/**
	 * @test
	 */
	public function testMixedAddition (): void
	{
		$fiveBucks = Money::dollar(5);
		$tenFrancs = Money::franc(10);
		$bank = new Bank();
		$bank->addRate('CHF', 'USD', 2);
		$result = $bank->reduce($fiveBucks->plus($tenFrancs), 'USD');
		$this->assertEquals(Money::dollar(10), $result);
	}
}