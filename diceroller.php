<?php
# Prompt the user for an input string
print 'What do you want to roll? (ex. 1d20, 1d20+3, 13d11-8'.PHP_EOL;

# Begin the loop
while(true){
    # Get a string from the user
    print 'Enter a roll (0 to exit): '; $string = trim(filter_var(fgets(STDIN),FILTER_SANITIZE_STRING));

    # Are we done?
    if($string == "0"){
        exit(0);
    }

    # Parse the string to make sure it looks right
    if(isset($roll)) unset($roll); $roll = array();
    if(preg_match_all('(([0-9]+)(d)([0-9]+)(([\+\-])([0-9]+)){0,1})',$string,$roll)){
        # Set up the array we'll use to store our rolls
        if(isset($dice)) unset($dice); $dice = array();

        #Roll the dice and store them in the array
        for($i=0;$i<$roll[1][0];$i++){$dice[$i] = mt_rand(1,$roll[3][0]);}

        # Display the individual rolls and calculate the total
        print 'Individual rolls: ';
        $total=0;
        foreach($dice as $die){
            print $die.', ';
            $total += $die;
        }

        # Display total
        print PHP_EOL.'Total: '.$total.PHP_EOL;

        # Display the modified total (if applicable)
        if(isset($roll[4][0]) && $roll[4][0]!= ''){
            print 'Modified total: '.($total+$roll[4][0]).PHP_EOL;
        }

        # New lines before next iteration
        print PHP_EOL;

    }else{
        print 'You must enter a valid roll. (ex. 1d20, 1d20+3, 13d11-8'.PHP_EOL.PHP_EOL;
    }
}