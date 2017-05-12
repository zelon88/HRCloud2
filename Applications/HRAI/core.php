<!DOCTYPE html>
<html>
<head>
<title>HRAI Core</title>
<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
</head>
<body>
  <div name="top"></div>
<?php 
session_start();

// / The following code loads core AI files. Write an entry to the log if successful.
require_once('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/coreVar.php');
require_once($coreArrfile);
require_once($coreFuncfile);
require_once($onlineFile);
require_once($HRC2SecurityCoreFile);
require_once($InstLoc.'/config.php');

if (!isset($_POST['input'])) { ?>
<div id="HRAITop" align='center'><img id='logo' src='<?php echo $URL.'/HRProprietary/HRCloud2/Applications/HRAI/'; ?>Resources/logoslowbreath.gif'/></div>
<?php } 
if (isset($_POST['input'])) {
  $_POST['input'] = str_replace(str_split('[]{};:$#^&%@>*<'), '', $_POST['input']); ?>
<div id="HRAITop" style="float: left; margin-left: 15px;">
<img id='logo' src='<?php echo $URL.'/HRProprietary/HRCloud2/Applications/HRAI/'; ?>Resources/logo.gif'/>
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

// / The following code takes ownership of required HRAI directories for the www-data usergroup.
system('chown -R www-data '.$InstLoc);
system('chown -R www-data '.$InstLoc.'/Applications/HRAI');

// / The following code cleans up and maintains the server.
$performMaintanence = performMaintanence();

// / The following code displays the MiniGui if needed.
$displayMiniGui = displayMiniGui();

// / The following code starts WordPress.
$detectWordPress = detectWordPress();

// / The followind code handles POSTED variables from other HRAI nodes.
$display_name = defineDisplay_Name();
$user_IDPOST = defineUser_ID(); 
$sesIDPOST = authSesID();
$input = defineUserInput();

// / The following code detects the user_ID and returns related variables.
$user_IDRAW = get_current_user_id();
$user_ID = hash('ripemd160', $user_IDRAW.$Salts);
if (!isset($_POST['sesID'])) {
  $sesIDhash = hash('sha256', $Salts.$display_name.$day);
  $sesID = substr($sesIDhash, -7); }

// / The following code creates the session directory and session log files.
$CreateSesDir = forceCreateSesDir();
$sesLogfile = ($InstLoc.'/DATA/'.$user_ID.'/.AppData/'.$Date.'/HRAI-'.$sesID.'.txt'); 
$JICsesLogfileDir = ($InstLoc.'/DATA/'.$user_ID.'/.AppData/'.$Date);
if (!is_dir($JICsesLogfileDir)) {
  mkdir($JICsesLogfileDir, 0755); }
if (!file_exists($JICsesLogfileDir)) {
  $JICCreateSesDir = file_put_contents($sesLogfile, ''); }
if (!file_exists($sesLogfile)) {
  echo nl2br('Discrepency detected!'."\r"); }

// / The following code verifies that a POSTED HRAI request came from a node with similar Salts.
if (isset ($_POST['inputServerIDHash'])) {
  $inputServerID = str_replace(str_split('[]{};:$#^&%@>*<'), '', $_POST['inputServerID']);
  $inputServerIDHash = hash ('sha256',$inputServerID.$networkSalts);
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
$nodeCount = getNetStat();
$serverStat = getServStat();
include($nodeCache); 
$txt = ('CoreAI: Loaded nodeCache, nodeCount is '.$nodeCount.'.');
$compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
$txt = ('CoreAI: Server status is '.$serverStat.'.');
$compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
$cpuUseNow = getServCPUUseNow();
$servMemUse = getServMemUse();
$getServBusy = getServBusy();

// / The following code checks if the server is busy, and attempts to redirect the session to an idle node.
// / EXPERIMENTAL !!!!! Regular users should not try to use this feature.
if ($getServBusy == 1) {
  $serverIDCFH = hash('sha256', $serverID.$sesID.$day); 
  echo nl2br("This server reports it is busy! \r"); 
  include($CallForHelp);
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
$input = str_replace(str_split(',.!?'), '', $_POST['input']);
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