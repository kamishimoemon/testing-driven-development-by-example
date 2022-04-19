<?php
interface Expression
{
	function plus (Expression $addend): Expression;
	function reduce (Bank $bank, string $to): Money;
}