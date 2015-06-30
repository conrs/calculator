<?php
/* 
	Simple command-line wrapper for calculator to faciliate evaluation / testing. 

	usage: php main.php [command to run on basic calculator]

*/

namespace DerpZone;

require_once(__DIR__ . "/calculator.php");


use MattsSuperFunBox\Calculator;




// For now, simply expose a basic CLI with basic calculator functionality.

if(count($argv) != 2)
{
	echo "Usage: php main.php \"[arithmetic expression]\"\n";
}
else
{
	$calc = Calculator::makeBasicCalculator();

	$command = "";

	$arguments = $argv;
	unset($arguments[0]);

	$command = implode($arguments, "");
	echo "Command: $command\n";
	echo "Result of calculation: " . $calc->execute($command) . "\n";
}



?>