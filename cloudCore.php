<!doctype html>
<?php
// / -----------------------------------------------------------------------------------
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
// / Apache 2.4, PHP 7.0+, MySQL, JScript, WordPress, LibreOffice, Unoconv, 
// / ClamAV, Tesseract, Rar, Unrar, Unzip, 7zipper, FFMPEG, and ImageMagick.
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will check for and initialize required HRCloud2 Core files.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC233, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/securityCore.php')) {
  echo nl2br('ERROR!!! HRC247, Cannot process the HRCloud2 Security Core file (securityCore.php).'."\n"); 
  die (); }
else {
  require ('/var/www/html/HRProprietary/HRCloud2/securityCore.php'); }
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('ERROR!!! HRC235, Cannot process the HRCloud2 Common Core file (commonCore.php).'."\n"); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is perfomed whenever a user POSTs an input directory.
// / This code is also used in some cases to create intermediate directories that are required for delivering data to the user.
if (isset($_POST['dirToMake'])) {
  $MAKEUserDir = $_POST['dirToMake'];
  // / If no UserDir exists, silently create one.
  if (!file_exists($CloudDir.'/'.$MAKEUserDir)) {
    @mkdir ($CloudDir.'/'.$MAKEUserDir, 0755); 
      // / Log the attempt.
      $txt = ('OP-Act: Created '.$CloudDir.'/'.$MAKEUserDir.' on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  // / If no CloudTempDir exists, silently create one.
  if (!file_exists($CloudTempDir.'/'.$MAKEUserDir)) {    
    @mkdir ($CloudTempDir.'/'.$MAKEUserDir, 0755); 
      // / Log the attempt.
      $txt = ('OP-Act: Created '.$CloudTempDir.'/'.$MAKEUserDir.' on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  // / The following code double checks that the specified directory were created and returns an error if it was not.
  // / If no UserDir exists, silently create one. 
  if (!file_exists($CloudDir.'/'.$MAKEUserDir)) {
      // / Log the attempt.
      $txt = ('ERROR!!! HRC265, Could not create '.$CloudDir.'/'.$MAKEUserDir.' on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  // / If no CloudTempDir exists, silently create one.  
  if (!file_exists($CloudTempDir.'/'.$MAKEUserDir)) {    
      // / Log the attempt.
      $txt = ('ERROR!!! HRC265, Could not create '.$CloudTempDir.'/'.$MAKEUserDir.' on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user initiates a file upload.
if(isset($_POST["upload"])) {
  $txt = ('OP-Act: Initiated Uploader on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  $_POST["upload"] = str_replace(str_split('\\~#()/[]{};:$!#^&%@>*<'), '', $_POST["upload"]);
  if (!is_array($_FILES["filesToUpload"]['name'])) {
    $_FILES["filesToUpload"]['name'] = array($_FILES["filesToUpload"]['name']); }
  foreach ($_FILES['filesToUpload']['name'] as $key=>$file) {
    if ($file == '.' or $file == '..' or $file == 'index.html') continue;     
    $_GET['UserDirPOST'] = str_replace(str_split('.[]{};:$!#^&%@>*<'), '', $_GET['UserDirPOST']);
    $file = str_replace(str_split('\\/[]{};:$!#^&%@>*<'), '', $file);
    $DangerousFiles = array('js', 'php', 'html', 'css');
    $F0 = pathinfo($file, PATHINFO_EXTENSION);
    if (in_array($F0, $DangerousFiles)) { 
      $txt = ("ERROR!!! HRC2103, Unsupported file format, $F0 on $Time.");
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      echo nl2br("ERROR!!! HRC2103, Unsupported file format, $F0 on $Time."."\n".'--------------------'."\n"); 
      continue; }
    $F2 = pathinfo($file, PATHINFO_BASENAME);
    $F3 = str_replace('//', '/', $CloudUsrDir.$F2);
    if($file == "") {
      $txt = ("ERROR!!! HRC2160, No file specified on $Time.");
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      echo nl2br("ERROR!!! HRC2160, No file specified on $Time."."\n".'--------------------'."\n"); 
      die(); }
    $COPY_TEMP = copy($_FILES['filesToUpload']['tmp_name'][$key], $F3);
    $txt = ('OP-Act: '."Uploaded $file to $CloudTmpDir on $Time".'.');
    echo nl2br ('OP-Act: '."Uploaded $file on $Time".'.'."\n".'--------------------'."\n");
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    chmod($F3, 0755); 
    // / The following code checks the Cloud Location with ClamAV after copying, just in case.
    if ($VirusScan == '1') {
      shell_exec(str_replace('  ', ' ', str_replace('  ', ' ', 'clamscan -r '.$Thorough.' '.$F3.' | grep FOUND >> '.$ClamLogDir)));
      $ClamLogFileDATA = @file_get_contents($ClamLogDir);
      if (strpos($ClamLogFileDATA, 'Virus Detected') == 'true' or strpos($ClamLogFileDATA, 'FOUND') == 'true') {
        $txt = ('WARNING HRC2338, There were potentially infected files detected. The file
          transfer could not be completed at this time. Please check your file for viruses or
          try again later.'."\n");
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);          
        unlink($F3);
        die($txt); } } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user downloads a selection of files.
if (isset($_POST["download"])) {
  $txt = ('OP-Act: Initiated Downloader on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  $_POST["download"] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST["download"]);
  if (!is_array($_POST['filesToDownload'])) {
    $_POST['filesToDownload'] = array($_POST['filesToDownload']); 
    $_POST['filesToDownload'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToDownload']); }
    foreach ($_POST['filesToDownload'] as $key=>$file) {
      $file = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $file);
      if ($file == '.' or $file == '..' or $file == 'index.html') continue;
      $file1 = $file;
      $file1 = ltrim(rtrim($file, '/'), '/');
      $file = $CloudUsrDir.$file;
      if (!file_exists($file)) continue;
      $F2 = pathinfo($file, PATHINFO_BASENAME);
      $F3 = $CloudTmpDir.$F2;
      if($file == "") {
        $txt = ("ERROR!!! HRC2187, No file specified on $Time".'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
        echo nl2br("ERROR!!! HRC2187, No file specified"."\n");
        die(); }
      if (file_exists($F3)) { 
        @touch($F3); }
      if (!is_dir($file)) { 
        $COPY_TEMP = symlink($file, $F3); 
        $txt = ('OP-Act: '."Submitted $file to $F3 on $Time".'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
      if (is_dir($file)) { 
        mkdir($F3, 0755);
          foreach ($iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($file, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST) as $item) {
            if ($item->isDir()) {
              mkdir($F3 . DIRECTORY_SEPARATOR . $iterator->getSubPathName()); }   
            else {
    symlink($item, $F3 . DIRECTORY_SEPARATOR . $iterator->getSubPathName()); } } } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects a file to copy.
if (isset($_POST['copy'])) {
  $txt = ('OP-Act: Initiated Copier on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  $_POST['copy'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['copy']);
  if (!is_array($_POST['filesToCopy'])) {
    $_POST['newcopyfilename'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['newcopyfilename']);
    $_POST['filesToCopy'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToCopy']);
    $_POST['filesToCopy'] = array($_POST['filesToCopy']); }
    $copycount = 0;
  foreach ($_POST['filesToCopy'] as $key=>$CFile) { 
    $CFile = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $CFile);
    if ($CFile == '' or $CFile == null) continue;   
    $newCopyFilename = $_POST['newcopyfilename'];
    if ($newCopyFilename == '' or $newCopyFilename == null) continue;  
    $copycount++;
    if (isset($newCopyFilename)) {
      $cext = pathinfo($CloudUsrDir.$CFile, PATHINFO_EXTENSION);
      if ($copycount >= 2) {
        $newCopyFilename = $newCopyFilename.'_'.$copycount; }
      $copySrc = str_replace('//', '/', $CloudUsrDir.$CFile);
      $copyDst = str_replace('//', '/', $CloudUsrDir.$newCopyFilename.'.'.$cext);
      if (file_exists($copySrc)) {
        // / The following code checks the Cloud Location with ClamAV before copying, just in case.
        if ($VirusScan == '1') {
          shell_exec(str_replace('  ', ' ', str_replace('  ', ' ', 'clamscan -r '.$Thorough.' '.$copySrc.' | grep FOUND >> '.$ClamLogDir)));
          $ClamLogFileDATA = file_get_contents($ClamLogDir);
          if (strpos($ClamLogFileDATA, 'Virus Detected') == 'true' or strpos($ClamLogFileDATA, 'FOUND') == 'true') {
            $txt = ('WARNING HRC2338, There were potentially infected files detected. The file
              transfer could not be completed at this time. Please check your file for viruses or
              try again later.'."\n");
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);          
            die($txt); } }
          // / Copy the files.
          copy($copySrc, $copyDst);
            $txt = ('OP-Act: '."Copied $CFile to $newCopyFilename".'.'."$cext on $Time".'.');
            echo nl2br ($txt."\n".'--------------------'."\n");
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } 
          if (!file_exists($copyDst)) { 
            $txt = ('ERROR!!! HRC2CloudCore198, '."Could not copy $CFile to $newCopyFilename".'.'."$cext on $Time".'!');
            echo nl2br ($txt."\n".'--------------------'."\n");
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects a file to rename.
if (isset($_POST['rename'])) {
  $txt = ('OP-Act: Initiated Renamer on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  $_POST['rename'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['rename']);
  if (!is_array($_POST['filesToRename'])) {
    $_POST['renamefilename'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['renamefilename']); 
    $_POST['filesToRename'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToRename']);
    $_POST['filesToRename'] = array($_POST['filesToRename']); }
    $rencount = 0;
  foreach ($_POST['filesToRename'] as $key=>$ReNFile) { 
    $ReNFile = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $ReNFile);
    if ($ReNFile == '' or $ReNFile == null) continue;
    $renameFilename = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['renamefilename']);
    if ($renameFilename == '' or $renameFilename == null) continue;    
    $rencount++;
    if (isset($renameFilename)) {
      $renext = pathinfo($CloudUsrDir.$ReNFile, PATHINFO_EXTENSION);
      if ($rencount >= 2) {
        $renameFilename = $renameFilename.'_'.$rencount; }
      $renSrc = str_replace('//', '/', $CloudUsrDir.$ReNFile);
      $renDst = str_replace('//', '/', $CloudUsrDir.$renameFilename.'.'.$renext);
      if (file_exists($renSrc)) { 
        // / The following code checks the Cloud Location with ClamAV before copying, just in case.
        if ($VirusScan == '1') {
          shell_exec(str_replace('  ', ' ', str_replace('  ', ' ', 'clamscan -r '.$Thorough.' '.$renSrc.' | grep FOUND >> '.$ClamLogDir)));
          $ClamLogFileDATA = file_get_contents($ClamLogDir);
          if (strpos($ClamLogFileDATA, 'Virus Detected') == 'true' or strpos($ClamLogFileDATA, 'FOUND') == 'true') {
            $txt = ('WARNING HRC2338, There were potentially infected files detected. The file
              transfer could not be completed at this time. Please check your file for viruses or
              try again later.'."\n");
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);          
            die($txt); } }
          // / Rename the files.
          rename($renSrc, $renDst);
            $txt = ('OP-Act: '."Renamed $ReNFile to $renameFilename".'.'."$renext on $Time".'.');
            echo nl2br ($txt."\n".'--------------------'."\n");
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } 
          if (!file_exists($renDst)) { 
            $txt = ('ERROR!!! HRC2CloudCore242, '."Could not rename $ReNFile to $renameFilename".'.'."$renext on $Time".'!');
            echo nl2br ($txt."\n".'--------------------'."\n");
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects a file to delete.
if (isset($_POST['deleteconfirm'])) {
  $txt = ('OP-Act: Initiated Deleter on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
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
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
      if (!file_exists($CloudDir.$DFile)) {
        $txt = ('OP-Act: '."Deleted $CloudDir$DFile on $Time".'.');
        echo nl2br ($txt."\n".'--------------------'."\n");
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
    if (is_dir($CloudUsrDir.$DFile)) {
      @rmdir($CloudUsrDir.$DFile);
      @unlink($CloudUsrDir.$DFile);
      @rmdir($CloudTmpDir.$DFile);
      @unlink($CloudTmpDir.$DFile);
      $objects = scandir($CloudUsrDir.$DFile); 
      // / Delete files from User directory.
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
      // / Delete files from Temp User directory.
      foreach ($objects as $object) { 
        if ($object == '.' or $object == '..') continue; 
          if (is_dir($CloudTmpDir.$DFile.'/'.$object)) {
             $objects2 = scandir($CloudTmpDir.$DFile.'/'.$object);
             foreach ($objects2 as $object2) { 
               if ($object2 == '.' or $object2 == '..') continue; 
                 if (!is_dir($CloudTmpDir.$DFile.'/'.$object.'/'.$object2)) {
                  @unlink($CloudTmpDir.$DFile.'/'.$object.'/'.$object2); }
                 if (is_dir($CloudTmpDir.$DFile.'/'.$object.'/'.$object2)) {
                  @unlink($CloudTmpDir.$DFile.'/'.$object.'/'.$object2.'/index.html');
                  @rmdir($CloudTmpDir.$DFile.'/'.$object.'/'.$object2); } }
             @unlink($CloudTmpDir.$DFile.'/'.$object.'/index.html'); 
             @rmdir($CloudTmpDir.$DFile.'/'.$object); }
          if (!is_dir($CloudTmpDir.$DFile.'/'.$object)) {
            @unlink($CloudTmpDir.$DFile.'/'.$object); } } 
    @unlink($CloudTmpDir.$DFile);
    @unlink($CloudTmpDir.$DFile.'/index.html');
    @rmdir($CloudTmpDir.$DFile);
    if (file_exists($CloudTmpDir.$DFile)) {
      @unlink($CloudTmpDir.$DFile); 
      $txt = ('OP-Act: '."Deleted $DFile from $CloudTmpDir on $Time".'.');
      echo nl2br ('OP-Act: '."Deleted $DFile from Temp directory on $Time".'.'."\n".'--------------------'."\n");
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
    $txt = ('OP-Act: '."Deleted $DFile from $CloudUsrDir from User directory on $Time".'.');
    echo nl2br ('OP-Act: '."Deleted $DFile on $Time".'.'."\n".'--------------------'."\n");   
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }  
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user selects files for archiving.
if (isset($_POST['archive'])) {
  $txt = ('OP-Act: Initiated Archiver on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  $_POST['archive'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['archive']);
  if (!is_array($_POST['filesToArchive'])) {
    $_POST['filesToArchive'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToArchive']);
    $_POST['filesToArchive'] = array($_POST['filesToArchive']); }
  foreach ($_POST['filesToArchive'] as $key=>$TFile1) {
$TFile1 = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $TFile1); 
$TFile1 = str_replace(' ', '\ ', $TFile1); 
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
$filename = str_replace('//', '/', $CloudUsrDir.$TFile1);
$filename1 = pathinfo($filename, PATHINFO_BASENAME);
$ext = pathinfo($filename, PATHINFO_EXTENSION);
$_POST['archextension'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['archextension']);
$UserExt = $_POST['archextension'];
$_POST['userfilename'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['userfilename']);
$UDP = '';
if ($UserDirPOST !== '/') {
  $UDP = $UserDirPOST; }
$UserFileName = str_replace('//', '/', $UDP.$_POST['userfilename']);
$UserFileName = str_replace(' ', '\ ', $UserFileName); 
$archSrc = str_replace('//', '/', $CloudTmpDir.$TFile1);
$archDst = str_replace('//', '/', $CloudUsrDir.$UserFileName);
if (!is_dir($filename)) {
  if(!in_array($ext, $allowed)) { 
    echo nl2br("ERROR!!! HRC2290, Unsupported File Format\n");
    die(); } }
// / Check the Cloud Location with ClamAV before archiving, just in case.
    if ($VirusScan == '1') {
      shell_exec(str_replace('  ', ' ', str_replace('  ', ' ', 'clamscan -r '.$Thorough.' '.$archSrc.' | grep FOUND >> '.$ClamLogDir)));
      $ClamLogFileDATA = file_get_contents($ClamLogDir);
      if (strpos($ClamLogFileDATA, 'Virus Detected') == 'true' or strpos($ClamLogFileDATA, 'FOUND') == 'true') {
        $txt = ('WARNING HRC2338, There were potentially infected files detected. The file
          transfer could not be completed at this time. Please check your file for viruses or
          try again later.'."\n");
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);          
        die($txt); } }
// / Handle archiving of rar compatible files.
if(in_array($UserExt, $rararr)) {
  copy ($filename, $CloudTmpDir.$TFile1); 
  shell_exec('rar a -ep '.$archDst.' '.$archSrc); 
  $txt = ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt in $CloudUsrDir on $Time".'.');
  echo nl2br ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt on $Time".'.'."\n".'--------------------'."\n");  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
// / Handle archiving of .zip compatible files.
if(in_array($UserExt, $ziparr)) {
  copy ($filename, $CloudTmpDir.$TFile1); 
  shell_exec('zip -j '.$archDst.'.zip '.$archSrc); 
  $txt = ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt in $CloudUsrDir on $Time".'.');
  echo nl2br ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt on $Time".'.'."\n".'--------------------'."\n");  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
// / Handle archiving of 7zipper compatible files.
if(in_array($UserExt, $tararr)) {
  copy ($filename, $CloudTmpDir.$TFile1); 
  shell_exec('7z a '.$archDst.'.'.$UserExt.' '.$archSrc); 
  $txt = ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt in $CloudUsrDir on $Time".'.');
  echo nl2br ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt on $Time".'.'."\n".'--------------------'."\n");  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } }  
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will be performed when a user selects archives to extract.
if (isset($_POST["dearchiveButton"])) {
  // / The following code sets the global dearchive variables for the session.
  $txt = ('OP-Act: Initiated Dearchiver on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  $_POST['dearchiveButton'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['dearchiveButton']);
  $UDP = '';
  $allowed =  array('zip', '7z', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
  $archarray = array('zip', '7z', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
  $rararr = array('rar');
  $ziparr = array('zip');
  $tararr = array('7z', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
  if ($UserDirPOST !== '/' or $UserDirPOST !== '//') {
    $UDP = $UserDirPOST; }
  if (isset($_POST["filesToDearchive"])) {
    if (!is_array($_POST["filesToDearchive"])) {
      $_POST['filesToDearchive'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToDearchive']);
      $_POST['filesToDearchive'] = array($_POST['filesToDearchive']); }
    foreach (($_POST['filesToDearchive']) as $File) {
      if ($File == '.' or $File == '..') continue;
      // / The following code sets variables for each archive being extracted.
      $File = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $File); 
      $File = str_replace(' ', '\ ', $File); 
      $File = str_replace('//', '/', str_replace('//', '/', $File));   
      $File = ltrim($UDP.$File, '/'); 
      // / The following code sets and detects the USER directory and filename variables to be used for the operation.
      $dearchUserPath = str_replace('//', '/', $CloudDir.'/'.$File);
      $ext = pathinfo(str_replace('//', '/', $CloudDir.'/'.$File), PATHINFO_EXTENSION); 
      $dearchUserDir = str_replace('.'.$ext, '', $dearchUserPath);
      $dearchUserFile = pathinfo($dearchUserPath, PATHINFO_FILENAME);
      $dearchUserFilename = $dearchUserFile.'.'.$ext;
      // / The following code sets the TEMP directory and filename variables to be used to copy files for the operation.
      $dearchTempPath = str_replace('//', '/', $CloudTempDir.'/'.$File);
      $dearchTempDir = str_replace('.'.$ext, '', $dearchTempPath);
      $dearchTempFile = $dearchUserFile;
      $dearchTempFilename = $dearchUserFile.'.'.$ext;
      // / The following code creates all of the temporary directories and file copies needed for the operation.
      // / The following code is performed when a dearchTempDir already exists.
      if (file_exists($dearchTempDir)) {
        copy ('index.html', $dearchTempDir.'/index.html');
        if (!is_dir($dearchTempDir)) {
          mkdir ($dearchTempDir, 0755);  
        if (is_dir($dearchTempDir)) {
          $txt = ('OP-Act: Verified '.$dearchTempDir.' on '.$Time.'.');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
        // / The follwing code creates a dearchTempDir if one does not exist, and checks again.
        if (!is_dir($dearchTempDir)) {
          mkdir($dearchTempDir, 0755); 
          copy ('index.html', $dearchTempDir.'/index.html');
        if (is_dir($dearchTempDir)) {
          $txt = ('OP-Act: Created '.$dearchTempDir.' on '.$Time.'!');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } 
        // / The following double checks that all directories exist, and writes an error to the logfile if there are any.
        if (!is_dir($dearchTempDir)) {
          $txt = ('ERROR!!! HRC2390, Could not create a temp directory at '.$dearchTempDir.' on '.$Time.'!');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
          die($txt); } 
        if (!is_dir($dearchTempDir)) {
          $txt = ('ERROR!!! HRC2394, Could not create a temp directory at '.$dearchTempDir.' on '.$Time.'!');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
          die($txt); } }
      if (!file_exists($dearchTempDir)) {
        mkdir($dearchTempDir);
        copy ('index.html', $dearchTempDir.'/index.html');
        if (is_dir($dearchTempDir)) {
          $txt = ('OP-Act: Created '.$dearchTempDir.' on '.$Time.'.');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
        if (!is_dir($dearchTempDir)) {
          $txt = ('ERROR!!! HRC2404, Could not create a temp directory at '.$dearchTempDir.' on '.$Time.'!');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
      // / The following code creates all of the user directories and file copies needed for the operation.
      // / The following code is performed when a dearchUserDir already exists.
      if (file_exists($dearchUserDir)) {
        copy ('index.html', $dearchUserDir.'/index.html');
        if (!is_dir($dearchUserDir)) {
          mkdir ($dearchUserDir, 0755);  
        if (is_dir($dearchUserDir)) {
          $txt = ('OP-Act: Verified '.$dearchUserDir.' on '.$Time.'.');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
        // / The follwing code creates a dearchUserDir if one does not exist, and checks again.
        if (!is_dir($dearchUserDir)) {
          mkdir($dearchUserDir, 0755); 
          copy ('index.html', $dearchUserDir.'/index.html');
        if (is_dir($dearchUserDir)) {
          $txt = ('OP-Act: Created '.$dearchUserDir.' on '.$Time.'!');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } 
        // / The following double checks that all directories exist, and writes an error to the logfile if there are any.
        if (!is_dir($dearchUserDir)) {
          $txt = ('ERROR!!! HRC2390, Could not create a user directory at '.$dearchUserDir.' on '.$Time.'!');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
          die($txt); } }
      if (!file_exists($dearchUserDir)) {
        mkdir($dearchUserDir);
        copy ('index.html', $dearchUserDir.'/index.html');
        if (is_dir($dearchUserDir)) {
          $txt = ('OP-Act: Created '.$dearchUserDir.' on '.$Time.'.');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
        if (!is_dir($dearchUserDir)) {
          $txt = ('ERROR!!! HRC2404, Could not create a user directory at '.$dearchUserDir.' on '.$Time.'!');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
      // / The following code checks that the source files exist and are valid, and returns any errors that occur.
      if (file_exists($dearchUserDir)) {
        if (is_dir($dearchUserDir)) {
          copy ($dearchUserPath, $dearchTempPath);
          if (!file_exists($dearchTempPath)) {
            $txt = ('ERROR!!! HRC2412, There was a problem copying '.$dearchUserPath.' to '.$dearchTempPath.' on '.$Time.'.');
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
            die($txt); } 
          if (file_exists($dearchTempPath)) { 
            $txt = ('OP-Act, Copied '.$dearchUserPath.' to '.$dearchTempPath.' on '.$Time.'.');
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
            // / Check the Cloud Location with ClamAV before dearchiving, just in case.
            if ($VirusScan == '1') {
              shell_exec(str_replace('  ', ' ', str_replace('  ', ' ', 'clamscan -r '.$Thorough.' '.$dearchTempPath.' | grep FOUND >> '.$ClamLogDir)));
              $ClamLogFileDATA = file_get_contents($ClamLogDir);
              if (strpos($ClamLogFileDATA, 'Virus Detected') == 'true' or strpos($ClamLogFileDATA, 'FOUND') == 'true') {
                $txt = ('WARNING HRC2338, There were potentially infected files detected. The file
                  transfer could not be completed at this time. Please check your file for viruses or
                  try again later.'."\n");
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);          
                unlink($dearchTempPath);
                die($txt); } } } }
        if (!is_dir($dearchUserDir)) {
          $txt = ('ERROR!!! HRC2419, Discrepency detected! The dearchive directory supplied is not a directory on '.$Time.'!');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
      if (!file_exists($dearchUserDir)) {
          mkdir($dearchUserDir, 0755); 
          if (file_exists($dearchUserDir)) {
            $txt = ('OP-Act: Created '.$dearchUserDir.' on '.$Time.'.');
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
            die($txt); }
          if (!file_exists($dearchUserDir)) {
            $txt = ('ERROR!!! HRC2428, The dearchive directory was not detected on '.$Time.'!');
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
            die($txt); } }
      // / Handle dearchiving of rar compatible files.
      if(in_array($ext,$rararr)) {
        $txt = ('OP-Act: Executing "unrar e '.$dearchTempPath.' '.$dearchUserDir.'" on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
        shell_exec('unrar e '.$dearchTempPath.' '.$dearchUserDir);
        if (file_exists($dearchUserDir)) {
          $txt = ('OP-Act: '."Dearchived $dearchTempPath to $dearchUserDir using method 1 on $Time".'.'); 
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
      // / Handle dearchiving of .zip compatible files.
      if(in_array($ext,$ziparr)) {
        $txt = ('OP-Act: Executing "unzip -o '.$dearchTempPath.' -d '.$dearchUserDir.'" on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
        shell_exec('unzip -o '.$dearchTempPath.' -d '.$dearchUserDir);
        if (file_exists($dearchUserDir)) {
          $txt = ('OP-Act: '."Dearchived $dearchTempPath to $dearchUserDir using method 2 on $Time".'.'); 
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } 
      // / Handle dearchiving of 7zipper compatible files.
      if(in_array($ext,$tararr)) {
        $txt = ('OP-Act: Executing "7z e '.$dearchTempPath.' '.$dearchUserDir.'" on '.$Time.'.'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
        shell_exec('7z e '.$dearchTempPath.' '.$dearchUserDir); 
        if (file_exists($dearchUserDir)) {
          $txt = ('OP-Act: '."Dearchived $dearchTempPath to $dearchUserDir using method 3 on $Time".'.'); 
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } }
    if (file_exists($dearchUserDir)) {
      $dearchFiles = scandir($dearchUserDir);
      foreach ($dearchFiles as $dearchFile) {
        $DangerousFiles = array('js', 'php', 'html', 'css');
        $dearchFileLoc = $dearchUserDir.'/'.$dearchFile;
        $ext = pathinfo($dearchFileLoc, PATHINFO_EXTENSION);
        if (in_array($ext, $DangerousFiles) && $dearchFile !== 'index.html') {
          unlink($dearchFileLoc);
          $txt = ('ERROR!!! HRC2568, Unsupported file format, '.$ext.' on '.$Time."\n".'--------------------'."\n"); 
          echo nl2br ('ERROR!!! HRC2568, Unsupported file format, '.$ext.' on '.$Time."\n".'--------------------'."\n"); 
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } }
    // / Return an error if the extraction failed and no files were created.
    if (!file_exists($dearchUserDir)) {
      $txt = ('ERROR!!! HRC2449, There was a problem creating '.$dearchUserDir.' on '.$Time."\n".'--------------------'."\n"); 
      echo nl2br ('ERROR!!! HRC2449, There was a problem creating '.$dearchUserDir.' on '.$Time."\n".'--------------------'."\n"); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user selects files to convert to other formats.
if (isset( $_POST['convertSelected'])) {
  $txt = ('OP-Act: Initiated HRConvert2 on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  $_POST['convertSelected'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['convertSelected']);
  if (!is_array($_POST['convertSelected'])) {
    $_POST['convertSelected'] = array($_POST['convertSelected']); } 
  foreach ($_POST['convertSelected'] as $key => $file) {
    $file = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $file); 
    $txt = ('OP-Act: User '.$UserID.' selected to Convert file '.$file.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    $allowed =  array('svg', 'dxf', 'vdx', 'fig', '3ds', 'obj', 'collada', 'off', 'ply', 'stl', 'ptx', 'dxf', 'u3d', 'vrml', 'mov', 'mp4', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'flac', 'aac', 'dat', 
      'cfg', 'txt', 'doc', 'docx', 'rtf' ,'xls', 'xlsx', 'ods', 'odf', 'odt', 'jpg', 'mp3', 'zip', 'rar', 'tar', 'tar.gz', 'tar.bz', 'tar.bZ2', '3gp', 'mkv', 'avi', 'mp4', 'flv', 'mpeg', 'wmv', 
      'avi', 'aac', 'mp2', 'wma', 'wav', 'ogg', 'jpeg', 'bmp', 'png', 'gif', 'pdf', 'abw', 'iso', 'vhd', 'vdi', 'pages', 'pptx', 'ppt', 'xps', 'potx', 'pot', 'ppa', 'ppa', 'odp');
    $file1 = str_replace('//', '/', $CloudUsrDir.$file);
    $file2 = str_replace('//', '/', $CloudTmpDir.$file);
    copy($file1, $file2); 
    if (file_exists($file2)) {
      $txt = ('OP-Act: '."Copied $file1 to $file2 on $Time".'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
    if (!file_exists($file2)) {
      $txt = ('ERROR!!! HRC2381, '."Could not copy $file1 to $file2 on $Time".'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      echo nl2br('ERROR!!! HRC2381, There was a problem copying your file between internal HRCloud directories.
        Please rename your file or try again later.'."\n");
      die(); }
    $convertcount = 0;
    $extension = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['extension']);
    $pathname = str_replace('//', '/', $CloudTmpDir.$file);
    $pathname = str_replace(' ', '\ ', $pathname);
    $oldPathname = str_replace('//', '/', $CloudUsrDir.$file);
    $filename = pathinfo($pathname, PATHINFO_FILENAME);
    $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
    $newFile = str_replace('//', '/', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['userconvertfilename'].'_'.$convertcount.'.'.$extension));
    $newPathname = str_replace('//', '/', $CloudUsrDir.$newFile);
    $docarray =  array('txt', 'doc', 'xls', 'xlsx', 'docx', 'rtf', 'odf', 'ods', 'odt', 'dat', 'cfg', 'pages', 'pptx', 'ppt', 'xps', 'potx', 'pot', 'ppa', 'odp', 'odf');
    $imgarray = array('jpg', 'jpeg', 'bmp', 'png', 'gif');
    $audioarray =  array('mp3', 'wma', 'wav', 'ogg', 'mp2', 'flac', 'aac');
    $videoarray =  array('3gp', 'mkv', 'avi', 'mp4', 'flv', 'mpeg', 'wmv');
    $modelarray = array('3ds', 'obj', 'collada', 'off', 'ply', 'stl', 'ptx', 'dxf', 'u3d', 'vrml');
    $drawingarray = array('xvg', 'dxf', 'vdx', 'fig');
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
    $stub = ('http://localhost/HRProprietary/HRClou2/DATA/');
    $newFileURL = $stub.$UserID.$UserDirPOST.$newFile;
    // / Code to increment the conversion in the event that an output file already exists.    
    while(file_exists($newPathname)) {
      $convertcount++;
      $newFile = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['userconvertfilename'].'_'.$convertcount.'.'.$extension);
      $newPathname = $CloudUsrDir.$newFile; }
          // / Code to convert document files.
          // / Note: Some servers may experience a delay between the script finishing and the
            // / converted file being placed into their Cloud drive. If your files do not immediately
            // / appear, simply refresh the page.
          if (in_array($oldExtension, $docarray)) {
          // / The following code performs several compatibility checks before copying or converting anything.
            if (file_exists('/usr/bin/unoconv')) {
              $txt = ('OP-Act: Verified the document conversion engine on '.$Time.'.');
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
            // / The following code checks to see if Unoconv is in memory.
              exec("pgrep soffice.bin", $DocEnginePID, $DocEngineStatus);
              if (count($DocEnginePID) < 1) {
                exec('/usr/bin/unoconv -l &', $DocEnginePID1); 
                $txt = ('OP-Act: Starting the document conversion engine (PID '.$DocEnginePID[1].') on '.$Time.'.');
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
                exec("pgrep soffice.bin", $DocEnginePID, $DocEngineStatus); } }
              if (!file_exists('/usr/bin/unoconv')) {
                $txt = ('ERROR!!! HRC2654 Could not verify the document conversion engine on '.$Time.'.');
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
                die($txt); }
            if (count($DocEnginePID) >= 1) {
              $txt = ('OP-Act, The document conversion engine PID is '.$DocEnginePID[1]);
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
              $txt = ("OP-Act, Executing \"unoconv -o $newPathname -f $extension $pathname\" on ".$Time.'.');
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);      
              exec("unoconv -o $newPathname -f $extension $pathname", $returnDATA); 
              if (!is_array($returnDATA)) {
                $txt = ('OP-Act, Unoconv returned '.$returnDATA.' on '.$Time.'.');
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
              if (is_array($returnDATA)) {
                $txt = ('OP-Act, Unoconv returned the following on '.$Time.':');
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }                
                foreach($returnDATA as $returnDATALINE) {
                  $txt = ($returnDATALINE);
                  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
            // / For some reason files take a moment to appear after being created with Unoconv.
            $stopper = 0;
            while(!file_exists($newPathname)) {
              exec("unoconv -o $newPathname -f $extension $pathname");
              $stopper++;
              if ($stopper == 10) {
                $txt = 'ERROR!!! HRC2425, The converter timed out while copying your file. ';
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
                die($txt); } } }
          // / Code to convert and manipulate image files.
          if (in_array($oldExtension, $imgarray)) {
            $height = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['height']);
            $height = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['width']);
            $_POST["rotate"] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['rotate']);
            $rotate = ('-rotate '.$_POST["rotate"]);
            $wxh = $width.'x'.$height;
            if ($wxh == '0x0' or $wxh =='x0' or $wxh == '0x' or $wxh == '0' or $wxh == '00' or $wxh == '' or $wxh == ' ') {       
              $txt = ("OP-Act, Executing \"convert -background none $pathname $rotate $newPathname\" on ".$Time.'.');
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
              shell_exec("convert -background none $pathname $rotate $newPathname"); } 
            else {
              $txt = ("OP-Act, Executing \"convert -background none -resize $wxh $rotate $pathname $newPathname\" on ".$Time.'.');
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
              shell_exec("convert -background none -resize $wxh $rotate $pathname $newPathname"); } }
          // / Code to convert and manipulate 3d model files.
          if (in_array($oldExtension, $modelarray)) { 
            $txt = ("OP-Act, Executing \"meshlabserver -i $pathname -o $newPathname\" on ".$Time.'.');
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
            shell_exec("meshlabserver -i $pathname -o $newPathname"); } 
          // / Code to convert and manipulate drawing files.
          if (in_array($oldExtension, $drawingarray)) { 
            $txt = ("OP-Act, Executing \"dia $pathname -e $newPathname\" on ".$Time.'.');
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
            shell_exec("dia $pathname -e $newPathname"); } 
          // / Code to convert and manipulate video files.
          if (in_array($oldExtension, $videoarray)) { 
            $txt = ("OP-Act, Executing \"HandBrakeCLI -i $pathname -o $newPathname\" on ".$Time.'.');
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
            shell_exec("HandBrakeCLI -i $pathname -o $newPathname"); } 
          // / Code to convert and manipulate audio files.
          if (in_array($oldExtension, $audioarray)) { 
            $ext = (' -f ' . $extension);
              if (isset($_POST['bitrate'])) {
                $bitrate = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['bitrate']); }
              if (!isset($_POST['bitrate'])) {
                $bitrate = 'auto'; }                  
            if ($bitrate = 'auto') {
              $br = ' '; } 
            elseif ($bitrate != 'auto' ) {
              $br = (' -ab ' . $bitrate . ' '); } 
              $txt = ("OP-Act, Executing \"ffmpeg -i $pathname$ext$br$newPathname\" on ".$Time.'.');
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
            shell_exec("ffmpeg -y -i $pathname$ext$br$newPathname"); } 
          // / Code to detect and extract an archive, and then re-archive the extracted
            // / files using a different method.
          if (in_array($oldExtension, $archarray)) {
            $safedir1 = $CloudTmpDir;
            $safedirTEMP = $CloudTmpDir.$filename;
            $safedirTEMP2 = pathinfo($safedirTEMP, PATHINFO_EXTENSION);
            $safedirTEMP3 = $CloudTmpDir.pathinfo($safedirTEMP, PATHINFO_BASENAME);            
            $safedir2 = $CloudTmpDir.$safedirTEMP3;
            mkdir("$safedir2", 0755);
            $safedir3 = ($safedir2.'.7z');
            $safedir4 = ($safedir2.'.zip');
          if(in_array($oldExtension, $arrayzipo)) {
            shell_exec("unzip $pathname -d $safedir2"); } 
          if(in_array($oldExtension, $array7zo)) {
            shell_exec("7z e $pathname -o$safedir2"); } 
          if(in_array($oldExtension, $array7zo2)) {
            shell_exec("7z e $pathname -o$safedir2"); } 
          if(in_array($oldExtension, $arrayraro)) {
            shell_exec("unrar e $pathname $safedir2"); } 
          if(in_array($oldExtension, $arraytaro)) {
            shell_exec("7z e $pathname -o$safedir2"); } 
            if (in_array($extension,$array7zo)) {
              shell_exec("7z a -t$extension $safedir3 $safedir2");
              copy($safedir3, $newPathname); } 
            if (file_exists($safedir3)) {
              @chmod($safedir3, 0755); 
              @unlink($safedir3);
              $delFiles = glob($safedir2 . '/*');
               foreach($delFiles as $delFile) {
                if(is_file($delFile) ) {
                  @chmod($delFile, 0755);  
                  @unlink($delFile); }
                elseif(is_dir($delFile) ) {
                  @chmod($delFile, 0755);
                  @rmdir($delFile); } }    
                  @rmdir($safedir2); }
            elseif (in_array($extension,$arrayzipo)) {
              shell_exec("zip -r -j $safedir4 $safedir2");
              @copy($safedir4, $newPathname); } 
              if (file_exists($safedir4)) {
                @chmod($safedir4, 0755); 
                @unlink($safedir4);
                $delFiles = glob($safedir2 . '/*');
                  foreach($delFiles as $delFile){
                    if(is_file($delFile)) {
                      @chmod($delFile, 0755);  
                      @unlink($delFile); }
                    elseif(is_dir($delFile)) {
                      @chmod($delFile, 0755);
                      @rmdir($delFile); } }    
                      @rmdir($safedir2); }
                    elseif (in_array($extension, $arraytaro)) {
                      shell_exec("tar czf $newPathname $safedir2");
                      $delFiles = glob($safedir2 . '/*');
                    foreach($delFiles as $delFile){
                      if(is_file($delFile)) {
                        @chmod($delFile, 0755);  
                        @unlink($delFile); }
                      elseif(is_dir($delFile)) {
                        @chmod($delFile, 0755);
                        @rmdir($delFile); } }     
                        @rmdir($safedir2); } 
                      elseif(in_array($extension, $arrayraro)) {
                        shell_exec("rar a -ep ".$newPathname.' '.$safedir2);
                        $delFiles = glob($safedir2 . '/*');
                          foreach($delFiles as $delFile){
                            if(is_file($delFile)) {
                              @chmod($delFile, 0755);  
                              unlink($delFile); }
                            elseif(is_dir($delFile) ) {
                              @chmod($delFile, 0755);
                              @rmdir($delFile); } } 
                              @rmdir($safedir2); } }
// / Error handler and logger for converting files.
if (!file_exists($newPathname)) {
  echo nl2br('ERROR!!! HRC2524, There was an error during the file conversion process and your file was not copied.'."\n");
  $txt = ('ERROR!!! HRC2524, '."Conversion failed! $newPathname could not be created from $oldPathname".'!');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  die(); } 
if (file_exists($newPathname)) {
  $txt = ('OP-Act: File '.$newPathname.' was created on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects a document or PDF for manipulation.
if (isset($_POST['pdfworkSelected'])) {
  $_POST['pdfworkSelected'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['pdfworkSelected']);
  $txt = ('OP-Act: Initiated PDFWork on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    if (!is_array($_POST['pdfworkSelected'])) {
      $_POST['pdfworkSelected'] = array($_POST['pdfworkSelected']); } 
  $pdfworkcount = '0';
  foreach ($_POST['pdfworkSelected'] as $key=>$file) {
    $file = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $file);
    $txt = ('OP-Act: User '.$UserID.' selected to PDFWork file '.$file.' on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    $allowedPDFw =  array('txt', 'doc', 'docx', 'rtf' ,'xls', 'xlsx', 'ods', 'odf', 'odt', 'jpg', 'jpeg', 'bmp', 'png', 'gif', 'pdf', 'abw');
    $file1 = $CloudUsrDir.$file;
    $file2 = $CloudTmpDir.$file;
    copy($file1, $file2); 
    if (file_exists($file2)) {
      $txt = ('OP-Act: '."Copied $file1 to $file2 on $Time".'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
    if (!file_exists($file2)) {
      $txt = ('ERROR!!! HRC2551, '."Could not copy $file1 to $file2 on $Time".'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      echo nl2br('ERROR!!! HRC2551, There was a problem copying your file between internal HRCloud directories.
        Please rename your file or try again later.'."\n");
      die(); }
    // / If no output format is selected the default of PDF is used instead.
    if (isset($_POST['pdfextension'])) {
      $extension = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['pdfextension']); } 
    if (!isset($_POST['pdfextension'])) {
      $extension = 'pdf'; }
    $pathname = str_replace('//', '/', $CloudTmpDir.$file); 
    $pathname = str_replace(' ', '\ ', $pathname);
    $oldPathname = str_replace('//', '/', $CloudUsrDir.$file);
    $filename = pathinfo($pathname, PATHINFO_FILENAME);
    $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
    $newFile = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['userpdfconvertfilename'].'_'.$pdfworkcount.'.'.$extension);
    $newPathname = str_replace('//', '/', $CloudUsrDir.$newFile);
    $doc1array =  array('txt', 'pages', 'doc', 'xls', 'xlsx', 'docx', 'rtf', 'odf', 'ods', 'odt');
    $img1array = array('jpg', 'jpeg', 'bmp', 'png', 'gif');
    $pdf1array = array('pdf');
    $stub = ($URL.'/HRProprietary/HRCloud2/DATA/');
    $newFileURL = $stub.$UserID.$UserDirPOST.$newFile;
      if (in_array($oldExtension, $allowedPDFw)) {
        while(file_exists($newPathname)) {
          $pdfworkcount++; 
          $newFile = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['userpdfconvertfilename'].'_'.$pdfworkcount.'.'.$extension);
          $newPathname = str_replace('//', '/', $CloudUsrDir.$newFile); } } 
          // / Code to convert a PDF to a document.
          if (in_array($oldExtension, $pdf1array)) {
            if (in_array($extension, $doc1array)) {
              $pathnameTEMP = str_replace('.'.$oldExtension, '.txt', $pathname);
    
            $_POST['method'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['method']);
              if ($_POST['method1'] == '0' or $_POST['method1'] == '') {
                shell_exec("pdftotext -layout $pathname $pathnameTEMP"); 
                $txt = ('OP-Act: '."Converted $pathnameTEMP1 to $pathnameTEMP on $Time".' using method 0.'); 
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
                if ((!file_exists($pathnameTEMP) or filesize($pathnameTEMP) < '5')) { 
                  $txt = ('Warning!!! HRC2591, There was a problem using the selected method to convert your file. Switching to 
                    automatic method and retrying the conversion.'."\n"); 
                  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
                  echo nl2br('Warning!!! HRC2591, There was a problem using the selected method to convert your file. Switching to 
                    automatic method and retrying the conversion on '.$Time.'.'."\n");
                  $_POST['method1'] = '1'; 
                  $txt = ('Notice!!! HRC2601, Attempting PDFWork conversion "method 2" on '.$Time.'.'."\n"); 
                  echo ($txt."\n".'--------------------'."\n"); 
                  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }          
              
              if ($_POST['method1'] == '1') {
                $pathnameTEMP1 = str_replace('.'.$oldExtension, '.jpg' , $pathname);
                shell_exec("convert $pathname $pathnameTEMP1");
                if (!file_exists($pathnameTEMP1)) {
                  $PagedFilesArrRAW = scandir($CloudTmpDir);
                  foreach ($PagedFilesArrRAW as $PagedFile) {
                    $pathnameTEMP1 = str_replace('.'.$oldExtension, '.jpg' , $pathname);
                    if ($PagedFile == '.' or $PagedFile == '..' or $PagedFile == '.AppData' or $PagedFile == 'index.html') continue;
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
                      shell_exec("tesseract $pathnameTEMP1 $pathnameTEMPTesseract");
                      $READPAGEDATA = file_get_contents($pathnameTEMP);
                      $WRITEDOCUMENT = file_put_contents($pathnameTEMP0, $READPAGEDATA.PHP_EOL, FILE_APPEND);
                      $multiple = '1'; 
                      $txt = ('OP-Act: '."Converted $pathnameTEMP1 to $pathnameTEMP on $Time".' using method 1.'); 
                      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
                      $pathnameTEMP = $pathnameTEMP0;
                      if (!file_exists($pathnameTEMP0)) {
                        $txt = ('ERROR!!! HRC2617, HRC2610, $pathnameTEMP0 does not exist on '.$Time.'.'."\n"); 
                        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);   
                        echo ($txt."\n".'--------------------'."\n"); } } } }
                    if ($multiple !== '1') {
                    $pathnameTEMPTesseract = str_replace('.'.$txt, '', $pathnameTEMP);
                    shell_exec("tesseract $pathnameTEMP1 $pathnameTEMPTesseract");
                    $txt = ('OP-Act: '."Converted $pathnameTEMP1 to $pathnameTEMP on $Time".' using method 1.'); 
                    echo ($txt."\n".'--------------------'."\n");    
                    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } } } 
            // / Code to convert a document to a PDF.
            if (in_array($oldExtension, $doc1array)) {                
              if (in_array($extension, $pdf1array)) {
                system("/usr/bin/unoconv -o $newPathname -f pdf $pathname"); 
                $txt = ('OP-Act: '."Converted $pathname to $newPathname on $Time".' using method 2.'); 
                echo ('OP-Act: '."Performed PDFWork on $Time".' using method 2.'."\n".'--------------------'."\n"); 
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } 
          // / Code to convert an image to a PDF.
          if (in_array($oldExtension, $img1array)) {
            $pathnameTEMP = str_replace('.'.$oldExtension, '.txt' , $pathname);
            $pathnameTEMPTesseract = str_replace('.'.$oldExtension, '', $pathname);
            $imgmethod = '1';
            shell_exec("tesseract $pathname $pathnameTEMPTesseract"); 
            if (!file_exists($pathnameTEMP)) {
              $imgmethod = '2';
              $pathnameTEMP3 = str_replace('.'.$oldExtension, '.pdf' , $pathname);
              system("/usr/bin/unoconv -o $pathnameTEMP3 -f pdf $pathname");
              shell_exec("pdftotext -layout $pathnameTEMP3 $pathnameTEMP"); } 
            if (file_exists($pathnameTEMP)) {
              $txt = ('OP-Act: '."Converted $pathname to $pathnameTEMP1 on $Time".' using method '.$imgmethod.'.'); 
              echo('OP-Act: '."Performed PDFWork on $Time".' using method '.$imgmethod.'.'."\n".'--------------------'."\n");
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
            if (!file_exists($pathnameTEMP)) {
              $txt = ('ERROR!!! HRC2667, '."An internal error occured converting $pathname to $pathnameTEMP1 on $Time".' using method '.$imgmethod.'.'); 
              echo('ERROR!!! HRC2667, '."An internal error occured your file on $Time".' using method '.$imgmethod.'.'."\n".'--------------------'."\n");
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
          // / If the output file is a txt file we leave it as-is.
        if (!file_exists($newPathname)) {                    
          if ($extension == 'txt') { 
            if (file_exists($pathnameTEMP)) {
              rename($pathnameTEMP, $newPathname); 
              $txt = ('OP-Act: HRC2613, '."Renamed $pathnameTEMP to $pathname on $Time".'.'); 
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
          // / If the output file is not a txt file we convert it with Unoconv.
          if ($extension !== 'txt') {
            system("/usr/bin/unoconv -o $newPathname -f $extension $pathnameTEMP");
            $txt = ('OP-Act: '."Converted $pathnameTEMP to $newPathname on $Time".'.'); 
            echo nl2br('OP-Act: '."Performing finishing touches on $Time".'.');
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
        // / Error handler for if the output file does not exist.
        if (!file_exists($newPathname)) {
          echo nl2br('ERROR!!! HRC2620, There was a problem converting your file! Please rename your file or try again later.'."\n".'--------------------'."\n"); 
          $txt = ('ERROR!!! HRC2620, '."Could not convert $pathname to $newPathname on $Time".'!'); 
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
           die(); } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will be performed when a user selects files to stream. (for you, Emily...)
if (isset($_POST['streamSelected'])) {
  // / Define the and sanitize global .Playlist environment variables.
  $getID3File = $InstLoc.'/Applications/getid3/getid3/getid3.php';
  $PlaylistName = str_replace(str_split('.\\/[]{};:>$#!&* <'), '', ($_POST['playlistname']));
  $PLVideoArr =  array('avi', 'mov', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp');    
  $PLVideoArr2 =  array('avi', 'mov', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'mp4');    
  $PLMediaArr =  array('mp2', 'mp3', 'wma', 'wav', 'aac', 'flac', 'ogg', 'avi', 'aac', 'mov', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'mp4');
  $PLAudioArr =  array('mp2', 'mp3', 'wma', 'wav', 'aac', 'flac');
  $PLAudioOGGArr =  array('ogg');
  $PLAudioMP4Arr =  array('mp4');
  $PLVideoMP4Arr =  array('mp4');
  $MediaFileCount = 0;
  $VideoFileCount = 0;
  // / Define temp .Playlist environment variables.
  $PlaylistTmpDir = $CloudTmpDir.'/'.$PlaylistName.'.Playlist';
  $playlistDir = $CloudUsrDir.'/'.$PlaylistName.'.Playlist'; 
  $playlistCacheDir = $playlistDir.'/.Cache';
  $PlaylistCacheFile = $playlistCacheDir.'/cache.php'; 
  // / Write the first Playlist entry to the user's logfile.
  $txt = ('OP-Act: Initiated .Playlist creation on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  require($getID3File);
  // / The following code creates the .Playlist directory as well as the .Cache directory and cache files.
  if (!file_exists($PlaylistCacheFile)) {
    mkdir($playlistDir, 0755);
    copy($InstLoc.'/index.html', $playlistDir.'/index.html');
    mkdir($playlistCacheDir, 0755); 
    copy($InstLoc.'/index.html', $playlistCacheDir.'/index.html');
    $txt = ('OP-Act: Created a playlist cache file on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (strpos($PlaylistCacheDir, '.Playlist') == 'false' or file_exists($PlaylistCacheDir)) {
    $txt = ('ERROR!!! HRC2746, There was a problem verifying the '.$PlaylistDir.' on '.$Time.'!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    die($txt); } 
  if (!is_array($_POST['streamSelected'])) {
    $_POST['streamSelected'] = array($_POST['streamSelected']); } 
  foreach (($_POST['streamSelected']) as $MediaFile) {
    // / The following code will only create cache data if the $MediaFile is in the $PLMediaArr.     
    $pathname = str_replace('//', '/', $CloudUsrDir.$MediaFile);
    $pathname = str_replace(' ', '\ ', $pathname);
    $Scanfilename = pathinfo($pathname, PATHINFO_FILENAME);
    $ScanoldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
    $txt = ('OP-Act: Detected a '.$ScanoldExtension.' named '.$MediaFile.' on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
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
      if(isset($id3Tags['id3v2']['APIC'][0]['data']) && $id3Tags['id3v2']['APIC'][0]['data'] !== '') {
        $PLSongImage = 'data:'.$id3Tags['id3v2']['APIC'][0]['image_mime'].';charset=utf-8;base64,'.base64_encode($id3Tags['id3v2']['APIC'][0]['data']); } 
        $PLSongImageDATA = $id3Tags['id3v2']['APIC'][0]['data'];
        $SongImageFile = $CloudUsrDir.'/'.$PlaylistName.'.Playlist/.Cache/'.$MediaFileCount.'.jpg';
        $fo1 = fopen($SongImageFile, 'w');
        $MAKECacheImageFile = file_put_contents($SongImageFile, $PLSongImageDATA);
        fclose($fo1);
        $SongImageFile2 = $CloudTmpDir.'/'.$PlaylistName.'.Playlist/.Cache/'.$MediaFileCount.'.jpg';
        $fo2 = fopen($SongImageFile2, 'w');
        $MAKECacheImageFileRAW = file_put_contents($SongImageFile2, $PLSongImageDATA);
        fclose($fo2);
        $SongImageFileRAW = $CloudUsrDir.'/'.$PlaylistName.'.Playlist/.Cache/'.$MediaFileCount.'.txt';
        $fo3 = fopen($SongImageFileRAW, 'w');
        $MAKECacheImageFileRAW = file_put_contents($SongImageFileRAW, $PLSongImageDATA);                   
        fclose($fo3);
        $SongImageFile2RAW = $CloudTmpDir.'/'.$PlaylistName.'.Playlist/.Cache/'.$MediaFileCount.'.txt';
        $fo4 = fopen($SongImageFile2, 'w');
        $MAKECacheImageFile2 = file_put_contents($SongImageFile2, $PLSongImageDATA);
        fclose($fo4);
      if(!isset($id3Tags['id3v2']['APIC'][0]['data']) or $id3Tags['id3v2']['APIC'][0]['data'] == '') {
        $PLSongImage = ''; } } }
  // / The following code converts the selected media files to device friendly formats and places them into the playlist directory.
  foreach (($_POST['streamSelected']) as $StreamFile) {
    $txt = ('OP-Act: Initiated Streamer on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    $pathname = str_replace('//', '/', $CloudTmpDir.'/'.$StreamFile);
    $pathname = str_replace(' ', '\ ', $pathname);
    $oldPathname = str_replace('//', '/', $CloudUsrDir.$StreamFile);
    copy ($oldPathname, $pathname);
    if ($StreamFile == '.' or $StreamFile == '..' or is_dir($pathname) or is_dir($oldPathname)) continue;
      $txt = ('OP-Act: User '.$UserID.' selected to StreamFile '.$StreamFile.' from CLOUD.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      $filename = pathinfo($pathname, PATHINFO_FILENAME);
      $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
        if (in_array($oldExtension, $PLAudioArr)) {
          $ext = (' -f ' . 'ogg');
          $bitrate = 'auto';                 
          if ($bitrate = 'auto' ) {
            $br = ' '; } 
          elseif ($bitrate != 'auto' ) {
            $br = (' -ab ' . $bitrate . ' '); }
          $pathname = str_replace('//', '/', $CloudUsrDir.$StreamFile);
          $newPathname = str_replace('//', '/', $playlistDir.'/'.$filename.'.ogg');
          $txt = ("OP-Act, Executing ffmpeg -i $pathname$ext$br$newPathname on ".$Time.'.');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
          shell_exec("ffmpeg -i $pathname$ext$br$newPathname"); }  
        if (in_array($oldExtension, $PLAudioOGGArr)) {
          copy ($oldPathname, str_replace('//', '/', $playlistDir.'/'.$StreamFile)); } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user selects files to share.
  if (isset($_POST['shareConfirm'])) {
    $CloudShareDir = $InstLoc.'/DATA/'.$UserID.'/.AppData/Shared';
    $txt = ('OP-Act: Initiated Share on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    $_POST['shareConfirm'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['shareConfirm']);
    if (!is_array($_POST["filesToShare"])) {
      $_POST['filesToShare'] = array(str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToShare'])); }
    foreach ($_POST['filesToShare'] as $FTS) {
      $FTS = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $FTS);
      $copySrc = str_replace('//', '/', $CloudUsrDir.$FTS);
      $copyDst = str_replace('//', '/', $CloudShareDir.'/'.$FTS);
      copy($copySrc, $copyDst); 
      if (file_exists($CloudShareDir.'/'.$FTS)) {
        $txt = ('OP-Act: Shared '.$FTS.' on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
      if (!file_exists($CloudShareDir.'/'.$FTS)) {
        $txt = ('ERROR!!! HRC2862, Could not share '.$FTS.' on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user selects files to unshare.
  if (isset($_POST['unshareConfirm'])) {
    $CloudShareDir = $InstLoc.'/DATA/'.$UserID.'/.AppData/Shared';
    $CloudShareDir2 = $CloudDir.'/.AppData/Shared';
    $txt = ('OP-Act: Initiated UnShare on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    $_POST['unshareConfirm'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['unshareConfirm']);
  if (isset($_POST["filesToUnShare"])) {
    if (!is_array($_POST["filesToUnShare"])) {
      $_POST['filesToUnShare'] = array(str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToUnShare'])); }
    foreach ($_POST['filesToUnShare'] as $FTS) {
      $FTS = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $FTS);
      @unlink($CloudShareDir.'/'.$FTS);
      @unlink($CloudShareDir2.'/'.$FTS);
      if (!file_exists($CloudShareDir.'/'.$FTS) && !file_exists($CloudShareDir2.'/'.$FTS)) {
        $txt = ('OP-Act: UnShared '.$FTS.' on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
      if (file_exists($CloudShareDir.'/'.$FTS) or file_exists($CloudShareDir2.'/'.$FTS)) {
        $txt = ('ERROR!!! HRC2862, Could not UnShare '.$FTS.' on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code controls the creation and management of a users clipboard cache file.
if (isset($_POST['clipboardCopy'])) {
  if (!is_array($_POST['clipboardSelected'])) {
    $_POST['clipboardSelected'] = array($_POST['clipboardSelected']); } 
  $UserClipboard = $InstLoc.'/DATA/'.$UserID.'/.AppData/.clipboard.php'; 
  include($UserClipboard);
  $clipboard = str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['clipboard']));
  $txt = ('OP-Act: Initiated Clipboard on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  $txt = '';
  $MAKEClipboardFile = file_put_contents($UserClipboard, $txt.PHP_EOL, FILE_APPEND); 
  $copyCounter = 0;
  if (isset($_POST['clipboardCopy'])) {
    $_POST['clipboardCopy'] = str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['clipboardCopy']));
    if (!isset($_POST['clipboardSelected'])) {
      $txt = ('ERROR!!! HRC21018, No file selected on '.$Time.'!');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      die($txt); }
    foreach ($_POST['clipboardSelected'] as $clipboardSelected) {
      $clipboardSelected = str_replace(str_split('\\/[]{};:>$#!&* <'), '', $clipboardSelected);
      $CopyDir = str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['clipboardCopyDir'])); 
      if ($CopyDir !== '') {
        $CopyDir = $CopyDir.'/'; }
      $txt = ('OP-Act: User selected to Copy "'.$clipboardSelected.'" to Clipboard on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      if ($copyCounter == 0) {
        $clipboardArray = '<?php $clipboardSelected = array(\''.$CopyDir.$clipboardSelected.'\'';
        $MAKEClipboardFile = file_put_contents($UserClipboard, $clipboardArray.PHP_EOL, FILE_APPEND); } 
      if ($copyCounter > 0) { 
        $clipboardArray = ', \''.$CopyDir.$clipboardSelected.'\'';
        $MAKEClipboardFile = file_put_contents($UserClipboard, $clipboardArray.PHP_EOL, FILE_APPEND); }
      $copyCounter++; } 
    $clipboardArray = '); ?>';
    $MAKEClipboardFile = file_put_contents($UserClipboard, $clipboardArray.PHP_EOL, FILE_APPEND); } }
  if (isset($_POST['clipboardPaste'])) {
    $_POST['clipboardPaste'] = str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['clipboardPaste']));
    if (!isset($_POST['clipboardPasteDir'])) {
      $txt = ('ERROR!!! HRC21018, No file selected on '.$Time.'!');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      die($txt); }
    $UserClipboard = $InstLoc.'/DATA/'.$UserID.'/.AppData/.clipboard.php';
    require ($UserClipboard);
    $txt = ('OP-Act: Initiated Clipboard on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    $PasteDir = (str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['clipboardPasteDir'])).'/');   
    $txt = ('OP-Act: User selected to Paste files from Clipboard to '.$PasteDir.' on '.$Time.'.');
    echo nl2br($txt);
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    foreach ($clipboardSelected as $clipboardSelected1) {
      if (!file_exists($CloudDir.'/'.$clipboardSelected1)) { 
        $txt = 'ERROR!!! HRC2937, No file exists while copying '.$clipboardSelected1.' to '.$PasteDir.' on '.$Time.'.';
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        echo nl2br($txt."\n"); }
      if (file_exists($CloudDir.'/'.$clipboardSelected1)) { 
        if (is_file($CloudDir.'/'.$clipboardSelected1)) {
          copy($CloudDir.'/'.$clipboardSelected1, $CloudDir.'/'.$PasteDir.$clipboardSelected1); 
          $txt = 'OP-Act: Copied '.$clipboardSelected1.' to '.$PasteDir.' on '.$Time.'.';
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
          if (!file_exists($CloudDir.'/'.$clipboardSelected1)) { 
            $txt = 'ERROR!!! HRC2945, There was a problem copying '.$CloudDir.'/'.$clipboardSelected1.' to '.$PasteDir.' on '.$Time.'.';
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
            echo nl2br($txt."\n"); } }
        if (is_dir($CloudDir.'/'.$clipboardSelected1)) {
        } } } }

// / -----------------------------------------------------------------------------------
// / Code to search a users Cloud Drive and return the results.
if (isset($_POST['search'])) { 
  $txt = ('OP-Act: '."User initiated Cloud Search on $Time".'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); ?>
  <div align="center"><h3>Search Results</h3></div>
  <hr />
  <?php
  $SearchRAW = $_POST['search'];
  $txt = ('OP-Act: Raw user input is "'.$SearchRAW.'" on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  $searchRAW = str_replace(str_split('\\/[]{};:!$#&@>*<'), '', $searchRAW);
  $txt = ('OP-Act: Sanitized user input is "'.$SearchRAW.'" on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
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
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
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
                  @mkdir($F3.DIRECTORY_SEPARATOR.$iterator->getSubPathName()); }   
                else {
                  @copy($item, $F3.DIRECTORY_SEPARATOR.$iterator->getSubPathName()); } } 
          $ResultURL = 'cloudCore.php?UserDirPOST='.$ResultFile0 ; }
        if (!is_dir($ResultFile)) {  
          @copy($ResultFile, $ResultTmpFile); } 
          ?><a href='<?php echo ($ResultURL); ?>'><?php echo nl2br($ResultFile0."\n"); ?></a>
          <hr /><?php } } 
  echo nl2br('Searched '.$PendingResCount1.' files for "'.$SearchRAW.'" and found '.$PendingResCount2.' results on '.$Time.'.'); 
  $txt = ('OP-ACT, Searched '.$PendingResCount1.' files for "'.$SearchRAW.'" and found '.$PendingResCount2.' results on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } ?>
  <br>
  <div align="center"><a href="#" onclick="goBack();">&#8592; Go Back</a></div>
  <hr />
<?php }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code handles which UI will be displayed for the selected operation.
if (isset($_GET['playlistSelected']) or isset($_POST['playlistSelected'])) {
  include($InstLoc.'/Applications/HRStreamer/HRStreamer.php'); 
  die(); } 
require($InstLoc.'/Applications/displaydirectorycontents_72716/index.php'); 
// / -----------------------------------------------------------------------------------
?>