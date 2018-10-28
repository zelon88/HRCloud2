<?php
// / -----------------------------------------------------------------------------------
// / The follwoing code checks for required core files and terminates if they are missing.
if (!file_exists(realpath(dirname(__FILE__)).'/securityCore.php')) die ('<body>ERROR!!! HRC2AppCore21, Cannot process the HRCloud2 Security Core file (securityCore.php).'.PHP_EOL.'</body></html>'); 
else require_once (realpath(dirname(__FILE__)).'/securityCore.php'); 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets the global variables for the session.
$AppDir = $InstLoc.'/Applications/';
$Apps = scandir($AppDir);
$defaultApps = array('.', '..', '', 'jquery-3.1.0.min.js', 'HRAI', 'HRConvert2', 'HRScan2', 'HRAIMiniGui.php',
 'HRStreamer', 'getid3', 'displaydirectorycontents_logs', 'displaydirectorycontents_logs1', 
 'displaydirectorycontents_72716', 'displaydirectorycontents_shared', 'wordpress.zip');
$installedApps = array_diff($Apps, $defaultApps);
if (isset($_POST['uninstallApplication'])) $uninstallApp = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['uninstallApplication']);
$apps = scandir($AppDir, SCANDIR_SORT_DESCENDING);
$stopper = 0;
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will be performed when an administrator selects to install an HRCloud2 App.
if (isset($_POST['installApplication'])) {
  // / Perform security check (UserID).
  if ($UserIDRAW !== 1) { 
    $txt = ('!!! WARNING !!! HRC2AppCore30 You are not an administrator!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die($txt); }
if (!isset($YUMMYSaltHash)) die('!!! WARNING !!! HRC2AppCore41, There was a critical security fault. Login Request Denied.'.PHP_EOL."Application was halted on $Time".'.'); 
if ($YUMMYSaltHash !== $SaltHash) die('!!! WARNING !!! HRC2AppCore41, There was a critical security fault. Login Request Denied.'.PHP_EOL."Application was halted on $Time".'.'); 
if (isset($_FILES["appToUpload"])) {
  // / Perform security check (SaltHash).
  $txt = ('OP-Act: Initiated AppCore Uploader on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  if (!is_array($_FILES["appToUpload"])) {
    $_FILES["appToUpload"] = array($_FILES["appToUpload"]['name']); }
  foreach ($_FILES['appToUpload']['name'] as $key=>$file) {
    if ($file == '.' or $file == '..' or $file == 'index.html') continue;
    $appToInstallRAW = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $file);
    $installableArr = array('zip', 'rar', 'tar', 'tar.bz', 'tar.bz2', 'tar.gz', '7z'); 
    $appToInstall = str_replace('.'.$appExt, '', $appToInstallRAW);
    $appInstallDir = $InstLoc.'/Applications/'.$appToInstall;
    $appInstallDir0 = $InstLoc.'/Applications/'.$appToInstallRAW;
    $file = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $file);      
    $file = str_replace(" ", "_", $file);
    $DangerousFiles = array('js', 'php', 'html', 'css');
    $F0 = pathinfo($file, PATHINFO_EXTENSION);
    if (in_array($F0, $DangerousFiles)) { 
        $txt = ("ERROR!!! HRC2AppCore67, Improper file format on $Time.");
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
        die($txt);  }
    if($file == "") {
        $txt = ("ERROR!!! HRC2AppCore160, No file specified on $Time.");
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
        die($txt); }
      $txt = ('OP-Act: '."Uploaded $file to $CloudTmpDir on $Time".'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      echo nl2br($txt."\n".PHP_EOL.'--------------------'.PHP_EOL."\n");
      $COPY_TEMP = copy($_FILES['appToUpload']['tmp_name'][$key], $appInstallDir0); 
      $txt = ('OP-Act: Initiated AppCore Dearchiver on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      $archarray = $installableArr;
      $rararr = array('rar');
      $ziparr = array('zip');
      $tararr = array('7z', 'tar', 'tar.gz', 'tar.bz2');
      $filename = str_replace(" ", "_", $File);
      $filename1 = pathinfo($appInstallDir0, PATHINFO_BASENAME);
      $filename2 = pathinfo($appInstallDir0, PATHINFO_FILENAME);
      $ext = pathinfo($appInstallDir0, PATHINFO_EXTENSION);  
      if (!in_array($ext, $installableArr)) {
        $txt = ('ERROR!!! HRC2AppCore40, The file "'.$file.'" is not a valid archive format on '.$Time.'!');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        unlink ($appInstallDir0);
        die($txt); }
      // / Create the new App directory in Applications/
      if (!file_exists($appInstallDir)) {
        mkdir($appInstallDir); }
      $txt = ('OP-Act: Dearchiving '.$appToInstallRAW.' to '.$filename2.' on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      echo nl2br($txt."\n".PHP_EOL.'--------------------'.PHP_EOL."\n"); 
      // / Handle dearchiving of rar compatible files.
      if(in_array($ext,$rararr)) {
        shell_exec('unrar e '.$appInstallDir0.' '.$AppDir);
        $txt = ('OP-Act: '."Installed $appInstallDir0. to $appInstallDir on $Time".'.'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
      // / Handle dearchiving of .zip compatible files.
      if(in_array($ext,$ziparr)) {
        shell_exec('unzip '.$appInstallDir0.' -d '.$AppDir);
        $txt = ('OP-Act: '."Installed $appInstallDir0. to $appInstallDir on $Time".'.'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
      // / Handle dearchiving of 7zipper compatible files.
      if(in_array($ext,$tararr)) {
        shell_exec('7z e'.$AppDir.'.'.$ext.' '.$appInstallDir0); 
        $txt = ('OP-Act: '."Installed $appInstallDir0. to $appInstallDir on $Time".'.'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
      // / Check the Cloud Location with ClamAV before archiving, just in case.
      if ($VirusScan == '1') {
        shell_exec('clamscan -r '.$appInstallDir0.' | grep FOUND >> '.$ClamLogDir); 
      if (filesize($ClamLogDir > 1)) {
        echo nl2br('WARNING!!! HRC2AppCore110, There were potentially infected files detected. The file
          transfer could not be completed at this time. Please check your file for viruses or
          try again later.'.PHP_EOL."\n");
          die(); }
        shell_exec('clamscan -r '.$appInstallDir.' | grep FOUND >> '.$ClamLogDir); 
      if (filesize($ClamLogDir > 1)) {
        echo nl2br('WARNING!!! HRC2AppCore116, There were potentially infected files detected. The file
          transfer could not be completed at this time. Please check your file for viruses or
          try again later.'.PHP_EOL."\n");
          die(); } } 
    if (!file_exists($appInstallDir)) {
      $txt = ('ERROR!!! HRC2AppCore137, There was a problem creating '.$appInstallDir.' on '.$Time.'.'); 
      echo nl2br($txt."\n".PHP_EOL.'--------------------'.PHP_EOL."\n"); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
    if (file_exists($appInstallDir)) {
      $txt = ('OP-Act: Installed App '.$appInstallDir.' on '.$Time.'.'); 
      echo nl2br($txt."\n".PHP_EOL.'--------------------'.PHP_EOL."\n"); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
    unlink ($appInstallDir0); 
    if (!file_exists($appInstallDir0)) {
      $txt = ('OP-Act: Cleaning up on '.$Time.'.'); 
      echo nl2br($txt."\n".PHP_EOL.'--------------------'.PHP_EOL."\n"); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
    if (file_exists($appInstallDir0)) {
      $txt = ('ERROR!!! HRC2AppCore142, There was a problem cleaning up '.$appToInstallRAW.' on '.$Time.'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      die($txt); } } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is perofmed whenever an administrator selects to uninstall an App.
if (isset($_POST['uninstallApplication'])) {
  $uninstallApp = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['uninstallApplication']);
  // / Check that the user is an administrator.
  if ($UserIDRAW !== 1) { 
    $txt = ('WARNING!!! HRC2AppCore36 You are not an administrator!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die($txt); }
  // / Check that the SaltHash is set.
  if (!isset($YUMMYSaltHash)) {
    echo nl2br('WARNING!!! HRC2AppCore60, There was a critical security fault. Login Request Denied.'.PHP_EOL."\n"); 
    die("Application was halted on $Time".'.'); }
  // / Check that the SaltHash is correct.
  if ($YUMMYSaltHash !== $SaltHash) {
    echo nl2br('WARNING!!! HRC2AppCore60, There was a critical security fault. Login Request Denied.'.PHP_EOL."\n"); 
    die("Application was halted on $Time".'.'); }
  $txt = ('OP-Act: Initiated AppCore Uninstaller on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  $uninstallApp = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['uninstallApplication']);
  // / Sets the CleanDir and CleanFiles variables for the Janitor.
  $CleanDir = $InstLoc.'/Applications/'.$uninstallApp;
  @chmod($CleanDir, 0755);
  // / Tests for an errant file instead of a directory, and deletes the file if possible.
  if (file_exists($CleanDir)) {
    if (!is_dir($CleanDir)) {
      unlink($CleanDir); 
      if (!file_exists($CleanDir)) {
        $txt = ('OP-Act: Deleted file '.$CleanDir.' on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        echo nl2br($txt."\n".PHP_EOL.'--------------------'.PHP_EOL."\n"); } 
      if (!file_exists($CleanDir)) {
        $txt = ('ERROR!!! HRC2AppCore165 Could not delete file '.$CleanDir.' on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        echo nl2br($txt."\n".PHP_EOL.'--------------------'.PHP_EOL."\n"); } } }
  if (is_dir($CleanDir)) {
    $txt = ('OP-Act: Executing Janitor on Target: '.$uninstallApp.' on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    echo nl2br($txt."\n".PHP_EOL.'--------------------'.PHP_EOL."\n"); 
    // / Includes the janitor to delete the target App.
    $CleanFiles = scandir($CleanDir);
    include ('janitor.php');
    @unlink ($CleanDir.'/index.html');
    @unlink ($CleanDir.'/'.$uninstallApp.'.php');
    @rmdir ($CleanDir);
    // / Check that the Janitor suceeded in deleting the target App.
    if (!is_dir($CleanDir)) { 
      $txt = ('ERROR!!! HRC2AppCore183 Could not uninstall App '.$uninstallApp.' on '.$Time.'.');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      echo nl2br($txt."\n".PHP_EOL.'--------------------'.PHP_EOL."\n"); }
    if (is_dir($CleanDir)) { 
    $txt = ('OP-Act: Uninstalled App '.$uninstallApp.' on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    echo nl2br($txt."\n".PHP_EOL.'--------------------'.PHP_EOL."\n"); } } } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code gets the App information, like official name, description, 
// / author, and license.
if (!isset($_POST['installApplication']) or !isset($_POST['uninstallApplication'])) {
  foreach ($Apps as $Application) {
    if ($Application == '.' or $Application == '..' or $Application == 'index.html' or in_array($Application, $defaultApps)) continue;
     $ApplicationFile = $InstLoc.'/Applications/'.$Application.'/'.$Application.'.php';
      $lines = @file($ApplicationFile);
      if (!is_file($ApplicationFile)) continue;
      if (is_dir($ApplicationFile)) continue;
      $lineCounter = 0;
      if ($lines == null) continue;
      foreach ($lines as $line) {
        if (strpos($line, 'App Name: ') == 'true') {
          $ApplicationName = str_replace('App Name: ', '', $line); 
          $ApplicationName = trim($ApplicationName); } 
        if (strpos($line, 'App Version: ') == 'true') {
          $ApplicationVersion = str_replace('App Version: ', '', $line); 
          $ApplicationVersion = trim($ApplicationVersion); } 
        if (strpos($line, 'App License: ') == 'true') {
          $ApplicationLicense = str_replace('App License: ', '', $line);  
          $ApplicationLicense = trim($ApplicationLicense); }
        if (strpos($line, 'App Author: ') == 'true') { 
          $ApplicationAuthor = str_replace('App Author: ', '', $line); 
          $ApplicationAuthor = trim($ApplicationAuthor); } 
        if (strpos($line, 'App Description: ') == 'true') {
          $ApplicationDescription = str_replace('App Description: ', '', $line); 
          $ApplicationDescription = trim($ApplicationDescription); } 
        if (strpos($line, 'App Website: ') == 'true') { 
          $ApplicationWebsite = str_replace('App Website: ', '', $line); 
          $ApplicationAWebsite = trim($ApplicationWebsite); } 
        if (strpos($line, 'App Integration: ') == 'true') {
          $ApplicationIntegration = str_replace('App Integration: ', '', $line); 
          $ApplicationIntegration = trim($ApplicationIntegration); } 
        $lineCounter++; } } } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code returns the random file or folder for each Cloud module. 
$files = scandir($CloudUsrDir, SCANDIR_SORT_DESCENDING);
$fileCounter = count($files)*2;
$fileCouner1 = 0;
$random_file = array_rand($files, 1);
$random_file = $files[$random_file];
while ($random_file == '.' or $random_file == '..' or strpos($random_file, '.html') or strpos($random_file, '.php')) {
  if ($fileCounter1 >= $appCounter) {
    $random_file = 'No files to show!';
    break; }
  $random_file = $files[$random_file]; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets a random App to echo for some home screens and GUI's.
$apps = scandir($AppDir, SCANDIR_SORT_DESCENDING);
$appCounter = count($apps)*2;
$appCouner1 = 0;
$random_app = array_rand($apps);
$random_app = $apps[$random_app];
while ($random_app == '.' or $random_app == '..' or in_array($random_app, $defaultApps) or strpos($random_app, '.')) {
  if ($appCounter1 >= $appCounter) {
    $random_app = 'No apps to show!';
    break; }
  $random_app = array_rand($apps);
  $random_app = $apps[$random_app]; }
// / --------------------------------------------------

// / --------------------------------------------------
// / Integrated App-Specific Code
// / Developers can add code here for their integrated apps to have it run whenever the appCore is loaded.

// / The following code sets a random Contact to echo for some home screens and GUI's.
if (!is_dir($ContactsDir)) {
  mkdir($ContactsDir, 0755);
  $txt = ('OP-Act: Created '.$ContactsDir.' on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
$contacts = scandir($ContactsDir, SCANDIR_SORT_DESCENDING);
$contactCounter = count($contacts)*2;
$contactCounter1 = 0;
$random_contact = array_rand($contacts);
$random_contact = $contacts[$random_contact];
while ($random_contact == '.' or $random_contact == '..' or in_array($random_contact, $defaultApps) or strpos($random_contact, '.txt') or strpos($random_contact, '.html')) {
  if ($contactCounter1 >= $contactCounter) {
    $random_contact = 'Create new contact!';
    break; }
  $random_contact = array_rand($contacts);
  $random_contact = $contacts[$random_contact]; 
  $contactCounter1++; }
$random_contact = str_replace('.php', '', $random_contact);

// / The following code sets a random Note to echo for some home screens and GUI's.
if (!is_dir($NotesDir)) {
  mkdir($NotesDir, 0755);
  $txt = ('OP-Act: Created '.$NotesDir.' on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
$notes = scandir($NotesDir, SCANDIR_SORT_DESCENDING);
$noteCounter = count($notes)*2;
$noteCouner1 = 0;
$random_note = array_rand($notes);
$random_note = $notes[$random_note];
while ($random_note == '.' or $random_note == '..' or in_array($random_note, $defaultApps) or strpos($random_note, '.php') or strpos($random_note, '.html')) {
  if ($noteCounter1 >= $noteCounter) {
    $random_note = 'Create new note!';
    break; }
  $random_note = array_rand($notes);
  $random_note = $notes[$random_note]; 
  $noteCounter1++; }
$random_note = str_replace('.txt', '', $random_note);
// / -----------------------------------------------------------------------------------
?>