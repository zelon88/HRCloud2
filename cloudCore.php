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
// / ClamAV, Tesseract, Rar, Unrar, Unzip, 7zipper, FFMPEG, PDF2TXT, and ImageMagick.
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will check for and initialize required HRCloud2 Core files.
if (!file_exists(realpath(dirname(__FILE__)).'/commonCore.php')) die ('ERROR!!! HRC235, Cannot process the HRCloud2 Common Core file (commonCore.php).'.PHP_EOL); 
else require_once (realpath(dirname(__FILE__)).'/commonCore.php'); 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is perfomed whenever a user POSTs an input directory.
// / This code is also used in some cases to create intermediate directories that are required for delivering data to the user.
if (isset($MAKEUserDir)) { 
  $MAKEUserDir = ltrim($MAKEUserDir, '/');
  // / If no UserDir exists, silently create one.
  if (!file_exists($CloudDir.'/'.$MAKEUserDir)) { 
    @mkdir ($CloudDir.'/'.$MAKEUserDir, $CLPerms); 
    $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Created '.$CloudDir.'/'.$MAKEUserDir.' on '.$Time.'.'.PHP_EOL, FILE_APPEND); }
  // / If no CloudTempDir exists, silently create one.
  if (!file_exists($CloudTempDir.'/'.$MAKEUserDir)) { 
    @mkdir ($CloudTempDir.'/'.$MAKEUserDir, $CLPerms); 
    $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Created '.$CloudTempDir.'/'.$MAKEUserDir.' on '.$Time.'.'.PHP_EOL, FILE_APPEND); }
  // / The following code double checks that the specified directory were created and returns an error if it was not.
  // / If no UserDir exists, silently create one. 
  if (!file_exists($CloudDir.'/'.$MAKEUserDir)) $MAKELogFile = file_put_contents($LogFile, 'ERROR!!! HRC265, Could not create '.$CloudDir.'/'.$MAKEUserDir.' on '.$Time.'.'.PHP_EOL, FILE_APPEND); 
  // / If no CloudTempDir exists, silently create one.  
  if (!file_exists($CloudTempDir.'/'.$MAKEUserDir)) $MAKELogFile = file_put_contents($LogFile, 'ERROR!!! HRC273, Could not create '.$CloudTempDir.'/'.$MAKEUserDir.' on '.$Time.'.'.PHP_EOL, FILE_APPEND); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user initiates a file upload.
if(isset($upload)) {
  $_GET['UserDirPOST'] = htmlentities(str_replace(str_split('.[]{};:$!#^&%@>*<'), '', $_GET['UserDirPOST']), ENT_QUOTES, 'UTF-8');
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Initiated Uploader on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  if (!is_array($_FILES["filesToUpload"]['name'])) $_FILES["filesToUpload"]['name'] = array($_FILES["filesToUpload"]['name']);
  foreach ($_FILES['filesToUpload']['name'] as $key=>$file) {
    if ($file == '.' or $file == '..' or $file == 'index.html') continue;
    foreach ($DangerousFiles as $DangerousFile) { 
      if (strpos($file, $DangerousFile) !== FALSE) continue 2; }  
    $file = htmlentities(str_replace('..', '', str_replace(str_split('\\/[]{};:$!#^&%@>*<'), '', $file)), ENT_QUOTES, 'UTF-8'); 
    $F0 = pathinfo($file, PATHINFO_EXTENSION);
    if (in_array($F0, $DangerousFiles)) { 
      $txt = ("ERROR!!! HRC2103, Unsupported file format, $F0 on $Time.");
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      echo($txt.$br.$hr); 
      continue; }
    $F2 = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', pathinfo($file, PATHINFO_BASENAME))));
    $F3 = str_replace('..', '', str_replace(str_split('()|&'), '', str_replace('//', '/', str_replace('///', '/', $CloudUsrDir.$F2))));
    if($file == "") {
      $txt = ("ERROR!!! HRC2160, No file specified on $Time.");
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      echo($txt.$br.$hr); 
      continue; }
    $COPY_TEMP = @copy($_FILES['filesToUpload']['tmp_name'][$key], $F3);
    if (file_exists($F3)) { 
      $txt = ('OP-Act: Uploaded '.$file.' to '.str_replace('//', '/', $Udir.'/'.$file).' on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      echo($txt.$br.$hr); }
    if (!file_exists($F3)) { 
      $txt = ("ERROR!!! HRC289, Could not upload $F3 on $Time.");
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      echo($txt.$br.$hr); }
    @chmod($F3, $ILPerms); 
    // / The following code checks the Cloud Location with ClamAV after copying, just in case.
    if ($VirusScan == '1') {
      shell_exec(str_replace('  ', ' ', str_replace('  ', ' ', 'clamscan -r '.$Thorough.' '.$F3.' | grep FOUND >> '.$ClamLogDir)));
      $ClamLogFileDATA = @file_get_contents($ClamLogDir);
      if (strpos($ClamLogFileDATA, 'Virus Detected') !== FALSE or strpos($ClamLogFileDATA, 'FOUND') !== FALSE) {
        $txt = ('Warning!!! HRC2338, There were potentially infected files detected. The file
          transfer could not be completed at this time. Please check your file for viruses or
          try again later.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);          
        @unlink($F3);
        die($txt.$br.$hr); } } } 
  // / Free un-needed memory.
  $txt = $file = $F0 = $F2 = $F3 = $ClamLogFileDATA = $Upload = $MAKELogFile = null;
  unset($txt, $file, $F0, $F2, $F3, $ClamLogFileDATA, $Upload, $MAKELogFile); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user downloads a selection of files.
if (isset($download)) {
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Initiated Downloader on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  if (!is_array($_POST['filesToDownload'])) $_POST['filesToDownload'] = array($_POST['filesToDownload']); 
  foreach ($_POST['filesToDownload'] as $key=>$file) {
    $file = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $file))));
    if ($file == '.' or $file == '..' or $file == 'index.html') continue;
    foreach ($DangerousFiles as $DangerousFile) if (strpos($file, $DangerousFile) !== FALSE) continue 2; 
    $file1 = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', trim($file, '/'))));
    $file = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudUsrDir.$file)));
    if (!file_exists($file)) {
      $txt = ('ERROR!!! HRC2138, File '.$file.' doesn\'t exist on '.$Time.'!');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      echo($txt.$br.$hr); 
      continue; }
    $F2 = pathinfo($file, PATHINFO_BASENAME);
    $F3 = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudTmpDir.$F2)));
    if ($file == "") {
      $txt = ("ERROR!!! HRC2187, No file specified on $Time".'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      echo($txt.$br.$hr); 
      continue; }
    if (file_exists($F3)) @touch($F3); 
    if (!is_dir($file) or !file_exists($file)) { 
      $COPY_TEMP = symlink($file, $F3); 
      $txt = ('OP-Act: Submitted '.$file.' to '.$F3.' on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      echo($txt.$br.$hr); }
    if (is_dir($file)) { 
      mkdir($F3, $ILPerms);
      foreach ($iterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($file, \RecursiveDirectoryIterator::SKIP_DOTS),
        \RecursiveIteratorIterator::SELF_FIRST) as $item) {
        foreach ($DangerousFiles as $DangerousFile) { 
          if (strpos($item, $DangerousFile) !== FALSE) continue 2; } 
        $item = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $item)));
        $F4 = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $F3.DIRECTORY_SEPARATOR.$iterator->getSubPathName())));
        if (is_dir($item)) {
          @mkdir($F4); 
          $txt = ('OP-Act: Created '.$F4.' on '.$Time.'.');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
          echo($txt.$br.$hr); }   
        else {
          @symlink($item, $F4); 
          $txt = ('OP-Act: Submitted '.$item.' to '.$F4.' on '.$Time.'.');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
          echo($txt.$br.$hr); } } } } 
  // / Free un-needed memory.
  $txt = $_POST['filesToDownload'] = $key = $file = $file1 = $F2 = $F3 = $F4 = $COPY_TEMP = $iterator = $item = $MAKELogFile = null;
  unset($txt, $_POST['filesToDownload'], $key, $file, $file1, $F2, $F3, $F4, $COPY_TEMP, $iterator, $item, $MAKELogFile); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects a file to copy.
if (isset($_POST['copy'])) {
  $_POST['copy'] = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['copy']));
  $_POST['newcopyfilename'] = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['newcopyfilename']));
  $_POST['filesToCopy'] = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToCopy']));
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Initiated Copier on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  $_POST['copy'] = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['copy']));
  $copycount = 0;
  if (!is_array($_POST['filesToCopy'])) $_POST['filesToCopy'] = array($_POST['filesToCopy']); 
  foreach ($_POST['filesToCopy'] as $key=>$CFile) { 
    $CFile = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $CFile))));
    if ($CFile == '' or $CFile == null) continue; 
    foreach ($DangerousFiles as $DangerousFile) if (strpos($CFile, $DangerousFile) !== FALSE) continue 2; 
    $newCopyFilename = $_POST['newcopyfilename'];
    if ($newCopyFilename == '' or $newCopyFilename == null) continue;  
    $copycount++;
    if (isset($newCopyFilename)) {
      $cext = pathinfo($CloudUsrDir.$CFile, PATHINFO_EXTENSION);
      if ($copycount >= 2) $newCopyFilename = $newCopyFilename.'_'.$copycount; 
      $copySrc = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudUsrDir.$CFile)));
      $copyDst = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudUsrDir.$newCopyFilename.'.'.$cext)));
      if (file_exists($copySrc)) {
        // / The following code checks the Cloud Location with ClamAV before copying, just in case.
        if ($VirusScan == '1') {
          shell_exec(str_replace('  ', ' ', str_replace('  ', ' ', 'clamscan -r '.$Thorough.' '.$copySrc.' | grep FOUND >> '.$ClamLogDir)));
          $ClamLogFileDATA = file_get_contents($ClamLogDir);
          if (strpos($ClamLogFileDATA, 'Virus Detected') !== FALSE or strpos($ClamLogFileDATA, 'FOUND') !== FALSE) {
            $txt = ('Warning!!! HRC2338, There were potentially infected files detected. The file
              transfer could not be completed at this time. Please check your file for viruses or
              try again later.'."\n");
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);          
            die($txt.$br.$hr); } }
          // / Copy the files.
          copy($copySrc, $copyDst);
            $txt = ('OP-Act: '."Copied $CFile to $newCopyFilename".'.'."$cext on $Time".'.');
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
            echo($txt.$br.$hr); } } 
          if (!file_exists($copyDst)) { 
            $txt = ('ERROR!!! HRC2198, '."Could not copy $CFile to $newCopyFilename".'.'."$cext on $Time".'!');
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
            echo($txt.$br.$hr); 
            continue; } } 
  // / Free un-needed memory.
  $txt = $_POST['copy'] = $_POST['filesToCopy'] = $_POST['newcopyfilename'] = $copycount = $key = $CFile = $cext = $newCopyFilename = $copySrc = $copyDst = $ClamLogFileDATA = $MAKELogFile = null;
  unset($_POST['copy'], $_POST['filesToCopy'], $_POST['newcopyfilename'], $copycount, $key, $CFile, $cext, $newCopyFilename, $copySrc, $copyDst, $ClamLogFileDATA, $MAKELogFile); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects a file to rename.
if (isset($_POST['rename'])) {
  $_POST['rename'] = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['rename']));
  $_POST['renamefilename'] = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['renamefilename'])); 
  $_POST['filesToRename'] = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToRename']));
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Initiated Renamer on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  $rencount = 0;
  if (!is_array($_POST['filesToRename'])) $_POST['filesToRename'] = array($_POST['filesToRename']); 
  foreach ($_POST['filesToRename'] as $key=>$ReNFile) { 
    $ReNFile = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $ReNFile))));
    if ($ReNFile == '' or $ReNFile == null) continue;
    foreach ($DangerousFiles as $DangerousFile) if (strpos($ReNFile, $DangerousFile) !== FALSE) continue 2; 
    $renameFilename = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['renamefilename']))));
    if ($renameFilename == '' or $renameFilename == null) continue;    
    $rencount++;
    if (isset($renameFilename)) {
      $renext = pathinfo($CloudUsrDir.$ReNFile, PATHINFO_EXTENSION);
      if ($rencount >= 2) $renameFilename = $renameFilename.'_'.$rencount; 
      $renSrc = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudUsrDir.$ReNFile)));
      $renDst = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudUsrDir.$renameFilename.'.'.$renext)));
      if (file_exists($renSrc)) { 
        // / The following code checks the Cloud Location with ClamAV before copying, just in case.
        if ($VirusScan == '1') {
          shell_exec(str_replace('  ', ' ', str_replace('  ', ' ', 'clamscan -r '.$Thorough.' '.$renSrc.' | grep FOUND >> '.$ClamLogDir)));
          $ClamLogFileDATA = file_get_contents($ClamLogDir);
          if (strpos($ClamLogFileDATA, 'Virus Detected') !== FALSE or strpos($ClamLogFileDATA, 'FOUND') !== FALSE) {
            $txt = ('Warning!!! HRC2247, There were potentially infected files detected. The file
              transfer could not be completed at this time. Please check your file for viruses or
              try again later.'."\n");
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);          
            die($txt.$br.$hr); } }
          // / Rename the files.
          @rename($renSrc, $renDst);
            $txt = ('OP-Act: '."Renamed $ReNFile to $renameFilename".'.'."$renext on $Time".'.');
            echo($txt.$br.$hr);
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } 
          if (!file_exists($renDst)) { 
            $txt = ('ERROR!!! HRC2242, '."Could not rename $ReNFile to $renameFilename".'.'."$renext on $Time".'!');
            echo($txt.$br.$hr);
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
            continue; } } 
  // / Free un-needed memory.
  $_POST['rename'] = $txt = $_POST['filesToRename'] = $_POST['renamefilename'] = $rencount = $key = $ReNFile = $renameFilename = $renext = $renSrc = $renDst = $ClamLogFileDATA = $MAKELogFile = null;
  unset($_POST['rename'], $txt, $_POST['filesToRename'], $_POST['renamefilename'], $rencount, $key, $ReNFile, $renameFilename, $renExt, $renSrc, $renDst, $ClamLogFileDATA, $MAKELogFile); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects a file to delete.
if (isset($_POST['deleteconfirm'])) {
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Initiated Deleter on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  $_POST['deleteconfirm'] = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['deleteconfirm']))));
  if (!is_array($_POST['filesToDelete'])) {
    $_POST['filesToDelete'] = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToDelete']));
    $_POST['filesToDelete'] = array($_POST['filesToDelete']); }
  foreach ($_POST['filesToDelete'] as $key=>$DFile) { 
    $DFile = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $DFile))));
    if (is_dir($CloudUsrDir.$DFile)) {
      $objects = scandir(str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudUsrDir.$DFile)))); 
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
    $txt = ('OP-Act: '."Deleted $DFile from $Udir on $Time".'.');
    echo($txt.$br.$hr);   
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
  // / Free un-needed memory.
  $_POST['deleteconfirm'] = $txt = $_POST['filesToDelete'] = $key = $DFile = $objects = $object = $object2 = $MAKELogFile = null;
  unset($_POST['deleteconfirm'], $txt, $_POST['filesToDelete'], $key, $DFile, $objects, $object, $object2, $MAKELogFile); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user selects files for archiving.
