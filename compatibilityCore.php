<?php



/*
HRCLOUD2 VERSION INFORMATION
THIS VERSION : v0.9,8
WRITTEN ON : 12/7/16 @ 0000 (12:00 am)
*/

// / The follwoing code checks if the CommonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('ERROR!!! HRC2CompatCore14, Cannot process the HRCloud2 Common Core file (commonCore.php).'."\n"); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('ERROR!!! HRC2CompatCore22, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php).'."\n"); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }

$ClearCachePOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['ClearCache']); 
$AutoUpdatePOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['AutoUpdate']); 
$CheckCompatPOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['CheckCompatibility']); 

if ($ClearCachePOST == '1' or $ClearCachePOST == 'true') {
  $txt = ('OP_Act: CompatCore - Cleaning user cache files on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  unlink($UserConfig); 
  if (!file_exists($UserConfig)) { 
    copy($LogInstallDir.'.config.php', $UserConfig); }
  if (!file_exists($UserConfig)) { 
    $txt = ('ERROR!!! HRC2CompatCore151, There was a problem creating the user config file on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die ('ERROR!!! HRC2CompatCore151, There was a problem creating the user config file on '.$Time.'!'); }
  if (file_exists($UserConfig)) {
    require ($UserConfig); } }

// / The following code is performed whenever a user requests that HRCloud2 Auto-Update to the latest version.
// / Will establish a CuRL connection to Github and download the latest Master commit in .zip form and unpack it
  // / to the $InstLoc. Temporary files will then be deleted.
if ($AutoUpdatePOST == '1' or $AutoUpdatePOST == 'true') {
  $DownloadUpdate = 'true';
  $InstallUpdate = 'true';
  $CleanUpdate = 'true';
  $ResourceDir = $InstLoc.'/Resources/TEMP';
  $UpdatedZIP = $ResourceDir.'/HRC2-UPDATE.zip';
  $UpdatedZIP1 = $ResourceDir.'/HRC2-UPDATE.zip';
  $UpdatedZIPURL = 'https://github.com/zelon88/HRCloud2/archive/master.zip';
  $txt = ('OP-Act: Initiating Auto-Updater on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);   
  if ($UserIDRAW !== 1) {
    $txt = ('ERROR!!! HRC2CompatCore43, A non-administrator attempted to update the system on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  if (!file_exists($ResourceDir)) {
    $txt = ('OP-Act: Creating a TEMP directory in /Resources to store pending updates on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    mkdir($ResourceDir, 0755); } }

if ($DownloadUpdate == '1' or $DownloadUpdate == 'true') {
  $txt = ('OP-Act: Opening a connection to Github and downloading data on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  set_time_limit(0);
  $MAKEUpdatedZIP = file_put_contents($UpdatedZIP, fopen($UpdatedZIPURL, 'r')); }

if ($InstallUpdate == '1' or $InstallUpdate == 'true') {
  shell_exec('unzip '.$UpdatedZIP.' -d '.$ResourceDir);
  shell_exec('cd '.$ResourceDir.' ; zip -r ../'.$UpdatedZIP1.' *');
  shell_exec('unzip -o '.$UpdatedZIP1.' -d '.$InstLoc); }

// / The following code cleans and deletes old, unused, or otherwise deprecated files from HRCloud2.
if ($CheckCompatPOST == '1' or $CheckCompatPOST == 'true') {
  $txt = ('OP-Act: Initiating Compatibility Checker on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  
  $txt = ('OP-Act: Scanning HRCloud2 Installation directories for deprecated files on'.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  if (file_exists($InstLoc.'/createUserFiles.php')) {
    @unlink($InstLoc.'/createUserFiles.php'); }
  if (file_exists($InstLoc.'/DocScan.php')) {
    @unlink($InstLoc.'/DocScan.php'); }
  if (file_exists($InstLoc.'/clipboardTester.php')) {
    @unlink($InstLoc.'/clipboardTester.php'); }
  if (file_exists($InstLoc.'/TEST.php')) {
    @unlink($InstLoc.'/TEST.php'); }
  if (file_exists($InstLoc.'/TEST1.php')) {
    @unlink($InstLoc.'/TEST1.php'); }
  if (file_exists($InstLoc.'/TEST2.php')) {
    @unlink($InstLoc.'/TEST2.php'); }
  if (file_exists($InstLoc.'/TEST3.php')) {
    @unlink($InstLoc.'/TEST3.php'); }
  if (file_exists($InstLoc.'/TEST4.php')) {
    @unlink($InstLoc.'/TEST4.php'); } } 