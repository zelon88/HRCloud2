<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
<?php
set_time_limit(0);
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
// / Python 2.7 and 3, ClamAV, Rar, Unrar, Unzip, 7zipper, FFMPEG, OpenCV, 
// / PyGames Rect, NumPy, setuptools for Python 2 and 3, Python-Pip, thetaexif,
// / Scikit, Scypy, and ImageMagick.

// / IMPORTANT NOTES ...
// / You need to allow www-data access to use sudo commands by editing the /etc/sudoers
// / file and adding the following lne... "www-data ALL=(ALL) NOPASSWD:ALL".
// / -----------------------------------------------------------------------------------

// / The follwoing code checks if the configuration file.php file exists and 
// / terminates if it does not.
if (!file_exists('config.php')) {
  echo nl2br('ERROR HRC230, Cannot process the HRCloud2 configuration file (config.php).'."\n"); 
  die (); }
else {
  require('config.php'); }
$WPFile = '/var/www/html/wp-load.php';

// / Verify that WordPress is installed.
if (!file_exists($WPFile)) {
  $txt = ('ERROR HRC265, WordPress not detected.');
  $LogFile = file_put_contents($SesLogDir.'/'.'_'.$LogInc.'.txt', $txt.PHP_EOL , FILE_APPEND);
  echo nl2br('ERROR HRC265, WordPress was not detected on the server.'."\n"); }
  else {
    require($WPFile); } 

$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$LogLoc = $InstLoc.'/AppLogs';
$LogInc = 0;
$SesLogDir = $LogLoc.'/'.$Date;
$ClamLogDir = ($InstLoc.'/'.'VirusLogs'.'/'.$Date.'.txt');
$LogFile = ($SesLogDir.'/'.$Date.'_'.$LogInc.'.txt');
$UserID = get_current_user_id();
$CloudDir = $CloudLoc.'/'.$UserID;
$CloudTemp = $InstLoc.'/DATA/';
$CloudTempDir = $CloudTemp.$UserID;
if (!file_exists($CloudTempDir)) {
  mkdir($CloudTempDir, 0755); }
if (!file_exists($CloudTmpDir)) {
  mkdir($CloudTmpDir, 0755); }
if (!file_exists($CloudDir)) {
  mkdir($CloudDir, 0755); }
if (!file_exists($SesLogDir)) {
$JICInstallLogs = @mkdir($SesLogDir, 0755); }
if (!file_exists($LogLoc)) { 
$JICInstallLogs = @mkdir($LogLoc, 0755); }
$JICTouchInstallLogFile = @touch($SesLogDir.'/'.$Date.'_'.$LogInc.'.txt');
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
  
// / Checks to see that the user is logged in.
if ($UserID == '') {
  echo nl2br('ERROR HRC272, You are not logged in!'."\n"); 
  die(); }
if ($UserID == '0') {
  echo nl2br('ERROR HRC275, You are not logged in!'."\n"); 
  die(); }
if (!isset($UserID)) {
  echo nl2br('ERROR HRC278, You are not logged in!'."\n"); 
  die(); }

// / The following code checks if VirusScan is enabled and update ClamAV definitions accordingly.
if ($VirusScan == '1') {
  shell_exec('freshclam'); }

