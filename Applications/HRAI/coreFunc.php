<?php
require('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/coreVar.php');

// / The following code is used to clean up old files from previous versions of HRCloud2.
// / This code last updated on 11/30/16 23:18.
function performMaintanence() {
  $InstLoc = '/var/www/html/HRProprietary/HRCloud2';
  if (file_exists($InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php')) {
    unlink ($InstLoc.'/Applications/HRAI/CoreCommands/CMDscan.php'); }
  if (file_exists($InstLoc.'/Applications/HRAI/CoreCommands/CMDsendafile.php')) {
    unlink ($InstLoc.'/Applications/HRAI/CoreCommands/CMDsendafile.php'); }
  if (file_exists($InstLoc.'/Applications/HRAI/HRAIHelper.php')) {
    unlink ($InstLoc.'/Applications/HRAI/HRAIHelper.php'); } }

// / The following code specifies if HRAI is required in an Iframer (Tells HRAI to shrink it's footprint).
function displayMiniGui() {
  $InstLoc = '/var/www/html/HRProprietary/HRCloud2';
  if (isset($_POST['HRAIMiniGUIPost'])) {
    $noMINICore = '1';
    $includeMINIIframer = '1'; }
  if (!isset($_POST['HRAIMiniGUIPost'])) {
    $noMINICore = '1'; 
    $includeMINIIFramer = '0'; }
  if (isset($includeMINIIframer)) {
    include_once($InstLoc.'/Applications/HRAIMiniGui.php'); } }

// / If there was text inputted by the user we use that text for $input. If there was no text, or if the input field 
// / blank we use '0' for $input. 0 as an input will tell HRAI that we want to run background tasks like learning or
// / research or networking functions.
function defineUserInput() {
  if(empty($_POST['input'])) {
    $input = ''; } 
  if(!empty($_POST['input'])) {
    $input = str_replace('\'', '\\\'', $_POST['input']);
    $input = str_replace(str_split('[]{};:$#^&%@>*<'), '', $_POST['input']); } 
  return ($input); }

// / If no display name has been set we set this to 0 to avoid errors. We need a display name to generate a sesLog.
function defineDisplay_Name() {
  if(empty($_POST['display_name'])) {
    $display_name = '0'; } 
  if(!empty($_POST['display_name'])) {
    $display_name = str_replace(str_split('[]{};:$!#^&%@>*\'<'), '', $_POST['display_name']); }
  return ($display_name); } 

// / If there is no user_ID we set this var to 0, which assumes either the user is not logged in or there is no WordPress.
// / Without this var we cannot generate a sesID.
function defineUser_ID() {
  if(empty($_POST['user_ID'])) {
    $user_ID = '0'; } 
  if(!empty($_POST['user_ID'])) {
    $user_ID = str_replace(str_split('[]{};:$!#^&%@>*\'<'), '', $_POST['user_ID']); }
  return ($user_ID); }

// / If there is no serverID we set the serverID to 0, which means localhost. This helps us track data that travels between
// / HRAI nodes.
function defineInputServerID() {
  if(empty($_POST['serverID'])) {
    $inputServerID = '0'; } 
  if(!empty($_POST['serverID'])) {
    $inputServerID = str_replace(str_split('[]{};:$!#^&%@>*\'<'), '', $_POST['serverID']); } 
  return ($inputServerID); }

function forceCreateSesID() {
  $user_ID = defineUser_ID();
  $display_name = defineDisplay_Name();
  $day = date("d");
  if(isset($_POST['sesID'])){
    $sesID = str_replace(str_split('[]{};:$!#^&%@>*\'<'), '', $_POST['sesID']); 
      if (empty($sesID)) {
        $sesIDhash = hash('sha256', $display_name.$day);
        $sesID = substr($sesIDhash, -7); } }
  if(!isset($_POST['sesID'])){
    $sesIDhash = hash('sha256', $display_name.$day);
    $sesID = substr($sesIDhash, -7);  
  $sesLogfile = ('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.$sesID.'.txt'); }
    $sesIDhashAuth = hash('sha256', $display_name.$day);
    $sesIDAuth = substr($sesIDhashAuth, -7);  
  if($sesID !== $sesIDAuth){
    $sesIDhash = hash('sha256', $display_name.$day);
    $sesID = substr($sesIDhash, -7); } 
  $sesLogfile = ('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.$sesID.'.txt'); 
  return ($sesID); }

// SECRET: This is to verify that the sesDir is authentic and up-to-date.
function authSesID() {
  $user_ID = defineUser_ID();
  $display_name = defineDisplay_Name();
  $day = date("d");
  if(isset($_POST['sesID'])){
    $sesID = $_POST['sesID']; 
      if (empty($sesID)) {
        $sesIDhash = hash('sha256', $display_name.$day);
        $sesID = substr($sesIDhash, -7); } }
  if(!isset($_POST['sesID'])){
    $sesIDhash = hash('sha256', $display_name.$day);
    $sesID = substr($sesIDhash, -7); } 
  $sesLogfile = ('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.$sesID.'.txt'); 
    $sesIDhashAuth = hash('sha256', $display_name.$day);
    $sesIDAuth = substr($sesIDhashAuth, -7);  
  if($sesID !== $sesIDAuth){
    $sesIDhash = hash('sha256', $display_name.$day);
    $sesID = substr($sesIDhash, -7); } 
  $sesLogfile = ('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.$sesID.'.txt'); 
  return ($sesID); }

function verifyUser() {
  $user_IDRAW = get_current_user_id();
  $user_ID = hash('ripemd160', $user_IDRAW.$Salts); }

function loadAdminInfo() {
  if ($user_IDRAW == 1) {
  include '/var/www/html/HRProprietary/HRAI/adminINFO.php'; }
  if ($user_IDRAW !== 1) {
  $display_name = get_currentuserinfo() ->$display_name; }
  if ($user_IDRAW == 0) {
    $display_name = $_POST['display_name']; }
    $input = defineUserInput(); 
    $inputServerID = defineInputServerID();
    $sesIDhash = hash('sha256', $display_name.$day);
    $sesID = substr($sesIDhash, -7); 
  if(isset($_POST['sesID'])) {
    $sesID = $_POST['sesID']; }
    if(isset($_POST['user_ID'])) {
    $user_ID = $_POST['user_ID']; }
    if(isset($_POST['sesID'])) {
    $display_name = $_POST['display_name']; } }

// / Get the session ID. If sesID is empty we post all vars to core.php to generate one, then post the data back
// / for processing. 
function getSesIDFromCore () {
  if(isset($_POST['sesID'])){
    $sesID = $_POST['sesID']; 
    if (empty($sesID)) {
      $coreFile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/core.php';
      $user_ID = defineUser_ID();
      $input = defineUserInput();
      $display_name = defineDisplay_Name();
      $dataArr = array('user_ID' =>  "$user_ID",
        'input' => "$input",
        'display_name' =>  '$display_name',
        'serverID' => '$serverID');
  $handle = curl_init($coreFile);
  curl_setopt($handle, CURLOPT_POST, true);
  curl_setopt($handle, CURLOPT_POSTFIELDS, $dataArr);
  curl_exec($handle);
  return(die('Sent data to coreFile to generate a session ID.') ); } } } 

function forceCreateSesDir() {
  $user_ID = defineUser_ID();
  $display_name = defineDisplay_Name();
  $input = defineUserInput();
  $day = date("d"); 
  $sesIDhash = hash('sha256', $display_name.$day);
  $sesID = substr($sesIDhash, -7); 
  $date = date("F j, Y, g:i a");
  $sesLogfile = ('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.$sesID.'.txt');
  if (!file_exists('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'.$user_ID)){
    mkdir(('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'.$user_ID), 0755); }
  if (!file_exists('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'.$user_ID.'/'.$sesID)){
    mkdir(('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'.$user_ID.'/'.$sesID), 0755); 
    echo 'Sucessfully generated session ID: '.$sesID.' '; }
  $sesLogfile = ('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.$sesID.'.txt');
  $txt = ('CoreAI: '."User $display_name".','." $user_ID initiated $sesID with $input on $date".'. Libraries loaded. Logfile created.');
  $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
  //echo 'Using sesID: '.$sesID.' ';
  return ($sesLogfile);
  // / Create a logfile for the session if none exists already.
  if (!file_exists($sesLogfile)){
    $txt = ('CoreAI: '."User $display_name".','." $user_ID initiated $sesID with $input on $date".
      ' Libraries loaded. Logfile created, method 2. ');
   $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); }
  // / Double check that a logfile was created. Attempt another method if it was not. 
  if (!file_exists($sesLogfile)){
    $sesLogfileO = fopen("$sesLogfile", "w");
    $txt = ('CoreAI: '."User $display_name".','." $user_ID initiated $sesID with $input on $date".
      ' Libraries loaded. Logfile created, method 3. ');
    $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); }
   // / If a logfile still doesn't exist try making one with extra privilages.
  if (!file_exists($sesLogfile)){
    mkdir('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'."$user_ID".'/'."$sesID".'/'."$sesID".'.txt', 0755);
    $sesLogfile = ('/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/sesLogs/'."$user_ID".'/'."$sesID".'/'."$sesID".'.txt');
    $txt = ('CoreAI: '."User $display_name".','." $user_ID initiated $sesID with $input on $date".
      ' Libraries loaded. Logfile created, method 4. ');
    $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); }
  // / If we cannot establish a logfile we kill the script.
  if (!file_exists($sesLogfile)){
    die('An internal error was encountered. I attempted to genereate a logfile for the session by several methods 
     and failed each time. I am sorry. Please try again later. '); } } 

// / Detect WordPress and require it if it is. Echo and log status when complete.
function detectWordPress() {
  $wpfile = '/var/www/html/wp-load.php';
  if (file_exists($wpfile)){
    require_once($wpfile);
    $txt = ''; 
  global $current_user; } 
  if (!file_exists($wpfile)){
    $txt = 'No WordPress detected! '; }
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

