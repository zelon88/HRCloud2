<?php
// / -----------------------------------------------------------------------------------
// / This file serves as the Common Core file which can be required by projects that need HRCloud2 to load it's config
// / file, authenticate user storage, and define variables for the session.
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------  
// / The following code checks if the config.php and the sanitizeCore.php files exist.
if (!file_exists(realpath(dirname(__FILE__)).'/config.php')) die('ERROR!!! HRC2CommonCore17, Cannot process the HRCloud2 configuration file (config.php).'.PHP_EOL); 
else require_once(realpath(dirname(__FILE__)).'/config.php'); 
if (!file_exists(realpath(dirname(__FILE__)).'/sanitizeCore.php')) die('ERROR!!! HRC2CommonCore9, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php).'.PHP_EOL); 
else require_once(realpath(dirname(__FILE__)).'/sanitizeCore.php'); 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code disables the platform when $EnableMaintenanceMode is set either here, or in config.php.
//$EnableMaintenanceMode = 1;
if (!isset($EnableMaintenanceMode) or $EnableMaintenanceMode !== '1') $EnableMaintenanceMode = '0';
if ($EnableMaintenanceMode == '1') die('<strong>The page you are trying to reach is unavailable due to maintenance. Please check back later.</strong>');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code verifies and cleans the config file.    
if ($Accept_GPLv3_OpenSource_License !== '1') die('ERROR!!! HRC2CommonCore124, You must read and completely fill out the config.php file located in your HRCloud2 installation directory before you can use this software!'.PHP_EOL); 
if (isset ($InternalIP)) unset ($InternalIP); 
if (isset ($ExternalIP)) unset ($ExternalIP);  
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code validates permission settings.
if (!isset($CLPerms)) if (strlen($CLPerms) > 4 or strlen($CLPerms < 3)) $CLPerms = '0755'; 
if (!isset($ILPerms)) if (strlen($IL_Perms) > 4 or strlen($IL_Perms < 3)) $IL_Perms = '0755'; 
if (!isset($ApacheUser)) $ApacheGroup = 'www-data';
if (!isset($ApacheUser)) $ApacheUser = 'www-data';
$CLPerms = octdec(str_replace('\'', '', $CLPerms));
$ILPerms = octdec(str_replace('\'', '', $ILPerms));
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code verifies that WordPress is installed.
$WPFile = $ServerRootDir.'/wp-load.php';
if (!file_exists($WPFile)) {
  $WPArch  = $InstLoc.'/Applications/wordpress.zip';
  echo nl2br('Notice!!! HRC2CommonCore27, WordPress was not detected on the server.'.PHP_EOL."\n".' Please visit http://yourserver in a browser and configure WordPress before returning or refreshing this page.'.PHP_EOL."\n");
  echo nl2br('OP-Act: Installing WordPress.'.PHP_EOL."\n");
  shell_exec('unzip '.$WPArch.' -d '.$ServerRootDir); 
  if (file_exists($WPFile)) echo nl2br('OP-Act: Sucessfully installed WordPress!'.PHP_EOL."\n"); 
  if (!file_exists($WPFile)) echo nl2br('ERROR!!! HRC2CommonCore32, WordPress was not detected on the server and could not be installed.'.PHP_EOL."\n"); 
  die(); }