// / The following code verifies and cleans the config file.  	
if ($Online == '') {
  $txt = ('ERROR HRC271, '.$Time.', You have not yet setup the HRCloud2 configuration file! Please 
    view and completely fill-out the settings or config.php file in your root HRCloud2
    directory.');
  $LogFile = file_put_contents($SesLogDir.'/'.'_'.$LogInc.'.txt', $txt.PHP_EOL , FILE_APPEND);
  die (' ERROR HRC275, '.$Time.', You have not yet setup the HRCloud2 configuration file! Please 
    view and completely fill-out the settings or config.php file in your root HRCloud2     
    directory. '); }
if ($Online == '0') { 
  $CleanConfig = '1';
  $INTIP = 'localhost';
  $EXTIP = 'localhost'; }
if ($Online !== '0') {
  $CleanConfig = '1';
  $INTIP = $InternalIP; 
  $EXTIP = $ExternalIP; }
if (isset ($InternalIP)) { 
  unset ($InternalIP); }
if (isset ($ExternalIP)) { 
  unset ($ExternalIP); } 

   // / The following code is performed when a user initiates a file upload.
if(isset($_POST["upload"])) {
  if (!is_array($_FILES["filesToUpload"])) {
    $_FILES["filesToUpload"] = array($_FILES["filesToUpload"]); }
  foreach ($_FILES['filesToUpload']['name'] as $key=>$file) {
    $fc++;
    if ($file !== '.' or $file !== '..') {
      $file = str_replace(" ", "_", $file);
      $F1 = (pathinfo($file, PATHINFO_DIRNAME).'/'.$file);
      $F2 = pathinfo($file, PATHINFO_BASENAME);
      $F3 = $CloudUsrDir.$F2;
      $txt = ('OP-Act: '."Submitted $file to $CloudTmpDir on $Time".'.');
      echo nl2br ('Uploaded: '."$F2 on $Time".'.'."\n".'--------------------'."\n");
      $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
        if($file == "") {
          die("ERROR HRC2103, No file specified"); }
        // / The following code checks the Cloud Location with ClamAV before copying, just in case.
        if ($VirusScan == '1') {
        shell_exec('clamscan -r '.$_FILES['filesToUpload'].'/'.$UserID.' | grep FOUND >> '.$ClamLogDir); 
        if (filesize($ClamLogDir > 1)) {
          echo nl2br('WARNING HRC2108, There were potentially infected files detected. The file
            transfer could not be completed at this time. Please check your file for viruses or 
            try again later.'."\n");
            die(); } } 
      $COPY_TEMP = copy($_FILES['filesToUpload']['tmp_name'][$key], $F3);
      chmod($F3,0755); } } } 

// / The following code is performed when a user downloads a selection of files.
if (isset($_POST['download'])) {
  $fc = 0;
  if (!is_array($_POST['filesToDownload'])) {
    $_POST['filesToDownload'] = array($_POST['filesToDownload']); }
    foreach ($_POST['filesToDownload'] as $key=>$file) {
      if ($file == '.' or $file == '..') continue;
      $fc++;
      $file = $CloudUsrDir.$file;
      $F1 = (pathinfo($file, PATHINFO_DIRNAME).'/'.$file);
      $F2 = pathinfo($file, PATHINFO_BASENAME);
      $F3 = $CloudTmpDir.$F2;
      $F4 = pathinfo($file, PATHINFO_FILENAME);
      $F5 = pathinfo($file, PATHINFO_EXTENSION);
      $F6 = $F4.'_'.$fc.'.'.$F5;
      $txt = ('OP-Act: '."Submitted $file to $CloudTmpDir on $Time".'.');
      $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
        if($file == "") {
          $txt = ("ERROR HRC2146, No file specified on $Time".'.');
          $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
          echo nl2br("ERROR HRC2146, No file specified"."\n");
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
  echo nl2br('WARNING HRC2154, There were potentially infected files detected. The file
    transfer could not be completed at this time. Please check your file for viruses or
    try again later.'."\n");
    die(); } } } 

// / The following code is performed whenever a user selects a file to copy.
if (isset($_POST['copy'])) {
  if (!is_array($_POST['filesToCopy'])) {
    $_POST['filesToCopy'] = array($_POST['filesToCopy']); }
    $copycount = 0;
  foreach ($_POST['filesToCopy'] as $key=>$CFile) { 
    $newCopyFilename = $_POST['newcopyfilename'];
    $copycount++;
    if (isset($newCopyFilename)) {
      $cext = pathinfo($CloudUsrDir.$CFile, PATHINFO_EXTENSION);
      if ($copycount >= 2) {
        $newCopyFilename = $newCopyFilename.'_'.$copycount; }
      copy($CloudUsrDir.$CFile, $CloudUsrDir.$newCopyFilename.'.'.$cext);
        $txt = ('OP-Act: '."Copied $CFile to $newCopyFilename on $Time".'.');
        $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); } } }

// / The following code is performed whenever a user selects a file to rename.
if (isset($_POST['rename'])) {
  if (!is_array($_POST['filesToRename'])) {
    $_POST['filesToRename'] = array($_POST['filesToRename']); }
    $rencount = 0;
  foreach ($_POST['filesToRename'] as $key=>$ReNFile) { 
    $renameFilename = $_POST['renamefilename'];
    $rencount++;
    if (isset($renameFilename)) {
      $renext = pathinfo($CloudUsrDir.$ReNFile, PATHINFO_EXTENSION);
      if ($rencount >= 2) {
        $renameFilename = $renameFilename.'_'.$rencount; }
      rename($CloudUsrDir.$ReNFile, $CloudUsrDir.$renameFilename.'.'.$renext);
        $txt = ('OP-Act: '."Copied $ReNFile to $renameFilename on $Time".'.');
        $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); } } }

// / The following code is performed whenever a user selects a file to delete.
if (isset($_POST['deleteconfirm'])) {
  if (!is_array($_POST['filesToDelete'])) {
    $_POST['filesToDelete'] = array($_POST['filesToDelete']); }
  foreach ($_POST['filesToDelete'] as $key=>$DFile) { 
    if (is_dir($CloudUsrDir.$DFile)) {
     $objects = scandir($CloudUsrDir.$DFile); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (is_dir($CloudUsrDir.$DFile."/".$object)) 
           rmdir($CloudUsrDir.$DFile."/".$object);
         else 
           unlink($CloudUsrDir.$DFile."/".$object); } }
     rmdir($CloudUsrDir.$DFile); } 
    unlink($CloudUsrDir.$DFile);
    if (file_exists($CloudTmpDir.$DFile)) {
      unlink($CloudTmpDir.$DFile); 
      $txt = ('OP-Act: '."Deleted $DFile from $CloudTmpDir on $Time".'.');
      $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); }
    $txt = ('OP-Act: '."Deleted $DFile from $CloudUsrDir on $Time".'.');
    $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); } }

