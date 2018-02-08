<?php

$CMDfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcfh.php'; 
$inputMATCH = array('callforhelp', 'call for help', 'cfh', 'load balance', 'balance load',);
$CMDcounter++;

if (isset($input) && $input !== '') {
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

// / Write the nodeCount to the sesLogfile.
  $txt = ('CoreAI: RELOADED nodeCache, nodeCount is '.$nodeCount.' on '.$date.'. ');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
  // / Get the status of this server and write it to the sesLogfile.
  $txt = ('CoreAI: Server status is '.$serverStat.' on '.$date.'. ');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
  $output = $output."Yes, Sir! \r";
  echo nl2br($output);
  // / Check to see if our server is busy. Find other nodes on the local network to help if so.
  $getServBusy = getServBusy();
  $serverIDCFH = hash('sha256', $serverID.$sesID.$day); 
  require($CallForHelp); }