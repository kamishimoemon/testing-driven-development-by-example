<?php
abstract class Money
{
	protected $amount;

	public function equals (Money $money): bool
	{
		return $this->amount == $money->amount && get_class($this) == get_class($money);
	}

	public abstract function times (int $multiplier): Money;

	public static function dollar (int $amount): Dollar
	{
		return new Dollar($amount);
	}

	public static function franc (int $amount): Franc
	{
		return new Franc($amount);
	}
}