// / The following code is performed when a user selects files for archiving.
if (isset($_POST['archive'])) {
  if (!is_array($_POST["filesToArchive"])) {
    $_POST["filesToArchive"] = array($_POST["filesToArchive"]); }
  foreach ($_POST['filesToArchive'] as $key=>$TFile1) { 
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
$UserExt = $_POST['archextension'];
$UserFileName = $_POST['userfilename'];
if(!in_array($ext, $allowed)) { 
  echo nl2br("ERROR HRC2181, Unsupported File Format\n");
  die(); }
// / Check the Cloud Location with ClamAV before archiving, just in case.
if ($VirusScan == '1') {
  shell_exec('clamscan -r '.$CloudTempDir.' | grep FOUND >> '.$ClamLogDir); 
if (filesize($ClamLogDir > 1)) {
  echo nl2br('WARNING HRC2187, There were potentially infected files detected. The file
    transfer could not be completed at this time. Please check your file for viruses or
    try again later.'."\n");
    die(); } }
// / Handle archiving of rar compatible files.
if(in_array($UserExt, $rararr)) {
  copy ($filename, $CloudTmpDir . $filename1); 
  $txt = ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt in $CloudTmpDir on $Time".'.');
  $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
  shell_exec('rar a '.$CloudUsrDir.$UserFileName.'.rar '.$CloudUsrDir.$filename1); } 
// / Handle archiving of .zip compatible files.
if(in_array($UserExt, $ziparr)) {
  copy ($filename, $CloudTmpDir.$filename1); 
  $txt = ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt in $CloudTmpDir on $Time".'.');
  $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); 
  shell_exec('zip -j '.$CloudUsrDir.$UserFileName.'.zip '.$CloudUsrDir.$filename1); } 
// / Handle archiving of 7zipper compatible files.
if(in_array($UserExt, $tararr)) {
  copy ($filename, $CloudTmpDir.$filename1); 
  $txt = ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt in $CloudTmpDir on $Time".'.');
  $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); 
  shell_exec('7z a '.$CloudUsrDir.$UserFileName.'.'.$UserExt.' '.$CloudUsrDir.$filename1); } } }  

// / The following code will be performed when a user selects archives to extract.
if (isset($_POST["dearchive"])) {
  if (isset($_POST["filesToDearchive"])) {
    if (!is_array($_POST["filesToDearchive"])) {
      $_POST['filesToDearchive'] = array($_POST['filesToDearchive']); }
    foreach (($_POST['filesToDearchive']) as $File) {
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
        echo nl2br('WARNING HRC2309, There were potentially infected files detected. The file
          transfer could not be completed at this time. Please check your file for viruses or
          try again later.'."\n");
          die(); } }
      if (!file_exists($CloudTmpDir.$filename)) {
        copy($CloudUsrDir.$filename, $CloudTmpDir.$filename); }
      if (!file_exists($CloudUsrDir.$filename2.'_'.$Date)) {
        mkdir($CloudUsrDir.$filename2.'_'.$Date, 0755); }
      // / Handle dearchiving of rar compatible files.
        if(in_array($ext,$rararr)) {
        shell_exec('unrar e '.$CloudTmpDir.$filename.'.rar '.$CloudUsrDir.$filename2.'_'.$Date);
        $txt = ('OP-Act: '."Submitted $filename to $filename2_$Date$ in $CloudTmpDir on $Time".'.');
        $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); } 
      // / Handle dearchiving of .zip compatible files.
      if(in_array($ext,$ziparr)) {
        shell_exec('unzip '.$CloudTmpDir.$filename.' -d '.$CloudUsrDir.$filename2.'_'.$Date);
        $txt = ('OP-Act: '."Submitted $filename to $filename2_$Date in $CloudTmpDir on $Time".'.');
        $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); } 
      // / Handle dearchiving of 7zipper compatible files.
      if(in_array($ext,$tararr)) {
        shell_exec('7z e'.$CloudUsrDir.$filename2.'_'.$Date.'.'.$ext.' '.$CloudTmpDir.$filename1); 
        $txt = ('OP-Act: '."Submitted $filename to $filename2_$Date in $CloudTmpDir on $Time".'.');
        $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); } } } }
  
