<?php

$CMDfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
$inputMATCH = array('scan a file', 'virus check', 'malware check', 'virus scan');
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

include('/var/www/html/HRProprietary/HRCloud2/Applications/HRScan2/uploadbuttonhtmlNOGUI.php');
echo nl2br("--------------------------------\r"); }
?>