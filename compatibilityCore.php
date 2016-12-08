<?php



/*
HRCLOUD2 VERSION INFORMATION
THIS VERSION : v0.9,8
WRITTEN ON : 12/7/16
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
$AutoDownloadPOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['AutoDownload']); 
$AutoInstallPOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['AutoInstall']); 
$AutoCleanPOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['AutoClean']); 
$CheckCompatPOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['CheckCompatibility']); 
$ResourceDir = $InstLoc.'/Resources/TEMP';
$ResourceDir1 = $ResourceDir.'/HRCLOUD2-master';
$UpdatedZIP = $ResourceDir.'/HRC2-UPDATE.zip';
$UpdatedZIP1 = $ResourceDir.'/HRC2-UPDATE';
$UpdatedZIPURL = 'https://github.com/zelon88/HRCloud2/archive/master.zip';
$HRC2Config = $InstLoc.'/config.php';
$HRAIConfig = $InstLoc.'/Applications/HRAI/adminINFO.php';

if ($ClearCachePOST == '1' or $ClearCachePOST == 'true') {
  $txt = ('OP_Act: Initiated User Cache Cleaner on '.$Time.'.');
  echo nl2br ($txt."\n");
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  unlink($UserConfig); 
  if (!file_exists($UserConfig)) { 
    copy($LogInstallDir.'.config.php', $UserConfig); }
  if (!file_exists($UserConfig)) { 
    $txt = ('ERROR!!! HRC2CompatCore151, There was a problem creating the user config file on '.$Time.'!'); 
    echo nl2br ($txt."\n");
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die ('ERROR!!! HRC2CompatCore151, There was a problem creating the user config file on '.$Time.'!'); }
  if (file_exists($UserConfig)) {
    require ($UserConfig); } }

// / The following code is performed whenever a user requests that HRCloud2 Auto-Update to the latest version.
// / Will establish a CuRL connection to Github and download the latest Master commit in .zip form and unpack it
  // / to the $InstLoc. Temporary files will then be deleted.
if ($AutoUpdatePOST == '1' or $AutoUpdatePOST == 'true'  or $AutoUpdatePOST == 'Automatic Update') {
  $AutoDownloadPOST = 'true';
  $AutoInstallPOST = 'true';
  $AutoCleanPOST = 'true';
  $CheckCompatPOST = 'true';
  $txt = ('OP-Act: Initiating Auto-Updater on '.$Time.'.'); 
  echo nl2br ($txt."\n");
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);   
  if ($UserIDRAW !== 1) {
    $txt = ('ERROR!!! HRC2CompatCore43, A non-administrator attempted to update the system on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die($txt); }
  if (!file_exists($ResourceDir)) {
    mkdir($ResourceDir, 0755); 
    $txt = ('OP-Act: Created a TEMP directory in /Resources to store pending updates on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }

if ($AutoDownloadPOST == '1' or $AutoDownloadPOST== 'true' or $AutoDownloadPOST == 'Download Update') {
  $txt = ('OP-Act: Initiating update "Auto-Downloader" on '.$Time.'.'); 
  echo nl2br ($txt."\n");
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);   
  set_time_limit(0);
  $MAKEUpdatedZIP = file_put_contents($UpdatedZIP, fopen($UpdatedZIPURL, 'r')); 
  $txt = ('OP-Act: Opened a connection to Github and downloading data on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  set_time_limit(0); 
  if (!file_exists($UpdatedZIP)) {
    $txt = ('ERROR!!! HRC2CompatCore79, Could not download the HRCLOUD2.zip file from Github on '.$Time.'.'); 
    echo nl2br ($txt."\n");
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die ($txt); } 
  if (file_exists($UpdatedZIP)) {
    $txt = ('OP-Act: The latest version of HRCloud2 was sucessfully downloaded on '.$Time.'.'); 
    echo nl2br ($txt."\n");
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }

if ($AutoInstallPOST == '1' or $AutoInstallPOST == 'true' or $AutoInstallPOST == 'Install Update') {
  $txt = ('OP-Act: Initiating update "Auto-Installer" on '.$Time.'.'); 
  echo nl2br ($txt."\n");
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);   
  shell_exec('unzip '.$UpdatedZIP.' -d '.$ResourceDir);
  $txt = ('OP-Act: Unpacked archive on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  shell_exec('zip -r '.$UpdatedZIP1.'/*');
  $txt = ('OP-Act: Created an installation image on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  shell_exec('unzip -o '.$UpdatedZIP1.' -d '.$InstLoc); 
  $txt = ('OP-Act: Unpacked the installation image on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  if (!file_exists($ResourceDir1.'/versionInfo.php')) {
    $txt = ('ERROR!!! HRC2CompatCore110, There was a problem unpacking the installation image on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die ($txt); }
  require ($ResourceDir1.'/versionInfo.php'); 
  $Version1 = $Version;
  require ($InstLoc.'/versionInfo.php'); 
  if ($Version1 !== $Version) {
    $txt = ('ERROR!!! HRC2CompatCore94, Version discrepency detected after unpacking the installation image on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    $txt = ('OP-Act: Continuing with errors on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  if ($Version1 == $Version) {
    $txt = ('OP-Act: Sucessfully installed version '.$Version.' of HRCloud2 on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } 
  $BAKinc = '';
  while (file_exists($InstLoc.'/configBACKUP'.$BAKinc.'.php')) {
    $BAKinc++; }
  $txt = ('OP-Act: Preserving server configuration data on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  copy ($InstLoc.'/config.php', $InstLoc.'/configBACKUP'.$BAKinc.'.php'); 
  rename ($UpdatedZIP1.'/config.php', $UpdatedZIP1.'/configLATEST.php');
  copy ($InstLoc.'/config.php', $UpdatedZIP1.'/config.php'); 
  require ($UpdatedZIP1.'/versionInfo.php'); 
  $Version1 = $Version;
  require ($InstLoc.'/versionInfo.php'); 
  if ($Version1 !== $Version) {
    $txt = ('ERROR!!! HRC2CompatCore94, Version discrepency detected after unpacking the installation image on '.$Time.'!'); 
    echo nl2br ($txt."\n");
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    $txt = ('OP-Act: Continuing with errors on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  if ($Version1 == $Version) {
    $txt = ('OP-Act: Sucessfully installed version '.$Version.' of HRCloud2 on '.$Time.'.'); 
    echo nl2br ($txt."\n");
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }

if ($AutoCleanPOST == '1' or $AutoCleanPOST == 'true' or $AutoCleanPOST == 'Clean Update') {
  $txt = ('OP-Act: Initiating update "Auto-Cleaner" on '.$Time.'.'); 
  echo nl2br ($txt."\n");
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  if (!file_exists($UpdatedZIP)) {
    $txt = ('Warning!!! HRC2CompatCore151, There was no installation images to clean on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die ($txt); 
    unlink($UpdatedZIP); }
  $txt = ('OP-Act: Deleted temporary update files on '.$Time.'.'); 
  echo nl2br ($txt."\n");
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);   }

// / The following code cleans and deletes old, unused, or otherwise deprecated files from HRCloud2.
if ($CheckCompatPOST == '1' or $CheckCompatPOST == 'true'  or $CheckCompatPOST == 'Check Compatibility') {
  $txt = ('OP-Act: Initiating Compatibility Checker on '.$Time.'.'); 
  echo nl2br ($txt."\n");
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);

  if (file_exists($InstLoc.'/createUserFiles.php')) {
    @unlink($InstLoc.'/createUserFiles.php'); }
  if (file_exists($InstLoc.'/DocScan.php')) {
    @unlink($InstLoc.'/DocScan.php'); }
  if (file_exists($InstLoc.'/clipboardTester.php')) {
    @unlink($InstLoc.'/clipboardTester.php'); }
  if (file_exists($InstLoc.'/clipboardTESTER.php')) {
    @unlink($InstLoc.'/clipboardTESTER.php'); }
  if (file_exists($InstLoc.'/TEST.php')) {
    @unlink($InstLoc.'/TEST.php'); }
  if (file_exists($InstLoc.'/TEST1.php')) {
    @unlink($InstLoc.'/TEST1.php'); }
  if (file_exists($InstLoc.'/TEST2.php')) {
    @unlink($InstLoc.'/TEST2.php'); }
  if (file_exists($InstLoc.'/TEST3.php')) {
    @unlink($InstLoc.'/TEST3.php'); }
  if (file_exists($InstLoc.'/TEST4.php')) {
    @unlink($InstLoc.'/TEST4.php'); } 
  $txt = ('OP-Act: Cleaned and optimized HRCloud2 on'.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  require ($ResourceDir1.'/versionInfo.php'); 
  $Version1 = $Version;
  require ($InstLoc.'/versionInfo.php'); 
  if ($Version1 > $Version) {
    $txt = ('OP-Act: The verson '.$Version.' of HRCloud2 stored in the update queue is newer than the one already installed on '.$Time.'.'); 
    echo nl2br ($txt."\n");
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    $txt = ('OP-Act: Continuing with errors on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  if ($Version1 < $Version) {
    $txt = ('OP-Act: The verson '.$Version.' of HRCloud2 stored in the update queue is older than the one already installed on '.$Time.'.'); 
    echo nl2br ($txt."\n");
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    $txt = ('OP-Act: Continuing with errors on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  if ($Version1 == $Version) {
    $txt = ('OP-Act: The verson '.$Version.' of HRCloud2 stored in the update queue is already installed on '.$Time.'.'); 
    echo nl2br ($txt."\n");
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }  