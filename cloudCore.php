<?php
// / APPLICATION INFORMATION ...
// / HRCloud2, Copyright on 7/12/2016 by Justin Grimes, www.github.com/zelon88
// / 
// / LICENSE INFORMATION ...
// / This project is protected by the GNU GPLv3 Open-Source license.
// / 
// / APPLICATION DESCRIPTION ...
// / This project was started on 7/12/2016 by Justin Grimes. It aims to create
// / an open-source, personal Cloud platform that allows anyone to operate their
// / own personal general-purpose Cloud server from home. It was based on the 
// / knowledge and experience Justin acquired while operating the HonestRepair
// / Cloud Network from 2015 - 2016. This project shares very little with the
// / original HRCloud platform, and should be considered to be a ground-up
// / redesign of the original application.
// / 
// / HARDWARE REQUIREMENTS ... 
// / This application requires at least a Raspberry Pi Model B+ or greater.
// / This application will run on just about any x86 or x64 computer.
// / 
// / DEPENDENCY REQUIREMENTS ... 
// / This application requires Debian Linux (w/3rd Party audio license), 
// / Apache 2.4, PHP 7.0, MySQL, JScript, WordPress, LibreOffice, Unoconv, 
// / Python 2.7 and 3, ClamAV, Tesseract, Rar, Unrar, Unzip, 7zipper, FFMPEG,  
// / PyGames Rect, NumPy, setuptools for Python 2 and 3, Python-Pip, thetaexif,
// / OpenCV, Scikit, Scypy, and ImageMagick.

// / -----------------------------------------------------------------------------------

// / Before we begin we will sanitize API inputs.
if (isset($_GET['UserDirPOST'])) {
  $_GET['UserDirPOST'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['UserDirPOST']);
  $_POST['UserDirPOST'] = $_GET['UserDirPOST'];
  $_POST['UserDir'] = $_GET['UserDirPOST']; }
if (isset($_GET['UserDir'])) {
  $_GET['UserDirPOST'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['UserDir']);
  $_POST['UserDirPOST'] = $_GET['UserDir'];
  $_POST['UserDir'] = $_GET['UserDir']; }

set_time_limit(0);

// / The follwoing code checks if the configuration file.php file exists and 
// / terminates if it does not.
if (!file_exists('config.php')) {
  echo nl2br('ERROR!!! HRC235, Cannot process the HRCloud2 configuration file (config.php).'."\n"); 
  die (); }
else {
  require('config.php'); }

// / Verify that WordPress is installed.
$WPFile = '/var/www/html/wp-load.php';
if (!file_exists($WPFile)) {
  echo nl2br('ERROR!!! HRC243, WordPress was not detected on the server.'."\n"); }
  else {
    require($WPFile); } 

// / Set variables for the session.
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

