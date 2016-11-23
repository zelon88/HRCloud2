<?php

// / This file serves as the Common Core file which can be required by projects that need HRCloud2 to load it's config
// / file, authenticate user storage, and define variables for the session.

// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('ERROR!!! HRC2CC9, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php).'."\n"); 
  die (); }
else {
  require_once('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }

// / The follwoing code checks if the config.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/config.php')) {
  echo nl2br('ERROR!!! HRC2CC17, Cannot process the HRCloud2 configuration file (config.php).'."\n"); 
  die (); }
else {
  require_once('/var/www/html/HRProprietary/HRCloud2/config.php'); }

// / The following code verifies that WordPress is installed.
$WPFile = '/var/www/html/wp-load.php';
if (!file_exists($WPFile)) {
  $WPArch  = $InstLoc.'/Applications/wordpress_11416.zip';
  $VARDir = '/var/www/html';
  echo nl2br('</head>WARNING!!! HRC2CC27, WordPress was not detected on the server.'."\n");
  echo nl2br('OP-Act: Installing WordPress.'."\n");
  shell_exec('unzip '.$WPArch.' -d '.$VARDir); 
  if (file_exists($WPFile)) {
    echo nl2br('OP-Act: Sucessfully installed WordPress!'."\n"); }
  $VARDir = null;
  unset($VARDir); }
if (!file_exists($WPFile)) {
  echo nl2br('ERROR!!! HRC2CC32, WordPress was not detected on the server. And could not be installed.</body></html>'."\n"); }
else {
  require($WPFile); } 

// / The following code sets variables for the session.
$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$UserIDRAW = get_current_user_id();
$UserID = hash('ripemd160', $UserIDRAW.$Salts);
$LogLoc = $InstLoc.'/DATA/'.$UserID.'/.AppLogs';
$LogInc = 0;
$SesLogDir = $LogLoc.'/'.$Date;
$ClamLogDir = ($InstLoc.'/'.'VirusLogs'.'/'.$Date.'.txt');
$LogFile = $SesLogDir.'/'.$Date.'.txt';
$CloudDir = $CloudLoc.'/'.$UserID;
$CloudTemp = $InstLoc.'/DATA/';
$CloudTempDir = $CloudTemp.$UserID;
$AppDir = $InstLoc.'/Applications/';
$Apps = scandir($AppDir);
$defaultApps = array('.', '..', '', 'jquery-3.1.0.min.js', 'index.html', 'HRAI', 'HRConvert2', 
  'HRStreamer', 'getID3-1.9.12', 'displaydirectorycontents_logs', 'displaydirectorycontents_logs1', 
  'displaydirectorycontents_72716', 'wordpress_11416.zip');
$installedApps = array_diff($Apps, $defaultApps);

// / The following code creates required HRCloud2 files if they do not exist. Also installs user 
// / specific files the first time a new user logs in.
if (!file_exists($CloudLoc)) {
  echo ('ERROR!!! HRC2CC59, There was an error verifying the CloudLoc as a valid directory. 
    Please check the config.php file and refresh the page.');
  die(); }
if (!file_exists($CloudDir)) {
  mkdir($CloudDir, 0755); }
if(!file_exists($CloudTemp)) {
  mkdir($CloudTemp);
  copy($InstLoc.'/index.html',$CloudTemp.'index.html'); }
if (!file_exists($CloudTempDir)) { 
  mkdir($CloudTempDir, 0755); 
  copy($InstLoc.'/index.html',$CloudTempDir.'index.html'); }
copy($InstLoc.'/index.html', $CloudTempDir.'/index.html');
$LogInstallDir = 'Applications/displaydirectorycontents_logs/';
$LogInstallDir1 = 'Applications/displaydirectorycontents_logs1/';
$LogInstallFiles = scandir($InstLoc.'/'.$LogInstallDir);
$LogInstallFiles1 = scandir($InstLoc.'/'.$LogInstallDir1);
copy($InstLoc.'/index.html',$LogLoc.'/index.html');
if (!file_exists($LogLoc)) {
  $JICInstallLogs = @mkdir($LogLoc, 0755); }
    foreach ($LogInstallFiles as $LIF) {
      if (file_exists($LogLoc.'/.config.php')) continue;
      if (in_array($LIF1, $installedApps)) continue;
      if ($LIF == '.' or $LIF == '..') continue;
      copy($InstLoc.'/'.$LogInstallDir.$LIF, $LogLoc.'/'.$LIF); } 
if (!file_exists($SesLogDir)) {
  $JICInstallLogs = @mkdir($SesLogDir, 0755); }
    foreach ($LogInstallFiles1 as $LIF1) {
      if (in_array($LIF1, $installedApps)) continue;
      if ($LIF1 == '.' or $LIF1 == '..') continue;
        copy($InstLoc.'/'.$LogInstallDir1.$LIF1, $SesLogDir.'/'.$LIF1); } 

// / The following code sets a target directory within a users Cloud drive and prefixes 
// / any request files with the $_POST['UserDir']. Also used to create new UserDirs.
if (isset($_POST['UserDir'])) {
  $UserDirPOST = ('/'.$_POST['UserDir'].'/'); }
if (!isset($_POST['UserDir'])) {
  $UserDirPOST = ('/'); }
$CloudUsrDir = $CloudDir.$UserDirPOST; 
$CloudTmpDir = $CloudTempDir.$UserDirPOST; 
$AppDir = $InstLoc.'/Applications/';
$ContactsDir = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/Contacts/';
$NotesDir = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/Notes/';
$UserConfig = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.config.php';
if (!file_exists($CloudUsrDir)) {
  mkdir($CloudUsrDir, 0755); }
if (!file_exists($CloudTmpDir)) { 
  mkdir($CloudTmpDir, 0755); }
copy($InstLoc.'/index.html',$CloudTmpDir.'/index.html');

// / The following code checks to see that the user is logged in.
if ($UserIDRAW == '') {
  echo nl2br('ERROR!!! HRC2CC100, You are not logged in!'."\n"); 
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }
if ($UserIDRAW == '0') {
  echo nl2br('ERROR!!! HRC2CC103, You are not logged in!'."\n");
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }
if (!isset($UserIDRAW)) {
  echo nl2br('ERROR!!! HRC2CC106, You are not logged in!'."\n");
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }

// / The following code checks if VirusScan is enabled and update ClamAV definitions accordingly.
if ($VirusScan == '1') {
  shell_exec('freshclam'); }

// / The following code verifies and cleans the config file.  	
if ($Accept_GPLv3_OpenSource_License !== '1') {
  $txt = ('ERROR!!! HRC2CC124, The user has not accepted the end-user license aggreement in config.php!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ('ERROR!!! HRC2CC124, You must read and completely fill out the config.php file located in your
    HRCloud2 installation directory before you can use this software!'); } 

// / The following code checks that the user has agreed to the terms of the GPLv3 before cleaning the config variables.
// / If the user has not read the GPLv3 the script will die!!!
if ($Accept_GPLv3_OpenSource_License == '1') { 
  $CleanConfig = '1';
  $INTIP = 'localhost';
  $EXTIP = 'localhost'; }
if (isset ($InternalIP)) { 
  unset ($InternalIP); }
if (isset ($ExternalIP)) { 
  unset ($ExternalIP); } 

// / HRAI Requires a helper to collect some information to complete HRCloud2 API calls (if HRAI is enabled).
if (!function_exists('readOutputOfPHPfile')) {
  if ($ShowHRAI == '1') {
    if (!file_exists($InstLoc.'/Applications/HRAI/HRAIHelper.php')) {
      echo nl2br('</head><body>ERROR!!! HRC2AL29, Cannot process the HRAI Helper file!'."\n".'</body></html>'); }
    else {
      require($InstLoc.'/Applications/HRAI/HRAIHelper.php'); } } }

// / The following code verifies that a user config file exists and creates one if it does not.
if (!file_exists($UserConfig)) { 
  $CacheData = ('$ColorScheme = \'0\'; $VirusScan = \'0\'; $ShowHRAI = \'1\';');
  $MAKECacheFile = file_put_contents($UserConfig, $CacheData.PHP_EOL , FILE_APPEND); 
  $txt = ('Created a user config file on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($UserConfig)) { 
  $txt = ('ERROR!!! HRC2CC151, There was a problem creating the user config file on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ('ERROR!!! HRC2151, There was a problem creating the user config file on '.$Time.'!'); }
if (file_exists($UserConfig)) {
require ($UserConfig); }

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