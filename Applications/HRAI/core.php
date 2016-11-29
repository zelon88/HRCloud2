<!DOCTYPE html>
<html>
<head>
<title>HRAI Core</title>
<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
</head>
<body>
  <div name="top"></div>
<?php 
if (isset($_POST['display_name'])) {
  $_POST['display_name'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['display_name']); }
if (!isset($_POST['input'])) { ?>
<div id="HRAITop" align='center'><img id='logo' src='Resources/logoslowbreath.gif'/></div>
<?php } 
if (isset($_POST['input'])) {
  $_POST['input'] = str_replace(str_split('[]{};:$#^&%@>*<'), '', $_POST['input']); ?>
<div id="HRAITop" style="float: left; margin-left: 15px;">
<img id='logo' src='Resources/logo.gif'/>
</div>
<?php } 
if (!isset($_POST['input'])) { ?>
<div align='center'>
<?php } 
if (isset($_POST['input'])) { ?>
<div style="float: right; padding-right: 50px;">
<?php } ?>
<script>
jQuery('#input').on('input', function() {
  $("#logo").attr("src","Resources/logo.gif");
});
jQuery('#submitHRAI').on('submit', function() {
  $("#logo").attr("src","Resources/logo.gif");
});
</script>
<?php
session_start();
// SECRET: Get core AI files as well as array and variable libraries.
// SECRET: The nodeCache is where data about recent HRAI networks is stored. 
// SECRET: The $nodeCache is a machine generated file.
//echo nl2br("Starting HRAI Core!"."\r\r");
$InstLoc = '/var/www/html/HRProprietary/HRCloud2';
$langParserfile = $InstLoc.'/Applications/HRAI/langPar.php';
$onlineFile = $InstLoc.'/Applications/HRAI/online.php';
$coreVarfile = $InstLoc.'/Applications/HRAI/coreVar.php';
$coreFuncfile = $InstLoc.'/Applications/HRAI/coreFunc.php';
$coreArrfile = $InstLoc.'/Applications/HRAI/coreArr.php';
$nodeCache = $InstLoc.'/Applications/HRAI/Cache/nodeCache.php';
$CallForHelpURL = $InstLoc.'/Applications/HRAI/CallForHelp.php';
$wpfile = '/var/www/html/wp-load.php';
$date = date("F j, Y, g:i a");
$hour = date("g:i a");
$day = date("d");
// / Load core AI files. Write an entry to the log if successful.
require_once($coreVarfile);
require_once($coreArrfile);
require_once($coreFuncfile);
require_once($onlineFile);
require_once($InstLoc.'/config.php');
//echo nl2br("Sucessfully loaded library files. \r");
// / Set our Post data for the session. If blank we substitute defaults to avoid errors.

// / The following code starts WordPress.
$DetectWordPress = detectWordPress();

// / The followind code handles POSTED variables from other HRAI nodes.
$display_name = defineDisplay_Name();
$user_IDPOST = defineUser_ID(); 
$sesIDPOST = authSesID();
$input = defineUserInput();

// / The following code detects the user_ID and returns related variables.
$user_IDRAW = get_current_user_id();
$user_ID = hash('ripemd160', $user_IDRAW.$Salts);

if (isset($_POST['HRAIMiniGUIPost'])) {
  $noMINICore = '1';
  $includeMINIIframer = '1'; }
if (!isset($_POST['HRAIMiniGUIPost'])) {
  $noMINICore = '1'; 
  $includeMINIIFramer = '0'; }
if (!isset($_POST['sesID'])) {
$sesIDhash = hash('sha1', $display_name.$day);
$sesID = substr($sesIDhash, -7); }

