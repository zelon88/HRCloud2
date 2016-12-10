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

// / The following code sets the global variables for the session.
$ClearCachePOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['ClearCache']); 
$AutoUpdatePOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['AutoUpdate']); 
$AutoDownloadPOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['AutoDownload']); 
$AutoInstallPOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['AutoInstall']); 
$AutoCleanPOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['AutoClean']); 
$CheckCompatPOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['CheckCompatibility']); 
$ResourceDir = $InstLoc.'/Resources/TEMP';
$ResourceDir1 = $ResourceDir.'/HRCloud2-master';
$UpdatedZIP = $ResourceDir.'/HRC2-UPDATE.zip';
$UpdatedZIP1 = $ResourceDir.'/HRCloud2';
$UpdatedZIPURL = 'https://github.com/zelon88/HRCloud2/archive/master.zip';
$HRC2Config = $InstLoc.'/config.php';
$HRAIConfig = $InstLoc.'/Applications/HRAI/adminINFO.php';

// / The following code is performed whenever an admin selects to 
if ($ClearCachePOST == '1' or $ClearCachePOST == 'true') {
  $txt = ('OP_Act: Initiated User Cache Cleaner on '.$Time.'.');
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  if ($UserIDRAW !== 1) {
    $txt = ('ERROR!!! HRC2CompatCore51, A non-administrator attempted to clear the global system cache on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die($txt.'<hr />'); }
  unlink($UserConfig); 
  if (!file_exists($UserConfig)) { 
    copy($LogInstallDir.'.config.php', $UserConfig); }
  if (!file_exists($UserConfig)) { 
    $txt = ('ERROR!!! HRC2CompatCore151, There was a problem creating the user config file on '.$Time.'!'); 
    echo nl2br ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die ($txt.'<hr />'); }
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
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);   
  if ($UserIDRAW !== 1) {
    $txt = ('ERROR!!! HRC2CompatCore43, A non-administrator attempted to update the system on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die($txt.'<hr />'); }
  if (!file_exists($ResourceDir)) {
    mkdir($ResourceDir, 0755); 
    $txt = ('OP-Act: Created a TEMP directory in /Resources to store pending updates on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }

// / The following code is performed whenever a user selects to manually download an update package.
if ($AutoDownloadPOST == '1' or $AutoDownloadPOST== 'true' or $AutoDownloadPOST == 'Download Update') {
  $txt = ('OP-Act: Initiating update "Auto-Downloader" on '.$Time.'.'); 
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);   
  if ($UserIDRAW !== 1) {
    $txt = ('ERROR!!! HRC2CompatCore89, A non-administrator attempted to download a system update on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die($txt.'<hr />'); }
  set_time_limit(0);
  $MAKEUpdatedZIP = file_put_contents($UpdatedZIP, fopen($UpdatedZIPURL, 'r')); 
  $txt = ('OP-Act: Opened a connection to Github and downloading data on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  set_time_limit(0); 
  if (!file_exists($UpdatedZIP)) {
    $txt = ('ERROR!!! HRC2CompatCore79, Could not download the HRCLOUD2.zip file from Github on '.$Time.'.'); 
    echo nl2br ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die ($txt.'<hr />'); } 
  if (file_exists($UpdatedZIP)) {
    $txt = ('OP-Act: The latest version of HRCloud2 was sucessfully downloaded on '.$Time.'.'); 
    echo nl2br ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }

// / The following code is performed whenever a user selects to perform a manual installation of the cached update package.
if ($AutoInstallPOST == '1' or $AutoInstallPOST == 'true' or $AutoInstallPOST == 'Install Update') {
  $txt = ('OP-Act: Initiating update "Auto-Installer" on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  echo nl2br ($txt.'<hr />');
  if ($UserIDRAW !== 1) {
    $txt = ('ERROR!!! HRC2CompatCore51, A non-administrator attempted to install a cached update on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die($txt.'<hr />'); }
  if (file_exists($UpdatedZIP)) {  
    shell_exec('unzip '.$UpdatedZIP.' -d '.$ResourceDir);
    $txt = ('OP-Act: Unpacked archive on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    if (!file_exists($UpdatedZIP)) { 
      $txt = ('ERROR!!! HRC2CompatCore108, There are no stored update packages on '.$Time.'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
      echo nl2br ($txt.'<hr />'); 
      die($txt.'<hr />'); }
    unlink($UpdatedZIP);
    shell_exec('zip -o -R '.$UpdatedZIP.' '.$ResourceDir1.'/* ');
    $txt = ('OP-Act: Created an installation image on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } 
  if (!file_exists($ResourceDir1.'/versionInfo.php')) {
    $txt = ('ERROR!!! HRC2CompatCore110, The installation image was missing critical HRCloud2 files on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die ($txt.'<hr />'); }

  // / The following code checks the HRCloud2 version and stops the update process if an old version was prepared.
  require ($ResourceDir1.'/versionInfo.php'); 
  $Version1 = $Version;
  require ($InstLoc.'/versionInfo.php'); 
  if ($Version1 < $Version) {
    $txt = ('ERROR!!! HRC2CompatCore94, The pending HRCloud2 update is older than the one already in use on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die ($txt.'<hr />'); }

  // / The following code preserves the base HRCloud2 configuration files to be restored after the update.
  $txt = ('OP-Act: Preserving server configuration data on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    $BAKinc = '';
  while (file_exists($InstLoc.'/configBACKUP'.$BAKinc.'.php')) {
    $BAKinc++; }
  copy ($InstLoc.'/config.php', $InstLoc.'/configBACKUP'.$BAKinc.'.php'); 
  rename ($ResourceDir1.'/config.php', $ResourceDir1.'/configLATEST.php');
  copy ($InstLoc.'/config.php', $ResourceDir1.'/config.php'); 

  // / The following code preserves HRAI configuration files to be restored after the update.
    $BAKinc1 = '';
  while (file_exists($InstLoc.'Applications/HRAI/adminINFOBACKUP'.$BAKinc1.'.php')) {
    $BAKinc1++; }
  copy ($InstLoc.'/Applications/HRAI/adminINFO.php', $InstLoc.'/Applications/HRAI/adminINFO'.$BAKinc.'.php'); 
  rename ($ResourceDir1.'/Applications/HRAI/adminINFO.php', $ResourceDir1.'/Applications/HRAI/adminINFOLATEST.php');
  copy ($InstLoc.'/Applications/HRAI/adminINFO.php', $ResourceDir1.'/Applications/HRAI/adminINFO.php'); 

  // / The following code unzips the prepared HRCloud2 installation archive (aka 'image') to the $InstLoc.
  shell_exec('unzip -o '.$UpdatedZIP.' -d '.$InstLoc); 
  $txt = ('OP-Act: Unpacked the installation image on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 

  // / The following code checks that HRCloud2 was sucessfully updated..
  require ($ResourceDir1.'/versionInfo.php'); 
  $Version1 = $Version;
  require ($InstLoc.'/versionInfo.php'); 
  if ($Version1 !== $Version) {
    $txt = ('ERROR!!! HRC2CompatCore94, Version discrepency detected after unpacking the installation image on '.$Time.'!'."\n".
      '    Important Note: Manual install reccomended! If problem persists, use a terminal window or file manager to update.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die ($txt.'<hr />'); }
  if ($Version1 == $Version) {
    if ($Version1 == $Version) {
      $txt = ('OP-Act: Sucessfully installed version '.$Version.' of HRCloud2 on '.$Time.'.'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } } 

if ($AutoCleanPOST == '1' or $AutoCleanPOST == 'true' or $AutoCleanPOST == 'Clean Update') {
  $txt = ('OP-Act: Initiating update "Auto-Cleaner" on '.$Time.'.'); 
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  if ($UserIDRAW !== 1) {
    $txt = ('ERROR!!! HRC2CompatCore184, A non-administrator attempted to clear the system update cache on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die($txt.'<hr />'); }
  if (!file_exists($UpdatedZIP)) {
    $txt = ('Warning!!! HRC2CompatCore151, There were no update packages to clean on '.$Time.'!'); 
    echo nl2br ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  if (file_exists($UpdatedZIP)) {
    @unlink($UpdatedZIP); 
    $txt = ('OP-Act: Deleted update package on '.$Time.'.'); 
    echo nl2br ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  if (file_exists($UpdatedZIP)) {
    $txt = ('Warning!!! HRC2CompatCore165, There was a problem deleting update packages on '.$Time.'!'); 
    echo nl2br ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);  
    if (!file_exists($UpdatedZIP)) {
      $txt = ('OP-Act: Deleted update packages on '.$Time.'.'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } 
  $ResourceDirFiles = scandir($ResourceDir1);
  foreach ($ResourceDirFiles as $ResourceDirFile) {
    if ($ResourceDirFile == '.' or $ResourceDirFile == '..') continue;
      if (is_dir($ResourceDirFile)) {
        $CleanDir = $ResourceDirFile;
        $CleanFiles = scandir($CleanDir.'/');
        include ($InstLoc.'/janitor.php'); 
        if (file_exists($CleanDir.'/config.php')) {              
          @chmod($CleanDir.'/config.php');
          @unlink($CleanDir.'/config.php'); }
        if (file_exists($CleanDir.'/index.php')) {  
          @chmod($CleanDir.'/index.php'); 
          @unlink($CleanDir.'/index.php'); } 
      foreach ($ResourceDirFiles as $ResourceDirFiles) {
        if ($ResourceDirFiles == '.' or $ResourceDirFiles == '..') continue;
          if (is_dir($ResourceDirFiles)) {
            $CleanDir = $ResourceDirFiles;
            $CleanFiles = scandir($CleanDir.'/');
            include ($InstLoc.'/janitor.php'); 
            if (file_exists($CleanDir.'/config.php')) { 
              @chmod($CleanDir.'/config.php');
              @unlink($CleanDir.'/config.php'); }
            if (file_exists($CleanDir.'/index.php')) {   
              @chmod($CleanDir.'/index.php');
              @unlink($CleanDir.'/index.php'); } } } } }
    @chmod($CleanDir);
    @rmdir($CleanDir); 
    if (is_dir($CleanDir)) { 
      copy ($InstLoc.'/index.html', $CleanDir.'/index.html'); } 
    $CleanDir = $ResourceDir1;
    @chmod($CleanDir);
    @rmdir($CleanDir); 
    if (is_dir($CleanDir)) { 
      copy ($InstLoc.'/index.html', $CleanDir.'/index.html'); 
      $txt = ('Notice!!! HRC2CompatCore220, Some files could not be deleted on '.$Time.'!'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } 
    if (!is_dir($CleanDir)) {
      $txt = ('OP-Act: Deleted temporary update data on '.$Time.'.'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }

// / The following code cleans and deletes old, unused, or otherwise deprecated files from HRCloud2.
if ($CheckCompatPOST == '1' or $CheckCompatPOST == 'true'  or $CheckCompatPOST == 'Compat Check') {
  $txt = ('OP-Act: Initiating Compatibility Checker on '.$Time.'.'); 
  echo nl2br ($txt.'<hr />');
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
  if (file_exists($InstLoc.'/coreCOMMANDS.php')) {
    @unlink($InstLoc.'/coreCOMMANDS.php'); } 
  if (file_exists($InstLoc.'/adminLogin.php')) {
    @unlink($InstLoc.'/adminLogin.php'); } 
  if (file_exists($InstLoc.'/AdminLogin.php')) {
    @unlink($InstLoc.'/AdminLogin.php'); } 
  $txt = ('OP-Act: Cleaned and optimized HRCloud2 on '.$Time.'.'); 
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  if (file_exists($ResourceDir1.'/versionInfo.php')) {
    require ($ResourceDir1.'/versionInfo.php'); 
    $Version1 = $Version;
    require ($InstLoc.'/versionInfo.php'); 
    if ($Version1 > $Version) {
      $txt = ('OP-Act: The verson '.$Version.' of HRCloud2 stored in the update queue is newer than the one already installed on '.$Time.'.'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
      $txt = ('OP-Act: Continuing with errors on '.$Time.'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
    if ($Version1 < $Version) {
      $txt = ('OP-Act: The verson '.$Version.' of HRCloud2 stored in the update queue is older than the one already installed on '.$Time.'.'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
      $txt = ('OP-Act: Continuing with errors on '.$Time.'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
    if ($Version1 == $Version) {
      $txt = ('OP-Act: The verson '.$Version.' of HRCloud2 stored in the update queue is already installed on '.$Time.'.'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } 
  if (!file_exists($ResourceDir1.'/versionInfo.php')) { 
    require ($InstLoc.'/versionInfo.php');  
      $txt = ('OP-Act: This server is running HRCloud2 '.$Version.'.'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } 
$ClearCachePOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['ClearCache']); 
$AutoUpdatePOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['AutoUpdate']); 
$AutoDownloadPOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['AutoDownload']); 
$AutoInstallPOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['AutoInstall']); 
$AutoCleanPOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['AutoClean']); 
$CheckCompatPOST = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['CheckCompatibility']); 

if (isset($_POST['ClearCache']) or isset($_POST['AutoUpdate']) or isset($_POST['AutoDownload']) or isset($_POST['AutoInstall']) or 
  isset($_POST['AutoClean']) or isset($_POST['CheckCompatibility'])) {
  echo ('<div align="center"><form target ="_parent" action="settings.php" method="get"><button id="button" name="home" value="1">Settings</button></form>
    <br><form target ="_parent" action="index1.php" method="get"><button id="button" name="home" value="1">Home</button></form></div>'); }