// / The following code is performed when a user selects files to convert to other formats.
if (isset( $_POST['convertSelected'])) {
  $txt = ('OP-Act: Initiated HRConvert on '.$Time.'.');
  $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);    
  if (!is_array($_POST['convertSelected'])) {
    $_POST['convertSelected'] = array($_POST['convertSelected']); }
  foreach ($_POST['convertSelected'] as $file) {
    $txt = ('OP-Act: User selected to Convert file '.$file.' from CLOUD.');
    $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
    $allowed =  array('mov', 'mp4', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'dat', 'cfg', 'txt', 'doc', 'docx', 'rtf' ,'xls', 'xlsx', 'ods', 'odf', 'odt', 'jpg', 'mp3', 
      'avi', 'wma', 'wav', 'ogg', 'jpeg', 'bmp', 'png', 'gif', 'pdf', 'abw', 'zip', '7z', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
    $file1 = $CloudUsrDir.$file;
    $file2 = $CloudTmpDir.$file;
    copy($file1, $file2); 
    if (file_exists($file2)) {
    $txt = ('OP-Act: '."Copied $file1 to $file2 on $Time".'.'); 
    $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); }
    if (!file_exists($file2)) {
      $txt = ('ERROR!!! HRC2333, '."Could not copy $file1 to $file2 on $Time".'.'); 
      $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
      echo nl2br('ERROR!!! HRC2333, There was a problem copying your file between internal HRCloud directories.
        Please rename your file or try again later.'."\n");
      die(); }
    $extension = $_POST['extension']; 
    $pathname = $CloudTmpDir.$file;
    $oldPathname = $CloudUsrDir.$file;
    $filename = pathinfo($pathname, PATHINFO_FILENAME);
    $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
    $newFile = $_POST['userconvertfilename'] . '.' . $extension;
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
        $stub = ('http://localhost/DATA/');
        $newFileURL = $stub.$UserID.$UserDirPOST.$newFile; 
          // / Note: Some servers may experience a delay between the script finishing and the
            // / converted file being placed into their Cloud drive. If your files do not immediately
            // / appear, simply refresh the page.
          if (in_array($oldExtension,$docarray) ) {
            echo("unoconv -o $newPathname -f $extension $pathname");
            shell_exec ("unoconv -o $newPathname -f $extension $pathname"); 
            // / For some reason files take a moment to appear after being created with Unoconv.
            $stopper = 0;
            while(!file_exists($newPathname)) {
              $stopper++;
              if ($stopper == 10) {
                die('ERROR HRC2364, The converter timed out while copying your file.'); }
              sleep(2); } }

          if (in_array($oldExtension,$imgarray) ) {
            $height = $_POST["height"];
            $width =  $_POST["width"]; 
            $rotate = ('-rotate ' . $_POST["rotate"]);
            $wxh = $width . 'x' . $height;
                if ($wxh === '0x0') {       
                  echo ("option1: convert $pathname $rotate $newPathname");
                  shell_exec ("convert $pathname $rotate $newPathname"); } 
                elseif (($width or $height) != '0') {
                  echo ("option2: convert -resize $wxh $rotate $pathname $newPathname");
                  shell_exec ("convert -resize $wxh $rotate $pathname $newPathname"); }  }


                  if (in_array($oldExtension,$audioarray) ) { 
                  $bitrate = $_POST['bitrate'];
                  $ext = (' -f ' . $extension);
              if ($bitrate = 'auto' ) {
                $br = ' '; } 
              elseif ($bitrate != 'auto' ) {
                $br = (' -ab ' . $bitrate . ' '); } 
                shell_exec ("ffmpeg -i $pathname$ext$br$newPathname"); } 


          if (in_array($oldExtension,$archarray) ) {
            $safedir1 = $CloudTmpDir;
            $safedir2 = $CloudTmpDir.$filename;
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
                        shell_exec("rar a $newPathname $safedir2");
                        $delFiles = glob($safedir2 . '/*');
                          foreach($delFiles as $delFile){
                            if(is_file($delFile) ) {
                            chmod($delFile, 0755);  
                            unlink($delFile); }
                            elseif(is_dir($delFile) ) {
                              chmod($delFile, 0755);
                              rmdir($delFile); } } 
                              rmdir($safedir2); } }
if (!file_exists($newPathname)) {
  echo nl2br('ERROR HRC2463, There was an error during the file conversion process and your file was not copied.'."\n");
  $txt = ('ERROR HRC2463, '."Conversion failed! $newPathname could not be created from $oldPathname".'.');
  $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
  die(); } 

if (file_exists($newPathname)) {
  $txt = ('ERROR HRC2470, No file to convert.');
  $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); } } }

