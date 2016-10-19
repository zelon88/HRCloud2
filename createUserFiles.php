<?php

if (!file_exists('config.php')) {
  echo nl2br('ERROR!!! CUF235, Cannot process the HRCloud2 configuration file (config.php).'."\n"); 
  die (); }
else {
  require('config.php'); }

$WPFile = '/var/www/html/wp-load.php';
// / Verify that WordPress is installed.
if (!file_exists($WPFile)) {
  echo nl2br('ERROR!!! CUF43, WordPress was not detected on the server.'."\n"); }
  else {
    require($WPFile); } 

$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$UserIDRAW = get_current_user_id();
$UserID = hash('ripemd160', $UserIDRAW.$Salts);
$LogLoc = $InstLoc.'/DATA/'.$UserID.'/.AppLogs';
$LogInc = 0;
$SesLogDir = $LogLoc.'/'.$Date;
$ClamLogDir = ($InstLoc.'/'.'VirusLogs'.'/'.$Date.'.txt');
$LogFile = ($SesLogDir.'/'.$Date.'.txt');
$CloudDir = $CloudLoc.'/'.$UserID;
$CloudTemp = $InstLoc.'/DATA/';
$CloudTempDir = $CloudTemp.$UserID;
if (!file_exists($CloudLoc)) {
  echo ('ERROR!!! CUF59, There was an error verifying the CloudLoc as a valid directory. Please check the config.php file and refresh the page.');
  die(); }
if (!file_exists($CloudDir)) {
  mkdir($CloudDir, 0755); }
if (!file_exists($CloudTempDir)) {  
  mkdir($CloudTempDir, 0755); }
copy($InstLoc.'/index.html', $CloudTempDir.'/index.html');
$LogInstallDir = 'Applications/displaydirectorycontents_logs/';
$LogInstallDir1 = 'Applications/displaydirectorycontents_logs1/';
$LogInstallFiles = scandir($InstLoc.'/'.$LogInstallDir);
$LogInstallFiles1 = scandir($InstLoc.'/'.$LogInstallDir1);
if (!file_exists($LogLoc)) {
$JICInstallLogs = @mkdir($LogLoc, 0755); 
  foreach ($LogInstallFiles as $LIF) {
    if ($LIF == '.' or $LIF == '..') continue;
      if (!file_exists($LIF)) {
      copy($LogInstallDir.$LIF, $LogLoc.'/'.$LIF); } } }
if (!file_exists($SesLogDir)) {
$JICInstallLogs = @mkdir($SesLogDir, 0755); 
  foreach ($LogInstallFiles1 as $LIF1) {
    if ($LIF1 == '.' or $LIF1 == '..') continue;
      if (!file_exists($LIF1)) {
      copy($LogInstallDir1.$LIF1, $SesLogDir.'/'.$LIF1); } } } // so HRCloud2 now should have no problems creating a new user. 

      // / and the search related security is improved!

if (isset($_POST['UserDir'])) {
$UserDirPOST = ('/'.$_POST['UserDir'].'/'); }
if (!isset($_POST['UserDir'])) {
$UserDirPOST = ('/'); }
$CloudUsrDir = $CloudDir.$UserDirPOST; 
$CloudTmpDir = $CloudTempDir.$UserDirPOST; 
if (!file_exists($CloudUsrDir)) {
  mkdir($CloudUsrDir, 0755); }
if (!file_exists($CloudTmpDir)) {  
  mkdir($CloudTmpDir, 0755); }
copy($InstLoc.'/index.html', $CloudTmpDir.'/index.html'); 
// / Checks to see that the user is logged in.
if ($UserIDRAW == '') {
  echo nl2br('ERROR!!! CUF100, You are not logged in!'."\n"); 
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }
if ($UserIDRAW == '0') {
  echo nl2br('ERROR!!! CUF103, You are not logged in!'."\n");
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }
if (!isset($UserIDRAW)) {
  echo nl2br('ERROR!!! CUF106, You are not logged in!'."\n");
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }