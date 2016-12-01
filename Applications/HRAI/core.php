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
$HRC2ConfigFile = $InstLoc.'/config.php';
$HRC2SecurityCoreFile = $InstLoc.'/securityCore.php';
$wpfile = '/var/www/html/wp-load.php';
$date = date("F j, Y, g:i a");
$hour = date("g:i a");
$day = date("d");

// / The following code is used to clean up old files from previous versions of HRCloud2.
// / This code last updated on 11/30/16 23:18.
if (file_exists($InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php')) {
  unlink ($InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'); }
if (file_exists($InstLoc.'/Applications/HRAI/CoreCommands/CMDsendafile.php')) {
  unlink ($InstLoc.'/Applications/HRAI/CoreCommands/CMDsendafile.php'); }
if (file_exists($InstLoc.'/Applications/HRAI/HRAIHelper.php')) {
  unlink ($InstLoc.'/Applications/HRAI/HRAIHelper.php'); }

// / Load core AI files. Write an entry to the log if successful.
require_once($coreVarfile);
require_once($coreArrfile);
require_once($coreFuncfile);
require_once($onlineFile);
require_once($HRC2ConfigFile);
require_once($HRC2SecurityCoreFile);
require_once($InstLoc.'/config.php');
//echo nl2br("Sucessfully loaded library files. \r");

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
$sesLogfile = ($InstLoc.'/DATA/'.$user_ID.'/.AppLogs/'.$Date.'/HRAI'.$sesID.'.txt'); 
$JICsesLogfileDir = ($InstLoc.'/DATA/'.$user_ID.'/.AppLogs/'.$Date);
if (!is_dir($JICsesLogfileDir)) {
  mkdir($JICsesLogfileDir, 0755); }
if (!file_exists($JICsesLogfileDir)) {
  $JICCreateSesDir = file_put_contents($sesLogfile, ''); }
if (!file_exists($sesLogfile)) {
  echo nl2br('Discrepency detected!'."\r"); }

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

// / Check how many other HRAI servers are in the vicinity. Returns the number of servers.
$serverStat = getServStat();
include($nodeCache); 
$txt = ('CoreAI: Loaded nodeCache, nodeCount is '.$nodeCount.' on '.$date.'. ');
$compLogfile = @file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
$txt = ('CoreAI: Server status is '.$serverStat.' on '.$date.'. ');
$compLogfile = @file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 

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
    $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); }

$cpuUseNow = getServCPUUseNow();
$servMemUse = getServMemUse();
$servPageUse = getServPageUse();
//echo nl2br("\r"); 
//echo nl2br('CPU Average: '.$cpuUseNow."\r"); 
//echo nl2br("Node Count: $nodeCount \r");
//echo nl2br("--------------------------------\r");

if (!file_exists($sesLogfile)) {
  echo nl2br('The core is not synced!'."\r"); }

// / Specifies if HRAI is required for use in an Iframer (Tells HRAI to shrink it's footprint).
if (isset($includeMINIIframer)) {
  include_once($InstLoc.'/HRAIMiniGui.php'); }

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
  echo nl2br('You are not logged in! This session is temporary! '."\r"); 
  echo nl2br ('<form action="core.php"><div align="center"><p><input type="submit" name="refresh" id="refresh" href="#" target="_parent" value="&#x21BA" class="button" onclick="toggle_visibility("loadingCommandDiv");"></p></div></form>'); }
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
$input = str_replace(' please/', '', $input); }
// / Now that we've condensed our input a bit we remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
if (preg_match('/plz/', $input)){
  echo nl2br('No problem, Commander! '."\r");  
$input = str_replace('plz','',$input); }
if (preg_match('/please/', $input)){
  echo nl2br('Of course, Commander! '."\r");  
$input = str_replace('please','',$input); }
if (preg_match('/thank you/', $input)){
  echo nl2br('My pleasure. '."\r"); 
$input = str_replace('/ please/', '', $input); } 
if (preg_match('/thanks/', $input)){
  echo nl2br('Anytime, Commander! '."\r");  
$input = str_replace('thanks','',$input); }
if (preg_match('/thx/', $input)){
  echo nl2br('No problem, Commander! '."\r");  
$input = str_replace('thx','',$input); }
if (preg_match('/your name/', $input)){
  echo nl2br('HRAI! '."\r");  
$input = str_replace('your name','',$input); }
if (preg_match('/whats your name/', $input)){
  echo nl2br('HRAI! '."\r");  
$input = str_replace('whats your name','',$input); }
if (preg_match('/what is your name/', $input)){
  echo nl2br('HRAI! '."\r");  
$input = str_replace('what is your name','',$input); }
// / Now that we've condensed our input a bit we remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);

// / TEMPORARILY DISABLE INCOMPATIBLE APPS
$CMDFilesDir1 = scandir($InstLoc.'/Applications/HRAI/CoreCommands');
$CMDcounter = 0;
foreach($CMDFilesDir1 as $CMDFile) {
  if ($CMDFile == '.' or $CMDFile == '..' or strpos($CMDFile, 'index') == 'true' or is_dir($CMDFile)) continue;
  $CMDFile = ($InstLoc.'/Applications/HRAI/CoreCommands/'.$CMDFile);
  include_once($CMDFile); }
// / 
?>
</div>
</body>
</html>