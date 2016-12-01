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
  $sesLogfileO = fopen("$sesLogfile", "a+");
  $txt = ('CoreAI: RELOADED nodeCache, nodeCount is '.$nodeCount.' on '.$date.'. ');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
  // / Get the status of this server and write it to the sesLogfile.
  $sesLogfileO = fopen("$sesLogfile", "a+");
  $txt = ('CoreAI: Server status is '.$serverStat.' on '.$date.'. ');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
echo nl2br("Yes, Sir! \r");
// / Check to see if our server is busy. Find other nodes on the local network to help if so.
  $getServBusy = getServBusy();
  $serverIDCFH = hash('sha1', $serverID.$sesID.$day); 
  $CallForHelpURL = '/var/www/html/HRProprietary/HRAI/ForceCallForHelp.php';
          $dataArr = array('user_ID' => "$user_ID",
            'display_name' => "$display_name",
            'serverIDCFH' => "$serverIDCFH",
            'sesID' => "$sesID", 
            'serverID' => "$serverID"); 
    $handle = curl_init($CallForHelpURL);
  curl_setopt($handle, CURLOPT_POST, true);
  curl_setopt($handle, CURLOPT_POSTFIELDS, $dataArr);
  curl_exec($handle);
    $sesLogfileO = fopen("$sesLogfile", "a+");
    $txt = ('CoreAI: Sent a CallForHelp request on '.$date.'. Continuing the script. ');
    $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br("-CallForHelp activated! \r");
    echo nl2br("--------------------------------\r"); }