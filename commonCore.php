<?php
// / -----------------------------------------------------------------------------------
// / This file serves as the Common Core file which can be required by projects that need HRCloud2 to load it's config
// / file, authenticate user storage, and define variables for the session.
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------  
// / The following code checks if the config.php and the sanitizeCore.php files exist.
if (!file_exists(realpath(dirname(__FILE__)).'/config.php')) {
  echo nl2br('ERROR!!! HRC2CommonCore17, Cannot process the HRCloud2 configuration file (config.php).'."\n"); 
  die (); }
else {
  require_once(realpath(dirname(__FILE__)).'/config.php'); }
if (!file_exists(realpath(dirname(__FILE__)).'/sanitizeCore.php')) {
  echo nl2br('ERROR!!! HRC2CommonCore9, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php).'."\n"); 
  die (); }
else {
  require_once(realpath(dirname(__FILE__)).'/sanitizeCore.php'); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code disables the platform when $EnableMaintenanceMode is set either here, or in config.php.
//$EnableMaintenanceMode = 1;
if (!isset($EnableMaintenanceMode) or $EnableMaintenanceMode !== '1') $EnableMaintenanceMode = '0';
if ($EnableMaintenanceMode == '1') die('<strong>The page you are trying to reach is unavailable due to maintenance. Please check back later.</strong>');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code verifies and cleans the config file.    
if ($Accept_GPLv3_OpenSource_License !== '1') {
  die ('ERROR!!! HRC2CommonCore124, You must read and completely fill out the config.php file located in your
    HRCloud2 installation directory before you can use this software!'); }
if (isset ($InternalIP)) { 
  unset ($InternalIP); }
if (isset ($ExternalIP)) { 
  unset ($ExternalIP); } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code validates permission settings.
if (!isset($CLPerms)) { 
  if (strlen($CLPerms) > 4 or strlen($CLPerms < 3)) $CLPerms = '0755'; }
if (!isset($CLPerms)) {
  if (strlen($IL_Perms) > 4 or strlen($IL_Perms < 3)) $IL_Perms = '0755'; }
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
  echo nl2br('Notice!!! HRC2CommonCore27, WordPress was not detected on the server. 
    Please visit http://yourserver in a browser and configure WordPress before returning or refreshing this page.'."\n");
  echo nl2br('OP-Act: Installing WordPress.'."\n");
  shell_exec('unzip '.$WPArch.' -d '.$ServerRootDir); 
  if (file_exists($WPFile)) {
    echo nl2br('OP-Act: Sucessfully installed WordPress!'."\n"); }
  $ServerRootDir = null;
  unset($ServerRootDir); 
  die(); }
if (!file_exists($WPFile)) {
  echo nl2br('ERROR!!! HRC2CommonCore32, WordPress was not detected on the server. 
   And could not be installed.'."\n"); }
else {
  require_once ($WPFile); } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks to see that the user is logged in.
$UserIDRAW = get_current_user_id();
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
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The followind code hashes the user ID and sets the directory structure for the session.
$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$Current_URL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$ServerID = hash('ripemd160', $UniqueServerName.$Salts);
$UserID = hash('ripemd160', $UserIDRAW.$Salts);
$SesHash = substr(hash('ripemd160', $Date.$UserID.$Salts), -7);
$LogLoc = $InstLoc.'/DATA/'.$UserID.'/.AppData';
$LogInc = 0;
$SesLogDir = $LogLoc.'/'.$Date;
$ClamLogFileInc = 0;
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
  'displaydirectorycontents_72716', 'displaydirectorycontents_shared', 'wordpress.zip', 'Bookmarks', 'Calendar', 'Contacts', 'Notes', 'UberGallery');
$DangerousFiles = array('js', 'php', 'html', 'css');
$installedApps = array_diff($Apps, $defaultApps);
$tipsHeight = '0';
$hr = '<hr style="width:100%;"/>'."\n";
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
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets some default settings if none are specified by the user's config.php.
if (!isset($ShowHRAI) or $ShowHRAI == '') $ShowHRAI = $defaultShowHRAI;
if (!isset($HRAIAudio) or $HRAIAudio == '') $HRAIAudio = $defaultHRAIAudio;
if (!isset($nickname) or $nickname == '') $nickname = $defaultNickname;
if (!isset($Timezone) or $Timezone == '') $Timezone = $defaultTimezone;
if (!isset($Font) or $Font == '') $Font = $defaultFont;
if (!isset($ColorScheme) or $ColorScheme == '') $ColorScheme = $defaultColorScheme;
if (!isset($ShowTips) or $ShowTips == '') $ShowTips = $defaultShowTips;
if (!isset($ApacheUser) or $ApacheUser == '') $ApacheUser = 'www-data';
if (!isset($ApacheGroup) or $ApacheGroup == '') $ApacheGroup = 'www-data';
if (!isset($CLPerms) or $CLPerms == '') $CLPerms = 0755;
if (!isset($ILPerms) or $ILPerms == '') $ILPerms = 0755;
if (!isset($PPEnableURL) or $PPEnableURL == '') $PPEnableURL = $defaultPPEnableURL;
if (!is_numeric($PPEnableURL) or $PPEnableURL > '1') $PPEnableURL = $defaultPPEnableURL; 
if (!isset($TOSEnableURL) or $TOSEnableURL == '') $TOSEnableURL = $defaultTOSEnableURL;
if (!is_numeric($TOSEnableURL) or $TOSEnableURL > '1') $TOSEnableURL = $defaultTOSEnableURL; 
if (!isset($PrivacyPolicyURL) or $PrivacyPolicyURL == '') $PrivacyPolicyURL = $defaultPrivacyPolicyURL;
if (!isset($TermsOfServiceURL) or $TermsOfServiceURL == '') $TermsOfServiceURL = $defaultTermsOfServiceURL;
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets a target directory within a users Cloud drive and prefixes 
// / any request files with the $_POST['UserDir']. Also used to create new UserDirs.
$UserDirPOST = '/';
if (isset($_POST['UserDirPOST']) or $_POST['UserDirPOST'] !== '/') {
  $UserDirPOST = str_replace('//', '/', ('/'.$_POST['UserDirPOST'].'/')); }
if (isset($_POST['UserDir']) or $_POST['UserDir'] !== '/') {
  $UserDirPOST = str_replace('//', '/', ('/'.$_POST['UserDir'].'/')); 
  $_POST['UserDirPOST'] = $UserDirPOST; }
if (!isset($_POST['UserDir']) && !isset($_POST['UserDirPOST'])) {
  $UserDirPOST = ('/'); }
// / The following code cleans extra slashes from the UserDirPOST.
$UserDirPOST = str_replace('//', '/', str_replace('//', '/', str_replace('//', '/', $_POST['UserDirPOST'])));
$CloudTmpDir = str_replace('//', '/', str_replace('//', '/', str_replace('//', '/', str_replace('//', '/', $CloudTempDir.$UserDirPOST)))); 
$CloudUsrDir = str_replace('//', '/', str_replace('//', '/', str_replace('//', '/', str_replace('//', '/', $CloudDir.$UserDirPOST)))); 
// / The following code represents the user directory handler.
if (isset($_POST['UserDir']) or isset($_POST['UserDirPOST'])) {
  if ($_POST['UserDir'] == '/' or $_POST['UserDirPOST'] == '/') { 
    $_POST['UserDir'] = '/'; 
    $_POST['UserDirPOST'] = '/'; }  
  $Udir = str_replace('//', '/', str_replace('//', '/', str_replace('//', '/', $_POST['UserDirPOST'].'/'))); }
if (!isset($_POST['UserDir']) or !isset($_POST['UserDirPOST'])) { 
  $Udir = '/'; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code creates required HRCloud2 files if they do not exist. Also installs user 
// / specific files and new index files as needed.
if (!is_dir($CloudLoc)) {
  $txt = ('ERROR!!! HRC2CommonCore59, There was an error verifying the CloudLoc as a valid directory. 
    Please check the config.php file and refresh the page.');
  die($txt); }
if (!file_exists($CloudDir)) {
  mkdir($CloudDir); }
if (file_exists($CloudDir)) { 
  chown($CloudDir, $ApacheUser);
  chgrp($CloudDir, $ApacheGroup);
  chmod($CloudDir, $CLPerms); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the $CloudTemp directory ($CloudLoc.$userID) exists, and creates one if it does not.
if(!file_exists($CloudTemp)) {
  mkdir($CloudTemp); 
  if (file_exists($CloudTemp)) {
    $txt = ('OP-Act: Created a Cloud Temp directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($CloudTemp)) {
    $txt = ('ERROR!!! HRC2CommonCore137, The Cloud Temp directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
if (file_exists($CloudTemp)) { 
  chown($CloudTemp, $ApacheUser);
  chgrp($CloudTemp, $ApacheGroup);
  chmod($CloudTemp, $ILPerms); }
@copy($InstLoc.'/index.html', $CloudTemp.'index.html');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the $CloudTemp directory ($InstLoc.'/DATA/'.$userID) exists, and creates one if it does not.
if (!file_exists($CloudTempDir)) { 
  mkdir($CloudTempDir); }
if (file_exists($CloudTempDir)) { 
  chown($CloudTempDir, $ApacheUser);
  chgrp($CloudTempDir, $ApacheGroup);
  chmod($CloudTempDir, $ILPerms); }
@copy($InstLoc.'/index.html', $CloudTempDir.'/index.html');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the CloudTmpDir exists, and creates one if it does not.
if (!file_exists($CloudTmpDir)) { 
  mkdir($CloudTmpDir); }
if (file_exists($CloudTmpDir)) { 
  chown($CloudTmpDir, $ApacheUser);
  chgrp($CloudTmpDir, $ApacheGroup);
  chmod($CloudTmpDir, $ILPerms); }
@copy($InstLoc.'/index.html', $CloudTmpDir.'/index.html');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the LogLoc exists, and creates one if it does not.
// / Also creates the file strucutre needed for the Logs to display content and store cache data.
if (!file_exists($LogLoc)) {
  mkdir($LogLoc); 
  @copy($InstLoc.'/index.html',$LogLoc.'/index.html'); 
    foreach ($LogInstallFiles as $LIF) {
      if ($LIF == '.' or $LIF == '..' or $LIF == '.config.php') continue;
      @copy($InstLoc.'/'.$LogInstallDir.$LIF, $LogLoc.'/'.$LIF); } }
if (file_exists($LogLoc)) { 
  chown($LogLoc, $ApacheUser);
  chgrp($LogLoc, $ApacheGroup);
  chmod($LogLoc, $ILPerms); }
copy($InstLoc.'/'.$LogInstallDir.'.index.php', $LogLoc.'/.index.php');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the appDataInstDir exists, and creates one if it does not.
if (!file_exists($appDataInstDir)) { 
  mkdir($appDataInstDir); }
if (file_exists($appDataInstDir)) { 
  chown($appDataInstDir, $ApacheUser);
  chgrp($appDataInstDir, $ApacheGroup);
  chmod($appDataInstDir, $ILPerms); }
@copy($InstLoc.'/index.html', $appDataInstDir.'/index.html');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the appDataCloudDir exists, and creates one if it does not.
if (!file_exists($appDataCloudDir)) { 
  mkdir($appDataCloudDir); }
if (file_exists($appDataCloudDir)) { 
  chown($appDataCloudDir, $ApacheUser);
  chgrp($appDataCloudDir, $ApacheGroup);
  chmod($appDataCloudDir, $CLPerms); }
@copy($InstLoc.'/index.html', $appDataCloudDir.'/index.html');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code creates a ClamLogFile if one does not exist.
while (file_exists($ClamLogDir)) {
  $ClamLogFileInc++;
  $ClamLogDir = $SesLogDir.'/VirusLog_'.$ClamLogFileInc.'_'.$Date.'.txt'; } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code reads the Admin configuration settings and sets temporary variables.
$AdminIDRAW = 1;
$AdminID = hash('ripemd160', $AdminIDRAW.$Salts);
$adminAppDataInstDir = $InstLoc.'/DATA/'.$AdminID.'/.AppData';
$AdminConfig = $adminAppDataInstDir.'/.config.php';
if (!file_exists($AdminConfig)) { 
  $txt = ('WARNING!!! HRC2CommonCore151, There was a problem loading the admin settings on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
if (file_exists($AdminConfig)) {
  include ($AdminConfig); }
$Nickname = '';
$AdminIDRAW = null;
$AdminID = null;
$adminAppDataInstDir = null;
$AdminConfig = null;  
unset ($AdminIDRAW, $AdminID, $adminAppDataInstDir, $AdminConfig);
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code loads the user config file if it exists and creates one if it does not.
if (!file_exists($UserConfig)) { 
  copy($LogInstallDir.'.config.php', $UserConfig); }
if (!file_exists($UserConfig)) { 
  $txt = ('ERROR!!! HRC2CommonCore151, There was a problem creating the user config file on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  die ($txt); }
if (file_exists($UserConfig)) {
  include ($UserConfig); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets the date and time for the session.
$Now = time();
$Timezone = str_replace(' ', '_', $Timezone);
date_default_timezone_set($Timezone);
$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the SesLogDir exists, and creates one if it does not.
// / Also creates the file strucutre needed for the sesLog to display content.
if (!file_exists($SesLogDir)) {
  mkdir($SesLogDir);
  @copy($InstLoc.'/index.html', $SesLogDir.'/index.html');
    foreach ($LogInstallFiles1 as $LIF1) {
      if (in_array($LIF1, $installedApps)) continue;
      if ($LIF1 == '.' or $LIF1 == '..') continue;
      @copy($InstLoc.'/'.$LogInstallDir1.$LIF1, $SesLogDir.'/'.$LIF1); } }
if (file_exists($SesLogDir)) { 
  chown($SesLogDir, $ApacheUser);
  chgrp($SesLogDir, $ApacheGroup);
  chmod($SesLogDir, $ILPerms); }
@copy($InstLoc.'/'.$LogInstallDir1.'.index.php', $SesLogDir.'/.index.php');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the Resources directory exists, and creates one if it does not.
if (!file_exists($ResourcesDir)) {
  mkdir($TempResourcesDir); 
  if (file_exists($ResourcesDir)) {
    $txt = ('OP-Act: Created a Resources Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($ResourcesDir)) {
    $txt = ('ERROR!!! HRC2CommonCore137, The Resources Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
if (file_exists($ResourcesDir)) { 
  chown($ResourcesDir, $ApacheUser);
  chgrp($ResourcesDir, $ApacheGroup);
  chmod($ResourcesDir, $ILPerms); }
@copy($InstLoc.'/index.html', $ResourcesDir.'/index.html');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the TempResources directory exists, and creates one if it does not.
if (!file_exists($TempResourcesDir)) {
  mkdir($TempResourcesDir); 
  if (file_exists($TempResourcesDir)) {
    $txt = ('OP-Act: Created a Temp Resources Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($TempResourcesDir)) {
    $txt = ('ERROR!!! HRC2CommonCore137, The Temp Resources Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
if (file_exists($TempResourcesDir)) { 
  chown($TempResourcesDir, $ApacheUser);
  chgrp($TempResourcesDir, $ApacheGroup);
  chmod($TempResourcesDir, $ILPerms); }
@copy($InstLoc.'/index.html', $TempResourcesDir.'/index.html');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the ClientInstallers directory exists, and creates one if it does not.
if (!file_exists($ClientInstallDir)) {
  mkdir($ClientInstallDir); 
  if (file_exists($ClientInstallDir)) {
    $txt = ('OP-Act: Created a Client Installer Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($ClientInstallDir)) {
    $txt = ('ERROR!!! HRC2CommonCore219, The Client Installer Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
if (file_exists($ClientInstallDir)) { 
  chown($ClientInstallDir, $ApacheUser);
  chgrp($ClientInstallDir, $ApacheGroup);
  chmod($ClientInstallDir, $ILPerms); }
@copy($InstLoc.'/index.html', $ClientInstallDir.'/index.html');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the Windows ClientInstallers directory exists, and creates one if it does not.
if (!file_exists($ClientInstallDirWin)) {
  mkdir($ClientInstallDirWin); 
  if (file_exists($ClientInstallDirWin)) {
    $txt = ('OP-Act: Created a Windows Client Installer Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($ClientInstallDirWin)) {
    $txt = ('ERROR!!! HRC2CommonCore230, The Client Windows Installer Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
if (file_exists($ClientInstallDirWin)) { 
  chown($ClientInstallDirWin, $ApacheUser);
  chgrp($ClientInstallDirWin, $ApacheGroup);
  chmod($ClientInstallDirWin, $ILPerms); }
@copy($InstLoc.'/index.html', $ClientInstallDirWin.'/index.html');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the Linux ClientInstallers directory exists, and creates one if it does not.
if (!file_exists($ClientInstallDirLin)) {
  mkdir($ClientInstallDirLin); 
  if (file_exists($ClientInstallDirLin)) {
    $txt = ('OP-Act: Created a Linux Client Installer Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($ClientInstallDirLin)) {
    $txt = ('ERROR!!! HRC2CommonCore241, The Client Linux Installer Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
if (file_exists($ClientInstallDirLin)) { 
  chown($ClientInstallDirLin, $ApacheUser);
  chgrp($ClientInstallDirLin, $ApacheGroup);
  chmod($ClientInstallDirLin, $ILPerms); }
@copy($InstLoc.'/index.html', $ClientInstallDirLin.'/index.html');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the OSX ClientInstallers directory exists, and creates one if it does not.
if (!file_exists($ClientInstallDirOsx)) {
  mkdir($ClientInstallDirOsx); 
  if (file_exists($ClientInstallDirOsx)) {
    $txt = ('OP-Act: Created a OSX Client Installer Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($ClientInstallDirOsx)) {
    $txt = ('ERROR!!! HRC2CommonCore230, The Client OSX Installer Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
if (file_exists($ClientInstallDirOsx)) { 
  chown($ClientInstallDirOsx, $ApacheUser);
  chgrp($ClientInstallDirOsx, $ApacheGroup);
  chmod($ClientInstallDirOsx, $ILPerms); }
@copy($InstLoc.'/index.html', $ClientInstallDirOsx.'/index.html');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the CloudUsrDir exists, and creates one if it does not.
if (!file_exists($CloudUsrDir)) {
  mkdir($CloudUsrDir); 
  if (file_exists($CloudUsrDir)) {
    $txt = ('OP-Act: Created a Cloud User Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($CloudUsrDir)) {
    $txt = ('ERROR!!! HRC2CommonCore137, The Cloud User Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
if (file_exists($CloudUsrDir)) { 
  chown($CloudUsrDir, $ApacheUser);
  chgrp($CloudUsrDir, $ApacheGroup);
  chmod($CloudUsrDir, $CLPerms); }
@copy($InstLoc.'/index.html', $CloudUsrDir.'index.html');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the CloudAppDir exists, and creates one if it does not.
if (!file_exists($CloudAppDir)) { 
  mkdir($CloudAppDir); 
  if (file_exists($CloudAppDir)) {
    $txt = ('OP-Act: Created a CloudLoc Apps Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($CloudAppDir)) {
    $txt = ('ERROR!!! HRC2CommonCore137, The CloudLoc Apps Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
if (file_exists($CloudAppDir)) { 
  chown($CloudAppDir, $ApacheUser);
  chgrp($CloudAppDir, $ApacheGroup);
  chmod($CloudAppDir, $ILPerms); }
@copy($InstLoc.'/index.html', $CloudAppDir.'/index.html');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will create a backup directory for restoration data.
  // / NO USER DATA IS STORED IN THE BACKUP DIRECTORY!!! Only server configuration data.
if (!file_exists($BackupDir)) {
  mkdir($BackupDir);
  if (file_exists($BackupDir)) {
    $txt = ('OP-Act: Created a Backup Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($BackupDir)) {
    $txt = ('ERROR!!! HRC2CommonCore137, The Backup Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
if (file_exists($BackupDir)) { 
  chown($BackupDir, $ApacheUser);
  chgrp($BackupDir, $ApacheGroup);
  chmod($BackupDir, $ILPerms); }
@copy($InstLoc.'/index.html', $BackupDir.'/index.html');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the CloudShareDir exists, and creates one if it does not.
if (!file_exists($CloudShareDir)) {
  mkdir($CloudShareDir); 
  @copy($InstLoc.'/index.html', $CloudShareDir.'/index.html');
    foreach ($SharedInstallFiles as $SIF) {
      if (in_array($SIF, $installedApps)) continue;
      if ($SIF == '.' or $SIF == '..' or is_dir($SIF)) continue;
      @copy($InstLoc.'/'.$SharedInstallDir.$SIF, $CloudShareDir.'/'.$SIF); } }
if (file_exists($CloudShareDir)) { 
  chown($CloudShareDir, $ApacheUser);
  chgrp($CloudShareDir, $ApacheGroup);
  chmod($CloudShareDir, $ILPerms); }
@copy($InstLoc.'/'.$SharedInstallDir.'.index.php', $CloudShareDir.'/.index.php');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the FavoritesCacheFile exists, and creates one if it does not.
if (!file_exists($FavoritesCacheFileCloud)) { 
  $data = '<?php $FavoriteFiles = array();';
  $txt = ('OP-Act: Created a Favorites cache file in the Cloud loc on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  $MAKEFavCacheFile = file_put_contents($FavoritesCacheFileCloud, $data.PHP_EOL, FILE_APPEND); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the FavoritesCacheFile exists, and creates one if it does not.
if (!file_exists($FavoritesCacheFileInst)) { 
  $data = '<?php $FavoriteFiles = array();';
  $txt = ('OP-Act: Created a Favorites cache file in the Inst loc on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  $MAKEFavCacheFile = file_put_contents($FavoritesCacheFileInst, $data.PHP_EOL, FILE_APPEND); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------        
// / The following code copies an index file to the Temp Cloud directory.
if (!file_exists($CloudTempDir.'/index.html')) {
  copy('index.html', $CloudTempDir.'/index.html'); }
if (!file_exists($CloudTmpDir.'/index.html')) {
  copy('index.html', $CloudTmpDir.'/index.html'); }  
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
          $txt = ('OP-Act: Cleaned '.$DFile.' on '.$Time.'.');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
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
  $txt = ('WARNING!!! HRC2CommonCore238, There was a problem creating the a sync\'d copy of the AppData 
   directory in the CloudLoc on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  echo nl2br($txt."\n".'Most likely the server\'s permissions are incorrect. 
   Make sure the www-data usergroup and user have R/W access to ALL folders in the /var/www/html directory. '); }
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
    else {
        if (!is_link($item) && !file_exists($ADCD)) {
          copy($item, $ADCD); } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sync's the users AppData between the CloudLoc and the InstLoc.
if (!file_exists($appDataInstDir)) {
  $txt = ('WARNING!!! HRC2CommonCore238, There was a problem creating the a sync\'d copy of the AppData 
   directory in the InstLoc on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  echo nl2br($txt."\n".'Most likely the server\'s permissions are incorrect. 
   Make sure the www-data usergroup and user have R/W access to ALL folders in the /var/www/html directory. '); }
foreach ($iterator = new \RecursiveIteratorIterator (
  new \RecursiveDirectoryIterator ($appDataCloudDir, \RecursiveDirectoryIterator::SKIP_DOTS),
  \RecursiveIteratorIterator::SELF_FIRST) as $item) {
  $ADID = $appDataInstDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName();
    if (is_dir($item)) {
      if (!is_dir($ADID)) {
        mkdir($ADID); 
        continue; } }
    else {
        if (!is_link($item) && !file_exists($ADID)) {
          copy($item, $ADID); } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if ShowTips is enabled and loads a random Tip if needed.
if (file_exists($TipFile) && $ShowTips == '1') {
  if ($ShowTips == '1') {
    include ($TipFile);
    $RandomTip = array_rand($Tips);
    $Tip = $Tips[$RandomTip];
    $Tips = null; 
    $RandomTip = null;
    unset($Tips, $RandomTip); } } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code determines the color scheme that the user has selected. 
// / May require a refresh to take effect.
if ($noStyles !== 1) {
  if ($ColorScheme == '0' or $ColorScheme == '' or !isset($ColorScheme)) {
    $ColorScheme = '1'; }
  if ($ColorScheme == '1') {
    echo ('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Styles/style.css">'); }
  if ($ColorScheme == '2') {
    echo ('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Styles/styleRED.css">'); }
  if ($ColorScheme == '3') {
    echo ('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Styles/styleGREEN.css">'); }
  if ($ColorScheme == '4') {
    echo ('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Styles/styleGREY.css">'); }
  if ($ColorScheme == '5') {
    echo ('<link rel="stylesheet" type="text/css" href="'.$URL.'/HRProprietary/HRCloud2/Styles/styleBLACK.css">'); } }
// / -----------------------------------------------------------------------------------
?>