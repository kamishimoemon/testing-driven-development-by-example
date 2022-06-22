<?php
$suite = new TestSuite();
$suite->add(new TestCaseTest('testTemplateMethod'));
$suite->add(new TestCaseTest('testResult'));
$suite->add(new TestCaseTest('testFailedResult'));
$suite->add(new TestCaseTest('testFailedResultFormatting'));
$result = new TestResult();
$suite->run($result);
echo $result->summary();

class TestCase
{
	private $name;

	public function __construct ($name)
	{
		$this->name = $name;
	}

	public function run (TestResult $result): void
	{
		$result->testStarted();
		$this->setUp();
		try
		{
			$this->{$this->name}();
		}
		catch (Exception $ex)
		{
			$result->testFailed();
		}
		$this->tearDown();
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
	private $errorCount = 0;

	public function testStarted (): void
	{
		$this->runCount++;
	}

	public function testFailed (): void
	{
		$this->errorCount++;
	}

	public function summary (): string
	{
		return "{$this->runCount} run, {$this->errorCount} failed";
	}
}

class TestSuite
{
	private $tests = [];

	public function add (TestCase $test): void
	{
		$this->tests[] = $test;
	}

	public function run (TestResult $result): void
	{
		foreach ($this->tests as $test)
		{
			$test->run($result);
		}
	}
}

class TestCaseTest
	extends TestCase
{
	private $test;
	private $result;

	public function setUp (): void
	{
		$this->result = new TestResult();
	}

	public function testTemplateMethod (): void
	{
		$this->test = new WasRun('testMethod');
		$this->test->run($this->result);
		assert($this->test->log == 'setUp testMethod tearDown');
	}

	public function testResult (): void
	{
		$test = new WasRun('testMethod');
		$test->run($this->result);
		assert($this->result->summary() == '1 run, 0 failed');
	}

	public function testFailedResult (): void
	{
		$test = new WasRun('testBrokenMethod');
		$test->run($this->result);
		assert($this->result->summary() == '1 run, 1 failed');
	}

	public function testFailedResultFormatting (): void
	{
		$this->result->testStarted();
		$this->result->testFailed();
		assert($this->result->summary() == '1 run, 1 failed');
	}

	public function testSuite (): void
	{
		$suite = new TestSuite();
		$suite->add(new WasRun('testMethod'));
		$suite->add(new WasRun('testBrokenMethod'));
		$suite->run($this->result);
		assert($result->summary() == '2 run, 1 failed');
	}
}