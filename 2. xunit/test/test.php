<?php
(new TestCaseTest('testRunning'))->run();
(new TestCaseTest('testSetUp'))->run();

class TestCase
{
	private $name;

	public function __construct ($name)
	{
		$this->name = $name;
	}

	public function run (): void
	{
		$this->setUp();
		$this->{$this->name}();
	}

	public function setUp (): void
	{
	}
}

class WasRun
	extends TestCase
{
	public $wasRun;
	public $wasSetUp;

	public function __construct ($name)
	{
		parent::__construct($name);
		$this->wasRun = false;
		$this->wasSetUp = false;
	}

	public function testMethod (): void
	{
		$this->wasRun = true;
	}

	public function setUp (): void
	{
		$this->wasSetUp = true;
	}
}

class TestCaseTest
	extends TestCase
{
	private $test;

	public function testRunning (): void
	{
		$this->test->run();
		assert($this->test->wasRun);
	}

	public function testSetUp (): void
	{
		$this->test->run();
		assert($this->test->wasSetUp);
	}

	public function setUp (): void
	{
		$this->test = new WasRun('testMethod');
	}
}