// / The following code will be performed when a user selects files to stream. (for you, Emily...)
if (isset($_POST['streamSelected'])) {
  $txt = ('OP-Act: Initiated HRStream on '.$Time.'.');
  $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
  foreach (($_POST['streamSelected']) as $StreamFile) {
    $txt = ('OP-Act: User selected to StreamFile '.$StreamFile.' from CLOUD.');
    $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
    $File1 = $CloudUsrDir.$file;
    $file1 = ((pathinfo($File1, PATHINFO_DIRNAME)).'/'.(pathinfo($File1, PATHINFO_FILENAME)));
    $file2 = $CloudTmpDir.pathinfo($File1, PATHINFO_FILENAME); // / I'm so sorry for mixing capital and lower case.
    copy($file1, $file2);
    $txt = ('OP-Act: '."Copied $file1 to $file2 on $Time".'.');
    $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
    $extension = $_POST['extension']; 
    $pathname = $CloudTmpDir.$file;
    $oldPathname = $CloudUsrDir.$file;
    $filename = pathinfo($pathname, PATHINFO_FILENAME);
    $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
    $newFile = $filename . '.' . $extension;
    $newPathname = $CloudUsrDir.$newFile;
    $audioarray =  array('mp3', 'wma', 'wav', 'ogg');
    $videoarray =  array('avi', 'mov', 'mp4', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp');
    $safedir = '/tmp/SAFEDIR/isolated/' . $newFile; 
      if (!file_exists($safedir)) {
        mkdir($safedir, 0755); }
        $stub = ('http://localhost/DATA/');
    // / The following code is performed if the user has selected an audio file for streaming.
    if (in_array($ext, $audioarray)) { 
      $StreamFile1 = $CloudUsrDir.$StreamFile;
      $StreamFile2 = $CloudTmpDir.$StreamFile;
      shell_exec('ffmpeg -i '.$StreamFile1.' -vcodec h264 -acodec aac -strict -2 '.$StreamFile2.".mp4"); 
      $txt = ('OP-Act: Optimized '.$StreamFile1.' for streaming in '.$StreamFile2.'.');
      $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); }
    // / The following code is performed if the user has selected a video file for streaming.    
    if (in_array($ext, $videoarray)) { 
      
  } } }

