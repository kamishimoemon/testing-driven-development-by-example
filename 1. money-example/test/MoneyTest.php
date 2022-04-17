<?php
use PHPUnit\Framework\TestCase;

class MoneyTest
	extends TestCase
{
	/**
	 * @test
	 */
	public function testMultiplication (): void
	{
		$five = new Dollar(5);
		$product = $five->times(2);
		$this->assertEquals(10, $product->amount);
		$product = $five->times(3);
		$this->assertEquals(15, $product->amount);
	}

	/**
	 * @test
	 */
	public function testEquality (): void
	{
		$this->assertTrue((new Dollar(5))->equals(new Dollar(5)));
		$this->assertFalse((new Dollar(5))->equals(new Dollar(6)));
	}
}