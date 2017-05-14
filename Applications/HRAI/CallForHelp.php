<?php
// / This file specifies the addresses this HRAI node will check for in the event of a CallForHelp request. These
// / are automatically set to the most common locations for local nodes, but could be external as well. 
// SECRET: Define the ServerID here to enable the CallForHelp feature. 

$InstLoc = '/var/www/html/HRProprietary/HRCloud2';
$coreFuncfile = $InstLoc.'/Applications/HRAI/coreFunc.php';
$coreArrfile = $InstLoc.'/Applications/HRAI/coreArr.php';
$coreVarfile = $InstLoc.'/Applications/HRAI/coreVar.php';
include($coreVarfile);
include_once($coreFuncfile);
include($adminInfofile);

if (isset($_POST['serverIDCFH'])) {
  $display_name = $_POST['display_name'];
  $user_ID = $_POST['user_ID'];
  $sesID = $_POST['sesID'];
  $day = date("d");
  $sesLogfile = ('/HRCloud2/Applications/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/HRAI-'.$sesID.'.txt'); 
  $serverIDCFH = $_POST['serverIDCFH'];
  $date = date("F j, Y, g:i a");
// SECRET: If the server ID hash matches the sha256 hash of the current server ID + the sesID + the day of the month, 
// SECRET: we continue processing the call for help request.
if ($serverIDCFH == hash('sha256', $serverID.$sesID.$day)) {
echo nl2br("This server has requested assistance. Searching for online nodes... \r");
  $txt = ('CallForHelp: Server reequests assistance on '.$date.'. Aquiring nodes. ');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
  $CallForHelp = getNode('http://192.168.1.2');
  echo nl2br("   Checking  http://192.168.1.2 \r");
  if ($CallForHelp == 0) {
  echo nl2br("   Checking  http://192.168.1.3 \r");
  $CallForHelp = getNode('http://192.168.1.3');
  if ($CallForHelp == 0) {
  echo nl2br("   Checking  http://192.168.1.4 \r");
  $CallForHelp = getNode('http://192.168.1.4');
  if ($CallForHelp == 0) {
  echo nl2br("   Checking  http://192.168.1.5 \r");
  $CallForHelp = getNode('http://192.168.1.5');
  if ($CallForHelp == 0) {
  echo nl2br("   Checking  http://192.168.1.6 \r");
  $CallForHelp = getNode('http://192.168.1.6');
  if ($CallForHelp == 0) {
  echo nl2br("   Checking  http://192.168.1.7 \r");
  $CallForHelp = getNode('http://192.168.1.7');
  if ($CallForHelp == 0) {
  echo nl2br("   Checking  http://192.168.1.8 \r");
  $CallForHelp = getNode('http://192.168.1.8');
  if ($CallForHelp == 0) {
  echo nl2br("   Checking  http://192.168.1.9 \r");
  $CallForHelp = getNode('http://192.168.1.9');
  if ($CallForHelp == 0) {
    echo nl2br("   Checking  http://192.168.1.10 \r");
    $CallForHelp = getNode('http://192.168.1.10'); 
  // / If we cannot find other servers to help us we keep going anyway.
    $sesLogfileO = fopen("$sesLogfile", "a+");
    echo nl2br("  No nodes found on local network. \r");
    echo nl2br("  Continuing with limited resources... \r");
    $txt = ('CallForHelp: Scanned network for nodes on '.$date.'. Found no HRAI servers. Continuing with limited resources... ');
    $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); } } } } } } } } }  

  if ($CallForHelp !== 0) {
  // / If we can find other servers to help us we write the result to the sesLog.
    $sesLogfileO = fopen("$sesLogfile", "a+");
    echo nl2br("  $nodeCount nodes found on local network. \r");
    echo nl2br("  Expanding resources... \r");
    $txt = ('CallForHelp: Scanned network for nodes on '.$date.'. Found '.$nodeCount.' nodes. Expanding resources... ');
    $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); } }