if (isset($_POST['archive'])) {
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Initiated Archiver on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  $_POST['archive'] = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['archive']))));
  if (!is_array($_POST['filesToArchive'])) {
    $_POST['filesToArchive'] = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToArchive']));
    $_POST['filesToArchive'] = array($_POST['filesToArchive']); }
  foreach ($_POST['filesToArchive'] as $key=>$TFile1) { 
    foreach ($DangerousFiles as $DangerousFile) if (strpos($TFile1, $DangerousFile) !== FALSE) continue 2;  
    $TFile1 = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace(' ', '\ ', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $TFile1))))); 
    $allowed =  array('mov', 'mp4', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'dat', 'cfg', 'txt', 'doc', 'docx', 'rtf', 'xls', 'xlsx', 'csv', 'ods', 'odf', 'odt', 'jpg', 'mp3', 
     'avi', 'wma', 'wav', 'ogg', 'jpeg', 'bmp', 'png', 'gif', 'pdf', 'abw', 'zip', '7z', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd', 'm4v', 'm4a');
    $archarray = array('zip', '7z', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
    $rararr = array('rar');
    $ziparr = array('zip');
    $tararr = array('7z', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
    $filename = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudUsrDir.$TFile1)));
    $filename1 = pathinfo($filename, PATHINFO_BASENAME);
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $_POST['archextension'] = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['archextension']));
    $UserExt = $_POST['archextension'];
    $_POST['userfilename'] = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['userfilename']));
    $UDP = '';
    if ($UserDirPOST !== '/') $UDP = $UserDirPOST; 
    $UserFileName = str_replace('..', '', str_replace(' ', '\ ', str_replace('//', '/', str_replace('///', '/', $UDP.$_POST['userfilename'])))); 
    $archSrc = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudTmpDir.$TFile1)));
    $archDst = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudUsrDir.$UserFileName)));
    if (!is_dir($filename)) {
      if(!in_array($ext, $allowed)) { 
        $txt = ('ERROR!!! HRC2290, Unsupported File Format on '.$Time.'!');
        echo($txt.$br.$hr);   
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        continue; } }
        // / Check the Cloud Location with ClamAV before archiving, just in case.
        if ($VirusScan == '1') {
          shell_exec(str_replace('  ', ' ', str_replace('  ', ' ', 'clamscan -r '.$Thorough.' '.$archSrc.' | grep FOUND >> '.$ClamLogDir)));
          $ClamLogFileDATA = file_get_contents($ClamLogDir);
          if (strpos($ClamLogFileDATA, 'Virus Detected') !== FALSE or strpos($ClamLogFileDATA, 'FOUND') !== FALSE) {
            $txt = ('Warning!!! HRC22338, There were potentially infected files detected. The file
              transfer could not be completed at this time. Please check your file for viruses or
              try again later.'."\n");
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);          
            die($txt.$br.$hr); } }
      // / Handle archiving of rar compatible files.
      if(in_array($UserExt, $rararr)) {
        copy ($filename, $CloudTmpDir.$TFile1); 
        shell_exec('rar a -ep '.$archDst.' '.$archSrc); 
        $txt = ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt in $CloudUsrDir on $Time".'.');
        echo('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt on $Time".'.'.$br.$hr);  
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
      // / Handle archiving of .zip compatible files.
      if(in_array($UserExt, $ziparr)) {
        copy ($filename, $CloudTmpDir.$TFile1); 
        shell_exec('zip -j '.$archDst.'.zip '.$archSrc); 
        $txt = ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt in $CloudUsrDir on $Time".'.');
        echo('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt on $Time".'.'.$br.$hr);  
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
      // / Handle archiving of 7zipper compatible files.
      if(in_array($UserExt, $tararr)) {
        copy ($filename, $CloudTmpDir.$TFile1); 
        shell_exec('7z a '.$archDst.'.'.$UserExt.' '.$archSrc); 
        $txt = ('OP-Act: '."Archived $filename to $UserFileName".'.'."$UserExt in $CloudUsrDir on $Time".'.');
        echo($txt.$br.$hr);  
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } 
  // / Free un-needed memory.
  $_POST['archive'] = $txt = $filesToArchive = $key = $TFile1 = $allowed = $archarray = $rararr = $ziparr = $tararr = $filename = $filename1 
   = $ext = $_POST['archextension'] = $UserExt = $_POST['userfilename'] = $UDP = $UserFileName = $archSrc = $archDst = $ClamLogFileDATA = $MAKELogFile = null;
  unset($_POST['archive'], $filesToArchive, $key, $TFile1, $allowed, $archarray, $rararr, $ziparr, $tararr, $filename, $filename1, $ext,
   $_POST['archextension'], $UserExt, $_POST['userfilename'], $UDP, $UserFileName, $archSrc, $archDst, $ClamLogFileDATA, $MAKELogFile); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will be performed when a user selects archives to extract.
if (isset($_POST["dearchiveButton"])) {
  $_POST['dearchiveButton'] = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['dearchiveButton']))));
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Initiated Dearchiver on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  $UDP = '';
  $allowed =  array('zip', '7z', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
  $archarray = array('zip', '7z', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
  $rararr = array('rar');
  $ziparr = array('zip');
  $tararr = array('7z', 'tar', 'tar.gz', 'tar.bz2', 'iso', 'vhd');
  if ($UserDirPOST !== '/' or $UserDirPOST !== '//') $UDP = $UserDirPOST;
  if (isset($_POST["filesToDearchive"])) {
    if (!is_array($_POST["filesToDearchive"])) $_POST['filesToDearchive'] = array($_POST['filesToDearchive']); 
    foreach (($_POST['filesToDearchive']) as $File) {
      if ($File == '.' or $File == '..') continue;
      foreach ($DangerousFiles as $DangerousFile) if (strpos($file, $DangerousFile) !== FALSE) continue 2; 
      // / The following code sets variables for each archive being extracted.
      $File = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $File)); 
      $File = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace(' ', '\ ', $File)))); 
      $File = ltrim($UDP.$File, '/'); 
      // / The following code sets and detects the USER directory and filename variables to be used for the operation.
      $dearchUserPath = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudUsrDir.$File)));
      $ext = pathinfo(str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudUsrDir.$File))), PATHINFO_EXTENSION); 
      $dearchUserDir = str_replace('..', '', str_replace('.'.$ext, '', $dearchUserPath));
      $dearchUserFile = pathinfo($dearchUserPath, PATHINFO_FILENAME);
      $dearchUserFilename = $dearchUserFile.'.'.$ext;
      // / The following code sets the TEMP directory and filename variables to be used to copy files for the operation.
      $dearchTempPath = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudTmpDir.$File)));
      $dearchTempDir = str_replace('..', '', str_replace('.'.$ext, '', $dearchTempPath));
      $dearchTempFile = $dearchUserFile;
      $dearchTempFilename = $dearchUserFile.'.'.$ext;
      // / The following code creates all of the temporary directories and file copies needed for the operation.
      if (!file_exists($dearchTempDir) or !is_dir($dearchTempDir)) @mkdir ($dearchTempDir, $ILPerms); 
      if (file_exists($dearchTempDir)) $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Verified '.$dearchTempDir.' on '.$Time.'.'.PHP_EOL, FILE_APPEND); 
      if (!file_exists($dearchTempDir) or !is_dir($dearchTempDir)) {
        $txt = ('ERROR!!! HRC2390, Could not create a temp directory at '.$dearchTempDir.' on '.$Time.'!');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        echo($txt.$br.$hr); 
        continue; } 
      if (!file_exists($dearchUserDir) or !is_dir($dearchUserDir)) @mkdir ($dearchUserDir, $CLPerms); 
      if (file_exists($dearchUserDir)) $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Verified '.$dearchUserDir.' on '.$Time.'.'.PHP_EOL, FILE_APPEND); 
      if (!file_exists($dearchUserDir) or !is_dir($dearchUserDir)) {
        $txt = ('ERROR!!! HRC2390, Could not create a temp directory at '.$dearchUserDir.' on '.$Time.'!');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        echo($txt.$br.$hr); 
        continue; } 
      // / The following code checks that the source files exist and are valid, and returns any errors that occur.
      if (file_exists($dearchUserDir)) {
        if (file_exists($dearchUserPath)) {
          @copy ($dearchUserPath, $dearchTempPath);
          if (!file_exists($dearchTempPath)) {
            $txt = ('ERROR!!! HRC2412, There was a problem copying '.$dearchUserPath.' to '.$dearchTempPath.' on '.$Time.'.');
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
            echo($txt.$br.$hr); 
            continue; } 
          if (file_exists($dearchTempPath)) { 
            $MAKELogFile = file_put_contents($LogFile, 'OP-Act, Copied '.$dearchUserPath.' to '.$dearchTempPath.' on '.$Time.'.'.PHP_EOL, FILE_APPEND); 
            // / Check the Cloud Location with ClamAV before dearchiving, just in case.
            if ($VirusScan == '1') {
              shell_exec(str_replace('  ', ' ', str_replace('  ', ' ', 'clamscan -r '.$Thorough.' '.$dearchTempPath.' | grep FOUND >> '.$ClamLogDir)));
              $ClamLogFileDATA = file_get_contents($ClamLogDir);
              if (strpos($ClamLogFileDATA, 'Virus Detected') !== FALSE or strpos($ClamLogFileDATA, 'FOUND') !== FALSE) {
                $txt = ('Warning!!! HRC2338, There were potentially infected files detected. The file
                  transfer could not be completed at this time. Please check your file for viruses or
                  try again later.'."\n");
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);          
                if (is_file($dearchTempPath)) @unlink($dearchTempPath);
                if (is_dir($dearchTempPath)) @rmdir($dearchTempPath);
                die ($txt.$br.$hr); } } } } }
      // / Handle dearchiving of rar compatible files.
      if(in_array($ext,$rararr)) {
        $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Executing "unrar e '.$dearchTempPath.' '.$dearchUserDir.'" on '.$Time.'.'.PHP_EOL, FILE_APPEND);
        shell_exec('unrar e '.$dearchTempPath.' '.$dearchUserDir);
        if (file_exists($dearchUserDir)) $MAKELogFile = file_put_contents($LogFile, 'OP-Act: '."Dearchived $dearchTempPath to $dearchUserDir using method 1 on $Time".'.'.PHP_EOL, FILE_APPEND); }
      // / Handle dearchiving of .zip compatible files.
      if(in_array($ext,$ziparr)) {
        $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Executing "unzip -o '.$dearchTempPath.' -d '.$dearchUserDir.'" on '.$Time.'.'.PHP_EOL, FILE_APPEND);
        shell_exec('unzip -o '.$dearchTempPath.' -d '.$dearchUserDir);
        if (file_exists($dearchUserDir)) $MAKELogFile = file_put_contents($LogFile, 'OP-Act: '."Dearchived $dearchTempPath to $dearchUserDir using method 2 on $Time".'.'.PHP_EOL, FILE_APPEND); } 
      // / Handle dearchiving of 7zipper compatible files.
      if (in_array($ext,$tararr)) {
        $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Executing "7z e '.$dearchTempPath.' '.$dearchUserDir.'" on '.$Time.'.'.PHP_EOL, FILE_APPEND);
        shell_exec('7z e '.$dearchTempPath.' '.$dearchUserDir); 
        if (file_exists($dearchUserDir)) $MAKELogFile = file_put_contents($LogFile, 'OP-Act: '."Dearchived $dearchTempPath to $dearchUserDir using method 3 on $Time".'.'.PHP_EOL, FILE_APPEND); } 
    if (file_exists($dearchUserDir)) {
      $dearchFiles = scandir($dearchUserDir);
      foreach ($dearchFiles as $dearchFile) {
        $dearchFileLoc = $dearchUserDir.'/'.$dearchFile;  
        foreach ($DangerousFiles as $DangerousFile) { 
          if (strpos($dearchFile, $DangerousFile) === TRUE) {          
            unlink($dearchFileLoc);
            $txt = ('Warning!!! HRC2568, Deleting the unsupported file '.$dearchFile.' on '.$Time.'!'.$br.$hr); 
            echo($txt.$br.$hr); 
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } } }
    // / Return an error if the extraction failed and no files were created.
    if (!file_exists($dearchUserDir)) {
      $txt = ('ERROR!!! HRC2449, There was a problem creating '.$dearchUserDir.' on '.$Time.'.'.$br.$hr); 
      echo($txt.$br.$hr); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } }
  // / Free un-needed memory.
  $_POST['dearchiveButton'] = $txt = $UDP = $allowed = $archarray = $rararr = $ziparr = $tararr = $_POST["filesToDearchive"] = $File = $dearchUserPath = $ext
   = $dearchUserDir = $dearchUserFile = $dearchUserFilename = $dearchTempPath = $dearchTempDir = $dearchTempFile = $dearchTempFilename = $ClamLogFileDATA = $MAKELogFile = null;
  unset($_POST['dearchiveButton'], $txt, $UDP, $allowed, $archarray, $rararr, $ziparr, $tararr, $_POST["filesToDearchive"], $File, $dearchUserPath, $ext, 
   $dearchUserDir, $dearchUserfile, $dearchUserFilename, $dearchTempPath, $dearchTempDir, $dearchTempFile, $dearchTempFilename, $ClamLogFileDATA, $MAKELogFile); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user selects files to convert to other formats.
