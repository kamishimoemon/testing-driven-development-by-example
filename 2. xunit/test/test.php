<?php
(new TestCaseTest('testTemplateMethod'))->run();
(new TestCaseTest('testResult'))->run();
(new TestCaseTest('testFailedResult'))->run();

class TestCase
{
	private $name;

	public function __construct ($name)
	{
		$this->name = $name;
	}

	public function run (): TestResult
	{
		$result = new TestResult();
		$result->testStarted();
		$this->setUp();
		$this->{$this->name}();
		$this->tearDown();
		return $result;
	}

	public function setUp (): void
	{
	}

	public function tearDown (): void
	{
	}
}

class WasRun
	extends TestCase
{
	public $log;

	public function __construct ($name)
	{
		parent::__construct($name);
		$this->log = '';
	}

	public function testMethod (): void
	{
		$this->log .= ' testMethod';
	}

	public function setUp (): void
	{
		$this->log .= 'setUp';
	}

	public function tearDown (): void
	{
		$this->log .= ' tearDown';
	}

	public function testBrokenMethod (): void
	{
		throw new Exception();
	}
}

class TestResult
{
	private $runCount = 0;

	public function testStarted (): void
	{
		$this->runCount++;
	}

	public function summary (): string
	{
		return "{$this->runCount} run, 0 failed";
	}
}

class TestCaseTest
	extends TestCase
{
	private $test;

	public function testTemplateMethod (): void
	{
		$this->test = new WasRun('testMethod');
		$this->test->run();
		assert($this->test->log == 'setUp testMethod tearDown');
	}

	public function testResult (): void
	{
		$test = new WasRun('testMethod');
		$result = $test->run();
		assert($result->summary() == '1 run, 0 failed');
	}

	public function testFailedResult (): void
	{
		$test = new WasRun('testBrokenMethod');
		$result = $test->run();
		assert($result->summary() == '1 run, 1 failed');
	}
}