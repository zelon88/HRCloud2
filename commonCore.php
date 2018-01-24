<?php
// / -----------------------------------------------------------------------------------
// / This file serves as the Common Core file which can be required by projects that need HRCloud2 to load it's config
// / file, authenticate user storage, and define variables for the session.
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets the $CD variable used to craft responsive absolute paths.
$CurrentDir = getcwd();
$CD = '';
if (strpos($CurrentDir, 'Applications') ==  TRUE) $CD = '../../';
if (strpos($_SERVER["SCRIPT_FILENAME"], 'HRAIMiniGui') == TRUE) $CD = '../';
if (strpos($CurrentDir, '.AppData') == TRUE) $CD = '../../../';
if (strpos($CurrentDir, 'Shared') == TRUE) $CD = '../../../../';
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------  
// / The following code checks if the config.php and the sanitizeCore.php files exist.
if (!file_exists($CD.'config.php')) {
  echo nl2br('ERROR!!! HRC2CommonCore17, Cannot process the HRCloud2 configuration file (config.php).'."\n"); 
  die (); }
else {
  require_once($CD.'config.php'); }
if (!file_exists($CD.'sanitizeCore.php')) {
  echo nl2br('ERROR!!! HRC2CommonCore9, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php).'."\n"); 
  die (); }
