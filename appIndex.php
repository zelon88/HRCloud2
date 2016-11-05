<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="Applications/displaydirectorycontents_72716/favicon.ico">
   <title>HRCLoud2 | App Launcher</title>
<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
<script type="text/javascript">
function goBack() {
    window.history.back(); }
</script>

<?php
// / This file was meant to be a resource to help users find useful 
// / documentation about HRCloud2.

if (!file_exists('config.php')) {
  echo nl2br('</head>ERROR!!! HRC2AppIndex12, Cannot process the HRCloud2 configuration file (config.php).'."\n"); 
  die (); }
else {
  require('config.php'); }
$WPFile = '/var/www/html/wp-load.php';

// / The following Code verifies that WordPress is installed.
if (!file_exists($WPFile)) {
  echo nl2br('</head>ERROR!!! HRC2AppIndex20, WordPress was not detected on the server.'."\n"); }
  else {
    require($WPFile); } 

// / Tje fp;;pwomg cpde sets the variables for the session.
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
$AppDir = $InstLoc.'/Applications/';
if (!file_exists($CloudLoc)) {
  echo ('</head>ERROR!!! HRC2AppIndex36, There was an error verifying the CloudLoc as a valid directory. Please check the config.php file and refresh the page.');
  die(); }
if (!file_exists($CloudDir)) {
  mkdir($CloudDir, 0755); }
if (!file_exists($CloudTempDir)) {
  mkdir($CloudTempDir, 0755); }

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
      copy($LogInstallDir1.$LIF1, $SesLogDir.'/'.$LIF1); } } }

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
$UserConfig = $CloudTemp.$UserID.'/'.'.AppLogs/.config.php';
if (!file_exists($UserConfig)) {
  echo nl2br('</head>ERROR!!! HRC2AppIndex27, User Cache file was not detected on the server!'."\n"); 
  die (); }
else {
    require($UserConfig); } 

// / Checks to see that the user is logged in.
if ($UserIDRAW == '') {
  echo nl2br('ERROR!!! HRC2AppIndex100, You are not logged in!'."\n"); 
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }
if ($UserIDRAW == '0') {
  echo nl2br('ERROR!!! HRC2AppIndex103, You are not logged in!'."\n");
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }
if (!isset($UserIDRAW)) {
  echo nl2br('ERROR!!! HRC2AppIndex106, You are not logged in!'."\n");
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }

// / The following code detects the existence of installed apps for the app launcher.
// / This code also checks that the plugin file is a valid HRCloud2 app.
$apps = scandir($AppDir, SCANDIR_SORT_DESCENDING);
$newest_app = $apps[0];
$defaultApps = array('.', '..', '', 
'jquery-3.1.0.min.js', 'index.html', 'HRAI', 'HRConvert2', 'HRStreamer', 'getID3-1.9.12', 'displaydirectorycontents_logs', 'displaydirectorycontents_logs1', 'displaydirectorycontents_72716');
foreach ($apps as $app) { 
  if ($app == '.' or $app == '..' or in_array($app, $defaultApps)) continue;
    $app = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $app); 
    $appName = $app;
    $appFile = $app.'.php';
    $appLoc = $appDir.$appFile; 
    if (!file_exists($appLoc)) {
      $txt = ('ERROR!!! HRC2AppIndex110, There was an error initializing app '.$appName.' on '.$Time.'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } 
    if (file_exists($appLoc)) {
      $appFileData = file_get_contents($appFile);
      if (strpos($appFileData, 'Name:') == 'false' or strpos($appFileData, 'Version:') == 'false' or strpos($appFileData, 'Author:') == 'false' 
        or strpos($appFileData, 'License: GPLv3') == 'false') die;
      require ($appLoc); 
      $txt = ('Op-Act: Initialized app '.$appName.' on '.$Time.'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }

// / The following code determines the color scheme that the user has selected. 
// / May require a refresh to take effect.
if ($ColorScheme == '0' or $ColorScheme == '' or !isset($ColorScheme)) {
  $ColorScheme = '1'; }
if ($ColorScheme == '1') {
  echo ('<link rel="stylesheet" type="text/css" href="style.css">'); }
if ($ColorScheme == '2') {
  echo ('<link rel="stylesheet" type="text/css" href="styleRED.css">'); }
if ($ColorScheme == '3') {
  echo ('<link rel="stylesheet" type="text/css" href="styleGREEN.css">'); }
if ($ColorScheme == '4') {
  echo ('<link rel="stylesheet" type="text/css" href="styleGREY.css">'); }
if ($ColorScheme == '5') {
  echo ('<link rel="stylesheet" type="text/css" href="styleBLACK.css">'); } 
 ?>
</head>
<body>
<div align="center">
 <h3>HRCloud2 Apps</h3>
</div>
<hr />
<div align="center">
<?php 
foreach ($apps as $appName) {
  if ($appName == '.' or $appName == '..' or in_array($appName, $defaultApps)) continue;
  $appCounter = 0;
  echo nl2br('<div id="app'.$appCounter.'Overview" name="'.$appName.'Overview" style="height:160px; float:left; width:195px; height:195px; border:inset; margin-bottom:2px;"><p><strong>'."\n".$appName.'</strong></p><hr /></div>');
$appCounter++; }
?>
</div>