else require_once ($WPFile); 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks to see that the user is logged in.
$UserIDRAW = get_current_user_id();
if ($UserIDRAW == '') {
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die('ERROR!!! HRC2CommonCore100, You are not logged in!'.PHP_EOL); }
if ($UserIDRAW == '0') {
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die('ERROR!!! HRC2CommonCore103, You are not logged in!'.PHP_EOL); }
if (!isset($UserIDRAW)) {
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die('ERROR!!! HRC2CommonCore106, You are not logged in!'.PHP_EOL); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The followind code sets the directory structure and global variables for the session.
$VersionFile = 'versionInfo.php';
require($VersionFile);
$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$Current_URL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$CallingScriptBasename = basename(pathinfo($_SERVER['SCRIPT_FILENAME'])['basename']);
$CallingScriptStylesDir = pathinfo($_SERVER['SCRIPT_FILENAME'])['dirname'].'/Styles';
$ServerID = hash('ripemd160', $UniqueServerName.$Salts);
$UserID = hash('ripemd160', $UserIDRAW.$Salts);
$SesHash = substr(hash('ripemd160', $Date.$UserID.$Salts), -7);
$LogLoc = $InstLoc.'/DATA/'.$UserID.'/.AppData';
$LogInc = $ClamLogFileInc = 0;
$SesLogDir = $LogLoc.'/'.$Date;
$ClamLogDir = $SesLogDir.'/VirusLog_'.$ClamLogFileInc.'_'.$Date.'.txt';
$LogFile = $SesLogDir.'/HRC2-'.$SesHash.'-'.$Date.'.txt';
$CloudDir = $CloudLoc.'/'.$UserID;
$CloudTemp = $InstLoc.'/DATA/';
$CloudTempDir = $CloudTemp.$UserID;
$CloudShareDir = $LogLoc.'/Shared';
$AppDir = $InstLoc.'/Applications/';
$CloudAppDir = $CloudLoc.'/Apps';
$JanitorFile = $InstLoc.'/janitor.php';
$AdminConfig = $InstLoc.'/DATA/'.$AdminCacheHash.'/.AppData/.config.php';
$LogInstallDir = 'Applications/displaydirectorycontents_logs/';
$LogInstallDir1 = 'Applications/displaydirectorycontents_logs1/';
$LogInstallFiles = scandir($InstLoc.'/'.$LogInstallDir);
$LogInstallFiles1 = scandir($InstLoc.'/'.$LogInstallDir1);
$UserShared = $URL.'/HRProprietary/HRCloud2/DATA/'.$UserID.'/.AppData/Shared';
$UserSharedIndex = $UserShared.'/.index.php';
$SharedInstallDir = 'Applications/displaydirectorycontents_shared/';
$UserSharedDir = $InstLoc.'/DATA/'.$UserID.'/.AppData/Shared';
$SharedInstallFiles = scandir($InstLoc.'/'.$SharedInstallDir);
$HRAIMiniGUIFile = $InstLoc.'/Applications/HRAIMiniGui.php';
$ResourcesDir = $InstLoc.'/Resources';
$ClientInstallDir = $ResourcesDir.'/ClientInstallers';
$ClientInstallDirWin = $ClientInstallDir.'/windows';
$ClientInstallDirLin = $ClientInstallDir.'/linux';
$ClientInstallDirOsx = $ClientInstallDir.'/osx';
$TipFile = $ResourcesDir.'/tips.php';
$TempResourcesDir = $ResourcesDir.'/TEMP';
$appDataInstDir = $InstLoc.'/DATA/'.$UserID.'/.AppData';
$appDataCloudDir = $CloudLoc.'/'.$UserID.'/.AppData';
$FavoritesCacheFileInst = $appDataInstDir.'/.favorites.php';
$FavoritesCacheFileCloud = $appDataCloudDir.'/.favorites.php';
$ContactsDir = $appDataInstDir.'/Contacts/';
$NotesDir = $appDataInstDir.'/Notes/';
$UserConfig = $appDataInstDir.'/.config.php';
$BackupDir = $InstLoc.'/BACKUP';
$AppDir = $InstLoc.'/Applications/';
$Apps = scandir($AppDir);
$UserContacts = $InstLoc.'/DATA/'.$UserID.'/.AppData/.contacts.php';
$UserNotes = $InstLoc.'/DATA/'.$UserID.'/.AppData/.notes.php';
$defaultApps = array('.', '..', '', 'error.php', 'HRAIMiniGui.php', 'jquery-3.1.0.min.js', 'index.html', 'HRAIMiniGui.php', 'HRAI', 'HRConvert2', 
 'HRStreamer', 'getid3', 'displaydirectorycontents_logs', 'displaydirectorycontents_logs1', 'style.css', 'Shared', 'ServMon.php', 'Favorites.php',  
 'displaydirectorycontents_72716', 'displaydirectorycontents_shared', 'wordpress.zip', 'PHPAV.php', 'Bookmarks', 'Calendar', 'Contacts', 'Notes', 'UberGallery');
$DangerousFiles = array('js', 'php', 'html', 'css');
$installedApps = array_diff($Apps, $defaultApps);
$RequiredDirs1 = array($CloudDir, $CloudTemp, $CloudTempDir, $appDataCloudDir, $ResourcesDir, $TempResourcesDir, $ClientInstallDir, $ClientInstallDirWin, $ClientInstallDirLin, $ClientInstallDirOsx, $CloudAppDir, $BackupDir);
$RequiredDirs2 = array($LogLoc, $SesLogDir, $CloudShareDir);
$tipsHeight = '0';
$hr = '<hr style="width:100%;"/>'."\n";
$br = '<br />';
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets some default settings if none are specified by config.php.
if (!isset($defaultNickname) or $defaultNickname == '') $defaultNickname = 'Commander';  
if (!isset($defaultTimezone) or $defaultTimezone == '') $defaultTimezone = 'America/New_York'; 
if (!isset($defaultFont) or $defaultFont == '') $defaultFont = 'Helvetica'; 
if (!isset($defaultColorScheme) or $defaultColorScheme == '') $defaultColorScheme = '1';
if (!is_numeric($defaultColorSchemes)) $defaultColorSchemes = '0'; 
if (!isset($defaultShowHRAI) or $defaultShowHRAI == '') $defaultShowHRAI = '';
if (!isset($defaultHRAIAudio) or $defaultHRAIAudio == '') $defaultHRAIAudio = '1'; 
if (!is_numeric($defaultHRAIAudio) or $defaultHRAIAudio > '1') $defaultHRAIAudio = '0'; 
if (!isset($defaultShowTips) or $defaultShowTips == '') $defaultShowTips = '1'; 
if (!is_numeric($defaultShowTips) or $defaultShowTips > '1') $defaultShowTips = '0'; 
if (!isset($defaultPPEnableURL) or $defaultPPEnableURL == '') $defaultPPEnableURL = '0';
if (!is_numeric($defaultPPEnableURL) or $defaultPPEnableURL > '1') $defaultPPEnableURL = '0'; 
if (!isset($defaultTOSEnableURL) or $defaultTOSEnableURL == '') $defaultTOSEnableURL = '0';
if (!is_numeric($defaultTOSEnableURL) or $defaultTOSEnableURL > '1') $defaultTOSEnableURL = '0'; 
if (!isset($defaultPrivacyPolicyURL) or $defaultPrivacyPolicyURL == '') $defaultPrivacyPolicyURL = 'https://www.honestrepair.net/index.php/privacy-policy';
if (!isset($defaultTermsOfServiceURL) or $defaultTermsOfServiceURL == '') $defaultTermsOfServiceURL = 'https://www.honestrepair.net/index.php/terms-of-service';
if (!isset($ShowHRAI) or $ShowHRAI == '') $ShowHRAI = $defaultShowHRAI;
if (!isset($HRAIAudio) or $HRAIAudio == '') $HRAIAudio = $defaultHRAIAudio;
if (!isset($nickname) or $nickname == '') $nickname = $defaultNickname;
if (!isset($Timezone) or $Timezone == '') $Timezone = $defaultTimezone;
if (!isset($Font) or $Font == '') $Font = $defaultFont;
if (!isset($ColorScheme) or $ColorScheme == '') $ColorScheme = $defaultColorScheme;
if (!isset($ShowTips) or $ShowTips == '') $ShowTips = $defaultShowTips;
if (!isset($PPEnableURL) or $PPEnableURL == '') $PPEnableURL = $defaultPPEnableURL;
if (!is_numeric($PPEnableURL) or $PPEnableURL > '1') $PPEnableURL = $defaultPPEnableURL; 
if (!isset($TOSEnableURL) or $TOSEnableURL == '') $TOSEnableURL = $defaultTOSEnableURL;
if (!is_numeric($TOSEnableURL) or $TOSEnableURL > '1') $TOSEnableURL = $defaultTOSEnableURL; 
if (!isset($PrivacyPolicyURL) or $PrivacyPolicyURL == '') $PrivacyPolicyURL = $defaultPrivacyPolicyURL;
if (!isset($TermsOfServiceURL) or $TermsOfServiceURL == '') $TermsOfServiceURL = $defaultTermsOfServiceURL;
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets a target directory within a users Cloud drive and prefixes 
// / any requested files with the $_POST['UserDir']. 
// / Also used to create new UserDirs.
$UserDirPOST = '/';
// / If a valid UserDir is set, use it for all paths and operations.
if (isset($_POST['UserDir']) or $_POST['UserDir'] !== '/') $UserDirPOST = $_POST['UserDirPOST'] = str_replace('//', '/', str_replace('///', '/', '/'.$_POST['UserDir'].'/')); 
// / If the root Cloud Drive is selected set the path directory and URL directory as a slash.
if (!isset($_POST['UserDir']) && !isset($_POST['UserDirPOST'])) $Udir = $UserDirPOST = '/'; 
// / Whatever directory the user is "in" is used for URLs.
if (isset($_POST['UserDir']) or isset($_POST['UserDirPOST'])) $Udir = str_replace('//', '/', str_replace('//', '/', str_replace('//', '/', $_POST['UserDirPOST'].'/'))); 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code defines the user directories and adds them to the array of RequiredDirs.
$CloudTmpDir = str_replace('//', '/', str_replace('//', '/', str_replace('//', '/', str_replace('///', '/', $CloudTempDir.$UserDirPOST)))); 
$CloudUsrDir = str_replace('//', '/', str_replace('//', '/', str_replace('//', '/', str_replace('///', '/', $CloudDir.$UserDirPOST)))); 
array_push($RequiredDirs1, $CloudTmpDir, $CloudUsrDir);
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code verifies that the CloudLoc exists.
if (!is_dir($CloudLoc)) die('ERROR!!! HRC2CommonCore59, There was a problem verifying the CloudLoc as a valid directory. Please check the config.php file and refresh the page.'); 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code creates the first set of required directories that need basic index.html document root protection files.
foreach ($RequiredDirs1 as $RequiredDir1) {
  $RequiredDir1 = rtrim($RequiredDir1, '/');
  if (!file_exists($RequiredDir1)) {
    @mkdir($RequiredDir1); 
    if (!file_exists($RequiredDir1)) die('ERROR!!! HRC2CommonCore137, The required directory '.$RequiredDir1.' does not exist and could not be created on '.$Time.'!'.PHP_EOL); }
  if (file_exists($RequiredDir1)) { 
    @chown($RequiredDir1, $ApacheUser);
    @chgrp($RequiredDir1, $ApacheGroup);
    @chmod($RequiredDir1, $ILPerms); }
  if (!file_exists($RequiredDir1.'/index.html')) @copy($InstLoc.'/index.html', $RequiredDir1.'/index.html');
  if (file_exists($RequiredDir1.'/index.html')) if ($Now - @filemtime($RequiredDir1.'/index.html') >= 60 * 60 * 24 * 1) { // 1 day
    @unlink($RequiredDir1.'/index.html');
    @copy($InstLoc.'/index.html', $RequiredDir1.'/index.html'); } } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code creates the last set of required directories that need advanced setup.
foreach ($RequiredDirs2 as $RequiredDir2) { 
  if ($RequiredDir2 === $SesLogDir) $LogInstallDir = $LogInstallDir1; 
  if ($RequiredDir2 === $CloudShareDir) $LogInstallDir = $SharedInstallDir; 
  if (!file_exists($RequiredDir2)) {
    @mkdir($RequiredDir2);
    if (!file_exists($RequiredDir2)) die('ERROR!!! HRC2CommonCore137, The required directory '.$RequiredDir2.' does not exist and could not be created on '.$Time.'!'.PHP_EOL); 
    @copy($InstLoc.'/index.html', $RequiredDir2.'/index.html');
    if ($RequiredDir2 === $LogLoc) $FilesArr = $LogInstallFiles; 
    if ($RequiredDir2 === $SesLogDir) $FilesArr = $LogInstallFiles1; 
    if ($RequiredDir2 === $CloudShareDir) $FilesArr = $SharedInstallFiles; 
    foreach ($FilesArr as $LIF1) {
      if (in_array($LIF1, $installedApps)) continue;
      if ($LIF1 == '.' or $LIF1 == '..') continue;
      @copy($InstLoc.'/'.$LogInstallDir1.$LIF1, $RequiredDir2.'/'.$LIF1); } }
  if (file_exists($RequiredDir2)) { 
    @chown($RequiredDir2, $ApacheUser);
    @chgrp($RequiredDir2, $ApacheGroup);
    @chmod($RequiredDir2, $ILPerms); }
  if (!file_exists($RequiredDir2.'/.index.php')) copy($InstLoc.'/'.$LogInstallDir.'.index.php', $RequiredDir2.'/.index.php');
  if (!file_exists($RequiredDir2.'/index.html')) copy($InstLoc.'/index.html', $RequiredDir2.'/index.html');
  if (file_exists($RequiredDir2.'/.index.php')) if ($Now - @filemtime($RequiredDir2.'/.index.php') >= 60 * 60 * 24 * 1) { // 1 day  
    @unlink($RequiredDir2.'/.index.php');
    @copy($InstLoc.'/'.$LogInstallDir.'.index.php', $RequiredDir2.'/.index.php'); } 
  if (file_exists($RequiredDir2.'/index.html')) if ($Now - @filemtime($RequiredDir2.'/index.html') >= 60 * 60 * 24 * 1) { // 1 day
    @unlink($RequiredDir2.'/index.html');
    @copy($InstLoc.'/index.html', $RequiredDir2.'/index.html'); } } 
$LogInstallDir = 'Applications/displaydirectorycontents_logs/';
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets a clean ClamLogFile if one does not exist.
while (file_exists($ClamLogDir)) $ClamLogDir = $SesLogDir.'/VirusLog_'.$ClamLogFileInc++.'_'.$Date.'.txt'; 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code reads the Admin configuration settings and sets temporary variables.
$AdminIDRAW = 1;
$AdminID = hash('ripemd160', $AdminIDRAW.$Salts);
$adminAppDataInstDir = $InstLoc.'/DATA/'.$AdminID.'/.AppData';
$AdminConfig = $adminAppDataInstDir.'/.config.php';
if (!file_exists($AdminConfig)) copy($LogInstallDir.'/.config.php', $AdminConfig);
if (!file_exists($AdminConfig)) { 
  $txt = 'WARNING!!! HRC2CommonCore151, There was a problem loading the admin settings on '.$Time.'!'; 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  die($txt); }
else include($AdminConfig); 
$Nickname = '';
$AdminIDRAW = $AdminID = $adminAppDataInstDir = $AdminConfig = null; 
unset ($AdminIDRAW, $AdminID, $adminAppDataInstDir, $AdminConfig);
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code loads the user config file if it exists and creates one if it does not.
if (!file_exists($UserConfig)) { 
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Creating a user config file on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  copy($LogInstallDir.'.config.php', $UserConfig); }
if (!file_exists($UserConfig)) { 
  $txt = 'ERROR!!! HRC2CommonCore151, There was a problem creating the user config file on '.$Time.'!'; 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  die($txt); }
else include($UserConfig);
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets the date and time for the session.
// / It's important to note that logs created before this variable is set may be written using server timezone.
$Now = time();
$Timezone = str_replace(' ', '_', $Timezone);
date_default_timezone_set($Timezone);
$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the FavoritesCacheFile exists, and creates one if it does not.
if (!file_exists($FavoritesCacheFileCloud)) { 
  $data = '<?php $FavoriteFiles = array();';
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Created a Favorites cache file in the Cloud directory on '.$Time.'.'.PHP_EOL, FILE_APPEND); 
  $MAKEFavCacheFile = file_put_contents($FavoritesCacheFileCloud, $data.PHP_EOL, FILE_APPEND); 
  if (!file_exists($FavoritesCacheFileCloud)) { 
    $txt = 'ERROR!!! HRC2CommonCore301, There was a problem creating a Favorites cache file in the Cloud directory on '.$Time.'!'; 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die($txt); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the FavoritesCacheFile exists, and creates one if it does not.
if (!file_exists($FavoritesCacheFileInst)) { 
  $data = '<?php $FavoriteFiles = array();';
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Creating a Favorites cache file in the Installation directory on '.$Time.'.'.PHP_EOL, FILE_APPEND); 
  $MAKEFavCacheFile = file_put_contents($FavoritesCacheFileInst, $data.PHP_EOL, FILE_APPEND); 
  if (!file_exists($FavoritesCacheFileCloud)) { 
    $txt = 'ERROR!!! HRC2CommonCore313, There was a problem creating a Favorites cache file in the Installation directory on '.$Time.'!'; 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die($txt); } } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------        
// / The following code ensures there are index files in the temp directories for document root protection.
if (!file_exists($CloudTempDir.'/index.html')) {
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Copying an index file to '.$CloudTempDir.' on '.$Time.'.'.PHP_EOL, FILE_APPEND); 
  @copy('index.html', $CloudTempDir.'/index.html'); 
  if (!file_exists($CloudTempDir.'/index.html')) { 
    $txt = 'ERROR!!! HRC2CommonCore309, There was a problem copying an index file to '.$CloudTempDir.' on '.$Time.'!'; 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die($txt); } }
if (!file_exists($CloudTmpDir.'/index.html')) {
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Copying an index file to '.$CloudTmpDir.' on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  @copy('index.html', $CloudTmpDir.'/index.html'); 
  if (!file_exists($CloudTempDir.'/index.html')) { 
    $txt = 'ERROR!!! HRC2CommonCore315, There was a problem copying an index file to '.$CloudTmpDir.' on '.$Time.'!'; 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die($txt); } }  
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will clean up old files.
if (file_exists($CloudTempDir)) {
  $DFiles = glob($CloudTempDir.'/*');
  foreach ($DFiles as $DFile) {
    if (in_array($DFile, $defaultApps) or $DFile == ($CloudTempDir.'/.') or $DFile == ($CloudTempDir.'/..')) continue;
    $stat = lstat($DFile);
    if (($Now - $stat['mtime']) >= 600) { // Time to keep files.
      if (is_file($DFile)) {
        unlink($DFile); 
        $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Cleaned '.$DFile.' on '.$Time.'.'.PHP_EOL, FILE_APPEND); } 
    if (is_dir($DFile)) {
      $CleanDir = $DFile;
      $CleanFiles = scandir($DFile);
      $JanitorDeleteIndex = 1;
      include($JanitorFile); 
      @rmdir($DFile); } } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sync's the users AppData between the InstLoc and the CloudLoc.
if (!file_exists($appDataCloudDir)) {
  $txt = 'WARNING!!! HRC2CommonCore238, There was a problem creating the a sync\'d copy of the AppData directory in the CloudLoc on '.$Time.'!'; 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  die($txt.PHP_EOL.'Most likely the server\'s permissions are incorrect. Make sure the www-data usergroup and user have R/W access to ALL folders in the Cloud directory.'); }
$dirs = array_filter(glob($appDataInstDir.'/*'), 'is_dir');
foreach($dirs as $dir) {
  chown($appDataInstDir.'/'.basename($dir), $ApacheUser);
  chgrp($appDataInstDir.'/'.basename($dir), $ApacheGroup);
  chmod($appDataInstDir.'/'.basename($dir), $ILPerms); }
foreach ($iterator = new \RecursiveIteratorIterator (
  new \RecursiveDirectoryIterator ($appDataInstDir, \RecursiveDirectoryIterator::SKIP_DOTS),
  \RecursiveIteratorIterator::SELF_FIRST) as $item) {
  $ADCD = $appDataCloudDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName();
  if (is_dir($item)) {
    if (!is_dir($ADCD)) {
      mkdir($ADCD); 
      continue; } }
  else if (!is_link($item) && !file_exists($ADCD)) copy($item, $ADCD); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sync's the users AppData between the CloudLoc and the InstLoc.
if (!file_exists($appDataInstDir)) {
  $txt = 'WARNING!!! HRC2CommonCore238, There was a problem creating the a sync\'d copy of the AppData directory in the InstLoc on '.$Time.'!'; 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  die($txt.PHP_EOL.'Most likely the server\'s permissions are incorrect. Make sure the www-data usergroup and user have R/W access to ALL folders in the Installation directory. '); }
foreach ($iterator = new \RecursiveIteratorIterator (
  new \RecursiveDirectoryIterator ($appDataCloudDir, \RecursiveDirectoryIterator::SKIP_DOTS),
  \RecursiveIteratorIterator::SELF_FIRST) as $item) {
  $ADID = $appDataInstDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName();
  if (is_dir($item)) {
    if (!is_dir($ADID)) {
      mkdir($ADID); 
      continue; } }
  else if (!is_link($item) && !file_exists($ADID)) copy($item, $ADID); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code represents the stylesheet/color scheme handler. 
if ($noStyles !== 1) {
  if ($ColorScheme == '0' or $ColorScheme == '' or !isset($ColorScheme)) $ColorScheme = '1'; 
  if ($CallingScriptBasename !== '.index.php' or $minStyles == 1 or $allStyles == 1) {   
    if ($ColorScheme == '1') echo('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Styles/styleBLUE.css">'); 
    if ($ColorScheme == '2') echo('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Styles/styleRED.css">'); 
    if ($ColorScheme == '3') echo('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Styles/styleGREEN.css">'); 
    if ($ColorScheme == '4') echo('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Styles/styleGREY.css">'); 
    if ($ColorScheme == '5') echo('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Styles/styleBLACK.css">'); }
  if ($CallingScriptBasename == '.index.php' or $CallingScriptBasename == 'cloudCore.php' or $maxStyles == 1 or $allStyles == 1) { 
    if ($ColorScheme == '1') echo('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Styles/iframeStyleBLUE.css">'); 
    if ($ColorScheme == '2') echo('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Styles/iframeStyleRED.css">'); 
    if ($ColorScheme == '3') echo('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Styles/iframeStyleGREEN.css">'); 
    if ($ColorScheme == '4') echo('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Styles/iframeStyleGREY.css">'); 
    if ($ColorScheme == '5') echo('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Styles/iframeStyleBLACK.css">'); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if ShowTips is enabled and loads a random Tip if needed.
if ($ShowTips == '1') {
  if (file_exists($TipFile)) {
    include($TipFile);
    $RandomTip = array_rand($Tips);
    $Tip = $Tips[$RandomTip];
    $Tips = null; 
    $RandomTip = null;
    unset($Tips, $RandomTip); } } 
// / -----------------------------------------------------------------------------------
?>