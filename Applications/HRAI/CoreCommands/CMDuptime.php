<?php

$CMDfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDuptime.php'; 
$inputMATCH = array('what is your uptime', 'whats your uptime', 'server uptime', 'busy', 'how long have you been online',
  'how long have you been awake', 'how long have you been on', 'how long have you been up');
$CMDcounter++;

if (isset($input)) {
  foreach ($inputMATCH as $inputM1) {
    if (preg_match('/'.$inputM1.'/', $input)) {
      $CMDinit[$CMDcounter] = 1;
      $input = preg_replace('/'.$inputM1.'/',' ',$input); } } }

if (!isset($input)) {
  $input = ''; }

$input = str_replace('   ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
$input = ltrim($input);
if ($CMDinit[$CMDcounter] == 1) {

// / --------------------------------------


$string = exec("uptime", $server); // get the uptime stats 
$string = $system[0]; // this might not be necessary 
$uptime = explode(" ", $string); // break up the stats into an array 
$up_days = $uptime[4]; // grab the days from the array 
$up_days1 = str_replace(',', '', $up_days);
$up_days2 = str_replace(':', ' h & ', $up_days1);
$up_days2 = ($up_days2." m");

echo nl2br("The server has been up for $up_days2.\r"); 
echo nl2br("--------------------------------\r"); } 