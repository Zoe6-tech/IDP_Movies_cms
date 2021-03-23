<?php

include_once 'config/database_old.php';
include_once 'config/database.php';

## Run the old code
$start = microtime(true); // tell php, starting with this point - pls measure the time for the following execution, until I call $time_cal

#repeat 100 times db connections
$i = 0;
while ($i < 1000) {
    $database = new Database_Old();
    $db = $database->getConnection();
    $i ++;
}

$old_time_cal = microtime(true) - $start; // take another snapshot and calculate the difference




## Run the new code
$start = microtime(true);

#repeat 100 times db connections in PHP
$i = 0;
while ($i < 1000) {
    $database = Database::getInstance();
    $db = $database->getConnection();
    $i ++;
}

$new_time_cal = microtime(true) - $start;

## Show result

$diff = ($old_time_cal - $new_time_cal)/1000;
$percentage = ($new_time_cal / $old_time_cal) * 100;

// - microtime(true) return seconds not miliseconds, so we need to add * 1000
printf('DB Old Connection Cal ==> %s ms'.PHP_EOL, $old_time_cal*1000);
printf('DB New Connection Cal ==> %s ms'.PHP_EOL, $new_time_cal*1000);

printf('You save %s ms per connection'.PHP_EOL, $diff*1000);
printf('New connection only takes %s%% of Old Connection'.PHP_EOL, $percentage);
