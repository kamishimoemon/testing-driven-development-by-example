<?php
use PHPUnit\Framework\TestCase;

class MoneyTest
	extends TestCase
{
	/**
	 * @test
	 * @depends testEquality
	 */
	public function testMultiplication (): void
	{
		$five = new Dollar(5);
		$this->assertEquals(new Dollar(10), $five->times(2));
		$this->assertEquals(new Dollar(15), $five->times(3));
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