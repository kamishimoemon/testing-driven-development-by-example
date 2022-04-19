<?php
class Bank
{
	private $rates;

	public function __construct ()
	{
		$this->rates = [];
	}

	public function addRate (string $from, string $to, int $rate): void
	{
		$this->rates["{$from}|{$to}"] = $rate;
	}

	public function rate (string $from, string $to): int
	{
		//return $from == 'CHF' && $to == 'USD' ? 2 : 1;
		if ($from == $to) return 1;
		return $this->rates["{$from}|{$to}"];
	}

	public function reduce (Expression $source, string $to): Money
	{
		return $source->reduce($this, $to);
	}
}