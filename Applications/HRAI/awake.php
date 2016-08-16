<?php

function getServMemUse(){
	// /Returns current memory usage.
    $free = shell_exec('free');
    $free = (string)trim($free);
    $free_arr = explode("\n", $free);
    $mem = explode(" ", $free_arr[1]);
    $mem = array_filter($mem);
    $mem = array_merge($mem);
    $memUse = $mem[2]/$mem[1]*100;
    return $memUse; }

function getServCPUUseNow(){
	// /Returns current CPU Usage.
    $load = sys_getloadavg();
    return $load[0]; }

function getServCPUUseAvg5(){
	// /Returns average CPU usage from the last 5 minutes.
    $load = sys_getloadavg();
    return $load[300]; }

function getServCPUUseAvg10(){
	// /Returns average CPU usage from the last 10 minutes.
    $load = sys_getloadavg();
    return $load[600]; }

function getServCPUUseCust(){
	// /Returns custom CPU usage from post data.
	$cust = $_POST['$custCPUAvg']
    $load = sys_getloadavg();
    return $load[$cust]; }

function getServUptime(){
	// /Returns custom CPU usage from post data.
	exec("uptime", $system); // get the uptime stats 
	$string = $system[0]; // this might not be necessary 
	$uptime = explode(" ", $string); // break up the stats into an array 
	$up_days = $uptime[4]; // grab the days from the array 
	$hours = explode(":", $uptime[7]); // split up the hour:min in the stats 
	$up_hours = $hours[0]; // grab the hours 
	$mins = $hours[1]; // get the mins 
	$up_mins = str_replace(",", "", $mins); // strip the comma from the mins 
    return $up_days;
    return $up_hours;
    return $up_mins; }

 

// Meta for search.
$metarrray1 = array( 'awake', 'alive', 'resource', 'memory', 'GPU', 'CPU', 'RAM', 'usage', 
  'use', 'monitor', 'up', 'uptime', 'old', 'age', 'online' );
// Questions: 
 // How old are you?
 // What is your $meta?
 // How long have you been $meta?  
// Statements: 
 // This file ( awake.php ) was the first file created for HRAI, on 3/25/2016 by Justin Grimes. 
?>
