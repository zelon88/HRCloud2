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
$HRAIMiniGUIFile = ($InstLoc.'/HRAIMiniGui.php');
$CallForHelpURL = $InstLoc.'/Applications/HRAI/CallForHelp.php';
$HRC2ConfigFile = $InstLoc.'/config.php';
$HRC2SecurityCoreFile = $InstLoc.'/securityCore.php';
$wpfile = '/var/www/html/wp-load.php';
$date = date("F j, Y, g:i a");
$hour = date("g:i a");
$day = date("d");

// / Specifies if HRAI is required in an Iframer (Tells HRAI to shrink it's footprint).
if (isset($_POST['HRAIMiniGUIPost'])) {
  $noMINICore = '1';
  $includeMINIIframer = '1'; }
if (!isset($_POST['HRAIMiniGUIPost'])) {
  $noMINICore = '1'; 
  $includeMINIIFramer = '0'; }

// / Load core AI files. Write an entry to the log if successful.
require_once($coreVarfile);
require_once($coreArrfile);
require_once($coreFuncfile);
require_once($onlineFile);
require_once($HRC2ConfigFile);
require_once($HRC2SecurityCoreFile);
require_once($InstLoc.'/config.php');
if (isset($includeMINIIframer)) {
  include_once($HRAIMiniGUIFile); }

// / The following code is used to clean up old files from previous versions of HRCloud2.
// / This code last updated on 11/30/16 23:18.
if (file_exists($InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php')) {
  unlink ($InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'); }
if (file_exists($InstLoc.'/Applications/HRAI/CoreCommands/CMDsendafile.php')) {
  unlink ($InstLoc.'/Applications/HRAI/CoreCommands/CMDsendafile.php'); }
if (file_exists($InstLoc.'/Applications/HRAI/HRAIHelper.php')) {
  unlink ($InstLoc.'/Applications/HRAI/HRAIHelper.php'); }

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
  $txt = ('CoreAI: Server '.$inputServerID.', connecting with '.$inputServerIDHash.' using sesID: '.$sesIDPOST.' and user_ID: '.$user_IDPOST.' on '.$date.'.');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND);
  if ($inputServerIDHash !== $_POST['inputServerIDHash']) {
    $txt = ('ERROR!!! HRAI101, This request could not be authenticated! inputServerIDHash Discrepency!');
    $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND);
    die ('ERROR!!! HRAI101, This request could not be authenticated!'); } }
if (!file_exists($coreArrfile)) {
  $txt = ('CoreAI: User '.','." $user_ID during $sesID on $date".'. ERROR: No coreArrfile 
    array file found. Continuing... ');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($coreVarfile)){
  $txt = ('CoreAI: User '.','." $user_ID during $sesID on $date".'. ERROR: No coreVarfile 
    variable file found. Continuing... ');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); }

// / Check how many other HRAI servers are in the vicinity. Returns the number of servers.
$serverStat = getServStat();
include($nodeCache); 
$txt = ('CoreAI: Loaded nodeCache, nodeCount is '.$nodeCount.'.');
$compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
$txt = ('CoreAI: Server status is '.$serverStat.'.');
$compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
$cpuUseNow = getServCPUUseNow();
$servMemUse = getServMemUse();
$servPageUse = getServPageUse();
$getServBusy = getServBusy();

// / The following code checks if the server is busy, and attempts to redirect the session to an idle node.
// / EXPERIMENTAL !!!!! Regular users should not try to use this feature.
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
  $txt = ('CoreAI: Sent a CallForHelp request on '.$date.'. Continuing the script. ');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
  echo nl2br("   Activating CallForHelp! Continuing... \r");  

// / If the server is busy AND the user needs something we try to offload the request to the next
  // / online HRAI node.
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
    $txt = ('CoreAI: Sent a langPar request on '.$date.'. Continuing... ');
    $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); } }

// / The following code prunes the user's input before loading the CoreCommands to execute matches.
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
// / The following code detects and initializes all CoreCommands.
  // / CoreCommands are parsed every time the core is executed.
  // / They contain the format for HRAI to match text to certain tasks.
  // / They also contain the code for the task to be completed.
  // / HRAI loads these CoreCommands, and if the input matches, the command will run.
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