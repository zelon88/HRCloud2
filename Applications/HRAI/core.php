<!DOCTYPE html>
<html>
<head>
<title>HRAI Core</title>
</head>
<div align='center'>
<img id='logo' src='Resources/logoslow.gif'/>
</div>
<div align='center'>
<body>
<?php
session_start();
// SECRET: Get core AI files as well as array and variable libraries.
// SECRET: The nodeCache is where data about recent HRAI networks is stored. 
// SECRET: The $nodeCache is a machine generated file.
//echo nl2br("Starting HRAI Core!"."\r\r");
$langParserfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/langPar.php';
$onlineFile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/online.php';
$coreVarfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/coreVar.php';
$coreFuncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/coreFunc.php';
$coreArrfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/coreArr.php';
$nodeCache = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/Cache/nodeCache.php';
$CallForHelpURL = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CallForHelp.php';
$wpfile = '/var/www/html/wp-load.php';
$date = date("F j, Y, g:i a");
$day = date("d");

// / Load core AI files. Write an entry to the log if successful.
require_once($coreVarfile);
require_once($coreArrfile);
require_once($coreFuncfile);
require_once($onlineFile);
//echo nl2br("Sucessfully loaded library files. \r");

// / Set our Post data for the session. If blank we substitute defaults to avoid errors.
$display_name = defineDisplay_Name();
$user_ID = defineUser_ID();
if (file_exists($wpfile)) {
require_once($wpfile);
global $current_user;
get_currentuserinfo();
$user_ID = get_current_user_id();
if ($user_ID == 1) {
  include '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/adminINFO.php'; }
if ($user_ID !== 1) {
$display_name = get_currentuserinfo() ->$display_name; } }
$inputServerID = defineInputServerID();
$input = defineUserInput();
$DetectWordPress = detectWordPress();
echo nl2br($DetectWordPress);
if (isset ($_POST['display_name'])) {
  $display_name = $_POST['display_name']; }
if (isset ($_POST['user_ID'])) {
  $user_ID = $_POST['user_ID']; }
if (isset ($_POST['sesID'])) {
  $sesID = $_POST['sesID']; }
if (isset ($_POST['inputServerIDHash'])) {
  $inputServerID = $_POST['inputServerID'];
  $inputServerIDHash = hash ('sha1',$inputServerID);
    if ($inputServerIDHash !== $_POST['inputServerIDHash']) { 
      die ('This request could not be authenticated!'); } }