// / The following code is performed if the user has selected or uploaded a standard image file for
// /  "Document Scanning" using OpenCV and https://github.com/vipul-sharma20/document-scanner
if (isset($_POST['scanDocSelected'])) {
  $txt = ('OP-Act: Initiated HRDocScan on '.$Time.'.');
  $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
    if (!is_array($_POST["scanDocSelected"])) {
    $_POST['scanDocSelected'] = array($_POST['scanDocSelected']); }
    foreach ($_POST['scanDocSelected'] as $key=>$scanDoc) {
      $txt = ('OP-Act: User selected to DocScan file '.$scanDoc.' from CLOUD.');
      $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
      if (!file_exists($CloudUsrDir.$scanDoc)) {
        $txt = ('OP-Act: ERROR HRC2512, '.$scanDoc.' does not exist!');
        $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
        echo nl2br('ERROR HRC2512, '.$scanDoc.' does not exist!'."\n");
        die(); }
    $CUD = $CloudUsrDir.$scanDoc;
    $CTD = $CloudTmpDir.$scanDoc;
    copy ($CUD, $CTD);
    if (file_exists($CTD)) {
      $txt = ('OP-Act: Copied '.$CUD.' to '.$CTD.'.');
      $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); }
    if (!file_exists($CTD)) {
      $txt = ('ERROR!!! HRC2537, Could not copy '.$CUD.' to '.$CTD.'.');
      $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); 
      echo nl2br ($txt."\n"); }
    $allowed = array('jpg', 'jpeg', 'bmp', 'png');
    $pdfarray = array('pdf');
    $filename = pathinfo($CTD, PATHINFO_FILENAME);
    $filename1 = pathinfo($CTD, PATHINFO_FILENAME);
    $oldExtension = pathinfo($CTD, PATHINFO_EXTENSION);
    if (in_array($oldExtension, $pdfarray)) {
      shell_exec('convert -density 150 -trim '.$CTD.'.jpg -quality 100 -sharpen 0x1.0 '.$CUD);
      $CTD = $CTD.'.jpg'; 
      $txt = ('OP-Act: Converted '.$CUD.' to '.$CTD.' on '.$Time.'.');
      $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); 
      $oldExtension = 'jpg'; }
    if (in_array($oldExtension,$allowed)) { 
      list($Width, $Height) = getimagesize($CUD);
      $EXFreshScript = $InstLoc.'/Applications/document-scanner-master.zip';
      $EXTempScript = $InstLoc.'/DATA/'.$UserID.'/TEMPSCRIPTS';
      mkdir($EXTempScript);
      chmod($EXTempScript, 0755);
      $ExtractScripts = shell_exec('unzip '.$EXFreshScript.' -d '.$EXTempScript);
      chmod($EXTempScript.'/document-scanner', 0755);
      $TempScript = $EXTempScript.'/document-scanner/scan.py';
        chmod($EXTempScript.'/document-scanner', 0755);
        $TempScriptGlob = glob($TempScript);
        foreach ($TempScriptGlob as $TSG) {
          chmod($TSG, 0755); }
        chmod($EXTempScript.'/document-scanner/pyimagesearch', 0755);
        $TempScript1 = $EXTempScript.'/document-scanner/pyimagesearch';
        $TempScriptGlob = glob($TempScript1);
        foreach ($TempScriptGlob as $TSG) {
          chmod($TSG, 0755); }
      $OutputDoc = $InstLoc.'/DATA/'.$UserID.'/DOCSCANTEMP.jpg';
      $Code = 'DOCSCANTEMP.jpg';
      $newCode = $InstLoc.'/DATA/'.$UserID.'/DOCSCANTEMP.jpg';
      $ScriptData = file_get_contents($TempScript);
      $SwapCode = str_replace($Code, $newCode, $ScriptData);
      $WriteCode = file_put_contents($TempScript, $SwapCode);
      $txt = ('OP-Act: Modified the code of '.$TempScript.' with '.$SwapCode.' on '.$Time.'.');
      $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
      $txt = ('OP-Act: Executing! '.$TempScript.' on '.$Time.'.');
      $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
      chmod($TempScript, 075);
      shell_exec('python '.$TempScript.' --image '.$CTD);
      $txt = ('OP-Act: Execute complete! '.$TempScript.' was executed  on '.$Time.'.');
      $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
      unlink($InstLoc.'/DATA/'.$UserID.'/TEMPSCRIPTS/document-scanner/pyimagesearch/imutils.py');
      unlink($InstLoc.'/DATA/'.$UserID.'/TEMPSCRIPTS/document-scanner/pyimagesearch/imutils.pyc');
      unlink($InstLoc.'/DATA/'.$UserID.'/TEMPSCRIPTS/document-scanner/pyimagesearch/__init__.py');
      unlink($InstLoc.'/DATA/'.$UserID.'/TEMPSCRIPTS/document-scanner/pyimagesearch/__init__.pyc');
      unlink($InstLoc.'/DATA/'.$UserID.'/TEMPSCRIPTS/document-scanner/pyimagesearch/transform.py');
      unlink($InstLoc.'/DATA/'.$UserID.'/TEMPSCRIPTS/document-scanner/pyimagesearch/transform.pyc');
      @unlink($InstLoc.'/DATA/'.$UserID.'/TEMPSCRIPTS/document-scanner/pyimagesearch/__pycache__/imutils.cpython-35.pyc');
      @unlink($InstLoc.'/DATA/'.$UserID.'/TEMPSCRIPTS/document-scanner/pyimagesearch/__pycache__/__init__.cpython-35.pyc');
      @unlink($InstLoc.'/DATA/'.$UserID.'/TEMPSCRIPTS/document-scanner/pyimagesearch/__pycache__/transform.cpython-35.pyc');
      @rmdir($InstLoc.'/DATA/'.$UserID.'/TEMPSCRIPTS/document-scanner/pyimagesearch/__pycache__');
      rmdir($InstLoc.'/DATA/'.$UserID.'/TEMPSCRIPTS/document-scanner/pyimagesearch');
      unlink($InstLoc.'/DATA/'.$UserID.'/TEMPSCRIPTS/document-scanner/scan.py');
      rmdir($InstLoc.'/DATA/'.$UserID.'/TEMPSCRIPTS/document-scanner');
      rmdir($InstLoc.'/DATA/'.$UserID.'/TEMPSCRIPTS');
      $txt = ('OP-Act: Deleted '.$TempScript.' on '.$Time.'.');
      $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
        if (!file_exists($OutputDoc)) {
          echo nl2br('ERROR HRC2551, There was an error scanning '.$scanDoc.'. Please try renaming the file, or 
            converting it to a different format first.'."\n");
          $txt = ('OP-Act: ERROR HRC2551, DocScan of '.$scanDoc.' failed. Output file does not exist on '.$Time.'.');
          $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);
          die(); }
        if (file_exists($OutputDoc)) {
          if (isset($_POST['scandocuserfilename'])) {
            $OutputDoc2 = $_POST['scandocuserfilename']; } 
          if (!isset($_POST['scandocuserfilename'])) {
            $OutputDoc2 = 'Scanned.'.$oldExtension; }
            copy($OutputDoc, $CloudUsrDir.$OutputDoc2); }
        if (($_POST['outputScanDocToPDF']) == '1') {
          $extension = 'pdf'; 
          $pathname = $CloudUsrDir.'scanned.'.$oldExtension;
          $filename1 = pathinfo($pathname, PATHINFO_FILENAME);
          $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
          $newFile = $filename . '.' . $extension;
          $newPathname = $CloudUsrDir.$newFile;
          $OutputDoc = $newPathname;
          shell_exec ("unoconv -o $newPathname -f $extension $pathname"); 
          $txt = ('OP-Act: Copied '.$pathname.'.'.$extension
            .'/'.$Date.'.txt to '.$newPathname." on $Time".'.');
          $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND);  } 
        @unlink($OutputDoc); } } }

