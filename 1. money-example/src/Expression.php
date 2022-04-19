<?php
interface Expression
{
	function times (int $multiplier): Expression;
	function plus (Expression $addend): Expression;
	function reduce (Bank $bank, string $to): Money;
}