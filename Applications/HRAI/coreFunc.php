<?php
// / The following code cleans any output generated from user input for the text-to-speech engine.
function cleanOutput($output) {
  global $newlineArr;
  $cleanOutput = strip_tags(str_replace($newlineArr, ' ', $output));
  return $cleanOutput; }

// / The following code cleans any inputs provided by the user.
function cleanInput($input) {
  $input = strtolower(htmlentities(str_replace(str_split(',.!?'), '', $input), ENT_QUOTES, 'UTF-8')); 
  return $input; }

// / The following code specifies if HRAI is required in an Iframer (Tells HRAI to shrink it's footprint).
function displayMiniGui() {
  global $InstLoc;
  if (isset($_POST['HRAIMiniGUIPost'])) {
    $noMINICore = '1';
    $includeMINIIframer = '1'; }
  if (!isset($_POST['HRAIMiniGUIPost'])) {
    $noMINICore = '1'; 
    $includeMINIIFramer = '0'; }
  if (isset($includeMINIIframer)) {
    require_once($InstLoc.'/Applications/HRAIMiniGui.php'); } }

// / If there was text inputted by the user we use that text for $input. If there was no text, or if the input field 
// / blank we use '0' for $input. 0 as an input will tell HRAI that we want to run background tasks like learning or
// / research or networking functions.
function defineUserInput() {
  if(!isset($_POST['input'])) {
    $input = ''; } 
  if(isset($_POST['input'])) {
    $input = str_replace('\'', '\\\'', $_POST['input']);
    $input = str_replace(str_split('[]{};:$#^&%@>*<'), '', $_POST['input']); } 
  return ($input); }

// / Use this to determine if a remote URL contains a file.
function remoteFileExists($path) {
   return (@fopen($path,"r")==true); }

// / Returns human readable memory usage in Kb, Mb, or Gb respective
// / to the amount of RAM being used.
function getServMemUse() {
  $mem_usage = memory_get_usage(true); 
  if ($mem_usage < 1024) {
      $mem = $mem_usage." bytes"; }
  elseif ($mem_usage < 1048576) {
      $mem =  round($mem_usage/1024,2)." kilobytes"; }
  else {
      $mem = round($mem_usage/1048576,2)." megabytes"; }
  return ($mem."\r"); }

// / Returns current CPU Usage.
function getServCPUUseNow() {
  $load = sys_getloadavg();
  return $load[1]; }

// / Returns average CPU Usage from last 60 seconds.
function getServCPUUseAvg1() {
  $load = sys_getloadavg();
  return $load[60]; }

// / Returns average CPU usage from the last 5 minutes.
function getServCPUUseAvg5() {
  $load = sys_getloadavg();
  return $load[300]; }

// / Returns average CPU usage from the last 10 minutes.
function getServCPUUseAvg10() {
  $load = sys_getloadavg();
  return $load[600]; }

// / Returns custom CPU usage from post data.
function getServUptime() {
  exec("uptime", $system); // get the uptime stats 
  $string = $system[0]; // this might not be necessary 
  $uptime = explode(" ", $string); // break up the stats into an array 
  $up_days = $uptime[4]; // grab the days from the array 
  $hours = explode(":", $uptime[7]); // split up the hour:min in the stats 
  $up_hours = $hours[0]; // grab the hours 
  $mins = $hours[1]; // get the mins 
  $up_mins = str_replace(",", "", $mins); // strip the comma from the mins 
    return ("echo $up_days;".','."echo $up_hours;".','."echo $up_mins;"); }
function getServBusy() {
  // / Determine if the server is busy by looking at average CPU usage.
  $cpuUse = getServCPUUseNow();
  if ($cpuUse > ('1.2')) {
  $busy = '1'; }  
  else {
  $busy = '0'; }
return $busy; }