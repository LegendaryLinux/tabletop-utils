<?php

//Check for arguments
if(!isset($argv[1])) die('Usage: target [target]... [[+/-]modifier]'.PHP_EOL);

//How many days it took
$days = 0;

foreach ($argv as $arg){
	if($arg != 'extest.php'){
		$test = str_replace(array('+','-'),'',$arg);
		if(!is_numeric($test)) die('All arguments must be numeric.'.PHP_EOL);
	}
}

$modifier = 0;
foreach($argv as $arg){
	if(strrchr($arg,'+')){
		$temp= str_replace('+','',$arg);
		$modifier += $temp;
	}elseif(strrchr($arg,'-')){
		$temp = str_replace('-','',$arg);
		$modifier -= $temp;
	}
}
if($modifier <= -5) die('Your modifier is too low. You will never finish.'.PHP_EOL);

foreach($argv as $arg){
	if($arg == 'extest.php' || strpos($arg,'+') !== false || strpos($arg,'-') !== false ) continue;
	global $days; global $modifier;
	$x=0; $goal=$arg;
	while ($x < $goal){
		$roll = mt_rand(1,20); $roll += $modifier;
		if ($roll > 15){
			$x += ($roll-15);}
		$days++;
		if ($x >= $goal) print 'It took '.$days.' days to reach '.$goal.' points.'.PHP_EOL;
	}$x=0;$days=0;
}
