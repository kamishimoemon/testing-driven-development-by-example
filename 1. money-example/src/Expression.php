<?php
interface Expression
{
	function reduce (string $to): Money;
}