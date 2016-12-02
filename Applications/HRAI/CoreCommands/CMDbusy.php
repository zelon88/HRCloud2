<?php

$CMDfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDbusy.php'; 
$inputMATCH = array('what is your status', 'whats your status', 'server status', 'are you busy', 'are you idle');
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

if (getServBusy() == 1 ) {
echo nl2br('This server reports it is busy.'."\r"); }
if (getServBusy() == 0 ) {
echo nl2br('This server reports it is idle.'."\r--------------------------------\r"); } }