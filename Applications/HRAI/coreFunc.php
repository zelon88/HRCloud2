<?php
require('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/coreVar.php');

// / The following code takes ownership of required HRAI directories for the www-data usergroup.
function checkServerPermissions() {
  global $InstLoc;
  system('chown -R www-data '.$InstLoc);
  system('chown -R www-data '.$InstLoc.'/DATA');
  system('chown -R www-data '.$InstLoc.'/Applications');
  system('chown -R www-data '.$InstLoc.'/Applications/HRAI'); }

// / The following code is used to clean up old files from previous versions of HRCloud2.
// / This code last updated on 11/30/16 23:18.
function performMaintanence() {
  global $InstLoc;
  if (file_exists($InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php')) {
    unlink ($InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'); }
  if (file_exists($InstLoc.'/Applications/HRAI/CoreCommands/CMDsendafile.php')) {
    unlink ($InstLoc.'/Applications/HRAI/CoreCommands/CMDsendafile.php'); }
  if (file_exists($InstLoc.'/Applications/HRAI/HRAIHelper.php')) {
    unlink ($InstLoc.'/Applications/HRAI/HRAIHelper.php'); } }

// / The following code specifies if HRAI is required in an Iframer (Tells HRAI to shrink it's footprint).
function displayMiniGui() {
  global $InstLoc;
  if (isset($_POST['HRAIMiniGUIPost'])) {
    $noMINICore = '1';
    $includeMINIIframer = '1'; }
  if (!isset($_POST['HRAIMiniGUIPost'])) {
    $noMINICore = '1'; 
    $includeMINIIFramer = '0'; }
  if (isset($includeMINIIframer)) {
    require_once($InstLoc.'/Applications/HRAIMiniGui.php'); } }

// / If there was text inputted by the user we use that text for $input. If there was no text, or if the input field 
// / blank we use '0' for $input. 0 as an input will tell HRAI that we want to run background tasks like learning or
// / research or networking functions.
function defineUserInput() {
  if(!isset($_POST['input'])) {
    $input = ''; } 
  if(isset($_POST['input'])) {
    $input = str_replace('\'', '\\\'', $_POST['input']);
    $input = str_replace(str_split('[]{};:$#^&%@>*<'), '', $_POST['input']); } 
  return ($input); }

// / If no display name has been set we set this to 0 to avoid errors. We need a display name to generate a sesLog.
function defineDisplay_Name() {
  if(!isset($_POST['display_name'])) {
    $display_name = '0'; } 
  if(isset($_POST['display_name'])) {
    $display_name = str_replace(str_split('[]{};:$!#^&%@>*\'<'), '', $_POST['display_name']); }
  return ($display_name); } 

// / If there is no user_ID we set this var to 0, which assumes either the user is not logged in or there is no WordPress.
// / Without this var we cannot generate a sesID.
function defineUser_ID() {
  if(!isset($_POST['user_ID']) or $_POST['user_ID'] == '') {
    $user_ID = '0'; } 
  if(isset($_POST['user_ID']) or $_POST['user_ID'] !== '') {
    $user_ID = str_replace(str_split('[]{};:$!#^&%@>*\'<'), '', $_POST['user_ID']); }
  return ($user_ID); }

// / If there is no serverID we set the serverID to 0, which means localhost. This helps us track data that travels between
// / HRAI nodes.
function defineInputServerID() {
  if(!isset($_POST['serverID'])) {
    $inputServerID = '0'; } 
  if(isset($_POST['serverID'])) {
    $inputServerID = str_replace(str_split('[]{};:$!#^&%@>*\'<'), '', $_POST['serverID']); } 
  return ($inputServerID); }

// / The following code authenticates the POSTed API inputs and ensures the login attempt came from a node with similar salts.
function authenticateAPI() {
  global $networkSalts, $date, $sesLogfile;
  if (isset ($_POST['inputServerIDHash']) && isset($_POST['user_ID'])) {
    $inputServerID = str_replace(str_split('[]{};:$#^&%@>*<'), '', $_POST['inputServerID']);
    $inputServerIDHash = hash ('sha256',$inputServerID.$networkSalts);
    $txt = ('CoreAI: Server '.$inputServerID.', connecting with '.$inputServerIDHash.' and user_ID: '.$_POST['User_ID'].' on '.$date.'.');
    echo nl2br($txt."\n");
    $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND);
  if ($inputServerIDHash !== $_POST['inputServerIDHash']) {
    $txt = ('ERROR!!! HRAI101, This request could not be authenticated! inputServerIDHash Discrepency!');
    echo nl2br($txt."\n");
    $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND);
    die ('ERROR!!! HRAI101, This request could not be authenticated!'); }
  if ($inputServerIDHash == $_POST['inputServerIDHash']) {
    return 1; } 
  if (!isset($_POST['inputServerID']) or !isset($_POST['inputServerIDHash'])) {
    return (0); } } }

// / The following code forces the generation of a sesID and related files.
function forceCreateSesID() {
  global $day, $Salts;
  $user_ID = verifyUser_ID();
  if(isset($_POST['sesID'])){
    $sesID = str_replace(str_split('[]{};:$!#^&%@>*\'<'), '', $_POST['sesID']); 
      if (empty($sesID)) {
        $sesIDhash = hash('sha256', $Salts.$user_ID.$day);
        $sesID = substr($sesIDhash, -7); } }
  if(!isset($_POST['sesID'])){
    $sesIDhash = hash('sha256', $Salts.$user_ID.$day);
    $sesID = substr($sesIDhash, -7);  
  $sesLogfile = $InstLoc.'/DATA/'.$user_ID.'/.AppData/'.$Date.'/HRAI-'.$sesID.'.txt';  }
    $sesIDhashAuth = hash('sha256', $Salts.$user_ID.$day);
    $sesIDAuth = substr($sesIDhashAuth, -7);  
  if($sesID !== $sesIDAuth){
    $sesIDhash = hash('sha256', $Salts.$user_ID.$day);
    $sesID = substr($sesIDhash, -7); } 
  $sesLogfile = $InstLoc.'/DATA/'.$user_ID.'/.AppData/'.$Date.'/HRAI-'.$sesID.'.txt';  
  return ($sesID); }

// / The following code verifies the users login
function verifyUser_ID() {
  global $Salts;
  $user_IDRAW = get_current_user_id();
  $user_ID = hash('ripemd160', $user_IDRAW.$Salts); 
  if (authenticateAPI() == 1) $user_ID = defineUserID();
return ($user_ID); }

// SECRET: This is to verify that the sesDir is authentic and up-to-date.
function authSesID($user_ID) {
  global $Salts, $day;
  if(isset($_POST['sesID'])){
    $sesID = $_POST['sesID']; 
      if (empty($sesID)) {
        $sesIDhash = hash('sha256', $Salts.$user_ID.$day);
        $sesID = substr($sesIDhash, -7); } }
  if(!isset($_POST['sesID'])){
    $sesIDhash = hash('sha256', $Salts.$user_ID.$day);
    $sesID = substr($sesIDhash, -7); } 
  $sesLogfile = $InstLoc.'/DATA/'.$user_ID.'/.AppData/'.$Date.'/HRAI-'.$sesID.'.txt';  
    $sesIDhashAuth = hash('sha256', $Salts.$user_ID.$day);
    $sesIDAuth = substr($sesIDhashAuth, -7);  
  if($sesID !== $sesIDAuth){
    $sesIDhash = hash('sha256', $Salts.$user_ID.$day);
    $sesID = substr($sesIDhash, -7); } 
  $sesLogfile = $InstLoc.'/DATA/'.$user_ID.'/.AppData/'.$Date.'/HRAI-'.$sesID.'.txt';  
  return ($sesID); }

function forceCreateSesDir($sesID) {
  global $InstLoc, $Salts, $Date, $date, $day;
  $user_ID = verifyUser_ID();
  $input = defineUserInput();
  $sesLogfile = $InstLoc.'/DATA/'.$user_ID.'/.AppData/'.$Date.'/HRAI-'.$sesID.'.txt'; 
  if (!file_exists($InstLoc.'/DATA/'.$user_ID.'/.AppData/'.$Date)) {
    mkdir($InstLoc.'/DATA/'.$user_ID.'/.AppData/'.$Date, 0755); }
  if (file_exists($InstLoc.'/DATA/'.$user_ID.'/.AppData/'.$Date)) { 
    echo nl2br('Session ID: '.$sesID.' '."\n"); 
  $txt = ('CoreAI: '."User $user_ID initiated session $sesID with input \"$input\" on $date".
    '. '."\n".'CoreAI: Libraries loaded. '."\n".'CoreAI: Logfile created.');
  echo nl2br($txt."\n");
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); }
  // / Create a logfile for the session if none exists already.
  if (!file_exists($sesLogfile)) {
    $txt = ('CoreAI: '."User $user_ID initiated session $sesID with input \"$input\" on $date".
      '. '."\n".'CoreAI: Libraries loaded. '."\n".'CoreAI: Logfile created, method 2. ');
    echo nl2br($txt."\n");
   $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); }
  // / Double check that a logfile was created. Attempt another method if it was not. 
  if (!file_exists($sesLogfile)) {
    $sesLogfileO = fopen("$sesLogfile", "w");
    $txt = ('CoreAI: '."User $user_ID initiated session $sesID with input \"$input\" on $date".
      '. '."\n".'CoreAI: Libraries loaded. '."\n".'CoreAI: Logfile created, method 3. ');
    echo nl2br($txt."\n");    
    $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); }
   // / If a logfile still doesn't exist try making one with extra privilages.
  if (!file_exists($sesLogfile)) {
    mkdir('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'."$user_ID".'/'."$sesID".'/'."$sesID".'.txt', 0755);
    $sesLogfile = ('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'."$user_ID".'/'."$sesID".'/'."$sesID".'.txt');
    $txt = ('CoreAI: '."User $display_name".','." $user_ID initiated $sesID with $input on $date".
      ' Libraries loaded. Logfile created, method 4. ');
    echo nl2br($txt."\n");
    $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); }
  // / If we cannot establish a logfile we kill the script.
  if (!file_exists($sesLogfile)) {
    die('An internal error was encountered. I attempted to genereate a logfile for the session by several methods 
     and failed each time. I am sorry. Please try again later. '); } 
    return($sesLogfile); } 

// / Detect WordPress and require it if it is. Echo and log status when complete.
function detectWordPress() {
  global $wpfile;
  if (file_exists($wpfile)){
    require_once($wpfile);
    $txt = ''; 
  global $current_user; } 
  if (!file_exists($wpfile)){
    $txt = 'No WordPress detected! ';
    echo nl2br($txt."\n"); }
  return($txt); }

function LOCALreadOutputOfPHPfile($aPHPfileORurl) {
  // / This function executes a PHP file and returns the output as the return variable.
  ob_start(); // begin collecting output
  include($aPHPfileORurl);
  $result = ob_get_clean(); // retrieve output from myfile.php, stop buffering
  $varCache0 = '/var/www/html/HRProprietary/HRAI/Cache/varCache.php';
    $varCache1 = fopen("$varCache0", "a+");
    $txt = ('$result = '.$result);
    $compLogfile = file_put_contents($varCache0, $txt.PHP_EOL , FILE_APPEND); 
return $result; }