else {
  require_once($CD.'sanitizeCore.php'); }
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
// / The following code verifies that WordPress is installed.
$WPFile = $ServerRootDir.'/wp-load.php';
if (!file_exists($WPFile)) {
  $WPArch  = $InstLoc.'/Applications/wordpress.zip';
  echo nl2br('</head>Notice!!! HRC2CommonCore27, WordPress was not detected on the server. 
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
   And could not be installed.</body></html>'."\n"); }
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
$defaultApps = array('.', '..', '', 'HRAIMiniGui.php', 'jquery-3.1.0.min.js', 'index.html', 'HRAIMiniGui.php', 'HRAI', 'HRConvert2', 
  'HRStreamer', 'getid3', 'displaydirectorycontents_logs', 'displaydirectorycontents_logs1', 'style.css', 'Shared', 'ServMon.php', 'Favorites.php',  
  'displaydirectorycontents_72716', 'displaydirectorycontents_shared', 'wordpress.zip', 'Bookmarks', 'Calendar', 'Contacts', 'Notes', 'UberGallery');
$DangerousFiles = array('js', 'php', 'html', 'css');
$installedApps = array_diff($Apps, $defaultApps);
$tipsHeight = '0';
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
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
// / The following code cleans extra slashes from the UserDirPOST.
$UserDirPOST = str_replace('//', '/', str_replace('//', '/', $_POST['UserDirPOST']));
$CloudTmpDir = str_replace('//', '/', $CloudTempDir.$UserDirPOST); 
$CloudTmpDir = str_replace('//', '/', str_replace('//', '/', $CloudTmpDir)); 
$CloudTmpDir = str_replace('//', '/', str_replace('//', '/', $CloudTmpDir)); 
$CloudUsrDir = str_replace('//', '/', $CloudDir.$UserDirPOST); 
$CloudUsrDir = str_replace('//', '/', str_replace('//', '/', $CloudUsrDir)); 
$CloudUsrDir = str_replace('//', '/', str_replace('//', '/', $CloudUsrDir)); 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code creates required HRCloud2 files if they do not exist. Also installs user 
// / specific files and new index files as needed.
if (!is_dir($CloudLoc)) {
  $txt = ('ERROR!!! HRC2CommonCore59, There was an error verifying the CloudLoc as a valid directory. 
    Please check the config.php file and refresh the page.');
  die($txt); }
if (!file_exists($CloudDir) && strpos($CloudDir, '.zip') == 'false') {
  @mkdir($CloudDir, 0755); }
// / -----

// / The following code checks if the $CloudTemp directory ($CloudLoc.$userID) exists, and creates one if it does not.
if(!file_exists($CloudTemp)) {
  mkdir($CloudTemp); 
  if (file_exists($CloudDir)) {
    $txt = ('OP-Act: Created a Cloud Temp BaseDirectory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($CloudDir)) {
    $txt = ('ERROR!!! HRC2CommonCore137, The Cloud Temp BaseDirectory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
@copy($InstLoc.'/index.html', $CloudTemp.'index.html');
// / -----
// / The following code checks if the $CloudTemp directory ($InstLoc.'/DATA/'.$userID) exists, and creates one if it does not.
if (!file_exists($CloudTempDir)) { 
  mkdir($CloudTempDir, 0755); }
@copy($InstLoc.'/index.html', $CloudTempDir.'/index.html');
// / -----
// / The following code checks if the CloudTmpDir exists, and creates one if it does not.
if (!file_exists($CloudTmpDir)) { 
  mkdir($CloudTmpDir, 0755); }
@copy($InstLoc.'/index.html', $CloudTmpDir.'/index.html');
// / -----
// / The following code checks if the LogLoc exists, and creates one if it does not.
// / Also creates the file strucutre needed for the Logs to display content and store cache data.
if (!file_exists($LogLoc)) {
  $JICInstallLogs = @mkdir($LogLoc, 0755); 
  @copy($InstLoc.'/index.html',$LogLoc.'/index.html'); 
    foreach ($LogInstallFiles as $LIF) {
      if ($LIF == '.' or $LIF == '..' or $LIF == '.config.php') continue;
      @copy($InstLoc.'/'.$LogInstallDir.$LIF, $LogLoc.'/'.$LIF); } }
copy($InstLoc.'/'.$LogInstallDir.'.index.php', $LogLoc.'/.index.php');
// / -----
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
// / -----
// / The following code checks if the Resources directory exists, and creates one if it does not.
if (!file_exists($ResourcesDir)) {
  @mkdir($TempResourcesDir, 0755); 
  if (file_exists($ResourcesDir)) {
    $txt = ('OP-Act: Created a Resources Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($ResourcesDir)) {
    $txt = ('ERROR!!! HRC2CommonCore137, The Resources Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
@copy($InstLoc.'/index.html', $ResourcesDir.'/index.html');
// / -----
// / The following code checks if the TempResources directory exists, and creates one if it does not.
if (!file_exists($TempResourcesDir)) {
  @mkdir($TempResourcesDir, 0755); 
  if (file_exists($TempResourcesDir)) {
    $txt = ('OP-Act: Created a Temp Resources Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($TempResourcesDir)) {
    $txt = ('ERROR!!! HRC2CommonCore137, The Temp Resources Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
@copy($InstLoc.'/index.html', $TempResourcesDir.'/index.html');
// / -----
// / The following code checks if the ClientInstallers directory exists, and creates one if it does not.
if (!file_exists($ClientInstallDir)) {
  @mkdir($ClientInstallDir, 0755); 
  if (file_exists($ClientInstallDir)) {
    $txt = ('OP-Act: Created a Client Installer Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($ClientInstallDir)) {
    $txt = ('ERROR!!! HRC2CommonCore219, The Client Installer Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
@copy($InstLoc.'/index.html', $ClientInstallDir.'/index.html');
// / -----
// / The following code checks if the Windows ClientInstallers directory exists, and creates one if it does not.
if (!file_exists($ClientInstallDirWin)) {
  @mkdir($ClientInstallDirWin, 0755); 
  if (file_exists($ClientInstallDirWin)) {
    $txt = ('OP-Act: Created a Windows Client Installer Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($ClientInstallDirWin)) {
    $txt = ('ERROR!!! HRC2CommonCore230, The Client Windows Installer Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
@copy($InstLoc.'/index.html', $ClientInstallDirWin.'/index.html');
// / -----
// / The following code checks if the Linux ClientInstallers directory exists, and creates one if it does not.
if (!file_exists($ClientInstallDirLin)) {
  @mkdir($ClientInstallDirLin, 0755); 
  if (file_exists($ClientInstallDirLin)) {
    $txt = ('OP-Act: Created a Linux Client Installer Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($ClientInstallDirLin)) {
    $txt = ('ERROR!!! HRC2CommonCore241, The Client Linux Installer Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
@copy($InstLoc.'/index.html', $ClientInstallDirLin.'/index.html');
// / -----
// / The following code checks if the OSX ClientInstallers directory exists, and creates one if it does not.
if (!file_exists($ClientInstallDirOsx)) {
  @mkdir($ClientInstallDirOsx, 0755); 
  if (file_exists($ClientInstallDirOsx)) {
    $txt = ('OP-Act: Created a OSX Client Installer Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($ClientInstallDirOsx)) {
    $txt = ('ERROR!!! HRC2CommonCore230, The Client OSX Installer Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
@copy($InstLoc.'/index.html', $ClientInstallDirOsx.'/index.html');
// / -----
// / The following code checks if the CloudUsrDir exists, and creates one if it does not.
if (!file_exists($CloudUsrDir)) {
  @mkdir($CloudUsrDir, 0755); 
  if (file_exists($CloudUsrDir)) {
    $txt = ('OP-Act: Created a Cloud User Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($CloudUsrDir)) {
    $txt = ('ERROR!!! HRC2CommonCore137, The Cloud User Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
@copy($InstLoc.'/index.html', $CloudUsrDir.'index.html');
// / -----
// / The following code checks if the CloudAppDir exists, and creates one if it does not.
if (!file_exists($CloudAppDir)) { 
  @mkdir($CloudAppDir, 0755); 
  if (file_exists($CloudAppDir)) {
    $txt = ('OP-Act: Created a CloudLoc Apps Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($CloudAppDir)) {
    $txt = ('ERROR!!! HRC2CommonCore137, The CloudLoc Apps Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
@copy($InstLoc.'/index.html', $CloudAppDir.'/index.html');
// / -----
// / The following code will create a backup directory for restoration data.
  // / NO USER DATA IS STORED IN THE BACKUP DIRECTORY!!! Only server configuration data.
if (!file_exists($BackupDir)) {
  @mkdir($BackupDir, 0755);
  if (file_exists($BackupDir)) {
    $txt = ('OP-Act: Created a Backup Directory on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($BackupDir)) {
    $txt = ('ERROR!!! HRC2CommonCore137, The Backup Directory does not exist and could not be created on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
@copy($InstLoc.'/index.html', $BackupDir.'/index.html');
// / -----
// / The following code checks if the CloudShareDir exists, and creates one if it does not.
if (!file_exists($CloudShareDir)) {
  $JICInstallShared = @mkdir($CloudShareDir, 0755); 
  @copy($InstLoc.'/index.html', $CloudShareDir.'/index.html');
    foreach ($SharedInstallFiles as $SIF) {
      if (in_array($SIF, $installedApps)) continue;
      if ($SIF == '.' or $SIF == '..' or is_dir($SIF)) continue;
      @copy($InstLoc.'/'.$SharedInstallDir.$SIF, $CloudShareDir.'/'.$SIF); } }
@copy($InstLoc.'/'.$SharedInstallDir.'.index.php', $CloudShareDir.'/.index.php');
// / -----
// / The following code checks if the FavoritesCacheFile exists, and creates one if it does not.
if (!file_exists($FavoritesCacheFileCloud) or !file_exists($FavoritesCacheFileInst)) { 
  $data = '<?php $FavoriteFiles = array();';
  $txt = ('OP-Act: Created a Favorites cache file on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  $MAKEFavCacheFile = file_put_contents($FavoritesCacheFileCloud, $data.PHP_EOL, FILE_APPEND);
  copy ($FavoritesCacheFileCloud, $FavoritesCacheFileInst); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code creates a ClamLogFile if one does not exist.
while (file_exists($ClamLogDir)) {
  $ClamLogFileInc++;
  $ClamLogDir = $SesLogDir.'/VirusLog_'.$ClamLogFileInc.'_'.$Date.'.txt'; } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if ShowTips is enabled and loads a random Tip if needed.
if (!isset($ShowTips)) {
  $ShowTips = '1'; }
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
// / The following code loads the user config file if it exists and creates one if it does not.
if (!file_exists($UserConfig)) { 
  @chmod($UserConfig, 0755); 
  @chown($UserConfig, 'www-data'); } 
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

// / -----------------------------------------------------------------------------------
// / The following code reads the Admin configuration settings and sets temporary variables.
$AdminIDRAW = 1;
$AdminID = hash('ripemd160', $AdminIDRAW.$Salts);
$adminAppDataInstDir = $InstLoc.'/DATA/'.$AdminID.'/.AppData';
$AdminConfig = $adminAppDataInstDir.'/.config.php';
if (!file_exists($AdminConfig)) { 
  $txt = ('WARNING!!! HRC2CommonCore151, There was a problem loading the admin config file on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
if (file_exists($AdminConfig)) {
  include ($AdminConfig); }
$AV = $VirusScan;
$HP = $HighPerformanceAV;
$TH = $ThoroughAV; 
$PS = $PersistentAV;
include ($AdminConfig);
$AdminIDRAW = null;
$AdminID = null;
$adminAppDataInstDir = null;
$AdminConfig = null;  
unset ($AdminIDRAW, $AdminID, $adminAppDataInstDir, $AdminConfig);
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code resets the official time according to the Timezone entry in the user's config file.
if (!isset($Timezone) or $Timezone == '') $Timezone = $defaultTimezone;
$Now = time();
$Timezone = str_replace(' ', '_', $Timezone);
date_default_timezone_set($Timezone);
$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code re-sets some variables for security. Just-in-case the UserConfig is compromised.
$VirusScan = $AV;
$HighPerformanceAV = $HP;
$ThoroughAV = $TH;
$PersistentAV = $PS;
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sync's the users AppData between the CloudLoc and the InstLoc.
if (!file_exists($appDataCloudDir)) {
  @mkdir($appDataCloudDir); }
if (!file_exists($appDataCloudDir)) {
  $txt = ('WARNING!!! HRC2CommonCore238, There was a problem creating the a sync\'d copy of the AppData 
   directory in the CloudLoc on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  echo nl2br($txt."\n".'Most likely the server\'s permissions are incorrect. 
   Make sure the www-data usergroup and user have R/W access to ALL folders in the /var/www/html directory. '); }
foreach ($iterator = new \RecursiveIteratorIterator (
  new \RecursiveDirectoryIterator ($appDataInstDir, \RecursiveDirectoryIterator::SKIP_DOTS),
  \RecursiveIteratorIterator::SELF_FIRST) as $item) {
    @chmod($item, 0755);
    if ($item->isDir()) {
      if (!file_exists($appDataCloudDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName())) {
        mkdir($appDataCloudDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName()); } }
    else {
        if (!is_link($item) or !file_exists($appDataInstDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName())) {
          copy($item, $appDataInstDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName()); } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sync's the users AppData between the CloudLoc and the InstLoc.
foreach ($iterator = new \RecursiveIteratorIterator (
  new \RecursiveDirectoryIterator ($appDataCloudDir, \RecursiveDirectoryIterator::SKIP_DOTS),
  \RecursiveIteratorIterator::SELF_FIRST) as $item) {
    @chmod($item, 0755);
    if ($item->isDir()) {
      if (!file_exists($appDataInstDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName())) {
        mkdir($appDataInstDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName()); } }
    else {
        if (!is_link($item)) {
          copy($item, $appDataCloudDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName()); } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code represents the user directory handler.
if (isset($_POST['UserDir']) or isset($_POST['UserDirPOST'])) {
  if ($_POST['UserDir'] == '/' or $_POST['UserDirPOST'] == '/') { 
    $_POST['UserDir'] = '/'; 
    $_POST['UserDirPOST'] = '/'; } 
  $Udir = $_POST['UserDirPOST'].'/'; }
if (!isset($_POST['UserDir']) or !isset($_POST['UserDirPOST'])) { 
  $Udir = '/'; }
if (strpos($Udir, '//') == 'true') {
  $Udir = str_replace('//', '/', $Udir); }
if (strpos($Udir, '//') == 'true') {
  $Udir = str_replace('//', '/', $Udir); }
if (strpos($Udir, '//') == 'true') {
  $Udir = str_replace('//', '/', $Udir); }
if ($Udir == '//') {
  $Udir = '/'; }
if ($Udir == '//') {
  $Udir = '/'; }
if ($Udir == '//') {
  $Udir = '/'; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will clean up old files.
// / --- Code by theo546 ---
  // / Here is the fix for symlink date. --theo546 (source: http://stackoverflow.com/questions/34512105/php-check-how-old-a-symlink-file-is)
  function symlinkmtime($symlinkPath)
  {
      $stat = lstat($symlinkPath);
      return isset($stat['mtime']) ? $stat['mtime'] : null;
    }
// / ---
if (file_exists($CloudTempDir)) {
  $DFiles = glob($CloudTempDir.'/*');
  $now = time();
  foreach ($DFiles as $DFile) {
    if (in_array($DFile, $defaultApps)) continue;
    if ($DFile == ($CloudTempDir.'/.') or $DFile == ($CloudTempDir.'/..')) continue;
    if (($now - symlinkmtime($DFile)) >= 600) { // Time to keep files.
      if (is_file($DFile)) {
        @chmod ($DFile, 0755);
        unlink($DFile); 
        $txt = ('OP-Act: Cleaned '.$DFile.' on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
      if (is_dir($DFile)) {
        $CleanDir = $DFile;
        @chmod ($CleanDir, 0755);
        $CleanFiles = scandir($DFile);
        include($JanitorFile); 
        @unlink($DFile.'/index.html');
        @rmdir($DFile); } } } }
// / Copy a fresh index file to the Temp Cloud directory.        
if (!file_exists($CloudTempDir.'/index.html')) {
  copy('index.html', $CloudTempDir.'/index.html'); }
// / Display appropriate filesizes.
$bytes = sprintf('%u', filesize($DisplayFile));
if ($bytes > 0) {
  $unit = intval(log($bytes, 1024));
  $units = array('B', 'KB', 'MB', 'GB');
  if (array_key_exists($unit, $units) === true) { 
    $DisplayFileSize = sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]); } }
// / -----------------------------------------------------------------------------------
?>