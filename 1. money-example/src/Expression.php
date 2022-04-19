<?php
interface Expression
{
	function reduce (Bank $bank, string $to): Money;
}