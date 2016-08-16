<?php

$string = exec("uptime", $server); // get the uptime stats 
$string = $system[0]; // this might not be necessary 
$uptime = explode(" ", $string); // break up the stats into an array 
$up_days = $uptime[4]; // grab the days from the array 
$up_days1 = str_replace(',', '', $up_days);
$up_days2 = str_replace(':', ' h & ', $up_days1);
$up_days2 = ($up_days2." m");

echo nl2br("The server has been up for $up_days2.\r"); 
echo nl2br("--------------------------------\r");  