if (isset($_POST['convertSelected'])) {
  $_POST['convertSelected'] = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['convertSelected']))));
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Initiated HRC2 on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  if (!is_array($_POST['convertSelected'])) $_POST['convertSelected'] = array($_POST['convertSelected']);
  foreach ($_POST['convertSelected'] as $file) { 
    $file = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', htmlentities(str_replace(str_split('[]{};:$!#^&%@>*<'), '', $file), ENT_QUOTES, 'UTF-8')))); 
    foreach ($DangerousFiles as $DangerousFile) if (strpos($file, $DangerousFile) !== FALSE) continue 2; 
    $MAKELogFile = file_put_contents($LogFile, 'OP-Act: User '.$UserID.' selected to Convert file '.$file.'.'.PHP_EOL, FILE_APPEND);
    $allowed =  array('svg', 'dxf', 'vdx', 'fig', '3ds', 'obj', 'collada', 'off', 'ply', 'stl', 'ptx', 'dxf', 'u3d', 'vrml', 'mov', 'mp4', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'flac', 'aac', 'dat', 
     'cfg', 'txt', 'doc', 'docx', 'rtf' ,'xls', 'xlsx', 'csv', 'ods', 'odf', 'odt', 'jpg', 'mp3', 'm4v', 'm4a', 'm4p', 'zip', 'rar', 'tar', 'tar.gz', 'tar.bz', 'tar.bZ2', '3gp', 'mkv', 'avi', 'mp4', 'flv', 'mpeg', 'wmv', 
     'avi', 'aac', 'mp2', 'wma', 'wav', 'ogg', 'jpeg', 'bmp', 'png', 'gif', 'pdf', 'abw', 'iso', 'vhd', 'vdi', 'pages', 'pptx', 'ppt', 'xps', 'potx', 'pot', 'ppa', 'ppa', 'odp');
    $file1 = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudUsrDir.$file)));
    $file2 = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudTmpDir.$file)));
    copy($file1, $file2); 
    if (file_exists($file2)) $MAKELogFile = file_put_contents($LogFile, 'OP-Act: '."Copied $file1 to $file2 on $Time".'.'.PHP_EOL, FILE_APPEND); 
    if (!file_exists($file2)) {
      $txt = ('ERROR!!! HRC2381, '."Could not copy $file1 to $file2 on $Time".'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      echo($txt.$br.$hr); 
      continue; }
    $convertcount = 0;
    $extension = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['extension']));
    $pathname = str_replace('..', '', str_replace(' ', '\ ', str_replace('//', '/', $CloudTmpDir.$file)));
    $oldPathname = str_replace('..', '', str_replace('//', '/', $CloudUsrDir.$file));
    $filename = pathinfo($pathname, PATHINFO_FILENAME);
    $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
    $newFile = str_replace('..', '', str_replace('//', '/', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['userconvertfilename'].'_'.$convertcount.'.'.$extension)));
    $newPathname = str_replace('..', '', str_replace('//', '/', $CloudUsrDir.$newFile));
    $docarray =  array('txt', 'doc', 'xls', 'xlsx', 'csv', 'docx', 'rtf', 'odf', 'ods', 'odt', 'dat', 'cfg', 'pages', 'pptx', 'ppt', 'xps', 'potx', 'pot', 'ppa', 'odp', 'odf');
    $imgarray = array('jpg', 'jpeg', 'bmp', 'png', 'gif');
    $audioarray =  array('mp3', 'wma', 'wav', 'ogg', 'mp2', 'flac', 'aac', 'm4a');
    $videoarray =  array('3gp', 'mkv', 'avi', 'mp4', 'flv', 'mpeg', 'wmv', 'm4v');
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
    // / Code to increment the conversion in the event that an output file already exists.    
    while(file_exists($newPathname)) {
      $convertcount++;
      $newFile = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['userconvertfilename'].'_'.$convertcount.'.'.$extension))));
      $newPathname = $CloudUsrDir.$newFile; }
    // / Code to convert document files.
    // / Note: Some servers may experience a delay between the script finishing and the
      // / converted file being placed into their Cloud drive. If your files do not immediately
      // / appear, simply refresh the page.
    if (in_array($oldExtension, $docarray)) {
    // / The following code performs several compatibility checks before copying or converting anything.
      if (!file_exists('/usr/bin/unoconv')) {
        $txt = ('ERROR!!! HRC2654 Could not verify the document conversion engine on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        echo($txt.$br.$hr); 
        continue; }
      if (file_exists('/usr/bin/unoconv')) {
        $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Verified the document conversion engine on '.$Time.'.'.PHP_EOL, FILE_APPEND); 
      // / The following code checks to see if Unoconv is in memory.
        exec("pgrep soffice.bin", $DocEnginePID, $DocEngineStatus);
        if (count($DocEnginePID) == 0) {
          $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Starting the document conversion engine on '.$Time.'.'.PHP_EOL, FILE_APPEND); 
          exec('/usr/bin/unoconv -l &', $DocEnginePID1); 
          exec("pgrep soffice.bin", $DocEnginePID, $DocEngineStatus); } }
      if (count($DocEnginePID) > 0) {
        $MAKELogFile = file_put_contents($LogFile, "OP-Act, Executing \"unoconv -o $newPathname -f $extension $pathname\" on ".$Time.'.'.PHP_EOL, FILE_APPEND);      
        exec("unoconv -o $newPathname -f $extension $pathname", $returnDATA); 
        if (!is_array($returnDATA)) $MAKELogFile = file_put_contents($LogFile, 'OP-Act, Unoconv returned '.$returnDATA.' on '.$Time.'.'.PHP_EOL, FILE_APPEND); 
        if (is_array($returnDATA)) {
          $MAKELogFile = file_put_contents($LogFile, 'OP-Act, Unoconv returned the following on '.$Time.':'.PHP_EOL, FILE_APPEND); }                
          foreach($returnDATA as $returnDATALINE) $MAKELogFile = file_put_contents($LogFile, $returnDATALINE.PHP_EOL, FILE_APPEND); }
      // / For some reason files take a moment to appear after being created with Unoconv.
      $stopper = 0;
      while(!file_exists($newPathname)) {
        exec("unoconv -o $newPathname -f $extension $pathname");
        $stopper++;
        if ($stopper == 10) {
          $txt = 'ERROR!!! HRC2425, The converter timed out while copying your file. ';
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
          echo($txt.$br.$hr); 
          continue; } } }
    // / Code to convert and manipulate image files.
    if (in_array($oldExtension, $imgarray)) {
      $height = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['height']));
      $width = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['width']));
      $_POST["rotate"] = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['rotate']));
      $rotate = ('-rotate '.$_POST["rotate"]);
      $wxh = $width.'x'.$height;
      if ($wxh == '0x0' or $wxh =='x0' or $wxh == '0x' or $wxh == '0' or $wxh == '00' or $wxh == '' or $wxh == ' ') { 
        $MAKELogFile = file_put_contents($LogFile, "OP-Act, Executing \"convert -background none $pathname $rotate $newPathname\" on ".$Time.'.'.PHP_EOL, FILE_APPEND);
        shell_exec("convert -background none $pathname $rotate $newPathname"); } 
      else { 
        $MAKELogFile = file_put_contents($LogFile, "OP-Act, Executing \"convert -background none -resize $wxh $rotate $pathname $newPathname\" on ".$Time.'.'.PHP_EOL, FILE_APPEND);
        shell_exec("convert -background none -resize $wxh $rotate $pathname $newPathname"); } }
    // / Code to convert and manipulate 3d model files.
    if (in_array($oldExtension, $modelarray)) { 
      $MAKELogFile = file_put_contents($LogFile, "OP-Act, Executing \"meshlabserver -i $pathname -o $newPathname\" on ".$Time.'.'.PHP_EOL, FILE_APPEND);
      shell_exec("meshlabserver -i $pathname -o $newPathname"); } 
    // / Code to convert and manipulate drawing files.
    if (in_array($oldExtension, $drawingarray)) { 
      $MAKELogFile = file_put_contents($LogFile, "OP-Act, Executing \"dia $pathname -e $newPathname\" on ".$Time.'.'.PHP_EOL, FILE_APPEND);
      shell_exec("dia $pathname -e $newPathname"); } 
    // / Code to convert and manipulate video files.
    if (in_array($oldExtension, $videoarray)) { 
      $MAKELogFile = file_put_contents($LogFile, "OP-Act, Executing \"ffmpeg -i $pathname -c:v libx264 $newPathname\" on ".$Time.'.'.PHP_EOL, FILE_APPEND);
      shell_exec("ffmpeg -i $pathname -c:v libx264 $newPathname"); } 
    // / Code to convert and manipulate audio files.
    if (in_array($oldExtension, $audioarray)) { 
      $ext = (' -f ' . $extension);
        if (isset($_POST['bitrate'])) $bitrate = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['bitrate']); 
        if (!isset($_POST['bitrate'])) $bitrate = 'auto'; 
      if ($bitrate = 'auto') $br = ' '; 
      elseif ($bitrate != 'auto' ) {
        $br = (' -ab ' . $bitrate . ' '); } 
        $MAKELogFile = file_put_contents($LogFile, "OP-Act, Executing \"ffmpeg -i $pathname$ext$br$newPathname\" on ".$Time.'.'.PHP_EOL, FILE_APPEND);
      shell_exec("ffmpeg -y -i $pathname$ext$br$newPathname"); } 
    // / Code to detect and extract an archive, and then re-archive the extracted
      // / files using a different method.
    if (in_array($oldExtension, $archarray)) { 
      $safedir = str_replace('.'.$oldExtension, '', $pathname);           
      @mkdir($safedir, $ILPerms);
      $safedir3 = ($safedir.'.7z');
      $safedir4 = ($safedir.'.zip');
    if(in_array($oldExtension, $arrayzipo)) {
      shell_exec("unzip $pathname -d $safedir"); 
      $MAKELogFile = file_put_contents($LogFile, "OP-Act, Executing \"unzip $pathname -d $safedir\" on ".$Time.'.'.PHP_EOL, FILE_APPEND); } 
    if(in_array($oldExtension, $array7zo)) {
      shell_exec("7z e $pathname -o$safedir"); 
      $MAKELogFile = file_put_contents($LogFile, "OP-Act, Executing \"7z e $pathname -o$safedir\" on ".$Time.'.'.PHP_EOL, FILE_APPEND); } 
    if(in_array($oldExtension, $array7zo2)) {
      shell_exec("7z e $pathname -o$safedir"); 
      $MAKELogFile = file_put_contents($LogFile, "OP-Act, Executing \"7z e $pathname -o$safedir\" on ".$Time.'.'.PHP_EOL, FILE_APPEND); } 
    if(in_array($oldExtension, $arrayraro)) {
      shell_exec("unrar e $pathname $safedir"); 
      $MAKELogFile = file_put_contents($LogFile, "OP-Act, Executing \"unrar e $pathname $safedir\" on ".$Time.'.'.PHP_EOL, FILE_APPEND); } 
    if(in_array($oldExtension, $arraytaro)) {
      shell_exec("7z e $pathname -o$safedir"); 
      $MAKELogFile = file_put_contents($LogFile, "OP-Act, Executing \"7z e $pathname -o$safedir\" on ".$Time.'.'.PHP_EOL, FILE_APPEND); } 
      if (in_array($extension,$array7zo)) {
        shell_exec("7z a -t$extension $safedir3 $safedir");
        @copy($safedir3, $newPathname); } 
      if (file_exists($safedir3)) {
        @chmod($safedir3, $ILPerms); 
        @unlink($safedir3);
        $delFiles = glob($safedir . '/*');
         foreach($delFiles as $delFile) {
          if(is_file($delFile) ) {
            @chmod($delFile, $ILPerms);  
            @unlink($delFile); }
          elseif(is_dir($delFile) ) {
            @chmod($delFile, $ILPerms);
            @rmdir($delFile); } }    
            @rmdir($safedir); }
      elseif (in_array($extension,$arrayzipo)) {
        shell_exec("zip -r -j $safedir4 $safedir");
        @copy($safedir4, $newPathname); } 
        if (file_exists($safedir4)) {
          @chmod($safedir4, $ILPerms); 
          @unlink($safedir4);
          $delFiles = glob($safedir . '/*');
            foreach($delFiles as $delFile){
              if(is_file($delFile)) {
                @chmod($delFile, $ILPerms);  
                @unlink($delFile); }
              elseif(is_dir($delFile)) {
                @chmod($delFile, $ILPerms);
                @rmdir($delFile); } }    
                @rmdir($safedir); }
              elseif (in_array($extension, $arraytaro)) {
                shell_exec("tar czf $newPathname $safedir");
                $delFiles = glob($safedir . '/*');
              foreach($delFiles as $delFile){
                if(is_file($delFile)) {
                  @chmod($delFile, $ILPerms);  
                  @unlink($delFile); }
                elseif(is_dir($delFile)) {
                  @chmod($delFile, $ILPerms);
                  @rmdir($delFile); } }     
                  @rmdir($safedir); } 
                elseif(in_array($extension, $arrayraro)) {
                  shell_exec("rar a -ep ".$newPathname.' '.$safedir);
                  $delFiles = glob($safedir . '/*');
                    foreach($delFiles as $delFile){
                      if(is_file($delFile)) {
                        @chmod($delFile, $ILPerms);  
                        unlink($delFile); }
                      elseif(is_dir($delFile) ) {
                        @chmod($delFile, $ILPerms);
                        @rmdir($delFile); } } 
                        @rmdir($safedir); } }
  // / Error handler and logger for converting files.
  if (!file_exists($newPathname)) {
    $txt = ('ERROR!!! HRC2524, '."Conversion failed! $newPathname could not be created from $oldPathname".'!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    echo($txt.$br.$hr); 
    continue; } 
  if (file_exists($newPathname)) {
    $txt = ('OP-Act: File '.$newPathname.' was created on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    echo($txt.$br.$hr); } } 
  // / Free un-needed memory.
  $_POST['convertSelected'] = $txt = $file = $allowed = $file1 = $file2 = $convertcount = $extension = $pathname = $oldPathname = $filename = $oldExtension
   = $newFile = $newPathname = $docarray = $imgarray = $audioarray = $videoarray = $modelarray = $drawingarray = $pdfarray = $abwarray = $archarray = $array7z = $array7zo
   = $arrayzipo = $arraytaro = $arrayraro = $abwstd = $abwuno = $_POST['userconvertfilename'] = $returnDATA = $returnDATALINE = $stopper = $height = $width = $_POST['height']
   = $_POST['width'] = $rotate = $_POST['rotate'] = $wxh = $bitrate = $_POST['bitrate'] = $safedirTEMP = $safedir = $safedir3  = $safedir4 = $delFiles 
   = $delFile = $MAKELogFile = null;
  unset($_POST['convertSelected'], $txt, $file, $allowed, $file1, $file2, $convertcount, $extension, $pathname, $oldPathname, $filename, $oldExtension, 
   $newFile, $newPathname, $docarray, $imgarray, $audioarray, $videoarray, $modelarray, $drawingarray, $pdfarray, $abwarray, $archarray, $array7z, $array7zo,
   $arrayzipo, $arraytaro, $arrayraro, $abwstd, $abwuno, $_POST['userconvertfilename'], $returnDATA, $returnDATALINE, $stopper, $height, $width, $_POST['height'], 
   $_POST['width'], $rotate, $_POST['rotate'], $wxh, $bitrate, $_POST['bitrate'], $safedirTEMP, $safedir, $safedir3, $safedir4, $delFiles, $delFile, $MAKELogFile ); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects a document or PDF for manipulation.
if (isset($_POST['pdfworkSelected'])) {
  $_POST['pdfworkSelected'] = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['pdfworkSelected']))));
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Initiated PDFWork on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  $pdfworkcount = '0';
  if (!is_array($_POST['pdfworkSelected'])) $_POST['pdfworkSelected'] = array($_POST['pdfworkSelected']);
  foreach ($_POST['pdfworkSelected'] as $key=>$file) {
    $file = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $file));
    foreach ($DangerousFiles as $DangerousFile) if (strpos($file, $DangerousFile) !== FALSE) continue 2; 
    $MAKELogFile = file_put_contents($LogFile, 'OP-Act: User '.$UserID.' selected to PDFWork file '.$file[$key].' on '.$Time.'.'.PHP_EOL, FILE_APPEND);
    $allowedPDFw =  array('txt', 'doc', 'docx', 'rtf' ,'xls', 'xlsx', 'csv', 'ods', 'odf', 'odt', 'jpg', 'jpeg', 'bmp', 'png', 'gif', 'pdf', 'abw');
    $file1 = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudUsrDir.$file)));
    $file2 = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudTmpDir.$file)));
    copy($file1, $file2); 
    if (file_exists($file2)) {
      $txt = ('OP-Act: '."Copied $file1 to $file2 on $Time".'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
    if (!file_exists($file2)) {
      $txt = ('ERROR!!! HRC2551, '."Could not copy $file1 to $file2 on $Time".'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      echo($txt.$br.$hr); 
      continue; }
    // / If no output format is selected the default of PDF is used instead.
    if (isset($_POST['pdfextension'])) {
      $extension = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['pdfextension'])); } 
    if (!isset($_POST['pdfextension'])) {
      $extension = 'pdf'; }
    $pathname = str_replace('..', '', str_replace(' ', '\ ', str_replace('//', '/', $CloudTmpDir.$file))); 
    $oldPathname = str_replace('..', '', str_replace('//', '/', $CloudUsrDir.$file));
    $filename = pathinfo($pathname, PATHINFO_FILENAME);
    $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
    $newFile = str_replace('..', '.', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['userpdfconvertfilename'].'_'.$pdfworkcount.'.'.$extension));
    $newPathname = str_replace('..', '.', str_replace('//', '/', str_replace('///', '/', $CloudUsrDir.$newFile)));
    $doc1array =  array('txt', 'pages', 'doc', 'xls', 'xlsx', 'csv', 'docx', 'rtf', 'odf', 'ods', 'odt');
    $img1array = array('jpg', 'jpeg', 'bmp', 'png', 'gif');
    $pdf1array = array('pdf');
    if (in_array($oldExtension, $allowedPDFw)) {
      while(file_exists($newPathname)) {
        $pdfworkcount++; 
        $newFile = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['userpdfconvertfilename'].'_'.$pdfworkcount.'.'.$extension));
        $newPathname = str_replace('..', '', str_replace('//', '/', $CloudUsrDir.$newFile)); } } 
    // / Code to convert a PDF to a document.
    if (in_array($oldExtension, $pdf1array)) {
      if (in_array($extension, $doc1array)) {
        $pathnameTEMP = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace('.'.$oldExtension, '.txt', $pathname))));
        $_POST['method'] = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['method']));
        if ($_POST['method'] == '0' or $_POST['method'] == '') {
          shell_exec("pdftotext -layout $pathname $pathnameTEMP"); 
          $MAKELogFile = file_put_contents($LogFile, 'OP-Act: '."Converted $pathnameTEMP1 to $pathnameTEMP on $Time".' using method 0.'.PHP_EOL, FILE_APPEND); 
          if (!file_exists($pathnameTEMP) or filesize($pathnameTEMP) < '5') { 
            $txt = ('Warning!!! HRC2591, There was a problem using the selected method to convert your file. Switching to 
              automatic method and retrying the conversion.'); 
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
            echo($txt.$br.$hr);
            $_POST['method'] = '1'; } }          
        if ($_POST['method'] == '1') {
          $pathnameTEMP1 = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace('.'.$oldExtension, '.jpg' , $pathname))));
          shell_exec("convert $pathname $pathnameTEMP1");
          if (!file_exists($pathnameTEMP1)) {
            $PagedFilesArrRAW = scandir($CloudTmpDir);
            foreach ($PagedFilesArrRAW as $PagedFile) {
              $pathnameTEMP1 = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace('.'.$oldExtension, '.jpg' , $pathname))));
              if ($PagedFile == '.' or $PagedFile == '..' or $PagedFile == '.AppData' or $PagedFile == 'index.html') continue;
              if (strpos($PagedFile, '.txt') !== FALSE) continue;
              if (strpos($PagedFile, '.pdf') !== FALSE) continue;
              $CleanFilname = str_replace('..', '', str_replace($oldExtension, '', $filename));
              $CleanPathnamePages = str_replace('.jpg', '', $PagedFile);
              $CleanPathnamePages = str_replace('.txt', '', $CleanPathnamePages);
              $CleanPathnamePages = str_replace('.pdf', '', $CleanPathnamePages);
              $CleanPathnamePages = str_replace($CleanFilname, '', $CleanPathnamePages);                    
              $CleanPathnamePages = str_replace('..', '', str_replace('-', '', $CleanPathnamePages));
              $PageNumber = $CleanPathnamePages;
              if (is_numeric($PageNumber)) {
                $pathnameTEMP1 = str_replace('..', '.', str_replace('.jpg', '-'.$PageNumber.'.jpg', $pathnameTEMP1));
                $pathnameTEMP = str_replace('..', '.', str_replace('.'.$oldExtension, '-'.$PageNumber.'.txt', $pathname)); 
                $pathnameTEMPTesseract = str_replace('..', '.', str_replace('.'.$oldExtension, '-'.$PageNumber, $pathname)); 
                $pathnameTEMP0 = str_replace('..', '.', str_replace('-'.$PageNumber.'.txt', '.txt', $pathnameTEMP)); 
                shell_exec("tesseract $pathnameTEMP1 $pathnameTEMPTesseract");
                $READPAGEDATA = file_get_contents($pathnameTEMP);
                $WRITEDOCUMENT = file_put_contents($pathnameTEMP0, $READPAGEDATA.PHP_EOL, FILE_APPEND);
                $multiple = '1';  
                $MAKELogFile = file_put_contents($LogFile, 'OP-Act: '."Converted $pathnameTEMP1 to $pathnameTEMP on $Time".' using method 1.'.PHP_EOL, FILE_APPEND);
                $pathnameTEMP = $pathnameTEMP0;
                if (!file_exists($pathnameTEMP0)) {
                  $txt = ('ERROR!!! HRC2617, HRC2610, $pathnameTEMP0 does not exist on '.$Time.'.'."\n"); 
                  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);   
                  echo($txt.$br.$hr); } } } }
              if ($multiple !== '1') {
              $pathnameTEMPTesseract = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', str_replace('.'.$txt, '', $pathnameTEMP))));
              shell_exec("tesseract $pathnameTEMP1 $pathnameTEMPTesseract");
              $MAKELogFile = file_put_contents($LogFile, 'OP-Act: '."Converted $pathnameTEMP1 to $pathnameTEMP on $Time".' using method 1.'.PHP_EOL, FILE_APPEND); } } } } 
            // / Code to convert a document to a PDF.
            if (in_array($oldExtension, $doc1array)) {                
              if (in_array($extension, $pdf1array)) {
                system("/usr/bin/unoconv -o $newPathname -f pdf $pathname"); 
                $MAKELogFile = file_put_contents($LogFile, 'OP-Act: '."Converted $pathname to $newPathname on $Time".' using method 2.'.PHP_EOL, FILE_APPEND); } } 
          // / Code to convert an image to a PDF.
          if (in_array($oldExtension, $img1array)) {
            $pathnameTEMP = str_replace('..', '.', str_replace('//', '/', str_replace('///', '/', str_replace('.'.$oldExtension, '.txt' , $pathname))));
            $pathnameTEMPTesseract = str_replace('..', '.', str_replace('//', '/', str_replace('///', '/', str_replace('.'.$oldExtension, '', $pathname))));
            $imgmethod = '1';
            shell_exec("tesseract $pathname $pathnameTEMPTesseract"); 
            if (!file_exists($pathnameTEMP)) {
              $imgmethod = '2';
              $pathnameTEMP3 = str_replace('..', '.', str_replace('//', '/', str_replace('///', '/', str_replace('.'.$oldExtension, '.pdf' , $pathname))));
              system("/usr/bin/unoconv -o $pathnameTEMP3 -f pdf $pathname");
              shell_exec("pdftotext -layout $pathnameTEMP3 $pathnameTEMP"); } 
            if (file_exists($pathnameTEMP)) $MAKELogFile = file_put_contents($LogFile, 'OP-Act: '."Converted $pathname to $pathnameTEMP1 on $Time".' using method '.$imgmethod.'.'.PHP_EOL, FILE_APPEND); 
            if (!file_exists($pathnameTEMP)) {
              $txt = ('ERROR!!! HRC2667, '."An internal error occured converting $pathname to $pathnameTEMP1 on $Time".' using method '.$imgmethod.'.'); 
              $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
              echo($txt.$br.$hr);
              continue; } }
        // / If the output file is a txt file we leave it as-is.
        if (!file_exists($newPathname)) {                    
          if ($extension == 'txt') { 
            if (file_exists($pathnameTEMP)) {
              rename($pathnameTEMP, $newPathname); 
              $MAKELogFile = file_put_contents($LogFile, 'OP-Act: HRC2613, '."Renamed $pathnameTEMP to $pathname on $Time".'.'.PHP_EOL, FILE_APPEND); } }
          // / If the output file is not a txt file we convert it with Unoconv.
          if ($extension !== 'txt') {
            system("/usr/bin/unoconv -o $newPathname -f $extension $pathnameTEMP");
            $txt = ('OP-Act: '."Converted $pathnameTEMP to $newPathname on $Time".'.'); 
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
            echo($txt.$br.$hr); } }
        // / Log handler for if the output file does exist.
        if (file_exists($newPathname)) {
          $txt = ('OP-Act: Converted '.$pathname.' to '.$newPathname.' on '.$Time.'.'); 
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
          echo($txt.$br.$hr); }
        // / Error handler for if the output file does not exist.
        if (!file_exists($newPathname)) {
          $txt = ('ERROR!!! HRC2620, '."Could not convert $pathname to $newPathname on $Time".'!'); 
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
          echo($txt.$br.$hr); 
          continue; } } 
  // / Free un-needed memory.
  $_POST['pdfworkSelected'] = $txt = $MAKELogFile = $pdfworkcount = $key = $file = $allowedPDFw = $file1 = $file2 = $_POST['pdfextension'] = $extension = $pathname 
   = $oldPathname = $filename = $oldExtension = $newFile = $newPathname = $doc1array = $img1array = $pdf1array = $pathnameTEMP = $_POST['method']
   = $_POST['method1'] = $pathnameTEMP1 = $PagedFilesArrRAW = $PagedFile = $CleanFilname = $CleanPathnamePages = $PageNumber = $READPAGEDATA = $WRITEDOCUMENT = $multiple
   = $pathnameTEMP0 = $pathnameTEMPTesseract = $pathnameTEMP0 = $imgmethod = $pathnameTEMP3 = null;
  unset($_POST['pdfworkSelected'], $txt, $MAKELogFile, $pdfworkcount, $key, $file, $allowedPDFw, $file1, $file2, $_POST['pdfextension'], $extension, $pathname,
   $oldPathname , $filename, $oldExtension, $newFile, $newPathname, $doc1array, $img1array, $pdf1array, $pathnameTEMP, $_POST['method'],
   $_POST['method1'], $pathnameTEMP1, $PagedFilesArrRAW, $PagedFile, $CleanFilname, $CleanPathnamePages, $PageNumber, $READPAGEDATA, $WRITEDOCUMENT, $multiple,
   $pathnameTEMP0, $pathnameTEMPTesseract, $pathnameTEMP0, $imgmethod, $pathnameTEMP3); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will be performed when a user selects files to stream. (for you, Emily...)
