<?php
// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2AppCore5, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once('sanitizeCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('commonCore.php')) {
  echo nl2br('ERROR!!! HRC2AppCore13, Cannot process the HRCloud2 Common Core file (commonCore.php).'."\n"); 
  die (); }
else {
  require_once('commonCore.php'); }
  
// / The following code sets the global variables for the session.
$AppDir = $InstLoc.'/Applications/';
$Apps = scandir($AppDir);
$uninstallApp = $_POST['uninstallApplication'];
$defaultApps = array('.', '..', '', 'jquery-3.1.0.min.js', 'index.html', 'HRAI', 'HRConvert2', 
  'HRStreamer', 'getID3-1.9.12', 'displaydirectorycontents_logs', 'displaydirectorycontents_logs1', 
  'displaydirectorycontents_72716', 'wordpress_11416.zip');
$installedApps = array_diff($Apps, $defaultApps);

// / The following code is perofmed whenever an administrator selects to install a new App.
if (isset($_POST['installApplication'])) {
  if ($UserIDRAW == '1') {
  $_POST['installApplication'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['installApplication']);
  $appToInstall = $_POST['installApplication']; } } 
  
// / The following code is perofmed whenever an administrator selects to uninstall a new App.
$uninstallApp = $_POST['uninstallApplication'];
if (isset($uninstallApp)) {
  if ($UserIDRAW !== 1) { 
    $txt = ('!!! WARNING !!! HRC2AppCore36 You are not an administrator!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die($txt); }
  if ($UserIDRAW == 1) {
  $_POST['installApplication'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['uninstallApplication']);
if (isset($uninstallApp)) {
  if (!isset($YUMMYSaltHash)) {
  echo nl2br('!!! WARNING !!! HRC2AppCore60, There was a critical security fault. Login Request Denied.'."\n"); 
  die("Application was halted on $Time".'.'); }
if ($YUMMYSaltHash !== $SaltHash) {
  echo nl2br('!!! WARNING !!! HRC2AppCore60, There was a critical security fault. Login Request Denied.'."\n"); 
  die("Application was halted on $Time".'.'); }
  $CleanDir = $InstLoc.'/Applications/'.$uninstallApp;
  @chmod($CleanDir, 0755);
  $CleanFiles = scandir($CleanDir);
  include ('janitor.php');
  unlink($CleanDir.'/index.html');
  rmdir($CleanDir);
  if (!file_exists($InstLoc.'/Applications/'.$uninstallApp)) {
    $txt = ('ERROR!!! HRC2AppCore53 Could not clean directory '.$CleanFile.' on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } } } 


// / The following code gets the App information, like official name, description, 
// / author, and license.
foreach ($Apps as $Application) {
  if ($Application == '.' or $Application == '..' or $Application == 'index.html' or in_array($Application, $defaultApps)) continue;
  $ApplicationFile = $InstLoc.'/Applications/'.$Application.'/'.$Application.'.php';
  $lines = file($ApplicationFile);
  $lineCounter = 0;
  foreach ($lines as $line) {
    if (strpos('App Name: ', $line) == 'true') {
      $ApplicationName = str_replace('App Name: ', '', $lines[$lineCounter]); } 
    if (strpos('App Version: ', $line) == 'true') {
      $ApplicationName = str_replace('App Version: ', '', $lines[$lineCounter]); } 
    if (strpos('App License: ', $line) == 'true') {
      $ApplicationName = str_replace('App License: ', '', $lines[$lineCounter]); } 
    if (strpos('App Author: ', $line) == 'true') {
      $ApplicationName = str_replace('App Author: ', '', $lines[$lineCounter]); } 
    if (strpos('App Description: ', $line) == 'true') {
      $ApplicationName = str_replace('App Description: ', '', $lines[$lineCounter]); } 
    if (strpos('App Integration: ', $line) == 'true') {
      $ApplicationName = str_replace('App Integration: ', '', $lines[$lineCounter]); } 
    $lineCounter++; } }  

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

// / The following code sets a random Contact to echo for some home screens and GUI's.
$contacts = scandir($ContactsDir, SCANDIR_SORT_DESCENDING);
$random_contact = array_rand($contacts);
$random_contact = $contacts[$random_contact];
if ($random_contact == '.' or $random_contact == '..' or strpos($random_contact, 'contacts.php') == 'true') {
  $random_contact = 'No contacts to show!'; }
if ($random_contact == 'contacts.php') { 
  $random_contact = 'No contacts to show!'; }

// / The following code sets a random Note to echo for some home screens and GUI's.
$notes = scandir($NotesDir, SCANDIR_SORT_DESCENDING);
$random_note = array_rand($notes);
$random_note = $notes[$random_note];
if ($random_note == '.' or $random_note == '..') {
  $random_note = array_rand($notes);
  $random_note = $notes[$random_note]; }
if ($random_note == '.' or $random_note == '..') {
  $random_note = array_rand($notes);
  $random_note = $notes[$random_note]; }
if ($random_note == '.' or $random_note == '..') {
  $random_note = array_rand($notes);
  $random_note = $notes[$random_note]; }
$random_note = str_replace('.txt', '', $random_note);
if ($random_note == '.' or $random_note == '..' or $random_note == '') {
  $random_note = 'No notes to show!'; } 
?>