// / The following code creates the session directory and session log files.
$CreateSesDir = forceCreateSesDir();
$sesLogfile = ($InstLoc.'/Applications/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.$sesID.'.txt'); 
$JICsesLogfileDir = ($InstLoc.'/Applications/HRAI/sesLogs/'.$user_ID.'/'.$sesID);
if (!is_dir($JICsesLogfileDir)) {
  mkdir($JICsesLogfileDir, 0755); }
if (!file_exists($JICsesLogfileDir)) {
  $JICCreateSesDir = file_put_contents($sesLogfile, ''); }

// / The following code verifies that a POSTED HRAI request came from a node with similar Salts.
if (isset ($_POST['inputServerIDHash'])) {
  $inputServerID = str_replace(str_split('[]{};:$#^&%@>*<'), '', $_POST['inputServerID']);
  $inputServerIDHash = hash ('sha1',$inputServerID.$networkSalts);
  $sesLogfile0 = fopen("$sesLogfile", "a+");
  $txt = ('CoreAI: Server '.$inputServerID.', connecting with '.$inputServerIDHash.' using sesID: '.$sesIDPOST.' and user_ID: '.$user_IDPOST.' on '.$date.'.');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND);
  if ($inputServerIDHash !== $_POST['inputServerIDHash']) {
    $txt = ('ERROR!!! HRAI101, This request could not be authenticated! inputServerIDHash Discrepency!');
    $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND);
    die ('ERROR!!! HRAI101, This request could not be authenticated!'); } }
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
if (!file_exists($sesLogfile)) {
  echo nl2br('Discrepency detected!'."\r"); }