if (!isset ($_POST['sesID'])) {
$sesIDhash = hash('sha1', $display_name.$day);
$sesID = substr($sesIDhash, -7); }
$ForceCreateSesDir = forceCreateSesDir();
$sesLogfile = ('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.$sesID.'.txt'); 
if ($sesLogfile !== $ForceCreateSesDir) {
  //echo nl2br("There was an issue creating the session directory.\r"); 
}
//echo nl2br("\rSucessfully loaded core variables. \r");
//echo nl2br("Sucessfully loaded core functions. \r");
//echo nl2br("Sucessfully loaded core POST data. \r");

// / Write an entry to logfile if there was a problem loading library files.
if (!file_exists($coreArrfile)) {
  $sesLogfile0 = fopen("$sesLogfile", "a+");
  $txt = ('CoreAI: '."User $display_name".','." $user_ID during $sesID on $date".'. ERROR: No coreArrfile 
  	      array file found. Continuing... ');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($coreVarfile)){
  $sesLogfile0 = fopen("$sesLogfile", "a+");
  $txt = ('CoreAI: '."User $display_name".','." $user_ID during $sesID on $date".'. ERROR: No coreVarfile 
  	      variable file found. Continuing... ');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); }

// / Check how many other HRAI servers are in the vicinity. Return number of servers.
include($nodeCache); 
$serverStat = getServStat();
//echo nl2br("Sucessfully loaded nodeCache. \r");
//echo nl2br("This server ID and status variables are $serverStat. \r");
// / Write the nodeCount to the sesLogfile.
$sesLogfileO = @fopen("$sesLogfile", "a+");
$txt = ('CoreAI: Loaded nodeCache, nodeCount is '.$nodeCount.' on '.$date.'. ');
$compLogfile = @file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
// / Get the status of this server and write it to the sesLogfile.
$sesLogfileO = @fopen("$sesLogfile", "a+");
$txt = ('CoreAI: Server status is '.$serverStat.' on '.$date.'. ');
$compLogfile = @file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
// / Since we silenced warnings from our above file open code, we will politely tell the user
// / if there was in issue.
$sesLogfile = ('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.$sesID.'.txt'); 
if (!file_exists($sesLogfile)) {
  echo nl2br('Discrepency detected!'."\r"); }

// / Check to see if our server is busy. Find other nodes on the local network to help if so.
$getServBusy = getServBusy();
if ($getServBusy == 1) {
$serverIDCFH = hash('sha1', $serverID.$sesID.$day); 
echo nl2br("This server reports it is busy! \r"); 
  $CallForHelpURL = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CallForHelp.php';
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
    echo nl2br("   Activating CallForHelp! Continuing... \r");  }

if ($getServBusy <= 1) {


  if (($_POST['input']) != '') {  
          $dataArr = array('user_ID' => "$user_ID",
            'display_name' => "$display_name",
            'sesID' => "$sesID", 
            'input' => "$input",
            'serverID' => "$serverID"); 
    $handle = curl_init($langParserfile);
  curl_setopt($handle, CURLOPT_POST, true);
  curl_setopt($handle, CURLOPT_POSTFIELDS, $dataArr);
  curl_exec($handle);
    $sesLogfileO = fopen("$sesLogfile", "a+");
    $txt = ('CoreAI:Sent a langPar request on '.$date.'. Continuing... ');
    $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
    //echo nl2br("Sent a local LangPar request.\r"); 
  } }

$cpuUseNow = getServCPUUseNow();
$servMemUse = getServMemUse();
$servPageUse = getServPageUse();
//echo nl2br("\r"); 
//echo nl2br('CPU Average: '.$cpuUseNow."\r"); 
///echo nl2br("Node Count: $nodeCount \r");
//cho nl2br("--------------------------------\r");

if (!file_exists($sesLogfile)) {
  echo nl2br('The core is not synced!'."\r"); }

// / Some basic commands to get the project started. Simple stuff, no computational thought or hashing.
// / Before we sinplify our input by removing punctuation and convert uppercase to lowercase we copy
// / the raw input to a new variable name, just-in-case. 
$inputRAW = $input;
$input = str_replace(',','',$input); 
$input = str_replace('.','',$input);
$input = str_replace('!','',$input); 
$input = str_replace('?','',$input);
$input = str_replace(',',"\'",$input); 
$input = strtolower ($input);
?>
<div id="end"></div>
<?php
$CoreGreetings = array('hello','hi','hey','sup',);
// / First we respond to basic greetings.
if ($input == 'hello'){
  echo nl2br('Hello, Commander! '."\r"); 
$input = preg_replace('/hello/','',$input);
$input = str_replace('hello ','',$input); }
if ($input == 'hi'){
  echo nl2br('Hello, Commander! '."\r");
$input = preg_replace('/hi/','',$input); 
$input = str_replace('hi ','',$input); }
if ($input == 'hey'){
  echo nl2br('Hello, Commander! '."\r"); 
$input = preg_replace('/hey/','',$input);
$input = str_replace('hey ','',$input); }
if ($input == 'sup'){
  echo nl2br('Hello, Commander! '."\r");
$input = preg_replace('/sup/','',$input);
$input = str_replace('sup ','',$input); }

// / Then we subtract basic greetings from the rest of the input, incase there is a command
// / behind the greeting. Again, this is very simple stuff.

$first3 = substr($input, 0, 3);
if ($first3 == 'hi '){
  echo nl2br('Hello, Commander! '."\r"); 
$input = str_replace('hi ','',$input); }

// / Now that we've condensed our input a bit we remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);

$first4 = substr($input, 0, 4);
if ($first4 == 'hey '){
  echo nl2br('Hello, Commander! '."\r"); 
$input = str_replace('hey ','',$input); }
if ($first4 == 'sup '){
  echo nl2br('Hello, Commander! '."\r"); 
$input = str_replace('sup ', '', $input); }

// / Now that we've condensed our input a bit we remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);

$first5 = substr($input, 0, 5);
if ($first5 == 'hello'){
  echo nl2br('Hello, Commander! '."\r"); 
$input = str_replace('hello ','',$input); }

// / Now that we've condensed our input a bit we remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);

$first6 = substr($input, 0, 6);
if ($first6 == 'please'){
  echo nl2br('Of course! '."\r");  
$input = preg_replace('/please /', '', $input); }

$last6 = substr($input, 0, -6);
if ($last6 == 'please'){
  echo nl2br('Of course! '."\r"); 
$input = preg_replace('/ please/', '', $input); }

// / Now that we've condensed our input a bit we remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);

$last8 = substr($input, 0, -8);
if ($last8 == 'thank you'){
  echo nl2br('My pleasure! '."\r"); 
$input = preg_replace('/ please/', '', $input); }

if (preg_match('/please/', $input)){
  echo nl2br('Of course! '."\r");  
$input = preg_replace('/please /','',$input);
$input = str_replace('please','',$input); }

if (preg_match('/thanks/', $input)){
  echo nl2br('My pleasure! '."\r");  
$input = preg_replace('/thanks/',' ',$input);
$input = str_replace('thanks','',$input); }

if (preg_match('/thx/', $input)){
  echo nl2br('My pleasure! '."\r");  
$input = preg_replace('/thx/',' ',$input);
$input = str_replace('thx','',$input); }

if (preg_match('/thank you/', $input)){
  echo nl2br('My pleasure! '."\r");  
$input = preg_replace('/thank you/',' ',$input);
$input = str_replace('thank you','',$input); }

// / Now that we've condensed our input a bit we remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);

// SECRET: Here we load a file containing all of the commands specific to logged-in WP users.
if ($user_ID !== 0) {
  if (preg_match('/sconvert file/', $input)) {
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconv.php'; 
include $CMDsyncfile; 
$input = preg_replace('/sync node/',' ',$input);} }


// / Here are the more complicated commands. To avoid making this script 5,000 lines long,
// / there is a CoreCommands directory in the hosted HRAI folder (/var/www/html) for the bulk
// / of this code. It's all really simple, no learning or research or hashing.
// /
// / Update / Refresh / Sync
if (preg_match('/sync node/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/sync node/',' ',$input);} 
if (preg_match('/who are you/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/who are you/',' ',$input);} 
if (preg_match('/node sync/', $input)) { 
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/node sync/',' ',$input);} 
if (preg_match('/whats your serverid/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/whats your serverid/',' ',$input);} 
if (preg_match('/what is your serverid/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/what is your server id/',' ',$input);} 
if (preg_match('/whats your server id/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/whats your server id/',' ',$input);} 
if (preg_match('/what is your serverid/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/what is your server id/',' ',$input);} 
if (preg_match('/reload node/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/reload node/',' ',$input);} 
if (preg_match('/refresh node/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/refresh node/',' ',$input);} 
if (preg_match('/update node/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/update node/',' ',$input); } 
if (preg_match('/syncnode/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/syncnode/',' ',$input); }
if (preg_match('/sync your node/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/sync your node/',' ',$input); }
if (preg_match('/reload your node/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/reload your node/',' ',$input); }
if (preg_match('/refresh your node/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/refresh your node/',' ',$input); }
if (preg_match('/nodesync/', $input)) {  
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/nodesync/',' ',$input); }
if (preg_match('/get node/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile;
$input = preg_replace('/get node/',' ',$input); } 
if (preg_match('/refresh the nodecache/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile;
$input = preg_replace('/refresh the nodecache/',' ',$input); } 
if (preg_match('/reload the nodecache/', $input)) {
$CMDsyncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile;
$input = preg_replace('/reload the nodecache/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);


if (preg_match('/callforhelp/', $input)) {
$CMDcfhfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcfh.php'; 
include $CMDcfhfile; 
$input = preg_replace('/callforhelp/',' ',$input); }
if (preg_match('/call for help/', $input)) { 
$CMDcfhfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcfh.php'; 
include $CMDcfhfile; 
$input = preg_replace('/call for help/',' ',$input); }
if (preg_match('/cfh/', $input)) {
$CMDcfhfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcfh.php'; 
include $CMDcfhfile; } 
if (preg_match('/get help/', $input)) {
$CMDcfhfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcfh.php'; 
include $CMDcfhfile; 
$input = preg_replace('/get help/',' ',$input); } 
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);

if (preg_match('/what time/', $input)) { 
 $CMDtimefile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/what time/',' ',$input); }
if (preg_match('/what is the time/', $input)) {
 $CMDtimefile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/what is the time/',' ',$input); }
if (preg_match('/whats the time/', $input)) {
 $CMDtimefile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/whats the time/',' ',$input); }
if (preg_match('/have you got the time/', $input)) {
 $CMDtimefile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile;
$input = preg_replace('/have you got the time/',' ',$input); } 
if (preg_match('/have you got the date/', $input)) {
 $CMDtimefile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/have you got the date/',' ',$input); }
if (preg_match('/what is the date/', $input)) {  
 $CMDtimefile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDtime.php'; 
 include $CMDtimefile; 
$input = preg_replace('/what is the date/',' ',$input); }
if (preg_match('/whats the the date/', $input)) {  
 $CMDtimefile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; }
if (preg_match('/what day is it/', $input)) {  
 $CMDtimefile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/what day is it/',' ',$input); }
if (preg_match('/what date is it/', $input)) {  
 $CMDtimefile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/what date is it',' ',$input); }
if (preg_match('/date/', $input)) {  
 $CMDtimefile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; }
if (preg_match('/the time/', $input)) {  
 $CMDtimefile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/the time/',' ',$input); }
if (preg_match('/what time/', $input)) {  
 $CMDtimefile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/what time/',' ',$input); }
if (preg_match('/tell me the day/', $input)) {   
 $CMDtimefile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/tell me the day/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);

if (preg_match('/what is your status/', $input)) {  
 $CMDbusyfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDbusy.php'; 
include $CMDbusyfile; 
$input = preg_replace('/what is your status/',' ',$input); }
if (preg_match('/whats your status/', $input)) {  
 $CMDbusyfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDbusy.php'; 
include $CMDbusyfile; 
$input = preg_replace('/whats your status/',' ',$input); }
if (preg_match('/server status/', $input)) {  
 $CMDbusyfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDbusy.php'; 
include $CMDbusyfile; 
$input = preg_replace('/server status/',' ',$input); }
if (preg_match('/busy/', $input)) {  
 $CMDbusyfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDbusy.php'; 
include $CMDbusyfile; 
$input = preg_replace('/busy/',' ',$input); } 
if (preg_match('/idle/', $input)) {  
 $CMDbusyfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDbusy.php'; 
include $CMDbusyfile; 
$input = preg_replace('/idle/',' ',$input); } 
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);

if (preg_match('/what is your uptime/', $input)) {  
 $CMDuptfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDuptime.php'; 
include $CMDuptfile; 
$input = preg_replace('/what is your uptime/',' ',$input); }
if (preg_match('/how long have you been online/', $input)) {  
 $CMDuptfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDuptime.php'; 
include $CMDuptfile; 
$input = preg_replace('/how long have you been online/',' ',$input); }
if (preg_match('/uptime/', $input)) {  
 $CMDuptfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDuptime.php'; 
include $CMDuptfile; 
$input = preg_replace('/uptime/',' ',$input); }
if (preg_match('/how long have you been up/', $input)) {  
 $CMDuptfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDuptime.php'; 
include $CMDuptfile; 
$input = preg_replace('/how long have you been up/',' ',$input); }
if (preg_match('/how long have you been awake/', $input)) {  
 $CMDuptfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDuptime.php'; 
include $CMDuptfile; 
$input = preg_replace('/how long have you been awake/',' ',$input); }
if (preg_match('/how long have you been on/', $input)) {  
 $CMDuptfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDuptime.php'; 
include $CMDuptfile; 
$input = preg_replace('/how long have you been on/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);

if (preg_match('/convert a/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert a/',' ',$input); }
if (preg_match('/convert this/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert this/',' ',$input); }
if (preg_match('/convert my/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert my/',' ',$input); }
if (preg_match('/convert file/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert file/',' ',$input); }
if (preg_match('/convert image/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert image/',' ',$input); }
if (preg_match('/convert photo/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert photo/',' ',$input); }
if (preg_match('/convert picture/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert picture/',' ',$input); }
if (preg_match('/convert song/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert song/',' ',$input); }
if (preg_match('/convert media/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert media/',' ',$input); }
if (preg_match('/convert archive/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert archive/',' ',$input); }
if (preg_match('/convert mp3/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert mp3/',' ',$input); }
if (preg_match('/convert zip/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert zip/',' ',$input); }
if (preg_match('/convert rar/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert rar/',' ',$input); }
if (preg_match('/convert jpg/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert jpg/',' ',$input); }
if (preg_match('/convert jpeg/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert jpeg/',' ',$input); }
if (preg_match('/convert bmp/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert bmp/',' ',$input); }
if (preg_match('/convert 7z/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert 7z/',' ',$input); }
if (preg_match('/convert something/', $input)) {  
$CMDconvfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert something/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);

if (preg_match('/scan a/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan a/',' ',$input); }
if (preg_match('/scan this/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/convert this/',' ',$input); }
if (preg_match('/scan my/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan my/',' ',$input); }
if (preg_match('/scan file/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRAI/HRCloud2/Applications/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan file/',' ',$input); }
if (preg_match('/scan image/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRAI/HRCloud2/Applications/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan image/',' ',$input); }
if (preg_match('/scan photo/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRAI/HRCloud2/Applications/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan photo/',' ',$input); }
if (preg_match('/scan picture/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRAI/HRCloud2/Applications/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan picture/',' ',$input); }
if (preg_match('/scan song/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRAI/HRCloud2/Applications/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan song/',' ',$input); }
if (preg_match('/scan media/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan media/',' ',$input); }
if (preg_match('/convert archive/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan archive/',' ',$input); }
if (preg_match('/scan mp3/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan mp3/',' ',$input); }
if (preg_match('/scan zip/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan zip/',' ',$input); }
if (preg_match('/scan rar/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan rar/',' ',$input); }
if (preg_match('/convert jpg/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan jpg/',' ',$input); }
if (preg_match('/scan jpeg/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan jpeg/',' ',$input); }
if (preg_match('/scan bmp/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan bmp/',' ',$input); }
if (preg_match('/scan 7z/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan 7z/',' ',$input); }
if (preg_match('/scan something/', $input)) {  
$CMDscanfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan something/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);

if (preg_match('/what is your cpu/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/what is your cpu/',' ',$input); }
if (preg_match('/what cpu/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/what cpu/',' ',$input); }
if (preg_match('/cpu info/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu info/',' ',$input); }
if (preg_match('/cpu status/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu status/',' ',$input); }
if (preg_match('/cpu usage/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu usage/',' ',$input); }
if (preg_match('/cpu stats/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu stats/',' ',$input); }
if (preg_match('/cpu specs/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu specs/',' ',$input); }
if (preg_match('/cpu specification/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu specification/',' ',$input); }
if (preg_match('/how many cpu/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/how many cpu/',' ',$input); }
if (preg_match('/how many cores/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/how many cores/',' ',$input); }
if (preg_match('/cpu brand/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu brand/',' ',$input); }
if (preg_match('/cpu type/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu type/',' ',$input); }
if (preg_match('/type cpu/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/type cpu/',' ',$input); }
if (preg_match('/brand cpu/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/brand cpu/',' ',$input); }
if (preg_match('/is your cpu/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/is your cpu/',' ',$input); }
if (preg_match('/cpu status/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu status/',' ',$input); }
if (preg_match('/processor status/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/processor status/',' ',$input); }
if (preg_match('/processor brand/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/processor brand/',' ',$input); }
if (preg_match('/processor type/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/processor type/',' ',$input); }
if (preg_match('/type processor/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/type processor/',' ',$input); }
if (preg_match('/brand processor/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/brand processor/',' ',$input); }
if (preg_match('/is your processor/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/is your processor/',' ',$input); }
if (preg_match('/intel or amd/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/intel or amd/',' ',$input); }
if (preg_match('/amd or intel/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/amd or intel/',' ',$input); }
if (preg_match('/arm or amd/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/arm or amd/',' ',$input); }
if (preg_match('/arm or intel/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/arm or intel/',' ',$input); }
if (preg_match('/intel or arm/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/intel or arm/',' ',$input); }
if (preg_match('/amd or arm/', $input)) {  
$CMDcpuinfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/amd or arm/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);

if (preg_match('/how much ram/', $input)) {  
$CMDmeminfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/how much ram/',' ',$input); }
if (preg_match('/how much memory/', $input)) {  
$CMDmeminfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/how much memory/',' ',$input); }
if (preg_match('/ram usage/', $input)) {  
$CMDmeminfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/ram usage/',' ',$input); }
if (preg_match('/ram use/', $input)) {  
$CMDmeminfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/ram use/',' ',$input); }
if (preg_match('/memory use/', $input)) {  
$CMDmeminfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/memory use/',' ',$input); }
if (preg_match('/mem use/', $input)) {  
$CMDmeminfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/mem use/',' ',$input); }
if (preg_match('/mem info/', $input)) {  
$CMDmeminfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/mem info/',' ',$input); }
if (preg_match('/memory info/', $input)) {  
$CMDmeminfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile;  
$input = preg_replace('/memory info/',' ',$input); }
if (preg_match('/ram info/', $input)) {  
$CMDmeminfofile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/ram info/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
?>
</div>

</body>
</html>