// / The following code creates required HRCloud2 files if they do not exist. Also installs user 
// / specific files the first time a new user logs in.
if (!file_exists($CloudLoc)) {
  echo ('ERROR!!! HRC259, There was an error verifying the CloudLoc as a valid directory. 
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
if (!file_exists($LogLoc)) {
@mkdir($LogLoc);
copy($InstLoc.'/index.html',$LogLoc.'/index.html');
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

// / The following code sets a target directory within a users Cloud drive and prefixes 
// / any request files with the $_POST['UserDir']. Also used to create new UserDirs.
if (isset($_POST['UserDir'])) {
$UserDirPOST = ('/'.$_POST['UserDir'].'/'); }
if (!isset($_POST['UserDir'])) {
$UserDirPOST = ('/'); }
$CloudUsrDir = $CloudDir.$UserDirPOST; 
$CloudTmpDir = $CloudTempDir.$UserDirPOST; 
$AppDir = $InstLoc.'/DATA/'.$UserID.'/.Applications/';
$ContactsDir = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/Contacts/';
$NotesDir = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/Notes/';
$UserContacts = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.contacts.php';
$UserNotes = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.notes.php';
$UserConfig = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.config.php';
if (!file_exists($CloudUsrDir)) {
  mkdir($CloudUsrDir, 0755); }
if (!file_exists($CloudTmpDir)) { 
  mkdir($CloudTmpDir, 0755); }
copy($InstLoc.'/index.html',$CloudTmpDir.'/index.html');

// / Checks to see that the user is logged in.
if ($UserIDRAW == '') {
  echo nl2br('ERROR!!! HRC2100, You are not logged in!'."\n"); 
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }
if ($UserIDRAW == '0') {
  echo nl2br('ERROR!!! HRC2103, You are not logged in!'."\n");
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }
if (!isset($UserIDRAW)) {
  echo nl2br('ERROR!!! HRC2106, You are not logged in!'."\n");
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }

// / The following code checks if VirusScan is enabled and update ClamAV definitions accordingly.
if ($VirusScan == '1') {
  shell_exec('freshclam'); }

// / The following code verifies and cleans the config file.  	
if ($Accept_GPLv3_OpenSource_License !== '1') {
  $txt = ('ERROR!!! HRC2124, The user has not accepted the end-user license aggreement in config.php!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ('ERROR!!! HRC2124, You must read and completely fill out the config.php file located in your
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

// / The following code verifies that a user config file exists and creates one if it does not.
if (!file_exists($UserConfig)) { 
  $CacheData = ('$ColorScheme = \'0\'; $VirusScan = \'0\'; $ShowHRAI = \'1\';');
  $MAKECacheFile = file_put_contents($UserConfig, $CacheData.PHP_EOL , FILE_APPEND); 
  $txt = ('Created a user config file on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($UserConfig)) { 
  $txt = ('ERROR!!! HRC2151, There was a problem creating the user config file on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ('ERROR!!! HRC2151, There was a problem creating the user config file on '.$Time.'!'); }
if (file_exists($UserConfig)) {
require ($UserConfig); }

// / The following code ensures the Contacts directory exists and creates it if it does not. Also creates empty Contacts file.
if (!file_exists($UserContacts)) { 
  $ContactsData = ('<?php ?>');
  if (!file_exists($ContactsDir)) {
    mkdir($ContactsDir); }
  $MAKEContactsFile = file_put_contents($UserContacts, $ContactsData.PHP_EOL , FILE_APPEND); 
  $txt = ('Created a user contacts file on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($UserContacts)) { 
  $txt = ('ERROR!!! HRC2162, There was a problem creating the user contacts file on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ('ERROR!!! HRC2162, There was a problem creating the user contacts file on '.$Time.'!'); }
if (file_exists($UserContacts)) {
require ($UserContacts); }

// / The following code ensures the Notes directory exists and creates it if it does not.
if (!file_exists($NotesDir)) { 
  mkdir($NotesDir); }
if (!file_exists($NotesDir)) { 
  $txt = ('ERROR!!! HRC2186, There was a problem creating the user notes directory on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ('ERROR!!! HRC2186, There was a problem creating the user notes directory on '.$Time.'!'); } 

   // / The following code is performed when a user initiates a file upload.
if(isset($_POST["upload"])) {
  $txt = ('OP-Act: Initiated Uploader on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  $_POST["upload"] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST["upload"]);
  if (!is_array($_FILES["filesToUpload"])) {
    $_FILES["filesToUpload"] = array($_FILES["filesToUpload"]); }
  foreach ($_FILES['filesToUpload']['name'] as $key=>$file) {
    if ($file !== '.' or $file !== '..' or $file == 'index.html') {
      $file = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $file);      
      $_GET['UserDirPOST'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['UserDirPOST']);
      $file = str_replace(" ", "_", $file);
      $file = str_replace(str_split('\\/[]{};:$!#^&%@>*<'), '', $file);
      $DangerousFiles = array('js', 'php', 'html', 'css');
      $F0 = pathinfo($file, PATHINFO_EXTENSION);
      if (in_array($F0, $DangerousFiles)) { 
        $file = str_replace($F0, $F0.'SAFE', $file); }
      $F2 = pathinfo($file, PATHINFO_BASENAME);
      $F3 = $CloudUsrDir.$F2;
      // / The following code checks the Cloud Location with ClamAV before copying, just in case.
      if ($VirusScan == '1') {
        shell_exec('clamscan -r '.$_FILES['filesToUpload']['tmp_name'][$key].' | grep FOUND >> '.$ClamLogDir); 
      if (filesize($ClamLogDir > 1)) {
        echo nl2br('WARNING!!! HRC2155, There were potentially infected files detected. The file
          transfer could not be completed at this time. Please check your file for viruses or 
          try again later.'."\n");
          die(); } } 
      if($file == "") {
        $txt = ("ERROR!!! HRC2160, No file specified on $Time.");
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
        die("ERROR!!! HRC2160, No file specified on $Time."); }
      $txt = ('OP-Act: '."Uploaded $file to $CloudTmpDir on $Time".'.');
      echo nl2br ('OP-Act: '."Uploaded $file to on $Time".'.'.'.'."\n".'--------------------'."\n");
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
      $COPY_TEMP = copy($_FILES['filesToUpload']['tmp_name'][$key], $F3);
      chmod($F3,0755); } } } 

// / The following code is performed when a user downloads a selection of files.
if (isset($_POST["download"])) {
  $txt = ('OP-Act: Initiated Downloader on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  $_POST["download"] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST["download"]);
  if (!is_array($_POST['filesToDownload'])) {
    $_POST['filesToDownload'] = array($_POST['filesToDownload']); 
    $_POST['filesToDownload'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToDownload']); }
    foreach ($_POST['filesToDownload'] as $key=>$file) {
      $file = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $file);
      if ($file == '.' or $file == '..' or $file == 'index.html') continue;
      $file = $CloudUsrDir.$file;
      $F2 = pathinfo($file, PATHINFO_BASENAME);
      $F3 = $CloudTmpDir.$F2;
      $F4 = pathinfo($file, PATHINFO_FILENAME);
      $F5 = pathinfo($file, PATHINFO_EXTENSION);
      $txt = ('OP-Act: '."Submitted $file to $CloudTmpDir on $Time".'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
        if($file == "") {
          $txt = ("ERROR!!! HRC2187, No file specified on $Time".'.');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
          echo nl2br("ERROR!!! HRC2187, No file specified"."\n");
          die(); }
      if (!file_exists($F3)) { 
      $COPY_TEMP = copy($file, $F3); }
      if (is_dir($file)) { 
        mkdir($F3, 0755);
          foreach ($iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($file, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST) as $item) {
            if ($item->isDir()) {
              mkdir($F3 . DIRECTORY_SEPARATOR . $iterator->getSubPathName()); }   
            else {
    copy($item, $F3 . DIRECTORY_SEPARATOR . $iterator->getSubPathName()); } } } }
// / The following code checks the Cloud Temp Directory with ClamAV after copying, just in case.      
if ($VirusScan == '1') {
  shell_exec('clamscan -r '.$CloudTempDir.' | grep FOUND >> '.$ClamLogDir); 
if (filesize($ClamLogDir > 1)) {
  echo nl2br('WARNING!!! HRC2206, There were potentially infected files detected. The file
    transfer could not be completed at this time. Please check your file for viruses or
    try again later.'."\n");
    die(); } } } 

// / The following code is performed whenever a user selects a file to copy.
if (isset($_POST['copy'])) {
  $txt = ('OP-Act: Initiated Copier on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  $_POST['copy'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['copy']);
  if (!is_array($_POST['filesToCopy'])) {
    $_POST['newcopyfilename'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['newcopyfilename']);
    $_POST['filesToCopy'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToCopy']);
    $_POST['filesToCopy'] = array($_POST['filesToCopy']); }
    $copycount = 0;
  foreach ($_POST['filesToCopy'] as $key=>$CFile) { 
    $CFile = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $CFile);
    $newCopyFilename = $_POST['newcopyfilename'];
    $copycount++;
    if (isset($newCopyFilename)) {
      $cext = pathinfo($CloudUsrDir.$CFile, PATHINFO_EXTENSION);
      if ($copycount >= 2) {
        $newCopyFilename = $newCopyFilename.'_'.$copycount; }
      copy($CloudUsrDir.$CFile, $CloudUsrDir.$newCopyFilename.'.'.$cext);
        $txt = ('OP-Act: '."Copied $CFile to $newCopyFilename on $Time".'.');
        echo nl2br ($txt."\n".'--------------------'."\n");
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } }

// / The following code is performed whenever a user selects a file to rename.
if (isset($_POST['rename'])) {
  $txt = ('OP-Act: Initiated Renamer on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  $_POST['rename'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['rename']);
  if (!is_array($_POST['filesToRename'])) {
    $_POST['renamefilename'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['renamefilename']); 
    $_POST['filesToRename'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToRename']);
    $_POST['filesToRename'] = array($_POST['filesToRename']); }
    $rencount = 0;
  foreach ($_POST['filesToRename'] as $key=>$ReNFile) { 
    $ReNFile = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $ReNFile);
    $renameFilename = $_POST['renamefilename'];
    $rencount++;
    if (isset($renameFilename)) {
      $renext = pathinfo($CloudUsrDir.$ReNFile, PATHINFO_EXTENSION);
      if ($rencount >= 2) {
        $renameFilename = $renameFilename.'_'.$rencount; }
      rename($CloudUsrDir.$ReNFile, $CloudUsrDir.$renameFilename.'.'.$renext);
        $txt = ('OP-Act: '."Copied $ReNFile to $renameFilename on $Time".'.');
        echo nl2br ($txt."\n".'--------------------'."\n");
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } }

// / The following code is performed whenever a user selects a file to delete.
if (isset($_POST['deleteconfirm'])) {
  $txt = ('OP-Act: Initiated Deleter on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  $_POST['deleteconfirm'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['deleteconfirm']);
  if (!is_array($_POST['filesToDelete'])) {
    $_POST['filesToDelete'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToDelete']);
    $_POST['filesToDelete'] = array($_POST['filesToDelete']); }
  foreach ($_POST['filesToDelete'] as $key=>$DFile) { 
    $DFile = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $DFile);
    if (is_dir($CloudDir.$DFile)) {
      @rmdir($CloudDir.$DFile);
      @unlink($CloudDir.$DFile); 
      if (file_exists($CloudDir.$DFile)) {
        $txt = ('WARNING!!! HRC246, '."Cannot delete $CloudDir$DFile on $Time".'. Trying another method.');
        echo nl2br ($txt."\n".'--------------------'."\n");
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
      if (!file_exists($CloudDir.$DFile)) {
        $txt = ('OP-Act: '."Deleted $CloudDir$DFile on $Time".'.');
        echo nl2br ($txt."\n".'--------------------'."\n");
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }
    if (is_dir($CloudUsrDir.$DFile)) {
      @rmdir($CloudUsrDir.$DFile);
      @unlink($CloudUsrDir.$DFile);
      @rmdir($CloudTmpDir.$DFile);
      @unlink($CloudTmpDir.$DFile);
      $objects = scandir($CloudUsrDir.$DFile); 
      foreach ($objects as $object) { 
        if ($object == '.' or $object == '..') continue; 
          if (is_dir($CloudUsrDir.$DFile.'/'.$object)) {
             $objects2 = scandir($CloudUsrDir.$DFile.'/'.$object);
             foreach ($objects2 as $object2) { 
               if ($object2 == '.' or $object2 == '..') continue; 
                 if (!is_dir($CloudUsrDir.$DFile.'/'.$object.'/'.$object2)) {
                  @unlink($CloudUsrDir.$DFile.'/'.$object.'/'.$object2); }
                 if (is_dir($CloudUsrDir.$DFile.'/'.$object.'/'.$object2)) {
                  @rmdir($CloudUsrDir.$DFile.'/'.$object.'/'.$object2); } }
             @rmdir($CloudUsrDir.$DFile.'/'.$object); }
          if (!is_dir($CloudUsrDir.$DFile.'/'.$object)) {
            @unlink($CloudUsrDir.$DFile.'/'.$object); } } } 
    @unlink($CloudUsrDir.$DFile);
    @rmdir($CloudUsrDir.$DFile);
    if (file_exists($CloudTmpDir.$DFile)) {
      @unlink($CloudTmpDir.$DFile); 
      $txt = ('OP-Act: '."Deleted $DFile from $CloudTmpDir on $Time".'.');
      echo nl2br ('OP-Act: '."Deleted $DFile on $Time".'.'."\n".'--------------------'."\n");
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
    $txt = ('OP-Act: '."Deleted $DFile from $CloudUsrDir on $Time".'.');
    echo nl2br ('OP-Act: '."Deleted $DFile on $Time".'.'."\n".'--------------------'."\n");   
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }  

// / The following code is performed when a user selects files for archiving.
if (isset($_POST['archive'])) {
  $txt = ('OP-Act: Initiated Archiver on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  $_POST['archive'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['archive']);
  if (!is_array($_POST['filesToArchive'])) {
    $_POST['filesToArchive'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToArchive']);
    $_POST['filesToArchive'] = array($_POST['filesToArchive']); }
  foreach ($_POST['filesToArchive'] as $key=>$TFile1) {
$TFile1 = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $TFile1); 
$allowed =  array('mov', 'mp4', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'dat', 'cfg', 'txt', 'doc', 'docx', 'rtf', 'xls', 'xlsx', 'ods', 'odf', 'odt', 'jpg', 'mp3', 
   'avi', 'wma', 'wav', 'ogg', 'jpeg', 'bmp', 'png', 'gif', 'pdf', 'abw', 'zip', '7z', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
$docarray =  array('dat', 'pages', 'cfg', 'txt', 'doc', 'docx', 'rtf', 'odf', 'odt', 'abw');
$spreadarray = array('xls', 'xlsx', 'ods');
$imgarray = array('jpg', 'jpeg', 'bmp', 'png', 'gif');
$audioarray =  array('mp3', 'avi', 'wma', 'wav', 'ogg');
$pdfarray = array('pdf');
$gifarray = array('gif');
$abwarray = array('abw');
$archarray = array('zip', '7z', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
$rararr = array('rar');
$ziparr = array('zip');
$tararr = array('7z', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
$F1 = str_replace(str_split('\\/ '), '', $TFile1);
$filename = $CloudUsrDir.$F1;
$filename1 = pathinfo($filename, PATHINFO_BASENAME);
$ext = pathinfo($filename, PATHINFO_EXTENSION);
$_POST['archextension'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['archextension']);
$UserExt = $_POST['archextension'];
$_POST['userfilename'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['userfilename']);
$UserFileName = $_POST['userfilename'];
if(!in_array($ext, $allowed)) { 
  echo nl2br("ERROR!!! HRC2290, Unsupported File Format\n");
  die(); }
// / Check the Cloud Location with ClamAV before archiving, just in case.
if ($VirusScan == '1') {
  shell_exec('clamscan -r '.$CloudTempDir.' | grep FOUND >> '.$ClamLogDir); 
if (filesize($ClamLogDir > 1)) {
  echo nl2br('WARNING!!! HRC2296, There were potentially infected files detected. The file
    transfer could not be completed at this time. Please check your file for viruses or
    try again later.'."\n");
    die(); } }
// / Handle archiving of rar compatible files.
if(in_array($UserExt, $rararr)) {
  copy ($filename, $CloudTmpDir . $filename1); 
  $txt = ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt in $CloudTmpDir on $Time".'.');
  echo nl2br ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt on $Time".'.'."\n".'--------------------'."\n");  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  shell_exec('rar a -ep '.$CloudUsrDir.$UserFileName.'.rar '.$CloudUsrDir.$filename1); } 
// / Handle archiving of .zip compatible files.
if(in_array($UserExt, $ziparr)) {
  copy ($filename, $CloudTmpDir.$filename1); 
  $txt = ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt in $CloudTmpDir on $Time".'.');
  echo nl2br ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt on $Time".'.'."\n".'--------------------'."\n");  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  shell_exec('zip -j '.$CloudUsrDir.$UserFileName.'.zip '.$CloudUsrDir.$filename1); } 
// / Handle archiving of 7zipper compatible files.
if(in_array($UserExt, $tararr)) {
  copy ($filename, $CloudTmpDir.$filename1); 
  $txt = ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt in $CloudTmpDir on $Time".'.');
  echo nl2br ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt on $Time".'.'."\n".'--------------------'."\n");  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  shell_exec('7z a '.$CloudUsrDir.$UserFileName.'.'.$UserExt.' '.$CloudUsrDir.$filename1); } } }  

// / The following code will be performed when a user selects archives to extract.
if (isset($_POST["dearchive"])) {
  $txt = ('OP-Act: Initiated Dearchiver on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  $_POST['dearchive'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['dearchive']);
  if (isset($_POST["filesToDearchive"])) {
    if (!is_array($_POST["filesToDearchive"])) {
      $_POST['filesToDearchive'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToDearchive']);
      $_POST['filesToDearchive'] = array($_POST['filesToDearchive']); }
    foreach (($_POST['filesToDearchive']) as $File) {
      $File = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $File); 
      $allowed =  array('zip', '7z', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
      $archarray = array('zip', '7z', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
      $rararr = array('rar');
      $ziparr = array('zip');
      $tararr = array('7z', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
      $filename = str_replace(" ", "_", $File);
      $filename1 = pathinfo($CloudUsrDir.$filename, PATHINFO_BASENAME);
      $filename2 = pathinfo($CloudUsrDir.$filename, PATHINFO_FILENAME);
      $ext = pathinfo($CloudUsrDir.$filename, PATHINFO_EXTENSION);  
      // / Check the Cloud Location with ClamAV before archiving, just in case.
      if ($VirusScan == '1') {
        shell_exec('clamscan -r '.$CloudTempDir.' | grep FOUND >> '.$ClamLogDir); 
      if (filesize($ClamLogDir > 1)) {
        echo nl2br('WARNING HRC2338, There were potentially infected files detected. The file
          transfer could not be completed at this time. Please check your file for viruses or
          try again later.'."\n");
          die(); } }
      if (!file_exists($CloudTmpDir.$filename)) {
        copy($CloudUsrDir.$filename, $CloudTmpDir.$filename); }
      if (!file_exists($CloudUsrDir.$filename2.'_'.$Date)) {
        mkdir($CloudUsrDir.$filename2.'_'.$Date, 0755); }
      echo nl2br ('OP-Act: Dearchiving '.$_POST["filesToDearchive"].' to '.$filename2.'_'.$Date.' on '.$Time."\n".'--------------------'."\n"); 
      // / Handle dearchiving of rar compatible files.
      if(in_array($ext,$rararr)) {
        shell_exec('unrar e '.$CloudTmpDir.$filename.'.rar '.$CloudUsrDir.$filename2.'_'.$Date);
        $txt = ('OP-Act: '."Submitted $filename to $filename2_$Date$ in $CloudUsrDir on $Time".'.'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } 
      // / Handle dearchiving of .zip compatible files.
      if(in_array($ext,$ziparr)) {
        shell_exec('unzip '.$CloudTmpDir.$filename.' -d '.$CloudUsrDir.$filename2.'_'.$Date);
        $txt = ('OP-Act: '."Submitted $filename to $filename2_$Date in $CloudUsrDir on $Time".'.'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } 
      // / Handle dearchiving of 7zipper compatible files.
      if(in_array($ext,$tararr)) {
        shell_exec('7z e'.$CloudUsrDir.$filename2.'_'.$Date.'.'.$ext.' '.$CloudTmpDir.$filename1); 
        $txt = ('OP-Act: '."Submitted $filename to $filename2_$Date in $CloudUsrDir on $Time".'.'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } } 
    if (!file_exists($CloudUsrDir.$filename2.'_'.$Date))
      $txt = ('ERROR!!! HRC2449, There was a problem creating '.$CloudUsrDir.$filename2.'_'.$Date.' on '.$Time."\n".'--------------------'."\n"); 
      echo nl2br ('ERROR!!! HRC2449, There was a problem creating '.$filename2.'_'.$Date.' on '.$Time."\n".'--------------------'."\n"); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);     }
  
// / The following code is performed when a user selects files to convert to other formats.
if (isset( $_POST['convertSelected'])) {
  $txt = ('OP-Act: Initiated HRConvert2 on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  $_POST['convertSelected'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['convertSelected']);
    if (!is_array($_POST['convertSelected'])) {
      $_POST['convertSelected'] = array($_POST['convertSelected']); } 
  $convertcount = 0;
  foreach ($_POST['convertSelected'] as $key=>$file) {
    $file = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $file); 
    $txt = ('OP-Act: User '.$UserID.' selected to Convert file '.$file.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    $allowed =  array('mov', 'mp4', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'dat', 'cfg', 'txt', 'doc', 'docx', 'rtf' ,'xls', 'xlsx', 'ods', 'odf', 'odt', 'jpg', 'mp3', 
      'avi', 'wma', 'wav', 'ogg', 'jpeg', 'bmp', 'png', 'gif', 'pdf', 'abw', 'zip', '7z', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
    $file1 = $CloudUsrDir.$file;
    $file2 = $CloudTmpDir.$file;
    copy($file1, $file2); 
    if (file_exists($file2)) {
    $txt = ('OP-Act: '."Copied $file1 to $file2 on $Time".'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
    if (!file_exists($file2)) {
      $txt = ('ERROR!!! HRC2381, '."Could not copy $file1 to $file2 on $Time".'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
      echo nl2br('ERROR!!! HRC2381, There was a problem copying your file between internal HRCloud directories.
        Please rename your file or try again later.'."\n");
      die(); }
    $extension = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['extension']);
    $pathname = $CloudTmpDir.$file;
    $oldPathname = $CloudUsrDir.$file;
    $filename = pathinfo($pathname, PATHINFO_FILENAME);
    $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
    $newFile = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['userconvertfilename'].'_'.$convertcount.'.'.$extension);
    $newPathname = $CloudUsrDir.$newFile;
    $docarray =  array('txt', 'pages', 'doc', 'xls', 'xlsx', 'docx', 'rtf', 'odf', 'ods', 'odt', 'dat', 'cfg');
    $imgarray = array('jpg', 'jpeg', 'bmp', 'png', 'gif');
    $pdfarray = array('pdf');
    $abwarray = array('abw');
    $archarray = array('zip', '7z', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd',);
    $array7z = array('7z', 'zip', 'rar', 'iso', 'vhd');
    $array7zo = array('7z');
    $arrayzipo = array('zip');
    $array7zo2 = array('vhd', 'iso');
    $arraytaro = array('tar.gz', 'tar.bz2', 'tar');
    $arrayraro = array('rar',);
    $abwstd = array('doc', 'abw');
    $abwuno = array('docx', 'pdf', 'txt', 'rtf', 'odf', 'dat', 'cfg');
    $audioarray =  array('mp3', 'wma', 'wav', 'ogg');
    $stub = ('http://localhost/HRProprietary/HRClou2/DATA/');
    $newFileURL = $stub.$UserID.$UserDirPOST.$newFile;
    // / Code to increment the filename in the event that an output file already exists.    
    while(file_exists($newPathname)) {
      $convertcount++; 
      $newFile = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['userconvertfilename'].'_'.$convertcount.'.'.$extension);
      $newPathname = $CloudUsrDir.$newFile; }
    $convertcount++;
          // / Code to convert document files.
          // / Note: Some servers may experience a delay between the script finishing and the
            // / converted file being placed into their Cloud drive. If your files do not immediately
            // / appear, simply refresh the page.
          if (in_array($oldExtension,$docarray) ) {
            shell_exec ("unoconv -o $newPathname -f $extension $pathname");
            sleep (1); 
            // / For some reason files take a moment to appear after being created with Unoconv.
            $stopper = 0;
            while(!file_exists($newPathname)) {
              $stopper++;
              if ($stopper == 10) {
                die('ERROR!!! HRC2425, The converter timed out while copying your file.'); }
              sleep(2); } }
        
          // / Code to convert and manipulate image files.
          if (in_array($oldExtension,$imgarray) ) {
            $height = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['height']);
            $height = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['width']);
            // / Code to sanitize the $width and $height $_POST variables.
            if ((!is_numeric($width)) or (!is_numeric($height))) {
              $txt = ("ERROR!!! HRC2432, User specified a witdh or height that is not numeric on ".$Time.'.');
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
              die(); }
            $_POST["rotate"] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['rotate']);
            $rotate = ('-rotate '.$_POST["rotate"]);
            $wxh = $width.'x'.$height;
                if ($wxh === '0x0') {       
                  shell_exec ("convert -background none $pathname $rotate $newPathname"); } 
                elseif (($width or $height) != '0') {
                  shell_exec ("convert -background none -resize $wxh $rotate $pathname $newPathname"); } }

          // / Code to convert and manipulate audio, video, and multi-media files.
          if (in_array($oldExtension,$audioarray) ) { 
            $ext = (' -f ' . $extension);
              if (isset($_POST['bitrate'])) {
                $bitrate = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['bitrate']); }
              if (!isset($_POST['bitrate'])) {
                $bitrate = 'auto'; }                  
            if ($bitrate = 'auto' ) {
              $br = ' '; } 
            elseif ($bitrate != 'auto' ) {
              $br = (' -ab ' . $bitrate . ' '); } 
              $txt = ("OP-Act, Executing ffmpeg -i $pathname$ext$br$newPathname on ".$Time.'.');
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
            shell_exec ("ffmpeg -y -i $pathname$ext$br$newPathname"); } 

          // / Code to detect and extract an archive, and then re-archive the extracted
            // / files using a different method.
          if (in_array($oldExtension,$archarray) ) {
            $safedir1 = $CloudTmpDir;
            $safedirTEMP = $CloudTmpDir.$filename;
            $safedirTEMP2 = pathinfo($safedirTEMP, PATHINFO_EXTENSION);
            $safedirTEMP3 = $CloudTmpDir.pathinfo($safedirTEMP, PATHINFO_BASENAME);            
            $safedir2 = $CloudTmpDir.$safedirTEMP3;
            mkdir("$safedir2", 0755, true);
            chmod($safedir2, 0755);
            $safedir3 = ($safedir2.'.7z');
            $safedir4 = ($safedir2.'.zip');
          if(in_array($oldExtension, $arrayzipo) ) {
            shell_exec("unzip $pathname -d $safedir2"); } 
          if(in_array($oldExtension, $array7zo) ) {
            shell_exec("7z e $pathname -o$safedir2"); } 
          if(in_array($oldExtension, $array7zo2) ) {
            shell_exec("7z e $pathname -o$safedir2"); } 
          if(in_array($oldExtension, $arrayraro) ) {
            shell_exec("unrar e $pathname $safedir2"); } 
          if(in_array($oldExtension, $arraytaro) ) {
            shell_exec("7z e $pathname -o$safedir2"); } 
            if (in_array($extension,$array7zo) ) {
              shell_exec("7z a -t$extension $safedir3 $safedir2");
              copy($safedir3, $newPathname); } 
            if (file_exists($safedir3) ) {
              chmod($safedir3, 0755); 
              unlink($safedir3);
              $delFiles = glob($safedir2 . '/*');
               foreach($delFiles as $delFile) {
                if(is_file($delFile) ) {
                  chmod($delFile, 0755);  
                  unlink($delFile); }
                elseif(is_dir($delFile) ) {
                  chmod($delFile, 0755);
                  rmdir($delFile); } }    
                  rmdir($safedir2); }
            elseif (in_array($extension,$arrayzipo) ) {
              shell_exec("zip -r $safedir4 $safedir2");
              copy($safedir4, $newPathname); } 
              if (file_exists($safedir4) ) {
                chmod($safedir4, 0755); 
                unlink($safedir4);
                $delFiles = glob($safedir2 . '/*');
                  foreach($delFiles as $delFile){
                    if(is_file($delFile) ) {
                      chmod($delFile, 0755);  
                      unlink($delFile); }
                    elseif(is_dir($delFile) ) {
                      chmod($delFile, 0755);
                      rmdir($delFile); } }    
                      rmdir($safedir2); }
                    elseif (in_array($extension, $arraytaro) ) {
                      shell_exec ("tar czf $newPathname $safedir2");
                      $delFiles = glob($safedir2 . '/*');
                    foreach($delFiles as $delFile){
                      if(is_file($delFile) ) {
                        chmod($delFile, 0755);  
                        unlink($delFile); }
                      elseif(is_dir($delFile) ) {
                        chmod($delFile, 0755);
                        rmdir($delFile); } }     
                        rmdir($safedir2); } 
                      elseif(in_array($extension, $arrayraro) ) {
                        shell_exec("rar a -ep".$newPathname.' '.$safedir2);
                        $delFiles = glob($safedir2 . '/*');
                          foreach($delFiles as $delFile){
                            if(is_file($delFile) ) {
                              chmod($delFile, 0755);  
                              unlink($delFile); }
                            elseif(is_dir($delFile) ) {
                              chmod($delFile, 0755);
                              rmdir($delFile); } } 
                              rmdir($safedir2); } }

// / Error handler and logger for converting files.
if (!file_exists($newPathname)) {
  echo nl2br('ERROR!!! HRC2524, There was an error during the file conversion process and your file was not copied.'."\n");
  $txt = ('ERROR!!! HRC2524, '."Conversion failed! $newPathname could not be created from $oldPathname".'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  die(); } 
if (file_exists($newPathname)) {
  $txt = ('OP-Act: File '.$newPathname.' was created on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } }

// / The following code is performed whenever a user selects a document or PDF for manipulation.
if (isset($_POST['pdfworkSelected'])) {
  $_POST['pdfworkSelected'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['pdfworkSelected']);
  $txt = ('OP-Act: Initiated PDFWork on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    if (!is_array($_POST['pdfworkSelected'])) {
      $_POST['pdfworkSelected'] = array($_POST['pdfworkSelected']); } 
  $pdfworkcount = '0';
  foreach ($_POST['pdfworkSelected'] as $key=>$file) {
    $file = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $file['pdfworkSelected']);
    $txt = ('OP-Act: User '.$UserID.' selected to PDFWork file '.$file.' on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    $allowedPDFw =  array('txt', 'doc', 'docx', 'rtf' ,'xls', 'xlsx', 'ods', 'odf', 'odt', 'jpg', 'jpeg', 'bmp', 'png', 'gif', 'pdf', 'abw');
    $file1 = $CloudUsrDir.$file;
    $file2 = $CloudTmpDir.$file;
    copy($file1, $file2); 
    if (file_exists($file2)) {
      $txt = ('OP-Act: '."Copied $file1 to $file2 on $Time".'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
    if (!file_exists($file2)) {
      $txt = ('ERROR!!! HRC2551, '."Could not copy $file1 to $file2 on $Time".'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
      echo nl2br('ERROR!!! HRC2551, There was a problem copying your file between internal HRCloud directories.
        Please rename your file or try again later.'."\n");
      die(); }
    // / If no output format is selected the default of PDF is used instead.
    if (isset($_POST['pdfextension'])) {
      $extension = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['pdfextension']); } 
    if (!isset($_POST['pdfextension'])) {
      $extension = 'pdf'; }
    $pathname = $CloudTmpDir.$file; 
    $oldPathname = $CloudUsrDir.$file;
    $filename = pathinfo($pathname, PATHINFO_FILENAME);
    $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
    $newFile = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['userpdfconvertfilename'].'_'.$pdfworkcount.'.'.$extension);
    $newPathname = $CloudUsrDir.$newFile;
    $doc1array =  array('txt', 'pages', 'doc', 'xls', 'xlsx', 'docx', 'rtf', 'odf', 'ods', 'odt');
    $img1array = array('jpg', 'jpeg', 'bmp', 'png', 'gif');
    $pdf1array = array('pdf');
    $stub = ($URL.'/HRProprietary/HRCloud2/DATA/');
    $newFileURL = $stub.$UserID.$UserDirPOST.$newFile;
      if (in_array($oldExtension, $allowedPDFw)) {
        while(file_exists($newPathname)) {
          $pdfworkcount++; 
          $newFile = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['userpdfconvertfilename'].'_'.$pdfworkcount.'.'.$extension);
          $newPathname = $CloudUsrDir.$newFile; } } 

          // / Code to convert a PDF to a document.
          if (in_array($oldExtension, $pdf1array)) {
            if (in_array($extension, $doc1array)) {
              $pathnameTEMP = str_replace('.'.$oldExtension, '.txt', $pathname);
    
            $_POST['method'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['method']);
              if (($_POST['method1'] == '0')) {
                shell_exec ("pdftotext -layout $pathname $pathnameTEMP"); 
                $txt = ('OP-Act: '."Converted $pathnameTEMP1 to $pathname on $Time".' using method 0.'); 
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
                if ((!file_exists($pathnameTEMP) or filesize($pathnameTEMP) < '5')) { 
                  $txt = ('Warning!!! HRC2591, There was a problem using the selected method to convert your file. Switching to 
                    automatic method and retrying the conversion.'."\n"); 
                  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
                  echo nl2br('Warning!!! HRC2591, There was a problem using the selected method to convert your file. Switching to 
                    automatic method and retrying the conversion on '.$Time.'.'."\n");
                  $_POST['method1'] = '1'; 
                  $txt = ('Notice!!! HRC2601, Attempting PDFWork conversion "method 2" on '.$Time.'.'."\n"); 
                  echo ($txt."\n".'--------------------'."\n"); 
                  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }          
              
              if ($_POST['method1'] == '1') {
                $pathnameTEMP1 = str_replace('.'.$oldExtension, '.jpg' , $pathname);
                shell_exec ("convert $pathname $pathnameTEMP1");
                if (!file_exists($pathnameTEMP1)) {
                  $PagedFilesArrRAW = scandir($CloudTmpDir);
                  foreach ($PagedFilesArrRAW as $PagedFile) {
                    $pathnameTEMP1 = str_replace('.'.$oldExtension, '.jpg' , $pathname);
                    if ($PagedFile == '.' or $PagedFile == '..' or $PagedFile == '.AppLogs' or $PagedFile == 'index.html') continue;
                    if (strpos($PagedFile, '.txt') !== false) continue;
                    if (strpos($PagedFile, '.pdf') !== false) continue;
                    $CleanFilname = str_replace($oldExtension, '', $filename);
                    $CleanPathnamePages = str_replace('.jpg', '', $PagedFile);
                    $CleanPathnamePages = str_replace('.txt', '', $CleanPathnamePages);
                    $CleanPathnamePages = str_replace('.pdf', '', $CleanPathnamePages);
                    $CleanPathnamePages = str_replace($CleanFilname, '', $CleanPathnamePages);                    
                    $CleanPathnamePages = str_replace('-', '', $CleanPathnamePages);
                    $PageNumber = $CleanPathnamePages;
                    if (is_numeric($PageNumber)) {
                      $pathnameTEMP1 = str_replace('.jpg', '-'.$PageNumber.'.jpg', $pathnameTEMP1);
                      $pathnameTEMP = str_replace('.'.$oldExtension, '-'.$PageNumber.'.txt', $pathname); 
                      $pathnameTEMPTesseract = str_replace('.'.$oldExtension, '-'.$PageNumber, $pathname); 
                      $pathnameTEMP0 = str_replace('-'.$PageNumber.'.txt', '.txt', $pathnameTEMP); 
                      echo nl2br("\n".$pathnameTEMP."\n");
                      shell_exec ("tesseract $pathnameTEMP1 $pathnameTEMPTesseract");
                      $READPAGEDATA = file_get_contents($pathnameTEMP);
                      $WRITEDOCUMENT = file_put_contents($pathnameTEMP0, $READPAGEDATA.PHP_EOL , FILE_APPEND);
                      $multiple = '1'; 
                      $txt = ('OP-Act: '."Converted $pathnameTEMP1 to $pathnameTEMP on $Time".' using method 1.'); 
                      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
                      $pathnameTEMP = $pathnameTEMP0;
                      if (!file_exists($pathnameTEMP0)) {
                        $txt = ('ERROR!!! HRC2617, HRC2610, $pathnameTEMP0 does not exist on '.$Time.'.'."\n"); 
                        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);   
                        echo ($txt."\n".'--------------------'."\n"); } } } }
                    if ($multiple !== '1') {
                    $pathnameTEMPTesseract = str_replace('.'.$txt, '', $pathnameTEMP);
                    shell_exec ("tesseract $pathnameTEMP1 $pathnameTEMPTesseract");
                    $txt = ('OP-Act: '."Converted $pathnameTEMP1 to $pathnameTEMP on $Time".' using method 1.'); 
                    echo ($txt."\n".'--------------------'."\n");    
                    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } } } 
                
            // / Code to convert a document to a PDF.
            if (in_array($oldExtension, $doc1array)) {                
              if (in_array($extension, $pdf1array)) {
                shell_exec ("unoconv -o $newPathname -f pdf $pathname"); 
                $txt = ('OP-Act: '."Converted $pathname to $newPathname on $Time".' using method 2.'); 
                echo ('OP-Act: '."Performed PDFWork on $Time".' using method 2.'."\n".'--------------------'."\n"); 
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } 

          // / Code to convert an image to a PDF.
          if (in_array($oldExtension, $img1array)) {
            $pathnameTEMP = str_replace('.'.$oldExtension, '.txt' , $pathname);
            $pathnameTEMPTesseract = str_replace('.'.$oldExtension, '', $pathname);
            $imgmethod = '1';
            shell_exec ("tesseract $pathname $pathnameTEMPTesseract"); 
            if (!file_exists($pathnameTEMP)) {
              $imgmethod = '2';
              $pathnameTEMP3 = str_replace('.'.$oldExtension, '.pdf' , $pathname);
              shell_exec ("unoconv -o $pathnameTEMP3 -f pdf $pathname");
              shell_exec ("pdftotext -layout $pathnameTEMP3 $pathnameTEMP"); } 
            if (file_exists($pathnameTEMP)) {
              $txt = ('OP-Act: '."Converted $pathname to $pathnameTEMP1 on $Time".' using method '.$imgmethod.'.'); 
              echo ('OP-Act: '."Performed PDFWork on $Time".' using method '.$imgmethod.'.'."\n".'--------------------'."\n");
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } 
            if (!file_exists($pathnameTEMP)) {
              $txt = ('ERROR!!! HRC2667, '."An internal error occured converting $pathname to $pathnameTEMP1 on $Time".' using method '.$imgmethod.'.'); 
              echo ('ERROR!!! HRC2667, '."An internal error occured converting your file on $Time".' using method '.$imgmethod.'.'."\n".'--------------------'."\n");
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }

          // / If the output file is a txt file we leave it as-is.
        if (!file_exists($newPathname)) {                    
          if ($extension == 'txt') { 
            if (file_exists($pathnameTEMP)) {
              rename ($pathnameTEMP, $newPathname); 
              $txt = ('OP-Act: HRC2613, '."Renamed $pathnameTEMP to $pathname on $Time".'.'); 
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }

          // / If the output file is not a txt file we convert it with Unoconv.
          if ($extension !== 'txt') {
            shell_exec ("unoconv -o $newPathname -f $extension $pathnameTEMP");
            $txt = ('OP-Act: '."Converted $pathnameTEMP to $newPathname on $Time".'.'); 
            echo nl2br ('OP-Act: '."Performing finishing touches on $Time".'.');
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }

        // / Error handler for if the output file does not exist.
        if (!file_exists($newPathname)) {
          echo nl2br('ERROR!!! HRC2620, There was a problem converting your file! Please rename your file or try again later.'."\n".'--------------------'."\n"); 
          $txt = ('ERROR!!! HRC2620, '."Could not convert $pathname to $newPathname on $Time".'!'); 
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
          die(); } } } // / BROKEN BRACKETS SOMEWHERE IN FILE BEFORE THIS POINT 9/3/16.

// / The following code will be performed when a user selects files to stream. (for you, Emily...)
if (isset($_POST['streamSelected'])) {
  // / Define the and sanitize global .Playlist environment variables.
  $getID3File = $InstLoc.'/Applications/getID3-1.9.12/getid3/getid3.php';
  $PlaylistName = str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['playlistname']));
  $PLVideoArr =  array('avi', 'mov', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp');    
  $PLVideoArr2 =  array('avi', 'mov', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'mp4');    
  $PLMediaArr =  array('mp2', 'mp3', 'wma', 'wav', 'aac', 'flac', 'ogg', 'avi', 'mov', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'mp4');
  $PLAudioArr =  array('mp2', 'mp3', 'wma', 'wav', 'aac', 'flac');
  $PLAudioOGGArr =  array('ogg');
  $PLAudioMP4Arr =  array('mp4');
  $MediaFileCount = 0;
  $VideoFileCount = 0;
  // / Define temp .Playlist environment variables.
  $PlaylistDir = $CloudTempDir.'/'.$PlaylistName.'.Playlist';
  $PlaylistCacheDir = $PlaylistDir.'/.Cache';
  $PlaylistCacheFile = $PlaylistCacheDir.'/cache.xml';
  $PlaylistCacheFile2 = $PlaylistCacheDir.'/cache.php';
  // / Define permanent .Playlist environment variables.
  $playlistDir = $CloudUsrDir.$PlaylistName.'.Playlist'; 
  $playlistCacheDir = $playlistDir.'/.Cache';
  $playlistCacheFile = $playlistCacheDir.'/cache.xml';
  $playlistCacheFile2 = $playlistCacheDir.'/cache.php'; 
  // / Write the first Playlist entry to the user's logfile.
  $txt = ('OP-Act: Initiated .Playlist creation on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);  
  require($getID3File);

  // / The following code creates the .Playlist directory as well as the .Cache directory and cache files.
  if (!file_exists($PlaylistCacheFile)) {
    @mkdir($PlaylistDir, 0755);
    @mkdir($playlistDir, 0755);
    copy($InstLoc.'/index.html', $PlaylistDir.'/index.html');
    copy($InstLoc.'/index.html', $playlistDir.'/index.html');
    @mkdir($PlaylistCacheDir, 0755); 
    @mkdir($playlistCacheDir, 0755); 
    copy($InstLoc.'/index.html', $PlaylistCacheDir.'/index.html');
    copy($InstLoc.'/index.html', $playlistCacheDir.'/index.html');
    $txt = ('OP-Act: Created a playlist cache file on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  if (strpos($PlaylistCacheDir, '.Playlist') == 'false') {
    $txt = ('ERROR!!! HRC2746, There was a problem verifying the '.$PlaylistDir.' on '.$Time.'!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    die($txt); }
  
  // / The following code detects which types of files are selected and creates the cache and playlist environment, including directories and cache files.
  // / We also generate a playlist.xml file for osmplayer. We don't wind up using this, but the core functionality is here for compatibility purposes.
  $txt = ('<?xml version="1.0" encoding="UTF-8"?> <playlist version="1" xmlns="'.$URL.'/HRProprietary/HRCloud2/Applications/osmplayer">');
  $MAKEPLCacheFile = file_put_contents($PlaylistCacheFile, $txt.PHP_EOL , FILE_APPEND);
  $MAKEplCacheFile = file_put_contents($playlistCacheFile, $txt.PHP_EOL , FILE_APPEND);
  if (!is_array($_POST['streamSelected'])) {
    $_POST['streamSelected'] = array($_POST['streamSelected']); } 
  foreach (($_POST['streamSelected']) as $MediaFile) {
    // / The following code will only create cache data if the $MediaFile is in the $PLMediaArr.     
        $pathname = $CloudUsrDir.$MediaFile;
        $Scanfilename = pathinfo($pathname, PATHINFO_FILENAME);
        $ScanoldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
        $txt = ('OP-Act: Detected a '.$ScanoldExtension.' named '.$MediaFile.' on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);

        if(in_array($ScanoldExtension, $PLMediaArr)) {
          $MediaFileCount++; 
          $getID3 = new getID3;
          $id3Tags = $getID3->analyze($pathname);
          getid3_lib::CopyTagsToComments($pathname);
          // / If id3v2 title tags are set, return them as a variable.
          if(isset($id3Tags['tags']['id3v2']['title'])) {
            $PLSongTitle = $id3Tags['tags']['id3v2']['title'][0]; 
            $PLSongTitle = str_replace(str_split('\\/[]{};:>#*\'<'), '', ($PLSongTitle)); }
          if(!isset($id3Tags['tags']['id3v2']['title'])) {
            $PLSongTitle = ''; }
          // / If id3v2 artist tags are set, return them as a variable.
          if(isset($id3Tags['tags']['id3v2']['artist'])) {
            $PLSongArtist = $id3Tags['tags']['id3v2']['artist'][0]; 
            $PLSongArtist = str_replace(str_split('\\/[]{};:>$#*\'<'), '', ($PLSongArtist)); }
          if(!isset($id3Tags['tags']['id3v2']['artist'])) {
            $PLSongArtist = ''; }
          // / If id3v2 album tags are set, return them as a variable.
          if(isset($id3Tags['tags']['id3v2']['album'])) {
            $PLSongAlbum = $id3Tags['tags']['id3v2']['album'][0]; 
            $PLSongAlbum = str_replace(str_split('\\/[]{};:>#*\'<'), '', ($PLSongAlbum)); }
          if(!isset($id3Tags['tags']['id3v2']['album'])) {
            $PLSongAlbum = ''; }
          // / If id3v2 image tags are set, return it as an image data variable as well as a .jpg file in the .Cache directory..
          if(isset($id3Tags['comments']['picture'][0])) {
            $PLSongImage = 'data:'.$id3Tags['comments']['picture'][0]['image_mime'].';charset=utf-8;base64,'.base64_encode($id3Tags['comments']['picture'][0]['data']); } 
            $PLSongImageDATA = $id3Tags['comments']['picture']['0']['data'];
            $SongImageFile = $CloudUsrDir.$PlaylistName.'.Playlist/.Cache/'.$MediaFileCount.'.jpg';
            $SongImageFileRAW = $CloudUsrDir.$PlaylistName.'.Playlist/.Cache/'.$MediaFileCount.'.txt';
            $SongImageFile2 = $CloudTempDir.$PlaylistName.'.Playlist/.Cache/'.$MediaFileCount.'.jpg';
            $SongImageFile2RAW = $CloudTempDir.$PlaylistName.'.Playlist/.Cache/'.$MediaFileCount.'.txt';
            $MAKECacheImageFile = file_put_contents($PLSongImageDATA, $SongImageFile);
            $MAKECacheImageFileRAW = file_put_contents($PLSongImageDATA, $SongImageFileRAW);
            $MAKECacheImageFile2 = file_put_contents($PLSongImageDATA, $SongImageFile2);  
            $MAKECacheImageFile2RAW = file_put_contents($PLSongImageDATA, $SongImageFile2RAW);                   
          if(!isset($id3Tags['comments']['picture'][0])) {
            $PLSongImage = ''; }
            // / If the audio count is one, this code will open tags within our XML cache file for the tracklist.
            if ($MediaFileCount == 1) {
              $txt = ('<tracklist>');
              $MAKEPLCacheFile = file_put_contents($PlaylistCacheFile, $txt.PHP_EOL , FILE_APPEND);  
              $MAKEplCacheFile = file_put_contents($playlistCacheFile, $txt.PHP_EOL , FILE_APPEND); }
            // / If the audio count is greater than 0, this code will save the id3 information for the song in the PHP cache file and write the track scr information to the XML cache file..
            if ($MediaFileCount > 0) {  
              // / Write XML cachefile data.
              if (isset($SongImageFile2)) {  
                if (file_exists($InstLoc.'/HRProprietary/HRCloud2/DATA/'.$UserID.'/'.$PlaylistName.'.Playlist/.Cache/'.$MediaFileCount.'.jpg')) {
                  $ImageTags = '<image>'.$URL.'/HRProprietary/HRCloud2/DATA/'.$UserID.'/'.$PlaylistName.'.Playlist/.Cache/'.$MediaFileCount.'.jpg</image>'; } }
              if (!isset($SongImageFile2)) {  
                $ImageTags = ''; }
              if (!file_exists($InstLoc.'/HRProprietary/HRCloud2/DATA/'.$UserID.'/'.$PlaylistName.'.Playlist/.Cache/'.$MediaFileCount.'.jpg')) {
                $ImageTags = ''; }
              $txt = ('<track><title>'.$MediaFile.'</title><location>'.$URL.'/HRProprietary/HRCloud2/DATA/'.$UserID.'/'.$PlaylistName.'.Playlist/'.$MediaFile.'</location>'.$ImageTags.'</track>');
              $MAKEPLCacheFile = file_put_contents($PlaylistCacheFile, $txt.PHP_EOL , FILE_APPEND);  
              $MAKEplCacheFile = file_put_contents($playlistCacheFile, $txt.PHP_EOL , FILE_APPEND);
              // / Write PHP cachefile data.
              $txt = ('<?php $MediaFileCount'.$MediaFileCount.' = \''.$MediaFileCount.'\'; $MediaFileName'.$MediaFileCount.' = \''.$MediaFile.'\'; $PLSongTitle'.$MediaFileCount.' = \''.$PLSongTitle.'\'; $PLSongArtist'.$MediaFileCount.' = \''.$PLSongArtist.'\'; $PLSongAlbum'.$MediaFileCount.' = \''.$PLSongAlbum.'\'; $PLSongImage'.$MediaFileCount.' = \''.$PLSongImage.'\';?>');
              $MAKEPLCacheFile2 = file_put_contents($PlaylistCacheFile2, $txt.PHP_EOL , FILE_APPEND);  
              $MAKEplCacheFile2 = file_put_contents($playlistCacheFile2, $txt.PHP_EOL , FILE_APPEND); } } }
          // / The following code will write the closing tags to the XML file in the event that there were audio files detected.
          if ($MediaFileCount >= 1) {  
            // / Write XML cachefile data.
            $txt = ('</tracklist></playlist>');
            $MAKEPLCacheFile = file_put_contents($PlaylistCacheFile, $txt.PHP_EOL , FILE_APPEND);  
            $MAKEplCacheFile = file_put_contents($playlistCacheFile, $txt.PHP_EOL , FILE_APPEND); }

  // / The following code converts the selected media files to device friendly formats and places them into the playlist directory.
  foreach (($_POST['streamSelected']) as $StreamFile) {
    $txt = ('OP-Act: Initiated Streamer on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    $pathname = $CloudTempDir.'/'.$StreamFile;
    $oldPathname = $CloudUsrDir.$StreamFile;
    copy ($oldPathname, $pathname);
    if ($StreamFile == '.' or $StreamFile == '..' or is_dir($pathname) or is_dir($oldPathname)) continue;
      $txt = ('OP-Act: User '.$UserID.' selected to StreamFile '.$StreamFile.' from CLOUD.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
      $filename = pathinfo($pathname, PATHINFO_FILENAME);
      $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
        if (in_array($oldExtension, $PLAudioArr)) {
          $ext = (' -f ' . 'ogg');
          $bitrate = 'auto';                 
          if ($bitrate = 'auto' ) {
            $br = ' '; } 
          elseif ($bitrate != 'auto' ) {
            $br = (' -ab ' . $bitrate . ' '); }
          $pathname = $CloudUsrDir.$StreamFile;
          $newPathname = $playlistDir.'/'.$filename.'.ogg';
          $txt = ("OP-Act, Executing ffmpeg -i $pathname$ext$br$newPathname on ".$Time.'.');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
          shell_exec ("ffmpeg -i $pathname$ext$br$newPathname"); }  
        if (in_array($oldExtension, $PLAudioOGGArr)) {
          copy ($oldPathname, $playlistDir.'/'.$StreamFile); } 
      
    // / The following code is performed if the user has selected a video file for streaming that is not already in mp4 format.    
    if (in_array($ext, $PLVideoArr)) { 
      shell_exec('ffmpeg -i '.$oldPathname.' -vcodec h264 -acodec aac -strict -2 '.$newPathname.".mp4"); 
      $txt = ('OP-Act: Optimized '.$oldPathname.' for streaming to '.$pathname.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } 
    // / The following code is performed if the user has selected a video file for streaming that is already in mp4 format.    
    if (in_array($ext, $PLVideoMP4Arr)) { 
      copy($oldPathname, $newPathname);
      $txt = ('OP-Act: Copied '.$oldPathname.' for streaming to '.$pathname.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } }

// / The following code will be performed whenever a user executes ANY HRC2 Cloud "core" feature.
if (file_exists($CloudTemp)) {
  $txt = ('OP-Act: Initiated AutoClean on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  $CleanFiles = scandir($CloudTempDir);
  $time = time();
  foreach ($CleanFiles as $CleanFile) {
    if ($CleanFile == '.' or $CleanFile == '..' or $CleanFile == 'index.html' or $CleanFile == '.AppLogs') continue;
      if ($time - filemtime($CloudTempDir.'/'.$CleanFile) >= 900) { // Every 15 mins.
        if (!is_dir($CloudTempDir.'/'.$CleanFile)) {
          unlink($CloudTempDir.'/'.$CleanFile); 
          $txt = ('OP-Act: Cleaned '.$CleanFile.' on '.$Time.'.');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
        if (is_dir($CloudTempDir.'/'.$CleanFile)) {
          $objects1 = scandir($CloudTempDir.'/'.$CleanFile); 
          foreach ($objects1 as $object1) { 
            if ($object1 == '.' or $object1 == '..') continue; 
              if (!is_dir($CloudTempDir.'/'.$CleanFile.'/'.$object1)) {
                unlink($CloudTempDir.'/'.$CleanFile.'/'.$object1); 
                $txt = ('OP-Act: Cleaned '.$object1.' on '.$Time.'.');
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } }
              if (is_dir($CloudTempDir.'/'.$CleanFile.'/'.$object1)) { 
                  $objects2 = scandir($CloudTempDir.'/'.$CleanFile.'/'.$object1); 
                  foreach ($objects2 as $object2) { 
                    if ($object2 == '.' or $object2 == '..') continue;
                      if (!is_dir($CloudTempDir.'/'.$CleanFile.'/'.$object1.'/'.$object2)) {
                        unlink($CloudTempDir.'/'.$CleanFile.'/'.$object1.'/'.$object2); 
                        $txt = ('OP-Act: Cleaned '.$object2.' on '.$Time.'.');
                        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } }
                      if (is_dir($CloudTempDir.'/'.$CleanFile.'/'.$object1.'/'.$object2)) { 
                          $objects3 = scandir($CloudTempDir.'/'.$CleanFile.'/'.$object1.'/'.$object2); 
                          foreach ($objects3 as $object3) { 
                            if ($object3 == '.' or $object3 == '..') continue;
                              if (!is_dir($CloudTempDir.'/'.$CleanFile.'/'.$object1.'/'.$object2.'/'.$object3)) {
                                unlink($CloudTempDir.'/'.$CleanFile.'/'.$object1.'/'.$object2.'/'.$object3); 
                                $txt = ('OP-Act: Cleaned '.$object3.' on '.$Time.'.');
                                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
                              if (is_dir($CloudTempDir.'/'.$CleanFile.'/'.$object1.'/'.$object2.'/'.$object3)) { 
                                @rmdir($CloudTempDir.'/'.$CleanFile.'/'.$object1.'/'.$object2.'/'.$object3); 
                                $txt = ('OP-Act: Cleaned directory '.$object3.' on '.$Time.'.');
                                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } } 
                        @rmdir($CloudTempDir.'/'.$CleanFile.'/'.$object1.'/'.$object2); 
                        $txt = ('OP-Act: Cleaned directory '.$object2.' on '.$Time.'.');
                        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);   
                @rmdir($CloudTempDir.'/'.$CleanFile.'/'.$object1); 
                $txt = ('OP-Act: Cleaned directory '.$object1.' on '.$Time.'.');
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
                @rmdir($CloudTempDir.'/'.$CleanFile); 
                $txt = ('OP-Act: Cleaned directory '.$CleanFile.' on '.$Time.'.');
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } }  

  $bytes = sprintf('%u', filesize($DisplayFile));
  if ($bytes > 0) {
    $unit = intval(log($bytes, 1024));
    $units = array('B', 'KB', 'MB', 'GB');
  if (array_key_exists($unit, $units) === true) { 
    $DisplayFileSize = sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]); } }  
$DisplayFileCon = scandir($CloudLoc.'/'.$UserID.$UserDirPOST);

// / Code to search a users Cloud Drive and return the results.
if (isset($_POST['search'])) { 
  $txt = ('OP-Act: '."User initiated Cloud Search on $Time".'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); ?>
  <div align="center"><h3>Search Results</h3></div>
<hr />
<?php
$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$SearchRAW = $_POST['search'];
$txt = ('OP-Act: Raw user input is "'.$SearchRAW.'" on '.$Time.'.');
$MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
$searchRAW = str_replace(str_split('\\/[]{};:!$#&@>*<'), '', $searchRAW);
$txt = ('OP-Act: Sanitized user input is "'.$SearchRAW.'" on '.$Time.'.');
$MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
$SearchLower = strtolower($SearchRAW);
if ($SearchRAW == '') {
  ?><div align="center"><?php echo nl2br('Please enter a search keyword.'."\n".'<a href="#" onclick="goBack();">&#8592; Go Back</a>'); ?><hr /></div> <?php die(); }
$PendingResCount1 = '0';
$PendingResCount2 = '0';
$ResultFiles = scandir($CloudUsrDir);
if (isset($SearchRAW)) {       
  foreach ($ResultFiles as $ResultFile0) {
    if ($ResultFile0 == '.' or $ResultFile0 == '..' or $ResultFile0 == 'index.html') continue;
      $ResultFile = $CloudUsrDir.$ResultFile0;    
      $ResultTmpFile = $CloudTmpDir.$ResultFile0;
      $ResultURL = 'DATA/'.$UserID.$UserDirPOST.$ResultFile0;
      $F2 = pathinfo($ResultFile, PATHINFO_BASENAME);
      $F3 = $CloudTmpDir.$F2;
      $F4 = pathinfo($ResultFile, PATHINFO_FILENAME);
      $F5 = pathinfo($ResultFile, PATHINFO_EXTENSION);
      $txt = ('OP-Act: '."Submitted $ResultFile to $CloudTmpDir on $Time".'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
      $PendingResCount1++; 
      $ResultRAW = $ResultFile0;
      $Result = strtolower($ResultRAW);
      if (!preg_match("/$SearchLower/", $Result)) continue; 
      if (preg_match("/$SearchLower/", $Result)) { 
        $PendingResCount2++; 
          if (is_dir($ResultFile)) {
            @mkdir($F3, 0755);
            foreach ($iterator = new \RecursiveIteratorIterator(
              new \RecursiveDirectoryIterator($ResultFile, \RecursiveDirectoryIterator::SKIP_DOTS),
              \RecursiveIteratorIterator::SELF_FIRST) as $item) {
              if ($item->isDir()) {
                @mkdir($F3 . DIRECTORY_SEPARATOR . $iterator->getSubPathName()); }   
              else {
                @copy($item, $F3 . DIRECTORY_SEPARATOR . $iterator->getSubPathName()); } } 
        $ResultURL = 'cloudCore.php?UserDirPOST='.$ResultFile0 ; }
      if (!is_dir($ResultFile)) {  
          @copy($ResultFile, $ResultTmpFile); } 
          ?><a href='<?php echo ($ResultURL); ?>'><?php echo nl2br($ResultFile0."\n"); ?></a>
          <hr /><?php } } 

echo nl2br('Searched '.$PendingResCount1.' files for "'.$SearchRAW.'" and found '.$PendingResCount2.' results on '.$Time.'.'); 
$txt = ('OP-ACT, Searched '.$PendingResCount1.' files for "'.$SearchRAW.'" and found '.$PendingResCount2.' results on '.$Time.'.');
$MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } ?>
<br>
<div align="center"><a href="#" onclick="goBack();">&#8592; Go Back</a></div>
<hr />

<?php }
if (isset($_GET['playlistSelected']) or isset($_POST['playlistSelected'])) {
include($InstLoc.'/Applications/HRStreamer/HRStreamer.php'); 
die(); } 

require($InstLoc.'/Applications/displaydirectorycontents_72716/index.php');

?>