// / Check to see if our server is busy. Find other nodes on the local network to help if so.
$getServBusy = getServBusy();
if ($getServBusy == 1) {
$serverIDCFH = hash('sha1', $serverID.$sesID.$day); 
echo nl2br("This server reports it is busy! \r"); 
  $CallForHelpURL = $InstLoc.'/Applications/HRAI/CallForHelp.php';
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
  if (($_POST['input']) !== '') {  
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
set_time_limit(0);
$CoreGreetings = array('hello','hi','hey','sup',);
$BasicTimeofDay = array('moirning','noon','afternoon','evening','night');
// / Return a specific basic greeting depending on time of day.
if ($user_ID == '0') {
  echo nl2br('You are not logged in! This session is temporary! '."\r"); }
// / Set time specific basic responses.
$timeGreeting = 'Hello, ';
$StopTime = '0';
// / Code for modning specific responses.
  if (date("H") <= '15' && date("H") > '3'){
    if (preg_match('/good morning/',$input)) { 
      echo nl2br('Good morning, Commander!'."\r"); 
      $input = preg_replace('/good morning/','',$input);
      $input = str_replace('good morning','',$input); }
    if (preg_match('/good afternoon/',$input)) {
      echo nl2br('It\'s only '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/good afternoon/','',$input);
      $input = str_replace('good afternoon','',$input); }
    if (preg_match('/good day/',$input)) {
      echo nl2br('It\'s only '.$hour.', Commander.'."\r");  
      $input = preg_replace('/good day/','',$input);
      $input = str_replace('good day ','',$input); }
    if (preg_match('/good evening/',$input)) {
      echo nl2br('It\'s only '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/good evening/','',$input);
      $input = str_replace('good evening','',$input); }
    if (preg_match('/good night/',$input)) {
      echo nl2br('Goodnight, Commander.'."\r"); 
      $input = preg_replace('/good night/','',$input);
      $input = str_replace('goodnight','',$input); }
    if (preg_match('/goodnight/',$input)) { 
      echo nl2br('Goodnight, Commander.'."\r"); 
      $input = preg_replace('/goodnight/','',$input);
      $input = str_replace('goodnight','',$input); }
    $timeGreeting = 'Good morning, '; }
// / Code for afternoon specific responses.
if ($StopTime == '0') {
  if (date("H") >= '15' && date("H") <= '20'){  
    if (preg_match('/good afternoon/',$input)) {
      echo nl2br('It has been so far, Commander!'."\r"); 
      $input = preg_replace('/good afternoon/','',$input);
      $input = str_replace('good afternoon','',$input); }
    if (preg_match('/good day/',$input)) {
      echo nl2br('It has been so far, Commander!'."\r"); 
      $input = preg_replace('/good day/','',$input);
      $input = str_replace('good day ','',$input); }
    if (preg_match('/good morning/',$input)) {
      echo nl2br('It\'s '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/good morning/','',$input);
      $input = str_replace('good morning','',$input); }
    if (preg_match('/good evening/',$input)) {
      echo nl2br('It\'s still only '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/good evening/','',$input);
      $input = str_replace('good evening','',$input); }
    if (preg_match('/good night/',$input)) {
      echo nl2br('Goodnight, although it\'s only '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/good night/','',$input);
      $input = str_replace('good night','',$input); }
    if (preg_match('/goodnight/',$input)) {
      echo nl2br('Goodnight, although it\'s only '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/goodnight/','',$input);
      $input = str_replace('goodnight','',$input); }
    $timeGreeting = 'Good afternoon, '; 
    $StopTime++; } }
// / Code for evening specific responses.
if ($StopTime == '0') {
  if (date("H") >= '20' or date("H") <= '3') {
    if (preg_match('/good evening/',$input)){
      echo nl2br('Yes, Commander. It has been.'."\r"); 
      $input = preg_replace('/good evening/','',$input);
      $input = str_replace('good evening','',$input); }
    if (date("H") >= '3' && date("H") <= '12') {
      if (preg_match('/good morning/',$input)){
        echo nl2br('Yes, Commander. It has been.'."\r"); 
        $input = preg_replace('/good morning/','',$input);
        $input = str_replace('good morning','',$input); } }
    if (date("H") >= '3' && date("H") <= '12' or date("H") > '20') {
      if (preg_match('/good morning/',$input)){      
      echo nl2br('It\'s '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/good morning/','',$input);
      $input = str_replace('good morning','',$input); } }
    if (preg_match('/good afternoon/',$input)){
      echo nl2br('It\'s '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/good afternoon/','',$input);
      $input = str_replace('good afternoon','',$input); }
    if (preg_match('/good day/',$input)){
      echo nl2br('It\'s '.$hour.', Commander.'."\r");  
      $input = preg_replace('/good day/','',$input);
      $input = str_replace('good day ','',$input); }
    if (preg_match('/good night/',$input)){
      echo nl2br('Yes, it was. Goodnight, Commander.'."\r"); 
      $input = preg_replace('/good night/','',$input);
      $input = str_replace('good night','',$input); }
    if (preg_match('/goodnight/',$input)){
      echo nl2br('Yes, it was. Goodnight, Commander.'."\r"); 
      $input = preg_replace('/goodnight/','',$input);
      $input = str_replace('goodnight','',$input); }
    $timeGreeting = 'Good evening, '; 
    $StopTime++; } }
// /a First we respond to basic greetings.
if ($input == 'hello'){
  echo nl2br($timeGreeting.'Commander! '."\r"); 
$input = preg_replace('/hello/','',$input);
$input = str_replace('hello ','',$input); }
if ($input == 'hi'){
  echo nl2br($timeGreeting.'Commander! '."\r");
$input = preg_replace('/hi/','',$input); 
$input = str_replace('hi ','',$input); }
if ($input == 'hey'){
  echo nl2br($timeGreeting.'Commander! '."\r");
$input = preg_replace('/hey/','',$input);
$input = str_replace('hey ','',$input); }
if ($input == 'sup'){
  echo nl2br($timeGreeting.'Commander! '."\r");
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
if (preg_match('/plz/', $input)){
  echo nl2br('No problem, Commander! '."\r");  
$input = preg_replace('/plz /','',$input);
$input = str_replace('plz','',$input); }
if (preg_match('/please/', $input)){
  echo nl2br('Of course, Commander! '."\r");  
$input = preg_replace('/please /','',$input);
$input = str_replace('please','',$input); }
if (preg_match('/thank you/', $input)){
  echo nl2br('My pleasure. '."\r"); 
$input = preg_replace('/ please/', '', $input); }
if (preg_match('/thanks/', $input)){
  echo nl2br('Anytime, Commander! '."\r");  
$input = preg_replace('/thanks/',' ',$input);
$input = str_replace('thanks','',$input); }
if (preg_match('/thx/', $input)){
  echo nl2br('No problem, Commander! '."\r");  
$input = preg_replace('/thx/',' ',$input);
$input = str_replace('thx','',$input); }
if (preg_match('/your name/', $input)){
  echo nl2br('HRAI! '."\r");  
$input = preg_replace('/your name/',' ',$input);
$input = str_replace('your name','',$input); }
if (preg_match('/whats your name/', $input)){
  echo nl2br('HRAI! '."\r");  
$input = preg_replace('/whats your name/',' ',$input);
$input = str_replace('whats your name','',$input); }
if (preg_match('/what is your name/', $input)){
  echo nl2br('HRAI! '."\r");  
$input = preg_replace('/what is your name/',' ',$input);
$input = str_replace('what is your name','',$input); }
// / Now that we've condensed our input a bit we remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
// / Here are the more complicated commands. To avoid making this script 5,000 lines long,
// / there is a CoreCommands directory in the hosted HRAI folder (/var/www/html) for the bulk
// / of this code. It's all really simple, no learning or research or hashing.
// /
// / Update / Refresh / Sync
if (preg_match('/sync node/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/sync node/',' ',$input);} 
if (preg_match('/node sync/', $input)) { 
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/node sync/',' ',$input);} 
if (preg_match('/whats your serverid/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/whats your serverid/',' ',$input);} 
if (preg_match('/what is your serverid/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/whats your serverid/',' ',$input);} 
if (preg_match('/whats your server id/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/whats your server id/',' ',$input);} 
if (preg_match('/what is your serverid/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/what is your serverid/',' ',$input);} 
if (preg_match('/what is your server id/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/what is your server id/',' ',$input);} 
if (preg_match('/reload node/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/reload node/',' ',$input);} 
if (preg_match('/refresh node/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/refresh node/',' ',$input);} 
if (preg_match('/update node/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/update node/',' ',$input); } 
if (preg_match('/syncnode/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/syncnode/',' ',$input); }
if (preg_match('/sync your node/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/sync your node/',' ',$input); }
if (preg_match('/reload your node/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/reload your node/',' ',$input); }
if (preg_match('/refresh your node/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/refresh your node/',' ',$input); }
if (preg_match('/nodesync/', $input)) {  
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile; 
$input = preg_replace('/nodesync/',' ',$input); }
if (preg_match('/get node/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile;
$input = preg_replace('/get node/',' ',$input); } 
if (preg_match('/refresh the nodecache/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile;
$input = preg_replace('/refresh the nodecache/',' ',$input); } 
if (preg_match('/reload the nodecache/', $input)) {
$CMDsyncfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDsync.php'; 
include $CMDsyncfile;
$input = preg_replace('/reload the nodecache/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
if (preg_match('/callforhelp/', $input)) {
$CMDcfhfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcfh.php'; 
include $CMDcfhfile; 
$input = preg_replace('/callforhelp/',' ',$input); }
if (preg_match('/call for help/', $input)) { 
$CMDcfhfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcfh.php'; 
include $CMDcfhfile; 
$input = preg_replace('/call for help/',' ',$input); }
if (preg_match('/cfh/', $input)) {
$CMDcfhfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcfh.php'; 
include $CMDcfhfile; } 
if (preg_match('/get help/', $input)) {
$CMDcfhfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcfh.php'; 
include $CMDcfhfile; 
$input = preg_replace('/get help/',' ',$input); } 
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
if (preg_match('/what time/', $input)) { 
 $CMDtimefile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/what time/',' ',$input); }
if (preg_match('/what is the time/', $input)) {
 $CMDtimefile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/what is the time/',' ',$input); }
if (preg_match('/whats the time/', $input)) {
 $CMDtimefile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/whats the time/',' ',$input); }
if (preg_match('/have you got the time/', $input)) {
 $CMDtimefile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile;
$input = preg_replace('/have you got the time/',' ',$input); } 
if (preg_match('/have you got the date/', $input)) {
 $CMDtimefile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/have you got the date/',' ',$input); }
if (preg_match('/what is the date/', $input)) {  
 $CMDtimefile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDtime.php'; 
 include $CMDtimefile; 
$input = preg_replace('/what is the date/',' ',$input); }
if (preg_match('/whats the the date/', $input)) {  
 $CMDtimefile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; }
if (preg_match('/what day is it/', $input)) {  
 $CMDtimefile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/what day is it/',' ',$input); }
if (preg_match('/what date is it/', $input)) {  
 $CMDtimefile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/what date is it',' ',$input); }
if (preg_match('/date/', $input)) {  
 $CMDtimefile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; }
if (preg_match('/the time/', $input)) {  
 $CMDtimefile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/the time/',' ',$input); }
if (preg_match('/what time/', $input)) {  
 $CMDtimefile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/what time/',' ',$input); }
if (preg_match('/tell me the day/', $input)) {   
 $CMDtimefile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDtime.php'; 
include $CMDtimefile; 
$input = preg_replace('/tell me the day/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
if (preg_match('/what is your status/', $input)) {  
 $CMDbusyfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDbusy.php'; 
include $CMDbusyfile; 
$input = preg_replace('/what is your status/',' ',$input); }
if (preg_match('/whats your status/', $input)) {  
 $CMDbusyfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDbusy.php'; 
include $CMDbusyfile; 
$input = preg_replace('/whats your status/',' ',$input); }
if (preg_match('/server status/', $input)) {  
 $CMDbusyfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDbusy.php'; 
include $CMDbusyfile; 
$input = preg_replace('/server status/',' ',$input); }
if (preg_match('/busy/', $input)) {  
 $CMDbusyfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDbusy.php'; 
include $CMDbusyfile; 
$input = preg_replace('/busy/',' ',$input); } 
if (preg_match('/idle/', $input)) {  
 $CMDbusyfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDbusy.php'; 
include $CMDbusyfile; 
$input = preg_replace('/idle/',' ',$input); } 
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
if (preg_match('/what is your uptime/', $input)) {  
 $CMDuptfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDuptime.php'; 
include $CMDuptfile; 
$input = preg_replace('/what is your uptime/',' ',$input); }
if (preg_match('/how long have you been online/', $input)) {  
 $CMDuptfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDuptime.php'; 
include $CMDuptfile; 
$input = preg_replace('/how long have you been online/',' ',$input); }
if (preg_match('/uptime/', $input)) {  
 $CMDuptfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDuptime.php'; 
include $CMDuptfile; 
$input = preg_replace('/uptime/',' ',$input); }
if (preg_match('/how long have you been up/', $input)) {  
 $CMDuptfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDuptime.php'; 
include $CMDuptfile; 
$input = preg_replace('/how long have you been up/',' ',$input); }
if (preg_match('/how long have you been awake/', $input)) {  
 $CMDuptfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDuptime.php'; 
include $CMDuptfile; 
$input = preg_replace('/how long have you been awake/',' ',$input); }
if (preg_match('/how long have you been on/', $input)) {  
 $CMDuptfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDuptime.php'; 
include $CMDuptfile; 
$input = preg_replace('/how long have you been on/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
if (preg_match('/convert a/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert a/',' ',$input); }
if (preg_match('/convert this/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert this/',' ',$input); }
if (preg_match('/convert my/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert my/',' ',$input); }
if (preg_match('/convert file/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert file/',' ',$input); }
if (preg_match('/convert image/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert image/',' ',$input); }
if (preg_match('/convert photo/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert photo/',' ',$input); }
if (preg_match('/convert picture/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert picture/',' ',$input); }
if (preg_match('/convert song/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert song/',' ',$input); }
if (preg_match('/convert media/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert media/',' ',$input); }
if (preg_match('/convert archive/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert archive/',' ',$input); }
if (preg_match('/convert mp3/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert mp3/',' ',$input); }
if (preg_match('/convert zip/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert zip/',' ',$input); }
if (preg_match('/convert rar/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert rar/',' ',$input); }
if (preg_match('/convert jpg/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert jpg/',' ',$input); }
if (preg_match('/convert jpeg/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert jpeg/',' ',$input); }
if (preg_match('/convert bmp/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert bmp/',' ',$input); }
if (preg_match('/convert 7z/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert 7z/',' ',$input); }
if (preg_match('/convert something/', $input)) {  
$CMDconvfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDconvert.php'; 
include $CMDconvfile; 
$input = preg_replace('/convert something/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
if (preg_match('/scan a/', $input)) {  
$CMDscanfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan a/',' ',$input); }
if (preg_match('/scan this/', $input)) {  
$CMDscanfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/convert this/',' ',$input); }
if (preg_match('/scan my/', $input)) {  
$CMDscanfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'; 
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
$CMDscanfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan media/',' ',$input); }
if (preg_match('/convert archive/', $input)) {  
$CMDscanfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan archive/',' ',$input); }
if (preg_match('/scan mp3/', $input)) {  
$CMDscanfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan mp3/',' ',$input); }
if (preg_match('/scan zip/', $input)) {  
$CMDscanfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan zip/',' ',$input); }
if (preg_match('/scan rar/', $input)) {  
$CMDscanfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan rar/',' ',$input); }
if (preg_match('/convert jpg/', $input)) {  
$CMDscanfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan jpg/',' ',$input); }
if (preg_match('/scan jpeg/', $input)) {  
$CMDscanfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan jpeg/',' ',$input); }
if (preg_match('/scan bmp/', $input)) {  
$CMDscanfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan bmp/',' ',$input); }
if (preg_match('/scan 7z/', $input)) {  
$CMDscanfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan 7z/',' ',$input); }
if (preg_match('/scan something/', $input)) {  
$CMDscanfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'; 
include $CMDscanfile; 
$input = preg_replace('/scan something/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
if (preg_match('/what/', $input) && preg_match('/cpu/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/what/',' ',$input);
$input = preg_replace('/cpu/',' ',$input); }
if (preg_match('/what/', $input) && preg_match('/processor/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile;
$input = preg_replace('/what/',' ',$input);
$input = preg_replace('/processor/',' ',$input); }
if (preg_match('/is your cpu/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/is your cpu/',' ',$input); }
if (preg_match('/which cpu/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/which cpu/',' ',$input); }
if (preg_match('/cpu info/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu info/',' ',$input); }
if (preg_match('/cpu status/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu status/',' ',$input); }
if (preg_match('/cpu usage/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu usage/',' ',$input); }
if (preg_match('/cpu stats/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu stats/',' ',$input); }
if (preg_match('/cpu specs/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu specs/',' ',$input); }
if (preg_match('/cpu specification/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu specification/',' ',$input); }
if (preg_match('/how many cpu/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/how many cpu/',' ',$input); }
if (preg_match('/how many cores/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/how many cores/',' ',$input); }
if (preg_match('/cpu brand/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu brand/',' ',$input); }
if (preg_match('/cpu type/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu type/',' ',$input); }
if (preg_match('/type cpu/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/type cpu/',' ',$input); }
if (preg_match('/brand cpu/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/brand cpu/',' ',$input); }
if (preg_match('/is your cpu/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/is your cpu/',' ',$input); }
if (preg_match('/cpu status/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/cpu status/',' ',$input); }
if (preg_match('/processor status/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/processor status/',' ',$input); }
if (preg_match('/processor brand/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/processor brand/',' ',$input); }
if (preg_match('/processor type/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/processor type/',' ',$input); }
if (preg_match('/type processor/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/type processor/',' ',$input); }
if (preg_match('/brand processor/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/brand processor/',' ',$input); }
if (preg_match('/is your processor/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/is your processor/',' ',$input); }
if (preg_match('/intel or amd/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/intel or amd/',' ',$input); }
if (preg_match('/amd or intel/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/amd or intel/',' ',$input); }
if (preg_match('/arm or amd/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/arm or amd/',' ',$input); }
if (preg_match('/arm or intel/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/arm or intel/',' ',$input); }
if (preg_match('/intel or arm/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/intel or arm/',' ',$input); }
if (preg_match('/amd or arm/', $input)) {  
$CMDcpuinfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcpuinfo.php'; 
include $CMDcpuinfofile; 
$input = preg_replace('/amd or arm/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
if (preg_match('/how much ram/', $input)) {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/how much ram/',' ',$input); }
if (preg_match('/how much memory/', $input)) {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/how much memory/',' ',$input); }
if (preg_match('/ram usage/', $input)) {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/ram usage/',' ',$input); }
if (preg_match('/ram use/', $input)) {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/ram use/',' ',$input); }
if (preg_match('/memory use/', $input)) {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/memory use/',' ',$input); }
if (preg_match('/mem use/', $input)) {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/mem use/',' ',$input); }
if (preg_match('/mem info/', $input)) {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/mem info/',' ',$input); }
if (preg_match('/memory info/', $input)) {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile;  
$input = preg_replace('/memory info/',' ',$input); }
if (preg_match('/ram info/', $input)) {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
include $CMDmeminfofile; 
$input = preg_replace('/ram info/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
if ($input == 'help') {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
echo nl2br('For help with HRCloud2 or HRAI, please visit the official '."\n".'zelon88/HRCloud2 Github repo and open an issue.'."\n".
  '<a href="https://github.com/zelon88/HRCloud2" target="parent"><i>github.com/zelon88/HRCloud2</i></a>'); 
$input = preg_replace('/help/',' ',$input); }
if (preg_match('/help me/', $input)) {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
echo nl2br('For help with HRCloud2 or HRAI, please visit the official '."\n".'zelon88/HRCloud2 Github repo and open an issue.'."\n".
  '<a href="https://github.com/zelon88/HRCloud2" target="parent"><i>github.com/zelon88/HRCloud2</i></a>'); 
$input = preg_replace('/help me/',' ',$input); }
if (preg_match('/help me/', $input)) {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
echo nl2br('For help with HRCloud2 or HRAI, please visit the official '."\n".'zelon88/HRCloud2 Github repo and open an issue.'."\n".
  '<a href="https://github.com/zelon88/HRCloud2" target="parent"><i>github.com/zelon88/HRCloud2</i></a>'); 
$input = preg_replace('/help me/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
if ($input == 'guidance') {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
echo nl2br('For guidance with HRCloud2 or HRAI, please visit the official '."\n".'zelon88/HRCloud2 Github repo and open an issue.'."\n".
  '<a href="https://github.com/zelon88/HRCloud2" target="parent"><i>github.com/zelon88/HRCloud2</i></a>'); 
$input = preg_replace('/help/',' ',$input); }
if ($input == 'how to') {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
echo nl2br('For guidance with HRCloud2 or HRAI, please visit the official '."\n".'zelon88/HRCloud2 Github repo and open an issue.'."\n".
  '<a href="https://github.com/zelon88/HRCloud2" target="parent"><i>github.com/zelon88/HRCloud2</i></a>'); 
$input = preg_replace('/how to/',' ',$input); }
if (preg_match('/how to/', $input)) {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
echo nl2br('For guidance with HRCloud2 or HRAI, please visit the official '."\n".'zelon88/HRCloud2 Github repo and open an issue.'."\n".
  '<a href="https://github.com/zelon88/HRCloud2" target="parent"><i>github.com/zelon88/HRCloud2</i></a>'); 
$input = preg_replace('/how to/',' ',$input); }
if (preg_match('/help me/', $input)) {  
$CMDmeminfofile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDmeminfo.php'; 
echo nl2br('For guidance with HRCloud2 or HRAI, please visit the official '."\n".'zelon88/HRCloud2 Github repo and open an issue.'."\n".
  '<a href="https://github.com/zelon88/HRCloud2" target="parent"><i>github.com/zelon88/HRCloud2</i></a>'); 
$input = preg_replace('/help me/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
// / Display a refresh button if the user is not logged in.
if ($user_ID == '0') { 
  echo nl2br ('<form action="core.php"><div align="center"><p><input type="submit" name="refresh" id="refresh" href="#" target="_parent" value="&#x21BA" class="button" onclick="toggle_visibility("loadingCommandDiv");"></p></div></form>'); }
if (isset($includeMINIIframer)) {
  include_once($InstLoc.'/HRAIMiniGui.php'); }
?>
</div>
</body>
</html>