if (isset($_POST['streamSelected'])) {
  // / Define the and sanitize global .Playlist environment variables.
  $getID3File = $InstLoc.'/Applications/getid3/getid3/getid3.php';
  $PlaylistName = str_replace('..', '', str_replace(str_split('.\\/[]{};:>$#!&* <'), '', ($_POST['playlistname'])));
  $PLVideoArr =  array('avi', 'mov', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp');    
  $PLVideoArr2 =  array('avi', 'mov', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'mp4');    
  $PLMediaArr =  array('mp2', 'mp3', 'wma', 'wav', 'aac', 'flac', 'ogg', 'avi', 'mov', 'mkv', 'flv', 'ogv', 'wmv', 'mpg', 'mpeg', 'm4v', '3gp', 'mp4');
  $PLAudioArr =  array('mp2', 'mp3', 'wma', 'wav', 'aac', 'flac', 'ogg', 'm4a', 'm4p');
  $PLAudioOGGArr =  array('ogg');
  $PLAudioMP4Arr =  array('mp4');
  $PLVideoMP4Arr =  array('mp4');
  $MediaFileCount = $VideoFileCount = 0;
  // / Define temp .Playlist environment variables.
  $PlaylistTmpDir = str_replace('..', '', $CloudTmpDir.'/'.$PlaylistName.'.Playlist');
  $playlistDir = str_replace('..', '', $CloudUsrDir.'/'.$PlaylistName.'.Playlist'); 
  $playlistCacheDir = str_replace('..', '', $playlistDir.'/.Cache');
  $PlaylistCacheFile = str_replace('..', '', $playlistCacheDir.'/cache.php'); 
  // / Write the first Playlist entry to the user's logfile.
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Initiated .Playlist creation on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  require($getID3File);
  // / The following code creates the .Playlist directory as well as the .Cache directory and cache files.
  if (!file_exists($playlistDir)) {
    mkdir($playlistDir, $CLPerms);
    copy($InstLoc.'/index.html', $playlistDir.'/index.html'); 
    $txt = ('OP-Act: Created a playlist directory on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($playlistCacheDir)) {
    mkdir($playlistCacheDir, $CLPerms);
    copy($InstLoc.'/index.html', $playlistCacheDir.'/index.html'); 
    $txt = ('OP-Act: Created a playlist cache directory on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($PlaylistCacheFile)) {
    @touch($PlaylistCacheFile);  
    $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Created a playlist cache file on '.$Time.'.'.PHP_EOL, FILE_APPEND); }
  if (strpos($PlaylistCacheDir, '.Playlist') == 'false' or file_exists($PlaylistCacheDir)) {
    $txt = ('ERROR!!! HRC2746, There was a problem verifying the '.$PlaylistDir.' on '.$Time.'!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    die ($txt.$br.$hr); } 
  if (!is_array($_POST['streamSelected'])) $_POST['streamSelected'] = array($_POST['streamSelected']); 
  foreach ($_POST['streamSelected'] as $MediaFile) { 
    foreach ($DangerousFiles as $DangerousFile) if (strpos($MediaFile, $DangerousFile) !== FALSE) continue 2; 
    // / The following code will only create cache data if the $MediaFile is in the $PLMediaArr.     
    $pathname = str_replace('..', '', str_replace('//', '/', $CloudUsrDir.$MediaFile));
    $pathname = str_replace('..', '', str_replace(' ', '\ ', $pathname));
    $Scanfilename = pathinfo($pathname, PATHINFO_FILENAME);
    $ScanoldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
    $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Detected a '.$ScanoldExtension.' named '.$MediaFile.' on '.$Time.'.'.PHP_EOL, FILE_APPEND);
    if(in_array($ScanoldExtension, $PLMediaArr)) {
      $MediaFileCount++; 
      $getID3 = new getID3;
      $id3Tags = $getID3->analyze($pathname);
      getid3_lib::CopyTagsToComments($pathname);
      // / ID3v1 tags
      // / If id3v1 title tags are set, return them as a variable.
      if(isset($id3Tags['tags']['id3v1']['title'][0])) {
        $PLSongTitle = $id3Tags['tags']['id3v1']['title'][0]; 
        $PLSongTitle = str_replace(str_split('\\/[]{};:>#*\'<'), '', ($PLSongTitle)); }
      if(!isset($id3Tags['tags']['id3v1']['title'][0]))  $PLSongTitle = ''; 
      // / If id3v1 artist tags are set, return them as a variable.
      if(isset($id3Tags['tags']['id3v1']['artist'][0])) {
        $PLSongArtist = $id3Tags['tags']['id3v1']['artist'][0]; 
        $PLSongArtist = str_replace(str_split('\\/[]{};:>$#*\'<'), '', ($PLSongArtist)); }
      if(!isset($id3Tags['tags']['id3v1']['artist'][0])) {
        $PLSongArtist = ''; }
      // / If id3v1 album tags are set, return them as a variable.
      if(isset($id3Tags['tags']['id3v1']['album'][0])) {
        $PLSongAlbum = $id3Tags['tags']['id3v1']['album'][0]; 
        $PLSongAlbum = str_replace(str_split('\\/[]{};:>#*\'<'), '', ($PLSongAlbum)); }
      if(!isset($id3Tags['tags']['id3v1']['album'][0])) $PLSongAlbum = ''; 
      // ID3v2 tags.
      // / If id3v2 title tags are set, return them as a variable.
      if(isset($id3Tags['tags']['id3v2']['title'][0])) {
        $PLSongTitle = $id3Tags['tags']['id3v2']['title'][0]; 
        $PLSongTitle = str_replace(str_split('\\/[]{};:>#*\'<'), '', ($PLSongTitle)); }
      if(!isset($id3Tags['tags']['id3v2']['title'][0])) $PLSongTitle = ''; 
      // / If id3v2 artist tags are set, return them as a variable.
      if(isset($id3Tags['tags']['id3v2']['artist'][0])) {
        $PLSongArtist = $id3Tags['tags']['id3v2']['artist'][0]; 
        $PLSongArtist = str_replace(str_split('\\/[]{};:>$#*\'<'), '', ($PLSongArtist)); }
      if(!isset($id3Tags['tags']['id3v2']['artist'][0])) $PLSongArtist = ''; 
      // / If id3v2 album tags are set, return them as a variable.
      if(isset($id3Tags['tags']['id3v2']['album'][0])) {
        $PLSongAlbum = $id3Tags['tags']['id3v2']['album'][0]; 
        $PLSongAlbum = str_replace(str_split('\\/[]{};:>#*\'<'), '', ($PLSongAlbum)); }
      if(!isset($id3Tags['tags']['id3v2']['album'][0])) $PLSongAlbum = ''; 
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
      if(!isset($id3Tags['id3v2']['APIC'][0]['data']) or $id3Tags['id3v2']['APIC'][0]['data'] == '') $PLSongImage = ''; } }
  // / The following code converts the selected media files to device friendly formats and places them into the playlist directory.
  foreach (($_POST['streamSelected']) as $StreamFile) { 
    $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Initiated Streamer on '.$Time.'.'.PHP_EOL, FILE_APPEND);
    $pathname = str_replace('..', '', str_replace(' ', '\ ', str_replace('//', '/', str_replace('///', '/', $CloudTmpDir.'/'.$StreamFile))));
    $oldPathname = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudUsrDir.$StreamFile)));
    copy ($oldPathname, $pathname);
    if ($StreamFile == '.' or $StreamFile == '..' or is_dir($pathname) or is_dir($oldPathname)) continue;
      foreach ($DangerousFiles as $DangerousFile) if (strpos($StreamFile, $DangerousFile) !== FALSE) continue 2; 
      $MAKELogFile = file_put_contents($LogFile, 'OP-Act: User '.$UserID.' selected to StreamFile '.$StreamFile.' from CLOUD.'.PHP_EOL, FILE_APPEND);
      $filename = pathinfo($pathname, PATHINFO_FILENAME);
      $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
        if (in_array($oldExtension, $PLAudioArr)) {
          $ext = (' -f ' . 'ogg');
          $bitrate = 'auto';                 
          if ($bitrate = 'auto' ) $br = ' ';  
          elseif ($bitrate != 'auto' ) $br = (' -ab ' . $bitrate . ' ');
          $pathname = str_replace('..', '', str_replace('//', '/', $CloudUsrDir.$StreamFile));
          $newPathname = str_replace('..', '', str_replace('//', '/', $playlistDir.'/'.$filename.'.ogg'));
          $MAKELogFile = file_put_contents($LogFile, "OP-Act, Executing ffmpeg -i $pathname$ext$br$newPathname on ".$Time.'.'.PHP_EOL, FILE_APPEND);
          shell_exec("ffmpeg -i $pathname$ext$br$newPathname"); }  
        if (in_array($oldExtension, $PLAudioOGGArr)) copy ($oldPathname, str_replace('//', '/', $playlistDir.'/'.$StreamFile)); } 
  // / Free un-needed memory.
  $_POST['streamSelected'] = $getID3File = $PlaylistName = $PLVideoArr = $PLVideoArr2 = $PLMediaArr = $PLAudioArr = $PLAudioOGGArr = $PLAudioMP4Arr = $PLVideoMP4Arr = $MediaFileCount 
   = $VideoFileCount = $PlaylistTmpDir = $playlistDir = $playlistCacheDir = $PlaylistCacheFile = $txt = $MAKELogFile = $_POST['streamSelected'] = $pathname = $Scanfilename = $ScanoldExtension
   = $getID3 = $id3Tags = $PLSongTitle = $PLSongArtist = $PLSongAlbum = $PLSongImage = $PLSongImageDATA = $SongImageFile = $SongImageFileRAW = $fo1 = $fo2 = $fo3 = $fo4 = $MAKECacheImageFileRAW 
   = $StreamFile = $filename = $oldPathname = $oldExtension = $ext = $bitrate = $br = null;
  unset($_POST['streamSelected'], $getID3File, $PlaylistName, $PLVideoArr, $PLVideoArr2, $PLMediaArr, $PLAudioArr, $PLAudioOGGArr, $PLAudioMP4Arr, $PLVideoMP4Arr, $MediaFileCount, 
   $VideoFileCount, $PlaylistTmpDir, $playlistDir, $playlistCacheDir, $PlaylistCacheFile, $txt, $MAKELogFile, $_POST['streamSelected'], $pathname, $Scanfilename, $ScanoldExtension, 
   $getID3, $id3Tags, $PLSongTitle, $PLSongArtist, $PLSongAlbum, $PLSongImage, $PLSongImageDATA, $SongImageFile, $SongImageFileRAW, $fo1, $fo2, $fo3, $fo4, $MAKECacheImageFileRAW, 
   $StreamFile, $filename, $oldPathname, $oldExtension, $ext, $bitrate, $br); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user selects files to share.
if (isset($_POST['shareConfirm'])) {
  $CloudShareDir = $InstLoc.'/DATA/'.$UserID.'/.AppData/Shared';
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Initiated Share on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  $_POST['shareConfirm'] = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['shareConfirm']));
  if (!is_array($_POST["filesToShare"])) $_POST['filesToShare'] = array(str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToShare'])); 
  foreach ($_POST['filesToShare'] as $FTS) { 
    foreach ($DangerousFiles as $DangerousFile) if (strpos($FTS, $DangerousFile) !== FALSE) continue 2; 
    $FTS = str_replace('..', '', str_replace($UserDirPOST, '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $FTS)));
    $MAKELogFile = file_put_contents($LogFile, 'OP-Act: User '.$UserID.' selected to share '.$FTS.' on '.$Time.'.'.PHP_EOL, FILE_APPEND);
    $copySrc = str_replace('..', '', str_replace('//', '/', $CloudUsrDir.$FTS));
    $copyDst = str_replace('..', '', str_replace('//', '/', $CloudShareDir.'/'.$FTS));
    symlink($copySrc, $copyDst); 
    if (file_exists($CloudShareDir.'/'.$FTS)) { 
      $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Shared '.$FTS.' on '.$Time.'.'.PHP_EOL, FILE_APPEND); }
    if (!file_exists($CloudShareDir.'/'.$FTS)) {
      $MAKELogFile = file_put_contents($LogFile, 'ERROR!!! HRC2862, Could not share '.$FTS.' on '.$Time.'.'.PHP_EOL, FILE_APPEND); } } 
  // / Free un-needed memory.
  $CloudShareDir = $MAKELogFile = $_POST['filesToShare'] = $FTS = $copySrc = $copyDst = null;
  unset($CloudShareDir, $MAKELogFile, $_POST['filesToShare'], $FTS, $copySrc, $copyDst); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user selects files to unshare.
if (isset($_POST['unshareConfirm'])) {
  $CloudShareDir = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $InstLoc.'/DATA/'.$UserID.'/.AppData/Shared')));
  $CloudShareDir2 = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudDir.'/.AppData/Shared')));
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Initiated UnShare on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  $_POST['unshareConfirm'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['unshareConfirm']);
  if (isset($_POST["filesToUnShare"])) {
    if (!is_array($_POST["filesToUnShare"])) $_POST['filesToUnShare'] = array(str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['filesToUnShare'])); 
    foreach ($_POST['filesToUnShare'] as $FTS) {
      $FTS = str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $FTS));
      if (strpos($FTS, 'http//') !== FALSE or strpos($FTS, 'https//') !== FALSE) {
        $txt = ('ERROR!!! HRC21193, URL supplied in filesToUnShare, expecting a filename, '.$FTS.' on '.$Time.'!');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        echo($txt.$br.$hr); 
        continue; }  
      if (strpos($FTS, 'http//') == FALSE or strpos($FTS, 'https//') == FALSE ) {
        @unlink(str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudShareDir.'/'.$FTS))));
        @unlink(str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudShareDir2.'/'.$FTS)))); 
        if (!file_exists($CloudShareDir.'/'.$FTS) && !file_exists($CloudShareDir2.'/'.$FTS)) {
          $txt = ('OP-Act: UnShared '.$FTS.' on '.$Time.'.');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
          echo($txt.$br.$hr); } }
      if (file_exists($CloudShareDir.'/'.$FTS) or file_exists($CloudShareDir2.'/'.$FTS)) {
        $txt = ('ERROR!!! HRC2862, Could not UnShare '.$FTS.' on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        echo($txt.$br.$hr); 
        continue; } } } 
  // / Free un-needed memory.
  $CloudShareDir = $CloudShareDir2 = $txt = $MAKELogFile = $_POST['filesToUnShare'] = $FTS = null;
  unset($CloudShareDir, $CloudShareDir2, $txt, $MAKELogFile, $_POST['filesToUnShare'], $FTS); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user selects files to add a file to their favorites.
