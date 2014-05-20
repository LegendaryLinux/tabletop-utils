<?php
/*
 * hits.php
 *
 * PURPOSE:
 * In Shadowrun, players roll a dice pool of d6. For each 5 or 6 rolled, they get one 'hit'. Get enough hits, and you
 * succeed at the task you were trying to perform. If half or more are 1s, you get a glitch, which is not necessarily
 * a failure, but messes you up a bit. If half or more are 1s and you get no hits, you critically fail. This script
 * rolls those dice and makes those calculations for you.
 *
 * USAGE:
 * php hits.php pool [hit [crit]]
 *
 * ARGUMENTS:
 * pool: Mandatory. The size of the dice pool to roll (how many dice to roll)
 * hit: Optional. The minimum number at which a roll is considered a hit (defaults to 5)
 * crit Optional. The maximum number at which a roll is considered a critical failure (defaults to 1)
 *
 */

# Did the user give any arguments and are they valid? Of not, tell them to.
if(!isset($argv[1]) || $argv[1]=='' || !is_numeric($argv[1])){
    usage();
}

# Variables for output
$rolls = array();
$hits = 0; $crit_hits = 0;
$misses = 0; $crit_misses = 0;

# Check for modified hit and crit fail numbers
$hit_num = (isset($argv[2]) && is_numeric($argv[2]) && $argv[2]>0 && $argv[2]<7) ? $argv[2] : 5;
$crit_fail = (isset($argv[3]) && is_numeric($argv[3]) && $argv[3]>0 && $argv[3]<7) ? $argv[3] : 1;

# Roll the dice
for($i=0;$i<$argv[1];$i++){
    $rolls[$i] = mt_rand(1,6);
}

# Update appropriate variables
foreach($rolls as $roll){
    if($roll <= $crit_fail) $crit_misses++;
    if($roll < $hit_num) $misses++;
    if($roll >= $hit_num) $hits++;
    if($roll == 6) $crit_hits++;
}

# Print results to user
print $hits.' Hits ('.$crit_hits.' sixes)'.PHP_EOL;
print $misses.' Misses ('.$crit_misses.' ones)'.PHP_EOL;

# Glitch or Critical Glitch?
if($crit_misses>=$argv[1]/2 && $hits==0){
    print 'Critical Glitch!'.PHP_EOL;
}elseif($crit_misses>=$argv[1]/2){
    print 'Glitch!'.PHP_EOL;
}

# Space at end of script for readability
print PHP_EOL;

/*
 * Function usage
 *
 * PURPOSE:
 * Tell the user how to use the script
 */
function usage(){
    print PHP_EOL.'Usage: hits.php pool [hit [crit]]'.PHP_EOL;
    exit(0);
}