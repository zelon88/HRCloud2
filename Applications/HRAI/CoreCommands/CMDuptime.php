<?php

// / Credit goes to http://www.sitepoint.com/forums/showthread.php?70104-How-do-I-output-System-Uptime
// / for the logical prowess behind echo'ing the server uptime.

$CMDfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDuptime.php'; 
$inputMATCH = array('what is your uptime', 'whats your uptime', 'server uptime', 'how long have you been online',
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
  exec("uptime", $system); // get the uptime stats
  $str   = @file_get_contents('/proc/uptime');
  $num   = floatval($str);
  $secs  = fmod($num, 60); $num = (int)($num / 60);
  $mins  = $num % 60;      $num = (int)($num / 60);
  $hours = $num % 24;      $num = (int)($num / 24);
  $days  = $num;
  $up_days = $days; // grab the days from the array
  $up_hours = $hours; // grab the hours
  $up_mins = str_replace(",", "", $mins); // strip the comma from the mins
  $output = "This server has been up for " . $up_days . " days, " . $up_hours . " hours, and " . $up_mins . " minutes.\n";
  echo nl2br($output); } 