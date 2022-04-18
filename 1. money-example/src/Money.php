<?php
abstract class Money
{
	protected $amount;
	protected $currency;

	protected function __construct (int $amount, string $currency)
	{
		$this->amount = $amount;
		$this->currency = $currency;
	}

	public function equals (Money $money): bool
	{
		return $this->amount == $money->amount && get_class($this) == get_class($money);
	}

	public function currency (): string
	{
		return $this->currency;
	}

	public abstract function times (int $multiplier): Money;

	public static function dollar (int $amount): Dollar
	{
		return new Dollar($amount, 'USD');
	}

	public static function franc (int $amount): Franc
	{
		return new Franc($amount, 'CHF');
	}
}