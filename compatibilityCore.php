<?php

/*
HRCLOUD2 VERSION INFORMATION
THIS VERSION : v1.6.4
WRITTEN ON : 7/11/2017
*/

// / -----------------------------------------------------------------------------------
// / This file is the HRCloud2 Compatibility Core! It is responsible for making sure HRCloud2 works. It will also
  // / keep HRCloud2 up-to-date, and remove deprecated files that could pose security risks. Lastly, this file will
  // / clean and regenerate HRCloud2 cache files.
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code opens an HTML Div element to contain the output from our compatibility operations.
echo ('<div style="margin-left:15px;">');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The follwoing code checks for required core files and terminates if they are missing.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('ERROR!!! HRC2CompatCore14, Cannot process the HRCloud2 Common Core file (commonCore.php).'."\n"); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('ERROR!!! HRC2CompatCore22, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php).'."\n"); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will check the PHP version installed on the server and return a warning message if anything less than 7.0 is detected.
if (version_compare(PHP_VERSION, '7.0.0') <= 0) {
  $txt = 'WARNING!!! HRC2CompatCore35, This server is running PHP version '.PHP_VERSION.'. HRCloud2 performs best using PHP 7.0 or later!';
  echo nl2br($txt.'</hr>');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will check the O/S installed on the server and return a warning message if Windows is detected.
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
  $txt = 'WARNING!!! HRC2CompatCore44, HRCloud2 was designed to be run on a Linux-based operating system!';
  echo nl2br($txt.'</hr>');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets the global variables for the session.
$ClearCachePOST = str_replace(str_split('./[]{};:$!#^&%@>*<'), '', $_POST['ClearCache']); 
$AutoUpdatePOST = str_replace(str_split('./[]{};:$!#^&%@>*<'), '', $_POST['AutoUpdate']); 
$AutoDownloadPOST = str_replace(str_split('./[]{};:$!#^&%@>*<'), '', $_POST['AutoDownload']); 
$AutoInstallPOST = str_replace(str_split('./[]{};:$!#^&%@>*<'), '', $_POST['AutoInstall']); 
$AutoCleanPOST = str_replace(str_split('./[]{};:$!#^&%@>*<'), '', $_POST['AutoClean']); 
$CheckCompatPOST = str_replace(str_split('./[]{};:$!#^&%@>*<'), '', $_POST['CheckCompatibility']); 
$CheckPermsPOST = str_replace(str_split('./[]{};:$!#^&%@>*<'), '', $_POST['CheckPermissions']); 
$ResourceDir = $InstLoc.'/Resources/TEMP';
$ResourceDir1 = $ResourceDir.'/HRCloud2-master';
$UpdatedZIP1 = $ResourceDir.'/HRC2UPDATE1.zip';
$UpdatedZIPURL = 'https://github.com/zelon88/HRCloud2/archive/master.zip';
$HRC2Config = $InstLoc.'/config.php';
$HRAIConfig = $InstLoc.'/Applications/HRAI/adminINFO.php';
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects to clear their user cache.
if ($ClearCachePOST == '1' or $ClearCachePOST == 'true' or $ClearCachePOST == 'Clear User Cache') {
  if ($UserIDRAW == 0) {
    $txt = 'ERROR!!! HRC2CompatCore54, A non-logged-in user attempted to Clear the User Cache on '.$Time.'.';
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die($txt.'<hr />'); }
  $txt = ('OP_Act: Initiated User Cache Cleaner on '.$Time.'.');
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  unlink($UserConfig); 
  if (!file_exists($UserConfig)) { 
    copy($LogInstallDir.'.config.php', $UserConfig); }
  if (!file_exists($UserConfig)) { 
    $txt = ('ERROR!!! HRC2CompatCore55, There was a problem creating the user config file on '.$Time.'!'); 
    echo nl2br ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die ($txt.'<hr />'); }
  if (file_exists($UserConfig)) {
    $txt = ('OP-Act: Cleaned user cache files on '.$Time.'!'); 
    echo nl2br($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    require ($UserConfig); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
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
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);   
  if ($UserIDRAW !== 1) {
    $txt = ('ERROR!!! HRC2CompatCore43, A non-administrator attempted to update the system on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die($txt.'<hr />'); }
  if (!file_exists($ResourceDir)) {
    mkdir($ResourceDir, 0755); 
    $txt = ('OP-Act: Created a TEMP directory in /Resources to store pending updates on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects to download an update package.
if ($AutoDownloadPOST == '1' or $AutoDownloadPOST== 'true' or $AutoDownloadPOST == 'Download Update') {
  $txt = ('OP-Act: Initiating Update-Downloader on '.$Time.'.'); 
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);   
  if ($UserIDRAW !== 1) {
    $txt = ('ERROR!!! HRC2CompatCore89, A non-administrator attempted to download a system update on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die($txt.'<hr />'); }
  set_time_limit(0);
  $MAKEUpdatedZIP = file_put_contents($UpdatedZIP1, @fopen($UpdatedZIPURL, 'r')); 
  if (!file_exists($UpdatedZIP1)) {
    $txt = ('ERROR!!! HRC2CompatCore110, Could not open a connection to Github on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    die ($txt.'<hr />'); }
  $txt = ('OP-Act: Opened a connection to Github and downloading data on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  set_time_limit(0); 
  if (!file_exists($UpdatedZIP1)) {
    $txt = ('ERROR!!! HRC2CompatCore79, Could not download the HRCLOUD2.zip file from Github on '.$Time.'.'); 
    echo nl2br ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die ($txt.'<hr />'); } 
  if (file_exists($UpdatedZIP1)) {
    $txt = ('OP-Act: The latest version of HRCloud2 was sucessfully downloaded on '.$Time.'.'); 
    echo nl2br ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects to install an update package.
if ($AutoInstallPOST == '1' or $AutoInstallPOST == 'true' or $AutoInstallPOST == 'Install Update') {
  $txt = ('OP-Act: Initiating Update-Installer on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  echo nl2br ($txt.'<hr />');
  // / The following code checks that the user is an administrator.
  if ($UserIDRAW !== 1) {
    $txt = ('ERROR!!! HRC2CompatCore51, A non-administrator attempted to install a cached update on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die($txt.'<hr />'); }
  // / The following code checks that there is an update .zip package to install before continuing.
  // / If a .zip file does exist, it is unpacked.
  if (file_exists($UpdatedZIP1)) {  
    shell_exec('unzip -o '.$UpdatedZIP1.' -d '.$ResourceDir);
    $txt = ('OP-Act: Unpacked archive on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  // / The following code is an error handler for if an update .zip package does NOT exist.
  if (!file_exists($UpdatedZIP1)) { 
    $txt = ('ERROR!!! HRC2CompatCore108, There are no stored update packages on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die($txt.'<hr />'); }
  // / The following code is performed as a check that the update .zip package was unpacked.
  if (!file_exists($ResourceDir1.'/config.php')) {
    $txt = ('ERROR!!! HRC2CompatCore130, There was a problem unpacking the update packages on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die($txt.'<hr />'); }
  // / The following code is performed when an update .zip package was sucessfully unpacked.
  // / It will recursively copy all update files and directories to a folder, and then zip that folder
    // / into an "installation image" that we can over-write the $InstLoc with.
  if (!file_exists($ResourceDir1.'/config.php')) {
    $txt = ('ERROR!!! HRC2175, there was no data downloaded! Check that Github is not undergoing maintanence on '.$Time.'.'); 
    echo nl2br ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die(); }
  if (file_exists($ResourceDir1.'/config.php')) {
    $txt = ('OP-Act: The update packages were unpacked sucessfully on '.$Time.'.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);     
    $UPDATEFiles = scandir($ResourceDir1);
      // / The following code preserves the base HRCloud2 configuration files to be restored after the update.
  $txt = ('OP-Act: Preserving server configuration data on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    $BAKinc = 0;
  while (file_exists($InstLoc.'/BACKUP/configBACKUP'.$BAKinc.'.php')) {
    $BAKinc++; }
  copy ($InstLoc.'/config.php', $InstLoc.'/BACKUP/configBACKUP'.$BAKinc.'.php'); 
  rename ($ResourceDir1.'/config.php', $ResourceDir1.'/configLATEST.php');
  copy ($InstLoc.'/config.php', $ResourceDir1.'/config.php');
  // / The following code preserves HRAI configuration files to be restored after the update.
    $BAKinc1 = 0;
  while (file_exists($InstLoc.'Applications/HRAI/adminINFOBACKUP'.$BAKinc1.'.php')) {
    $BAKinc1++; }
  @copy ($InstLoc.'/Applications/HRAI/adminINFO.php', $InstLoc.'/Applications/HRAI/adminINFO'.$BAKinc.'.php'); 
  rename ($ResourceDir1.'/Applications/HRAI/adminINFO.php', $ResourceDir1.'/Applications/HRAI/adminINFOLATEST.php');
  copy ($InstLoc.'/Applications/HRAI/adminINFO.php', $ResourceDir1.'/Applications/HRAI/adminINFO.php'); 
    foreach($UPDATEFiles as $UF) {
      if ($UF == '.' or $UF == '..' or $UF == 'var' or $UF == 'www' or $UF == 'html' or $UF == 'HRProprietary') continue;
      $UFSrcDir = $ResourceDir1.'/'.$UF;
      $UFDstDir = $InstLoc.'/'.$UF;
      if (is_dir($ResourceDir1)) @mkdir($InstLoc, 0755);
      if (is_file($UFSrcDir)) @copy ($UFSrcDir, $UFDstDir);
      if (is_dir($UFSrcDir)) {
        @mkdir ($UFDstDir);
        $UPDATEFiles2 = scandir ($UFSrcDir);
        foreach ($UPDATEFiles2 as $UF2) {
          if ($UF2 == '.' or $UF2 == '..' or $UF2 == 'var' or $UF2 == 'www' or $UF2 == 'html' or $UF2 == 'HRProprietary') continue;
          $UFSrcDir2 = $ResourceDir1.'/'.$UF.'/'.$UF2;
          $UFDstDir2 = $InstLoc.'/'.$UF.'/'.$UF2;
          if (is_dir($ResourceDir1.'/'.$UF)) @mkdir($InstLoc.'/'.$UF, 0755);
          if (is_file($UFSrcDir2)) @copy ($UFSrcDir2, $UFDstDir2);
            if (is_dir($UFSrcDir2)) {
              @mkdir ($UFDstDir2);
              $UPDATEFiles3 = scandir ($UFSrcDir2);
              foreach ($UPDATEFiles3 as $UF3) {
                if ($UF3 == '.' or $UF3 == '..' or $UF3 == 'var' or $UF3 == 'www' or $UF3 == 'html' or $UF3 == 'HRProprietary') continue;
                $UFSrcDir3 = $ResourceDir1.'/'.$UF.'/'.$UF2.'/'.$UF3;
                $UFDstDir3 = $InstLoc.'/'.$UF.'/'.$UF2.'/'.$UF3;
                if (is_dir($ResourceDir1.'/'.$UF.'/'.$UF2)) @mkdir($InstLoc.'/'.$UF.'/'.$UF2, 0755);
                if (is_file($UFSrcDir3)) @copy ($UFSrcDir3, $UFDstDir3);
                if (is_dir($UFSrcDir3)) {
                  @mkdir ($UFDstDir3);
                  $UPDATEFiles4 = scandir ($UFSrcDir3);
                  foreach ($UPDATEFiles4 as $UF4) {   
                    if ($UF4 == '.' or $UF4 == '..' or $UF4 == 'var' or $UF4 == 'www' or $UF4 == 'html' or $UF4 == 'HRProprietary') continue;    
                    $UFSrcDir4 = $ResourceDir1.'/'.$UF.'/'.$UF2.'/'.$UF3.'/'.$UF4;
                    $UFDstDir4 = $InstLoc.'/'.$UF.'/'.$UF2.'/'.$UF3.'/'.$UF4;
                    if (is_dir($ResourceDir1.'/'.$UF.'/'.$UF2.'/'.$UF3)) @mkdir($InstLoc.'/'.$UF.'/'.$UF2.'/'.$UF3, 0755);
                    if (is_file($UFSrcDir4)) @copy ($UFSrcDir4, $UFDstDir4);
                    if (is_dir($UFSrcDir4)) {
                      @mkdir ($UFDstDir4);
                      $UPDATEFiles5 = scandir ($UFSrcDir4);
                      foreach ($UPDATEFiles5 as $UF5) {  
                        if ($UF5 == '.' or $UF5 == '..' or $UF5 == 'var' or $UF5 == 'www' or $UF5 == 'html' or $UF5 == 'HRProprietary') continue;     
                        $UFSrcDir5 = $ResourceDir1.'/'.$UF.'/'.$UF2.'/'.$UF3.'/'.$UF4.'/'.$UF5;
                        $UFDstDir5 = $InstLoc.'/'.$UF.'/'.$UF2.'/'.$UF3.'/'.$UF4.'/'.$UF5; 
                      if (is_dir($ResourceDir1.'/'.$UF.'/'.$UF2.'/'.$UF3.'/'.$UF4)) @mkdir($InstLoc.'/'.$UF.'/'.$UF2.'/'.$UF3.'/'.$UF4, 0755);
                      if (is_file($UFSrcDir5)) @copy ($UFSrcDir5, $UFDstDir5);
                      if (is_dir($UFSrcDir5)) {
                        @mkdir ($UFDstDir5);
                        $UPDATEFiles6 = scandir ($UFSrcDir5);
                        foreach ($UPDATEFiles7 as $UF6) {    
                          if ($UF6 == '.' or $UF6 == '..' or $UF6 == 'var' or $UF6 == 'www' or $UF6 == 'html' or $UF6 == 'HRProprietary') continue;   
                          $UFSrcDir6 = $ResourceDir1.'/'.$UF.'/'.$UF2.'/'.$UF3.'/'.$UF5.'/'.$UF5.'/'.$UF6;
                          $UFDstDir6 = $InstLoc.'/'.$UF.'/'.$UF2.'/'.$UF3.'/'.$UF5.'/'.$UF5.'/'.$UF6; 
                        if (is_dir($ResourceDir1.'/'.$UF.'/'.$UF2.'/'.$UF3.'/'.$UF4.'/'.$UF5)) @mkdir($InstLoc.'/'.$UF.'/'.$UF2.'/'.$UF3.'/'.$UF4.'/'.$UF5, 0755);
                        if (is_file($UFSrcDir6)) @copy ($UFSrcDir6, $UFDstDir6); } } } } } } } } } } }   
        $txt = ('OP-Act: Copied update data on '.$Time.'.'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  // / The following code checks the HRCloud2 version and stops the update process if an old version was prepared.
  if (!file_exists($ResourceDir1.'/versionInfo.php')) {
    $txt = ('ERROR!!! HRC2CompatCore223, Could not verify the latest "versionInfo.php" on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die($txt.'<hr />');  }
  require ($ResourceDir1.'/versionInfo.php'); 
  $Version1 = $Version;
  require ($InstLoc.'/versionInfo.php'); 
  if ($Version1 < $Version) {
    $txt = ('ERROR!!! HRC2CompatCor139, The pending HRCloud2 update is older than the one already in use on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die ($txt.'<hr />'); }
  // / The following code checks that HRCloud2 was sucessfully updated..
  require ($ResourceDir1.'/versionInfo.php'); 
  $Version1 = $Version;
  require ($InstLoc.'/versionInfo.php'); 
  if ($Version1 !== $Version) {
    $txt = ('WARNING!!! HRC2CompatCore94, Version discrepency detected after unpacking the installation image on '.$Time.'!'."\n".
      '    Important Note: Manual install reccomended! Try using "Clean Update" and "Check Compatibility." If problem persists, 
      check permissions to all HRC2 directories and use a terminal window or file manager to update.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br($txt.'<hr />'); }
  if ($Version1 == $Version) {
    if ($Version1 == $Version) {
      $txt = ('OP-Act: Sucessfully installed version '.$Version.' of HRCloud2 on '.$Time.'.'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when a user selects to Clean temporary update package files.
if ($AutoCleanPOST == '1' or $AutoCleanPOST == 'true' or $AutoCleanPOST == 'Clean Update') {
  $txt = ('OP-Act: Initiating Update-Cleaner on '.$Time.'.'); 
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  if ($UserIDRAW !== 1) {
    $txt = ('ERROR!!! HRC2CompatCore184, A non-administrator attempted to clear the system update cache on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die($txt.'<hr />'); }
  if (!file_exists($UpdatedZIP1)) {
    $txt = ('OP-Act: No update packages detected on '.$Time.'!'); 
    echo nl2br ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (file_exists($UpdatedZIP1)) {
    @unlink($UpdatedZIP1); 
    $txt = ('OP-Act: Deleted update package on '.$Time.'.'); 
    echo nl2br ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (file_exists($UpdatedZIP1)) {
    $txt = ('Warning!!! HRC2CompatCore165, There was a problem deleting update packages on '.$Time.'!'); 
    echo nl2br ($txt.'<hr />');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);  
    if (!file_exists($UpdatedZIP1)) {
      $txt = ('OP-Act: Deleted update packages on '.$Time.'.'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } 
  if (is_dir($ResourceDir1)) {
    $ResourceDirFiles = scandir($ResourceDir1); 
    $CleanFiles = $ResourceDirFiles;
    include ($InstLoc.'/janitor.php');  
  foreach ($ResourceDirFiles as $ResourceDirFile) {
    if ($ResourceDirFile == '.' or $ResourceDirFile == '..') continue;
        $CleanDir = $ResourceDir1.'/'.$ResourceDirFile;
      if (is_file($CleanDir)) {
        @unlink($CleanDir); }
      if (is_dir($CleanDir)) {
        $CleanFiles = scandir($CleanDir.'/');
        include ($InstLoc.'/janitor.php'); 
        @chmod($CleanDir.'/config.php');
        @unlink($CleanDir.'/config.php');
        @chmod($CleanDir.'/index.html');
        @unlink($CleanDir.'/index.html');
        @chmod($CleanDir.'/jquery-3.1.0.min.js');
        @unlink($CleanDir.'/jquery-3.1.0.min.js');
        @chmod($CleanDir.'/wordpress_1-28-17.zip');
        @unlink($CleanDir.'/wordpress_1-28-17.zip');
        @chmod($CleanDir.'/wordpress_3-16-17.zip');
        @unlink($CleanDir.'/wordpress_3-16-17.zip');
        @chmod($CleanDir.'/Database/Words/index.html');
        @unlink($CleanDir.'/Database/Words/index.html');
        @chmod($CleanDir.'/Words/index.html');
        @unlink($CleanDir.'/Words/index.html');
        @chmod($CleanDir.'/Database/Words');
        @rmdir($CleanDir.'/Database/Words');
        @chmod($CleanDir.'/Words');
        @rmdir($CleanDir.'/Words');
        @chmod($CleanDir.'/displaydirectorycontents_72716');
        @rmdir($CleanDir.'/displaydirectorycontents_72716');
        @chmod($CleanDir.'/displaydirectorycontents_logs');
        @rmdir($CleanDir.'/displaydirectorycontents_logs');
        @chmod($CleanDir.'/displaydirectorycontents_logs1');
        @rmdir($CleanDir.'/displaydirectorycontents_logs1'); 
        @chmod($CleanDir.'/displaydirectorycontents_shared');
        @rmdir($CleanDir.'/displaydirectorycontents_shared');
        @chmod($CleanDir.'/Applications/index.html');
        @unlink($CleanDir.'/Applications/index.html');
        @chmod($CleanDir.'/Applications');
        @rmdir($CleanDir.'/Applications');
        @chmod($CleanDir.'/Resources');
        @rmdir($CleanDir.'/Resources');
        @chmod($CleanDir.'/Screenshots');
        @rmdir($CleanDir.'/Screenshots');
        @chmod($CleanDir.'/HRAI');
        @rmdir($CleanDir.'/HRAI');
        @chmod($CleanDir.'/HRStreamer');
        @rmdir($CleanDir.'/HRStreamer');
        @chmod($CleanDir);
        @rmdir($CleanDir);  
      foreach ($CleanFiles as $ResourceDirFile2) {
        if ($ResourceDirFile2 == '.' or $ResourceDirFile2 == '..') continue;
          $CleanDir = $ResourceDir1.'/'.$ResourceDirFile.'/'.$ResourceDirFile2;
          if (is_dir($CleanDir)) {
            $CleanFiles = scandir($CleanDir.'/');
            include ($InstLoc.'/janitor.php');  
            @chmod($CleanDir.'/config.php');
            @unlink($CleanDir.'/config.php');
            @chmod($CleanDir.'/index.html');
            @unlink($CleanDir.'/index.html');
            @chmod($CleanDir.'/jquery-3.1.0.min.js');
            @unlink($CleanDir.'/jquery-3.1.0.min.js');
            @chmod($CleanDir.'/wordpress_1-28-17.zip');
            @unlink($CleanDir.'/wordpress_1-28-17.zip');
            @chmod($CleanDir.'/wordpress_3-16-17.zip');
            @unlink($CleanDir.'/wordpress_3-16-17.zip');
            @chmod($CleanDir.'/Database/Words/index.html');
            @unlink($CleanDir.'/Database/Words/index.html');
            @chmod($CleanDir.'/Words/index.html');
            @unlink($CleanDir.'/Words/index.html');
            @chmod($CleanDir.'/Database/Words');
            @rmdir($CleanDir.'/Database/Words');
            @chmod($CleanDir.'/Words');
            @rmdir($CleanDir.'/Words');
            @chmod($CleanDir.'/displaydirectorycontents_72716');
            @rmdir($CleanDir.'/displaydirectorycontents_72716');
            @chmod($CleanDir.'/displaydirectorycontents_logs');
            @rmdir($CleanDir.'/displaydirectorycontents_logs');
            @chmod($CleanDir.'/displaydirectorycontents_logs1');
            @rmdir($CleanDir.'/displaydirectorycontents_logs1'); 
            @chmod($CleanDir.'/displaydirectorycontents_shared');
            @rmdir($CleanDir.'/displaydirectorycontents_shared');
            @chmod($CleanDir.'/Applications/index.html');
            @unlink($CleanDir.'/Applications/index.html');
            @chmod($CleanDir.'/Applications');
            @rmdir($CleanDir.'/Applications');
            @chmod($CleanDir.'/Resources');
            @rmdir($CleanDir.'/Resources');
            @chmod($CleanDir.'/Screenshots');
            @rmdir($CleanDir.'/Screenshots');
            @chmod($CleanDir.'/HRAI');
            @rmdir($CleanDir.'/HRAI');
            @chmod($CleanDir.'/HRStreamer');
            @rmdir($CleanDir.'/HRStreamer');
            @chmod($CleanDir);
            @rmdir($CleanDir); 
        foreach ($CleanFiles as $ResourceDirFile3) {
          if ($ResourceDirFile3 == '.' or $ResourceDirFile4 == '..') continue;
            $CleanDir = $ResourceDir1.'/'.$ResourceDirFile.'/'.$ResourceDirFile2.'/'.$ResourceDirFile3;
            if (is_dir($CleanDir)) {
              $CleanFiles = scandir($CleanDir.'/');
              include ($InstLoc.'/janitor.php'); 
              @chmod($CleanDir.'/config.php');
              @unlink($CleanDir.'/config.php');
              @chmod($CleanDir.'/index.html');
              @unlink($CleanDir.'/index.html');
              @chmod($CleanDir.'/jquery-3.1.0.min.js');
              @unlink($CleanDir.'/jquery-3.1.0.min.js');
              @chmod($CleanDir.'/wordpress_1-28-17.zip');
              @unlink($CleanDir.'/wordpress_1-28-17.zip');
              @chmod($CleanDir.'/Database/Words/index.html');
              @unlink($CleanDir.'/Database/Words/index.html');
              @chmod($CleanDir.'/Words/index.html');
              @unlink($CleanDir.'/Words/index.html');
              @chmod($CleanDir.'/Database/Words');
              @rmdir($CleanDir.'/Database/Words');
              @chmod($CleanDir.'/Words');
              @rmdir($CleanDir.'/Words');
              @chmod($CleanDir.'/displaydirectorycontents_72716');
              @rmdir($CleanDir.'/displaydirectorycontents_72716');
              @chmod($CleanDir.'/displaydirectorycontents_logs');
              @rmdir($CleanDir.'/displaydirectorycontents_logs');
              @chmod($CleanDir.'/displaydirectorycontents_logs1');
              @rmdir($CleanDir.'/displaydirectorycontents_logs1'); 
              @chmod($CleanDir.'/displaydirectorycontents_shared');
              @rmdir($CleanDir.'/displaydirectorycontents_shared');
              @chmod($CleanDir.'/Applications/index.html');
              @unlink($CleanDir.'/Applications/index.html');
              @chmod($CleanDir.'/Applications');
              @rmdir($CleanDir.'/Applications');
              @chmod($CleanDir.'/Resources');
              @rmdir($CleanDir.'/Resources');
              @chmod($CleanDir.'/Screenshots');
              @rmdir($CleanDir.'/Screenshots');
              @chmod($CleanDir.'/HRAI');
              @rmdir($CleanDir.'/HRAI');
              @chmod($CleanDir.'/HRStreamer');
              @rmdir($CleanDir.'/HRStreamer');
              @chmod($CleanDir);
              @rmdir($CleanDir); } } } } } }
    if (is_dir($CleanDir)) { 
      $CleanDir = $ResourceDir1;
      @chmod($CleanDir);
      @rmdir($CleanDir); }
    if (is_dir($CleanDir)) { 
      copy ($InstLoc.'/index.html', $CleanDir.'/index.html'); 
      $txt = ('Warning!!! HRC2CompatCore220, Some files could not be deleted on '.$Time.'!'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
    if (!is_dir($CleanDir)) {
      $txt = ('OP-Act: Deleted temporary update data on '.$Time.'.'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
  @copy ($InstLoc.'/index.html', $ResourceDir.'/index.html'); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code cleans and deletes old, unused, or otherwise deprecated files from HRCloud2.
if ($CheckCompatPOST == '1' or $CheckCompatPOST == 'true'  or $CheckCompatPOST == 'Compat Check') {
  $txt = ('OP-Act: Initiating Compatibility Checker on '.$Time.'.'); 
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  $ChkFileIsBACKUP = scandir($InstLoc);
  foreach ($ChkFileIsBACKUP as $ChkFileIsBACKUP1) {
    if (strpos($ChkFileIsBACKUP1, 'configBACKUP') == 'true') {
      rename($InstLoc.'/'.$ChkFileIsBACKUP1, $BackupDir.'/'.$ChkFileIsBACKUP1); 
      $txt = ('OP-Act: Copied the backup file "'.$ChkFileIsBACKUP1.'" to the Backup Directory on '.$Time.'.'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
  if (file_exists($InstLoc.'/appSettings.php')) {
    @unlink($InstLoc.'/appSettings.php'); }
  if (file_exists($InstLoc.'/SAVEappSettings.php')) {
    @unlink($InstLoc.'/SAVEappSettings.php'); }
  if (file_exists($InstLoc.'/search2.php')) {
    @unlink($InstLoc.'/search2.php'); }
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
  if (file_exists($InstLoc.'/search.php')) {
    @unlink($InstLoc.'/search.php'); } 
  if (file_exists($InstLoc.'/HRAIMiniGui.php')) {
    @unlink($InstLoc.'/HRAIMiniGui.php'); } 
  if (file_exists($InstLoc.'/coreCOMMANDS.php')) {
    @unlink($InstLoc.'/coreCOMMANDS.php'); } 
  if (file_exists($InstLoc.'/adminLogin.php')) {
    @unlink($InstLoc.'/adminLogin.php'); } 
  if (file_exists($InstLoc.'/AdminLogin.php')) {
    @unlink($InstLoc.'/AdminLogin.php'); } 
  if (file_exists($InstLoc.'/Applications/HRAI/awake.php')) {
    @unlink($InstLoc.'/Applications/HRAI/awake.php'); } 
  if (file_exists($InstLoc.'/Applications/wordpress_1-28-17.zip')) {
    @unlink($InstLoc.'/Applications/wordpress_1-28-17.zip'); } 
  if (file_exists($InstLoc.'/Applications/HRAI/wordpress_11416.zip')) {
    @unlink($InstLoc.'/Applications/wordpress_11416.zip'); } 
  if (file_exists($InstLoc.'/Applications/HRAI/HRAIMiniGui.php')) {
    @unlink($InstLoc.'/Applications/HRAI/HRAIMiniGui.php'); } 
  if (file_exists($InstLoc.'/Applications/ServMonitor/cpuUpdate.php')) {
    @unlink($InstLoc.'/Applications/ServMonitor/cpuUpdate.php'); } 
  if (file_exists($InstLoc.'/Applications/ServMonitor/ramUpdate.php')) {
    @unlink($InstLoc.'/Applications/ServMonitor/ramUpdate.php'); } 
  if (file_exists($InstLoc.'/Applications/HRConvert2/uploaderNOGUI.php')) {
    @unlink($InstLoc.'/Applications/HRConvert2/uploaderNOGUI.php'); } 
  if (file_exists($InstLoc.'/Applications/displaydirectorycontents_logs1/index.php')) {
    @unlink($InstLoc.'/Applications/displaydirectorycontents_logs1/index.php'); }
  if (file_exists($InstLoc.'/Applications/displaydirectorycontents_logs/index.php')) {
    @unlink($InstLoc.'/Applications/displaydirectorycontents_logs1/index.php'); } 
  $txt = ('OP-Act: Cleaned and optimized HRCloud2 on '.$Time.'.'); 
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  if (file_exists($ResourceDir1.'/versionInfo.php')) {
    require ($ResourceDir1.'/versionInfo.php'); 
    $Version1 = $Version;
    require ($InstLoc.'/versionInfo.php'); 
    if ($Version1 > $Version) {
      $txt = ('OP-Act: The verson '.$Version.' of HRCloud2 stored in the update queue is newer than the one already installed on '.$Time.'.'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      $txt = ('OP-Act: Continuing with errors on '.$Time.'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
    if ($Version1 < $Version) {
      $txt = ('OP-Act: The verson '.$Version.' of HRCloud2 stored in the update queue is older than the one already installed on '.$Time.'.'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      $txt = ('OP-Act: Continuing with errors on '.$Time.'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
    if ($Version1 == $Version) {
      $txt = ('OP-Act: The verson '.$Version.' of HRCloud2 stored in the update queue is already installed on '.$Time.'.'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } 
  if (!file_exists($ResourceDir1.'/versionInfo.php')) { 
    require ($InstLoc.'/versionInfo.php');  
      $txt = ('OP-Act: This server is running HRCloud2 '.$Version.'.'); 
      echo nl2br ($txt.'<hr />');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }  
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code attempts to correct file permissions for HRCloud2 controlled directories.
if ($CheckPermsPOST == '1' or $CheckPermsPOST == 'true'  or $CheckPermsPOST == 'Perms Check') {
  @system("/bin/chmod -R 0755 $CloudLoc");
  $txt = 'Op-Act: The current permission level of the CloudLoc is "'.substr(sprintf('%o', fileperms($CloudLoc)), -4).'".' ;
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  @system("/bin/chmod -R 0755 $InstLoc");
  $txt = 'Op-Act: The current permission level of the InstLoc is "'.substr(sprintf('%o', fileperms($InstLoc)), -4).'".' ;
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  @system("/bin/chgrp -R $user $CloudLoc");
  $txt = 'Op-Act: The current user-group of the InstLoc is "'.posix_getpwuid(filegroup($InstLoc)).'".' ;
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);   
  @system("/bin/chgrp -R $user $InstLoc");
  $txt = 'Op-Act: The current user-group of the InstLoc is "'.posix_getpwuid(filegroup($InstLoc)).'".' ;
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  @system("/bin/chown -R $user $CloudLoc");
  $txt = 'Op-Act: The current owner of the CloudLoc is "'.posix_getpwuid(fileowner($CloudLoc)).'".' ;
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  @system("/bin/chown -R $user $InstLoc"); 
  $txt = 'Op-Act: The current owner of the InstLoc is "'.posix_getpwuid(fileowner($InstLoc)).'".' ;
  echo nl2br ($txt.'<hr />');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code displays the navigation buttons for when a user selects a compatibility related operation that this page has satisfied.
if (isset($_POST['ClearCache']) or isset($_POST['AutoUpdate']) or isset($_POST['AutoDownload']) or isset($_POST['AutoInstall']) or 
  isset($_POST['AutoClean']) or isset($_POST['CheckCompatibility'])) {
  echo ('<div align="center"><form target ="_parent" action="index1.php" method="get"><button id="button" name="home" value="1">Home</button></form></div>'); }
echo ('</div>');
// / -----------------------------------------------------------------------------------
