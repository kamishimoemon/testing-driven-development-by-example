<?php
//(new TestCaseTest('testRunning'))->run();
(new TestCaseTest('testTemplateMethod'))->run();

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
}