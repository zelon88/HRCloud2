<?php
// / This file specifies the addresses this HRAI node will check for in the event of a CallForHelp request. These
// / are automatically set to the most common locations for local nodes, but could be external as well. 
// SECRET: Define the ServerID here to enable the CallForHelp feature. 

// SECRET:  ----------------------------------------------
// SECRET: The server ID of the server is defined below.
// SECRET: See below for an example with serverID GamingRig. 
include '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/adminINFO.php';
// SECRET:  ----------------------------------------------

$coreFuncFile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/coreFunc.php';

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
  include ($coreFuncFile);
echo nl2br("This server has requested assistance. Searching for online nodes... \r");
  $sesLogfileO = fopen("$sesLogfile", "a+");
  $txt = ('CallForHelp: Server reequests assistance on '.$date.'. Aquiring nodes. ');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
  $CallForHelp = getNode('http://192.168.1.2');
  echo nl2br("   Checking  http://192.168.1.2 \r");
  if ($CallForHelp < 9) {
  echo nl2br("   Checking  http://192.168.1.3 \r");
  $CallForHelp = getNode('http://192.168.1.3');
  if ($CallForHelp < 9) {
  echo nl2br("   Checking  http://192.168.1.10 \r");
  $CallForHelp = getNode('http://192.168.1.10');
  if ($CallForHelp < 9) {
  echo nl2br("   Checking  http://192.168.1.16 \r");
  $CallForHelp = getNode('http://192.168.1.16');
  if ($CallForHelp < 9) {
  echo nl2br("   Checking  http://192.168.1.15 \r");
  $CallForHelp = getNode('http://192.168.1.15');
  if ($CallForHelp < 9) {
  echo nl2br("   Checking  http://192.168.1.14 \r");
  $CallForHelp = getNode('http://192.168.1.14');
  if ($CallForHelp < 9) {
  echo nl2br("   Checking  http://192.168.1.13 \r");
  $CallForHelp = getNode('http://192.168.1.13');
  if ($CallForHelp < 9) {
  echo nl2br("   Checking  http://192.168.1.12 \r");
  $CallForHelp = getNode('http://192.168.1.12');
  if ($CallForHelp < 9) {
    echo nl2br("   Checking  http://192.168.1.11 \r");
    $CallForHelp = getNode('http://192.168.1.11'); 
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