// / The following code will be performed whenever a user executes ANY HRC2 Cloud "core" feature.
if (file_exists($CloudTemp)) {
  $CleanFiles = glob($CloudTemp.'*');
  $time = time();
  foreach ($CleanFiles as $CleanFile) {
    if ($CleanFile == '.' or $CleanFile == '..') continue;
      if ($time - filemtime($CleanFile) >= 900) { // Every 15 mins.
        if (!is_dir($CleanFile)) {
          unlink($CleanFile); }
        if (is_dir($CleanFile)) {
          $objects1 = scandir($CleanFile); 
          foreach ($objects1 as $object1) { 
            if ($object1 != "." && $object1 != "..") { 
              if (!is_dir($CleanFile.'/'.$object1)) {
                unlink($CleanFile.'/'.$object1); }
              if (is_dir($CleanFile."/".$object1)) { 
                @rmdir($CleanFile."/".$object1); } } } } 
          if (!file_exists($CleanFile)) { 
            $txt = ('OP-Act: '."Cleaned $CleanFile on $Time".'.');
            $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); 
          if (file_exists($CleanFile)) { 
            $txt = ('ERROR HRC2614, Could not delete temp file '.$CleanFile.' on '.$Time.'.');
            $LogFile = file_put_contents($SesLogDir.'/'.$Date.'.txt', $txt.PHP_EOL , FILE_APPEND); } } } } }

  $bytes = sprintf('%u', filesize($DisplayFile));
  if ($bytes > 0) {
    $unit = intval(log($bytes, 1024));
    $units = array('B', 'KB', 'MB', 'GB');
  if (array_key_exists($unit, $units) === true) { 
    $DisplayFileSize = sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]); } }

        $DisplayFileCon = scandir($CloudLoc.$UserDirPOST.$UserID);
        foreach ($DisplayFileCon as $DisplayFile) {}
          $file_url = $URL.'/DATA/'.$UserID.$UserDirPOST.$DisplayFile;

require($InstLoc.'/Applications/displaydirectorycontents_72716/index.php');
?>
