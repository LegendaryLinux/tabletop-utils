<?php

/**
 * In many tabletop games, an extended test is a challenge requiring many days to complete. The game master
 * will set a target number to complete the task. The player will then roll a twenty-sided die (d20), and subtract
 * fifteen. If this value is greater than zero, it is added to the running total. When the total reaches or exceeds
 * the target set by the game master, the task is complete. An optional modifier may be specified to increase or
 * decrease the difficulty of the task.
 */

# Find options if provided
$opts = getopt('m:t:v',['modifier:','target:','verbose']);

# Option parsing
$target = $opts['t'] ?? $opts['target'];
$modifierString = $opts['m'] ?? $opts['modifier'];

# A target is required
if(!$target) usage();

# Track progress
$progress = $dayCount = 0;

$modifier = 0;
if($modifierString && preg_match('/^([+\-])(\d*)/',$modifierString,$matches)){
    $matches[1] === '+' ? $modifier += (int) $matches[2] : $modifier -= (int) $matches[2];
}

if($modifier < -4){
    print "The modifier is too low. The task is impossible.".PHP_EOL;
    exit(0);
}

dprint("Modifier: $modifier".PHP_EOL);

do{
    # Increment number of days to complete task
    ++$dayCount;
    dprint("Day $dayCount");

    # Roll a d20
    $roll = mt_rand(1,20);
    dprint("Rolled a $roll");

    # Subtract fifteen from the roll
    $roll -= 15;
    dprint("Reduced to $roll");

    # Add the modifier to the roll
    if($modifier !== 0){
        $roll += $modifier;
        dprint("Modified to $roll");
    }

    # If the result is positive, add it to progress
    if($roll > 0) $progress += $roll;
    dprint("Current progress: $progress/$target".PHP_EOL);

    # If progress has reached or exceeded the target, the task is complete
    if($progress >= $target) break;
}while(1);

# Report stats
print "The task took $dayCount days to complete.".PHP_EOL;

function usage():void{
    print "Usage: php extest.php target [+/- modifier] [-v|--verbose]".PHP_EOL;
    exit(0);
}

function dprint(string $message=''):void{
    global $opts;
    if(isset($opts['v']) || isset($opts['verbose'])){
        print $message.PHP_EOL;
    }
}