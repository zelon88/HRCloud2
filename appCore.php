<?php

// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2AppCore5, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('ERROR!!! HRC2AppCore13, Cannot process the HRCloud2 Common Core file (commonCore.php).'."\n"); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

// / The follwoing code checks if the securityCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/securityCore.php')) {
  echo nl2br('ERROR!!! HRC2AppCore21, Cannot process the HRCloud2 Security Core file (securityCore.php).'."\n"); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/securityCore.php'); }
  
// / The following code sets the global variables for the session.
$AppDir = $InstLoc.'/Applications/';
$Apps = scandir($AppDir);
$defaultApps = array('.', '..', '', 'jquery-3.1.0.min.js', 'index.html', 'HRAI', 'HRConvert2', 
  'HRStreamer', 'getID3-1.9.12', 'displaydirectorycontents_logs', 'displaydirectorycontents_logs1', 
  'displaydirectorycontents_72716', 'displaydirectorycontents_shared', 'wordpress_11416.zip');
$installedApps = array_diff($Apps, $defaultApps);
if (isset($_POST['uninstallApplication'])) { 
  $uninstallApp = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['uninstallApplication']); }
$apps = scandir($AppDir, SCANDIR_SORT_DESCENDING);

// / The following code will be performed when an administrator selects to install an HRCloud2 App..
if (isset($_POST['installApplication'])) {
  // / Perform security check (UserID).
  if ($UserIDRAW !== 1) { 
    $txt = ('!!! WARNING !!! HRC2AppCore30 You are not an administrator!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die($txt); }
if (!isset($YUMMYSaltHash)) {
  echo nl2br('!!! WARNING !!! HRC2AppCore41, There was a critical security fault. Login Request Denied.'."\n"); 
  die("Application was halted on $Time".'.'); }
if ($YUMMYSaltHash !== $SaltHash) {
  echo nl2br('!!! WARNING !!! HRC2AppCore41, There was a critical security fault. Login Request Denied.'."\n"); 
  die("Application was halted on $Time".'.'); }
if (isset($_FILES["appToUpload"])) {
  // / Perform security check (SaltHash).
  $txt = ('OP-Act: Initiated AppCore Uploader on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  if (!is_array($_FILES["appToUpload"])) {
    $_FILES["appToUpload"] = array($_FILES["appToUpload"]['name']); }
  foreach ($_FILES['appToUpload']['name'] as $key=>$file) {
    if ($file == '.' or $file == '..' or $file == 'index.html') continue;
    $appToInstallRAW = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $file);
    $installableArr = array('zip', 'rar', 'tar', 'tar.bz', 'tar.bz2', 'tar.gz', '7z'); 
    foreach ($installableArr as $extToTest) {
      if (strpos($appToInstallRAW, $extToTest)) {
        $appExt = $extToTest; } }
    $appToInstall = str_replace('.'.$appExt, '', $appToInstallRAW);
    $appInstallDir = $InstLoc.'/Applications/'.$appToInstall;
    $appInstallDir0 = $InstLoc.'/Applications/'.$appToInstallRAW;
      $file = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $file);      
      $file = str_replace(" ", "_", $file);
      $DangerousFiles = array('js', 'php', 'html', 'css');
      $F0 = pathinfo($file, PATHINFO_EXTENSION);
      if (in_array($F0, $DangerousFiles)) { 
        $file = str_replace($F0, $F0.'SAFE', $file); }
      $F2 = pathinfo($file, PATHINFO_BASENAME);
      if($file == "") {
        $txt = ("ERROR!!! HRC2AppCore160, No file specified on $Time.");
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
        die("ERROR!!! HRC2AppCore160, No file specified on $Time."); }
      $txt = ('OP-Act: '."Uploaded $file to $CloudTmpDir on $Time".'.');
      echo nl2br ('OP-Act: '."Uploaded $file on $Time".'.'.'.'."\n".'--------------------'."\n");
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
      $COPY_TEMP = copy($_FILES['appToUpload']['tmp_name'][$key], $appInstallDir0); 
    $txt = ('OP-Act: Initiated AppCore Dearchiver on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
      $allowed =  $installableArr;
      $archarray = $installableArr;
      $rararr = array('rar');
      $ziparr = array('zip');
      $tararr = array('7z', 'tar', 'tar.gz', 'tar.bz2');
      $filename = str_replace(" ", "_", $File);
      $filename1 = pathinfo($appInstallDir0, PATHINFO_BASENAME);
      $filename2 = pathinfo($appInstallDir0, PATHINFO_FILENAME);
      $ext = pathinfo($appInstallDir0, PATHINFO_EXTENSION);  
      if (!in_array($ext, $installableArr)) {
        $txt = ('ERROR!!! HRC2AppCore40, The '.$file.' is not a valid archive format on '.$Time.'!');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
        die($txt); }
      // / Create the new App directory in Applications/
      if (!file_exists($appInstallDir)) {
        mkdir($appInstallDir); }

      echo nl2br ('OP-Act: Dearchiving '.$appToInstallRAW.' to '.$filename2.' on '.$Time.'.'."\n".'--------------------'."\n"); 
      // / Handle dearchiving of rar compatible files.
      if(in_array($ext,$rararr)) {
        shell_exec('unrar e '.$appInstallDir0.' '.$AppDir);
        $txt = ('OP-Act: '."Installed $appInstallDir0. to $appInstallDir on $Time".'.'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } 
      // / Handle dearchiving of .zip compatible files.
      if(in_array($ext,$ziparr)) {
        shell_exec('unzip '.$appInstallDir0.' -d '.$AppDir);
        $txt = ('OP-Act: '."Installed $appInstallDir0. to $appInstallDir on $Time".'.'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } 
      // / Handle dearchiving of 7zipper compatible files.
      if(in_array($ext,$tararr)) {
        shell_exec('7z e'.$AppDir.'.'.$ext.' '.$appInstallDir0); 
        $txt = ('OP-Act: '."Installed $appInstallDir0. to $appInstallDir on $Time".'.'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }

            // / Check the Cloud Location with ClamAV before archiving, just in case.
      if ($VirusScan == '1') {
        shell_exec('clamscan -r '.$appInstallDir0.' | grep FOUND >> '.$ClamLogDir); 
      if (filesize($ClamLogDir > 1)) {
        echo nl2br('WARNING HRC2AppCore110, There were potentially infected files detected. The file
          transfer could not be completed at this time. Please check your file for viruses or
          try again later.'."\n");
          die(); }
        shell_exec('clamscan -r '.$appInstallDir.' | grep FOUND >> '.$ClamLogDir); 
      if (filesize($ClamLogDir > 1)) {
        echo nl2br('WARNING HRC2AppCore116, There were potentially infected files detected. The file
          transfer could not be completed at this time. Please check your file for viruses or
          try again later.'."\n");
          die(); } } 
    if (!file_exists($appInstallDir)) {
      $txt = ('ERROR!!! HRC2AppCore137, There was a problem creating '.$appInstallDir.' on '.$Time.'.'); 
      echo nl2br ($txt."\n".'--------------------'."\n"); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
    if (file_exists($appInstallDir)) {
      $txt = ('OP-Act: Installed App '.$appInstallDir.' on '.$Time.'.'); 
      echo nl2br ($txt."\n".'--------------------'."\n"); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
    unlink ($appInstallDir0); 
    if (!file_exists($appInstallDir0)) {
      $txt = ('OP-Act: Cleaning up on '.$Time.'.'); 
      echo nl2br ($txt."\n".'--------------------'."\n"); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } 
    if (file_exists($appInstallDir0)) {
      $txt = ('ERROR!!! HRC2AppCore142, There was a problem cleaning up '.$appToInstallRAW.' on '.$Time.'.'); 
      echo nl2br ($txt."\n".'--------------------'."\n"); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }} } }
  
// / The following code is perofmed whenever an administrator selects to uninstall a new App.
if (isset($_POST['uninstallApplication'])) {
  $uninstallApp = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['uninstallApplication']);
  // / Check that the user is an administrator.
  if ($UserIDRAW !== 1) { 
    $txt = ('!!! WARNING !!! HRC2AppCore36 You are not an administrator!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die($txt); }
  // / Check that the SaltHash is set.
  if (!isset($YUMMYSaltHash)) {
    echo nl2br('!!! WARNING !!! HRC2AppCore60, There was a critical security fault. Login Request Denied.'."\n"); 
    die("Application was halted on $Time".'.'); }
  // / Check that the SaltHash is correct.
  if ($YUMMYSaltHash !== $SaltHash) {
    echo nl2br('!!! WARNING !!! HRC2AppCore60, There was a critical security fault. Login Request Denied.'."\n"); 
    die("Application was halted on $Time".'.'); }
  $txt = ('OP-Act: Initiated AppCore Uninstaller on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
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
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
        echo nl2br($txt."\n".'--------------------'."\n"); } 
      if (!file_exists($CleanDir)) {
        $txt = ('ERROR!!! HRC2AppCore165 Could not delete file '.$CleanDir.' on '.$Time.'.');
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
        echo nl2br($txt."\n".'--------------------'."\n"); } } }
  if (is_dir($CleanDir)) {
  $CleanFiles = scandir($CleanDir);
  echo nl2br('OP-Act: Executing Janitor on Target: '.$uninstallApp.' on '.$Time.'.'."\n".'--------------------'."\n");
  // / Includes the janitor to delete the target App.
  include ('janitor.php');
  @unlink ($CleanDir.'/index.html');
  @unlink ($CleanDir.'/'.$uninstallApp.'.php');
  @rmdir ($CleanDir);
  // / Check that the Janitor suceeded in deleting the target App.
  if (!file_exists($CleanDir)) {
    $txt = ('OP-Act: Uninstalled App '.$uninstallApp.' on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br($txt."\n".'--------------------'."\n"); }
  if (file_exists($CleanDir)) {
    $txt = ('ERROR!!! HRC2AppCore183 Could not uninstall App '.$uninstallApp.' on '.$Time.'.'."\n".'--------------------'."\n");
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    echo nl2br($txt."\n".'--------------------'."\n"); } } }

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

// / The following code returns the random file or folder for each Cloud module. 
$files = scandir($CloudUsrDir, SCANDIR_SORT_DESCENDING);
$random_file = array_rand($files, 1);
$random_file = $files[$random_file];
if ($random_file == '.' or $random_file == '..') {
  $random_file = $files[$random_file]; }
if ($random_file == '.' or $random_file == '..') {
  $random_file = $files[$random_file]; }  
if ($random_file == '.' or $random_file == '..') {
  $random_file = $files[$random_file]; }
if ($random_file == '.' or $random_file == '..') {
  $random_file = 'No files to show!'; } 
if ($random_file == '') {
  $random_file = 'No files to show!'; } 

// / The following code sets a random App to echo for some home screens and GUI's.
$apps = scandir($AppDir, SCANDIR_SORT_DESCENDING);
$random_app = array_rand($apps);
$random_app = $apps[$random_app];
if ($random_app == '.' or $random_app == '..' or in_array($random_app, $defaultApps)) {
  $random_app = array_rand($apps);
  $random_app = $apps[$random_app]; }
if ($random_app == '.' or $random_app == '..' or in_array($random_app, $defaultApps)) {
  $random_app = array_rand($apps);
  $random_app = $apps[$random_app]; }
if ($random_app == '.' or $random_app == '..' or in_array($random_app, $defaultApps)) {
  $random_app = array_rand($apps);
  $random_app = $apps[$random_app]; }
if ($random_app == '.' or $random_app == '..' or in_array($random_app, $defaultApps)) {
  $random_app = array_rand($apps);
  $random_app = $apps[$random_app]; }
if ($random_app == '.' or $random_app == '..' or in_array($random_app, $defaultApps)) {
  $random_app = array_rand($apps);
  $random_app = $apps[$random_app]; }
if ($random_app == '.' or $random_app == '..' or in_array($random_app, $defaultApps)) {
  $random_app = array_rand($apps);
  $random_app = $apps[$random_app]; }
if ($random_app == '.' or $random_app == '..' or in_array($random_app, $defaultApps)) {
  $random_app = 'No apps to show!'; }


// / --------------------------------------------------
// / Integrated App-Specific Code
// / Developers can add code here for their integrated apps to have it run whenever the appCore is loaded.

// / The following code sets a random Contact to echo for some home screens and GUI's.
if (!is_dir($ContactsDir)) {
  mkdir($ContactsDir, 0755);
    $txt = ('OP-Act: Created '.$ContactsDir.' on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
$contacts = scandir($ContactsDir, SCANDIR_SORT_DESCENDING);
$random_contact = array_rand($contacts);
$random_contact = $contacts[$random_contact];
if ($random_contact == '.' or $random_contact == '..' or in_array($random_contact, $defaultApps) or strpos($random_contact, '.txt') == 'true') {
  $random_contact = 'No contacts to show!'; }
if ($random_contact == 'contacts.php') { 
  $random_contact = 'No contacts to show!'; }
$random_contact = str_replace('.php', '', $random_contact);

// / The following code sets a random Note to echo for some home screens and GUI's.
if (!is_dir($NotesDir)) {
  mkdir($NotesDir, 0755);
    $txt = ('OP-Act: Created '.$NotesDir.' on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
$notes = scandir($NotesDir, SCANDIR_SORT_DESCENDING);
$random_note = array_rand($notes);
$random_note = $notes[$random_note];
if ($random_note == '.' or $random_note == '..' or in_array($random_note, $defaultApps) or strpos($random_note, '.txt') == 'true' 
  or strpos($random_note, '.php') == 'true') {
  $random_note = array_rand($notes);
  $random_note = $notes[$random_note]; }
if ($random_note == '.' or $random_note == '..' or in_array($random_note, $defaultApps) or strpos($random_note, '.txt') == 'true' 
  or strpos($random_note, '.php') == 'true') {
  $random_note = array_rand($notes);
  $random_note = $notes[$random_note]; }
if ($random_note == '.' or $random_note == '..' or in_array($random_note, $defaultApps) or strpos($random_note, '.txt') == 'true' 
  or strpos($random_note, '.php') == 'true') {
  $random_note = array_rand($notes);
  $random_note = $notes[$random_note]; }
$random_note = str_replace('.txt', '', $random_note);
if ($random_note == '.' or $random_note == '..' or in_array($random_note, $defaultApps) or $random_note == '' 
  or strpos($random_note, '.txt') == 'true' or strpos($random_note, '.php') == 'true') {
  $random_note = 'No notes to show!'; } 
?>