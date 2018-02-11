<?php

$CMDfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDtime.php'; 
$inputMATCH = array('what time', 'what is the time', 'whats the time', 'have you got the date', 'what is the date',
  'whats the the date', 'what day is it', 'what date is it' ,'date', 'what time', 
  'the time', 'the day', 'tell me the day', 'what day is it');
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
  $output = $output.'It is currently '."\r".$date.". \r";
  echo nl2br($output); }