if (isset($_POST['favoriteConfirm'])) {
  include($FavoritesCacheFileCloud);
  if (!is_array($_POST["favoriteConfirm"])) $_POST['favoriteConfirm'] = array(str_replace('..', '', str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['favoriteConfirm']))); 
  foreach ($_POST['favoriteConfirm'] as $favoriteToAdd) { 
    foreach ($DangerousFiles as $DangerousFile) if (strpos($favoriteToAdd, $DangerousFile) !== FALSE) continue 2; 
    $favoriteToAdd = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', ltrim(str_replace(str_split('[]{};:$!#^&%@>*<'), '', $favoriteToAdd), '/'))));
    array_push($FavoriteFiles, $favoriteToAdd);
    $txt = ('OP-Act: User added \''.$favoriteToAdd.'\' to their Favorite Files on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo($txt.$br.$hr); }
  $FavoriteFilesCSV = str_replace('..', '', str_replace('\'\', ', '', implode('\', \'', $FavoriteFiles)));
  $data = '$FavoriteFiles = array(\''.$FavoriteFilesCSV.'\');';
  $MAKEFavCacheFile = file_put_contents($FavoritesCacheFileCloud, $data.PHP_EOL, FILE_APPEND); 
  copy($FavoritesCacheFileCloud, $FavoritesCacheFileInst); 
  $_POST['favoriteConfirm'] = $favoriteToAdd = $FavoriteFiles = $FavoriteFilesCSV = $data = $MAKEFavCacheFile = null; 
  unset($_POST['favoriteConfirm'], $favoriteToAdd, $FavoriteFiles, $FavoriteFilesCSV, $data, $MAKEFavCacheFile); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user selects files to remove a file from their favorites.
if (isset($_POST['favoriteDelete'])) {
  include($FavoritesCacheFileCloud);
  foreach ($_POST['favoriteDelete'] as $favoriteToRemove) {
    $favoriteToRemove = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', ltrim(str_replace(str_split('[]{};:$!#^&%@>*<'), '', $favoriteToRemove), '/')))); 
    $favfilecounter = 0;
    foreach ($FavoriteFiles as $FavFile) {
      if ($FavFile == $favoriteToRemove or $FavFile == '') $FavoriteFiles[$favfilecounter] = null; 
      $favfilecounter++; }
    $txt = ('OP-Act: User removed \''.$favoriteToRemove.'\' from their Favorite Files on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo($txt.$br.$hr); }
  $data = '$FavoriteFiles = array(\''.implode('\', \'', $FavoriteFiles).'\');';
  $MAKEFavCacheFile = file_put_contents($FavoritesCacheFileCloud, $data.PHP_EOL, FILE_APPEND); 
  copy($FavoritesCacheFileCloud, $FavoritesCacheFileInst); 
  $_POST['favoriteDelete'] = $favoriteToRemove = $FavoriteFiles = $favfilecounter = $FavFile = $data = $MAKEFavCacheFile = null; 
  unset($_POST['favoriteDelete'], $favoriteToRemove, $FavoriteFiles, $favfilecounter, $FavFile, $data, $MAKEFavCacheFile); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code controls the creation and management of a users clipboard cache file.
if (isset($_POST['clipboardCopy'])) { 
  if (!is_array($_POST['clipboardSelected'])) $_POST['clipboardSelected'] = array($_POST['clipboardSelected']); 
  $UserClipboard = $InstLoc.'/DATA/'.$UserID.'/.AppData/.clipboard.php'; 
  include($UserClipboard);
  $clipboard = str_replace('..', '', str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['clipboard'])));
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Initiated Clipboard on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  $txt = '';
  $MAKEClipboardFile = file_put_contents($UserClipboard, $txt.PHP_EOL, FILE_APPEND); 
  $copyCounter = 0;
  if (isset($_POST['clipboardCopy'])) {
    $_POST['clipboardCopy'] = str_replace('..', '', str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['clipboardCopy'])));
    if (!isset($_POST['clipboardSelected'])) {
      $txt = ('ERROR!!! HRC21018, No file selected on '.$Time.'!');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      die($txt.$br.$hr); }
    foreach ($_POST['clipboardSelected'] as $clipboardSelected) { 
      foreach ($DangerousFiles as $DangerousFile) if (strpos($clipboardSelected, $DangerousFile) !== FALSE) continue 2; 
      $clipboardSelected = str_replace('..', '', str_replace(str_split('\\/[]{};:>$#!&* <'), '', $clipboardSelected));
      $CopyDir = str_replace('..', '', str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['clipboardCopyDir']))); 
      if ($CopyDir !== '') $CopyDir = $CopyDir.'/'; 
      $MAKELogFile = file_put_contents($LogFile, 'OP-Act: User selected to Copy "'.$clipboardSelected.'" to Clipboard on '.$Time.'.'.PHP_EOL, FILE_APPEND);
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
    $_POST['clipboardPaste'] = str_replace('..', '', str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['clipboardPaste'])));
    if (!isset($_POST['clipboardPasteDir'])) {
      $txt = ('ERROR!!! HRC21018, No file selected on '.$Time.'!');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      die($txt.$br.$hr); }
    $UserClipboard = $InstLoc.'/DATA/'.$UserID.'/.AppData/.clipboard.php';
    require ($UserClipboard);
    $MAKELogFile = file_put_contents($LogFile, 'OP-Act: Initiated Clipboard on '.$Time.'.'.PHP_EOL, FILE_APPEND); 
    $PasteDir = (str_replace('..', '', str_replace(str_split('\\/[]{};:>$#!&* <'), '', ($_POST['clipboardPasteDir'])).'/'));   
    $txt = ('OP-Act: User selected to Paste files from Clipboard to '.$PasteDir.' on '.$Time.'.');
    echo($txt.$br.$hr);
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    foreach ($clipboardSelected as $clipboardSelected1) {
      foreach ($DangerousFiles as $DangerousFile) if (strpos($clipboardSelected1, $DangerousFile) !== FALSE) continue 2; 
      if (!file_exists($CloudDir.'/'.$clipboardSelected1)) { 
        $txt = 'ERROR!!! HRC2937, No file exists while copying '.$clipboardSelected1.' to '.$PasteDir.' on '.$Time.'.';
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        echo($txt.$br.$hr); }
      if (file_exists($CloudDir.'/'.$clipboardSelected1)) { 
        if (is_file($CloudDir.'/'.$clipboardSelected1)) {
          copy($CloudDir.'/'.$clipboardSelected1, $CloudDir.'/'.$PasteDir.$clipboardSelected1); 
          $txt = 'OP-Act: Copied '.$clipboardSelected1.' to '.$PasteDir.' on '.$Time.'.';
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
          if (!file_exists($CloudDir.'/'.$clipboardSelected1)) { 
            $txt = 'ERROR!!! HRC2945, There was a problem copying '.$CloudDir.'/'.$clipboardSelected1.' to '.$PasteDir.' on '.$Time.'.';
            $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
            echo($txt.$br.$hr); } }
        if (is_dir($CloudDir.'/'.$clipboardSelected1)) { } } } 
  // / Free un-needed memory.
  $_POST['clipboardCopy'] = $_POST['clipboardSelected'] = $UserClipboard = $clipboard = $txt = $MAKELogFile = $MAKEClipboardFile = $copyCounter = $clipboardSelected
   = $_POST['clipboardCopyDir'] = $CopyDir = $clipboardArray = $_POST['clipboardPasteDir'] = $PasteDir = null;
  unset($_POST['clipboardCopy'], $_POST['clipboardSelected'], $UserClipboard, $clipboard, $txt, $MAKELogFile, $MAKEClipboardFile, $copyCounter, $clipboardSelected,
   $_POST['clipboardCopyDir'], $CopyDir, $clipboardArray, $_POST['clipboardPasteDir'], $PasteDir); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Code to search a users Cloud Drive and return the results.
