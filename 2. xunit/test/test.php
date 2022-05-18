<?php
(new TestCaseTest('testRunning'))->run();

class TestCase
{
	private $name;

	public function __construct ($name)
	{
		$this->name = $name;
	}

	public function run (): void
	{
		$this->{$this->name}();
	}
}

class WasRun
	extends TestCase
{
	public $wasRun;

	public function __construct ($name)
	{
		parent::__construct($name);
		$this->wasRun = false;
	}

	public function testMethod (): void
	{
		$this->wasRun = true;
	}
}

class TestCaseTest
	extends TestCase
{
	public function testRunning (): void
	{
		$test = new WasRun('testMethod');
		assert(!$test->wasRun);
		$test->run();
		assert($test->wasRun);
	}
}