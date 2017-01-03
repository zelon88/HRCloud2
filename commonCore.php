<?php

// / This file serves as the Common Core file which can be required by projects that need HRCloud2 to load it's config
// / file, authenticate user storage, and define variables for the session.

// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('ERROR!!! HRC2CommonCore9, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php).'."\n"); 
  die (); }
else {
  require_once('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }

// / The follwoing code checks if the config.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/config.php')) {
  echo nl2br('ERROR!!! HRC2CommonCore17, Cannot process the HRCloud2 configuration file (config.php).'."\n"); 
  die (); }
else {
  require_once('/var/www/html/HRProprietary/HRCloud2/config.php'); }

// / The following code verifies and cleans the config file.    
if ($Accept_GPLv3_OpenSource_License !== '1') {
  die ('ERROR!!! HRC2CommonCore124, You must read and completely fill out the config.php file located in your
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

// / The following code verifies that WordPress is installed.
$WPFile = '/var/www/html/wp-load.php';
if (!file_exists($WPFile)) {
  $WPArch  = $InstLoc.'/Applications/wordpress_11416.zip';
  $VARDir = '/var/www/html';
  echo nl2br('</head>WARNING!!! HRC2CommonCore27, WordPress was not detected on the server.'."\n");
  echo nl2br('OP-Act: Installing WordPress.'."\n");
  shell_exec('unzip '.$WPArch.' -d '.$VARDir); 
  if (file_exists($WPFile)) {
    echo nl2br('OP-Act: Sucessfully installed WordPress!'."\n"); }
  $VARDir = null;
  unset($VARDir); }
if (!file_exists($WPFile)) {
  echo nl2br('ERROR!!! HRC2CommonCore32, WordPress was not detected on the server. And could not be installed.</body></html>'."\n"); }
else {
  require_once ($WPFile); } 

// / The following code sets variables for the session.
$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$UserIDRAW = get_current_user_id();

// / The following code checks to see that the user is logged in.
if ($UserIDRAW == '') {
  echo nl2br('ERROR!!! HRC2CommonCore100, You are not logged in!'."\n"); 
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }
if ($UserIDRAW == '0') {
  echo nl2br('ERROR!!! HRC2CommonCore103, You are not logged in!'."\n");
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }
if (!isset($UserIDRAW)) {
  echo nl2br('ERROR!!! HRC2CommonCore106, You are not logged in!'."\n");
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }

// / The followind code hashes the user ID and sets the directory structure for the session.
$UserID = hash('ripemd160', $UserIDRAW.$Salts);
$LogLoc = $InstLoc.'/DATA/'.$UserID.'/.AppData';
$LogInc = 0;
$SesLogDir = $LogLoc.'/'.$Date;
$ClamLogDir = ($InstLoc.'/'.'VirusLogs'.'/'.$Date.'.txt');
$LogFile = $SesLogDir.'/HRC2-'.$Date.'.txt';
$CloudDir = $CloudLoc.'/'.$UserID;
$CloudTemp = $InstLoc.'/DATA/';
$CloudTempDir = $CloudTemp.$UserID;
$CloudShareDir = $LogLoc.'/Shared';
$AppDir = $InstLoc.'/Applications/';
$ContactsDir = $InstLoc.'/DATA/'.$UserID.'/.AppData/Contacts/';
$NotesDir = $InstLoc.'/DATA/'.$UserID.'/.AppData/Notes/';
$UserConfig = $InstLoc.'/DATA/'.$UserID.'/.AppData/.config.php';
$LogInstallDir = 'Applications/displaydirectorycontents_logs/';
$LogInstallDir1 = 'Applications/displaydirectorycontents_logs1/';
$LogInstallFiles = scandir($InstLoc.'/'.$LogInstallDir);
$LogInstallFiles1 = scandir($InstLoc.'/'.$LogInstallDir1);
$SharedInstallDir = 'Applications/displaydirectorycontents_shared/';
$SharedInstallFiles = scandir($InstLoc.'/'.$SharedInstallDir);
$TempResourcesDir = $InstLoc.'/Resources/TEMP';
$BackupDir = $InstLoc.'/BACKUP';
$AppDir = $InstLoc.'/Applications/';
$Apps = scandir($AppDir);
$defaultApps = array('.', '..', '', 'jquery-3.1.0.min.js', 'index.html', 'HRAI', 'HRConvert2', 
  'HRStreamer', 'getID3-1.9.12', 'displaydirectorycontents_logs', 'displaydirectorycontents_logs1', 
  'displaydirectorycontents_72716', 'displaydirectorycontents_shared', 'wordpress_11416.zip');
$installedApps = array_diff($Apps, $defaultApps);

// / The following code sets a target directory within a users Cloud drive and prefixes 
// / any request files with the $_POST['UserDir']. Also used to create new UserDirs.
$UserDirPOST = '/';
if (isset($_POST['UserDirPOST']) or $_POST['UserDirPOST'] !== '/') {
  $UserDirPOST = ('/'.$_POST['UserDirPOST'].'/'); }
if (isset($_POST['UserDir']) or $_POST['UserDir'] !== '/') {
  $UserDirPOST = ('/'.$_POST['UserDir'].'/'); 
  $_POST['UserDirPOST'] = $UserDirPOST; }
if (!isset($_POST['UserDir']) && !isset($_POST['UserDirPOST'])) {
  $UserDirPOST = ('/'); }

$UserDirPOST = str_replace('//', '/', $_POST['UserDirPOST']);

$CloudTmpDir = $CloudTempDir.$UserDirPOST; 
$CloudTmpDir = str_replace('//', '/', $CloudTmpDir); 
$CloudTmpDir = str_replace('//', '/', $CloudTmpDir); 

$CloudUsrDir = $CloudDir.$UserDirPOST; 
$CloudUsrDir = str_replace('//', '/', $CloudUsrDir); 
$CloudUsrDir = str_replace('//', '/', $CloudUsrDir); 

// / The following code creates required HRCloud2 files if they do not exist. Also installs user 
// / specific files the first time a new user logs in.
if (!file_exists($CloudLoc)) {
  echo ('ERROR!!! HRC2CommonCore59, There was an error verifying the CloudLoc as a valid directory. 
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

// / The following code checks if the TempResources directory exists, and creates one if it does not.
if (!file_exists($TempResourcesDir)) {
  mkdir($TempResourcesDir, 0755); }
copy($InstLoc.'/index.html',$TempResourcesDir.'/index.html');

// / The following code checks if the CloudUsrDir exists, and creates one if it does not.
if (!file_exists($CloudUsrDir)) {
  mkdir($CloudUsrDir, 0755); }

// / The following code checks if the CloudTmpDir exists, and creates one if it does not.
if (!file_exists($CloudTmpDir)) { 
  mkdir($CloudTmpDir, 0755); }
copy($InstLoc.'/index.html',$CloudTmpDir.'/index.html');

// / The following code checks if the LogLoc exists, and creates one if it does not.
// / Also creates the file strucutre needed for the Logs to display content and store cache data.
if (!file_exists($LogLoc)) {
  $JICInstallLogs = @mkdir($LogLoc, 0755); 
  @copy($InstLoc.'/index.html',$LogLoc.'/index.html'); 
    foreach ($LogInstallFiles as $LIF) {
      if (in_array($LIF, $installedApps)) continue;
      if ($LIF == '.' or $LIF == '..' or $LIF == '.config.php') continue;
      @copy($InstLoc.'/'.$LogInstallDir.$LIF, $LogLoc.'/'.$LIF); } }
copy($InstLoc.'/'.$LogInstallDir.'.index.php',$LogLoc.'/.index.php');

// / The following code checks if the SesLogDir exists, and creates one if it does not.
// / Also creates the file strucutre needed for the sesLog to display content.
if (!file_exists($SesLogDir)) {
  $JICInstallLogs = @mkdir($SesLogDir, 0755);
  @copy($InstLoc.'/index.html', $SesLogDir.'/index.html');
    foreach ($LogInstallFiles1 as $LIF1) {
      if (in_array($LIF1, $installedApps)) continue;
      if ($LIF1 == '.' or $LIF1 == '..') continue;
        @copy($InstLoc.'/'.$LogInstallDir1.$LIF1, $SesLogDir.'/'.$LIF1); } }
@copy($InstLoc.'/'.$LogInstallDir1.'.index.php', $SesLogDir.'/.index.php');

// / The following code checks if the CloudShareDir exists, and creates one if it does not.
if (!file_exists($CloudShareDir)) {
  $JICInstallShared = @mkdir($CloudShareDir, 0755); 
  @copy($InstLoc.'/index.html', $CloudShareDir.'/index.html');
    foreach ($SharedInstallFiles as $SIF) {
      if (in_array($SIF, $installedApps)) continue;
      if ($SIF == '.' or $SIF == '..' or is_dir($SIF)) continue;
      @copy($InstLoc.'/'.$SharedInstallDir.$SIF, $CloudShareDir.'/'.$SIF); } }
@copy($InstLoc.'/'.$SharedInstallDir.'.index.php', $CloudShareDir.'/.index.php');

// / The following code will create a backup directory for restoration data.
  // / NO USER DATA IS STORED IN THE BACKUP DIRECTORY!!! Only server configuration data.
if (!file_exists($BackupDir)) {
  mkdir($BackupDir, 0755);
  if (file_exists($BackupDir)) {
    $txt = ('OP-Act: Created a Backup Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($BackupDir)) {
    $txt = ('ERROR!!! HRC2CommonCore137, The Backup Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }

// / The following code verifies that a user config file exists and creates one if it does not.
if (!file_exists($UserConfig)) { 
  @chmod($UserConfig, 0755); 
  @chown($UserConfig, 'www-data'); } 
if (!file_exists($UserConfig)) { 
  copy($LogInstallDir.'.config.php', $UserConfig); }
if (!file_exists($UserConfig)) { 
  $txt = ('ERROR!!! HRC2CommonCore151, There was a problem creating the user config file on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  die ('ERROR!!! HRC2CommonCore151, There was a problem creating the user config file on '.$Time.'!'); }
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