if (isset($_POST['search'])) { ?>
  <div align="center"><h3>Search Results</h3></div><hr /><?php
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: '."User initiated Cloud Search on $Time".'.'.PHP_EOL, FILE_APPEND); 
  $MAKELogFile = file_put_contents($LogFile, 'OP-Act: User input is "'.$SearchRAW.'" on '.$Time.'.'.PHP_EOL, FILE_APPEND);
  $PendingResCount1 = $PendingResCount2 = 0;
  $searchDir = $CloudUsrDir;
  function search($searchTerm, $searchDir) { 
    global $LogFile, $PendingResCount1, $PendingResCount2, $Time, $br, $DangerousFiles, $CloudUsrDir, $CloudTmpDir, $UserID, $UserDirPOST;
    $SearchRAW = str_replace('..', '', str_replace(str_split('\\/[]{};:!$#&@>*<'), '', $searchTerm));
    $SearchLower = strtolower($SearchRAW);
    if ($SearchRAW == '') {
      ?><div align="center"><?php echo('Please enter a search keyword.'.$br.'<a href="#" onclick="goBack();">&#8592; Go Back</a>'); ?><hr /></div> <?php die(); }
    $ResultFiles =  scandir($searchDir); 
    if (isset($SearchRAW)) {       
      foreach ($ResultFiles as $ResultFile0) {
        if ($ResultFile0 == '.' or $ResultFile0 == '..' or $ResultFile0 == 'index.html' 
         or $ResultFile0 == '.AppData' or strpos($ResultFile0, '.php') !== FALSE or strpos($ResultFile0, '.htaccess') !== FALSE) continue;
        foreach ($DangerousFiles as $DangerousFile) if (strpos($ResultFile0, $DangerousFile) !== FALSE) continue 2; 
        $ResultFile = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $searchDir.$ResultFile0)));    
        $PendingResCount1++; 
        $ResultRAW = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $ResultFile0)));
        $Result = strtolower($ResultRAW);
        if (strpos($Result, $SearchLower) === FALSE or !file_exists($ResultFile)) continue; 
        else {  
          if (!is_dir($ResultFile)) { 
            $ResultTmpFile = str_replace('..', '', str_replace('//', '/', str_replace('///', '/', $CloudTmpDir.$ResultFile0)));
            $ResultURL = 'DATA/'.$UserID.$UserDirPOST.$ResultFile0;
            $F2 = pathinfo($ResultFile, PATHINFO_BASENAME);
            $F3 = $CloudTmpDir.$F2;
            $F4 = pathinfo($ResultFile, PATHINFO_FILENAME);
            $F5 = pathinfo($ResultFile, PATHINFO_EXTENSION);
            @symlink($ResultFile, $ResultTmpFile); 
            $MAKELogFile = file_put_contents($LogFile, 'OP-Act: '."Submitted $ResultFile to $CloudTmpDir on $Time".'.'.PHP_EOL, FILE_APPEND);
            $PendingResCount2++;
            ?><a href='<?php echo($ResultURL); ?>'><?php echo($ResultFile0."\n"); ?></a>
            <hr /><?php } } } } 
    echo('Searched '.$PendingResCount1.' files for "'.$SearchRAW.'" and found '.$PendingResCount2.' results on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, 'OP-ACT, Searched '.$PendingResCount1.' files for "'.$SearchRAW.'" and found '.$PendingResCount2.' results on '.$Time.'.'.PHP_EOL, FILE_APPEND); }
  search($_POST['search'], $searchDir); ?>
  <br>
  <div align="center"><a href="#" onclick="goBack();">&#8592; Go Back</a></div>
  <hr /><?php
  // / Free un-needed memory.
  $_POST['search'] = $txt = $MAKELogFile = $SearchRAW = $PendingResCount1 = $PendingResCount2 = $ResultFiles = $SearchLower = $ResultFile = $ResultFile0 = $ResultTmpFile
   = $ResultURL = $F2 = $F3 = $F4 = $F5 = $F6 = $Result = $iterator = $item = null;
  unset($_POST['search'], $txt, $MAKELogFile, $SearchRAW, $PendingResCount1, $PendingResCount2, $ResultFiles, $SearchLower, $ResultFile, $ResultFile0, $ResultTmpFile,
   $ResultURL, $F2, $F3, $F4, $F5, $F6, $Result, $iterator, $item); } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code handles which UI will be displayed for the selected operation.
if (isset($_GET['playlistSelected']) or isset($_POST['playlistSelected'])) {
  include($InstLoc.'/Applications/HRStreamer/HRStreamer.php'); 
  die(); }
if (isset($_POST['shareConfirm']) or isset($_POST['unshareConfirm']) or isset($_GET['showShared'])) {
  die('<script type="text/javascript">window.location = "DATA/'.$UserID.'/.AppData/Shared/.index.php?viewsharebutton=view+shared";</script>'); }
require($InstLoc.'/Applications/displaydirectorycontents_72716/index.php'); 
// / -----------------------------------------------------------------------------------
?>
