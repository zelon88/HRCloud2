<?php 

// / The follwoing code checks if the config.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/config.php')) {
  echo nl2br('ERROR!!! HRC2SecCore3, Cannot process the HRCloud2 Config file (config.php).'."\n"); 
  die (); }
else {
  require ('/var/www/html/HRProprietary/HRCloud2/config.php'); }

// / The follwoing code checks if the CommonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('ERROR!!! HRC2SecCore14, Cannot process the HRCloud2 Common Core file (commonCore.php).'."\n"); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('ERROR!!! HRC2SecCore22, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php).'."\n"); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }

// / The following code sets the variables for the session.
$SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
$UserConfig = $InstLoc.'/DATA/'.$UserID.'/.AppData/.config.php';
$user = 'www-data';
$LogFile0 = $SesLogDir.'/VirusLog_'.$Date.'.txt';
$LogFile1 = $SesLogDir.'/VirusLog1_'.$Date.'.txt';
$LogFile2 = $SesLogDir.'/VirusLog2_'.$Date.'.txt';
$LogFileInc0 = 0;
$LogFileInc1 = 0;
$LogFileInc2 = 0;

// / The following code changes the permission of certain directories to 0755,
@chmod($CloudLoc, 0755);
@chmod('/var/www', 0755);
@chmod('/var/www/html', 0755);
@chmod('/var/www/html/HRProprietary', 0755);
@chmod($InstLoc, 0755);
@chmod($InstLoc.'/Applications', 0755);
@chmod($InstLoc.'/Resources', 0755);
@chmod($InstLoc.'/DATA', 0755);
@chmod($InstLoc.'/Screenshots', 0755);
@chmod($InstLoc.'/Styles', 0755);
@chmod($UserConfig, 0755);
@system("/bin/chmod -R 0755 $CloudLoc");
@system("/bin/chmod -R 0755 $InstLoc");

// / The following code changes the group of certain directories to the www-data group,
@chgrp($CloudLoc, $user);
@chgrp('/var/www', $user);
@chgrp('/var/www/html', $user);
@chgrp('/var/www/html/HRProprietary', $user);
@chgrp($InstLoc, $user);
@chgrp($InstLoc.'/Applications', $user);
@chgrp($InstLoc.'/Resources', $user);
@chgrp($InstLoc.'/DATA', $user);
@chgrp($InstLoc.'/Screenshots', $user);
@chgrp($InstLoc.'/Styles', $user);
@chgrp($UserConfig, $user);
@system("/bin/chgrp -R $user $CloudLoc");
@system("/bin/chgrp -R $user $InstLoc");

// / The following code changes the ownership of certain directories to the www-data user,
@chown($CloudLoc, $user);
@chown('/var/www', $user);
@chown('/var/www/html', $user);
@chown('/var/www/html/HRProprietary', $user);
@chown($InstLoc, $user);
@chown($InstLoc.'/Applications', $user);
@chown($InstLoc.'/Resources', $user);
@chown($InstLoc.'/DATA', $user);
@chown($InstLoc.'/Screenshots', $user);
@chown($InstLoc.'/Styles', $user);
@chown($UserConfig, $user);
@system("/bin/chown -R $user $CloudLoc");
@system("/bin/chown -R $user $InstLoc");

// / The following code purges old index.html files from the HRProprietary directory directory daily.
if (!file_exists('/var/www/html/HRProprietary/index.html') or filemtime('/var/www/html/HRProprietary/index.html') >= 86400) {
  copy ('index.html', '/var/www/html/HRProprietary/index.html'); }

// / Secutity related processing.
if (isset($_POST['YUMMYSaltHash'])) {
  $YUMMYSaltHash = $_POST['YUMMYSaltHash'];
if ($YUMMYSaltHash !== $SaltHash) {
  echo nl2br('WARNING!!! HRC2SecCore46, There was a critical security fault. Login Request Denied.'."\n"); 
  die("Application was halted on $Time".'.'); } }

// / The following code is performend when an admin selects to scan the Cloud with ClamAV.
if (isset($_POST['Scan']) or isset($_POST['scanSelected'])) { 
// / To detect viruses HRCloud2 gathers calls ClamAV to scan a directory or user supplied file and calls grep to output 
  // / the results to a txt file. HRCloud2 then reads the outputted file as a string to detect infections.
?>
<div align="center"><h3>Scan Complete!</h3></div>
<hr />
<?php
// / Set whether ClamAV will use multi-threaded capibility or not.
if ($HighPerformanceAV == 1) {
  $HighPerf = '-m '; }
if (!isset($HighPerformanceAV) or $HighPerformanceAV == '0') {
  $HighPerf = ''; }
if ($ThoroughAVAV == 1) {
  $Thorough = ''; }
if (!isset($ThoroughAV) or $ThouroughAV == '0') {
  $Thorough = '-fdpass'; }

// / Handle pre-existing VirusLog files (increment the filename until one is found that doesn't exist).
while (file_exists($LogFile0)) {
  $LogFileInc0++;
  $LogFile0 = $SesLogDir.'/VirusLog_'.$LogFileInc0.'_'.$Date.'.txt'; } 
while (file_exists($LogFile1)) {
  unlink($LogFile1);
  $LogFileInc1++;
  $LogFile1 = $SesLogDir.'/VirusLog_'.$LogFileInc1.'_'.$Date.'.txt';  }
while (file_exists($LogFile2)) {
  unlink($LogFile2);
  $LogFileInc2++;
  $LogFile2 = $SesLogDir.'/VirusLog_'.$LogFileInc2.'_'.$Date.'.txt';  }

// / The following code can be used to scan user submitted files with ClamAV.
if (isset($_POST['scanSelected'])) {
  if (isset($_POST['userscanfilename'])) {
    $userscanfilename = $_POST['userscanfilename'];
    // / Update anti-virus definitions from ClamAV.
    @shell_exec('sudo freshclam');
    echo nl2br('<a style="padding-left:15px;">Updated Virus Definitions.</a>'."\n");
    ?><hr /><?php
    // / Perform a ClamScan on the supplied user file and cache the results.
    shell_exec('clamscan -r '.$CloudLoc.'/'.$userscanfilename.' | grep FOUND >> '.'Virus Detected!!! '.$LogFile1);
    $LogTXT = file_get_contents($LogFile1);
    $WriteClamLogFile = file_put_contents($LogFile, $LogTXT.PHP_EOL, FILE_APPEND);
    $WriteClamLogFile = file_put_contents($LogFile0, $LogTXT.PHP_EOL, FILE_APPEND);
    echo nl2br('<a style="padding-left:15px;">Scanned Supplied File.</a>'."\n");
    ?><hr /><?php } }

// / The following code is used to scan the entire Cloud drive.
if (!isset($_POST['scanSelected']) && isset($_POST['Scan'])) {
  // / Update anti-virus definitions from ClamAV.
  shell_exec('sudo freshclam');
  echo nl2br('<a style="padding-left:15px;">Updated Virus Definitions.</a>'."\n");
  ?><hr /><?php
  // / Perform a ClamScan on the HRCloud2 Cloud Location Directory and cache the results.
  $LogFileSize3 = 0;
  shell_exec(str_replace('  ', ' ', str_replace('   ', ' ', 'clamscan -r '.$Thorough.' '.$HighPerf.' '.$CloudLoc.' | grep FOUND >> '.$LogFile1)));
  sleep(1);
  if (!file_exists($LogFile1)) {
    if ($PersistentAV !== '1') {
      $PersistenceEcho = 'Stopping.'; }
    if ($PersistentAV == '1') {
      $PersistenceEcho = 'Continuing...'; 
      $ThoroughRAW = $Thorough;
      if ($ThoroughRAW == '') {
        $Thorough = '-fdpass'; } 
      if ($ThoroughRAW !== '-fdpass') {
        $Thorough = ''; } }
  shell_exec(str_replace('  ', ' ', str_replace('   ', ' ', 'clamscan -r '.$Thorough.' '.$HighPerf.' '.$CloudLoc.' | grep FOUND >> '.$LogFile1))); }
  if (!file_exists($LogFile1)) {
    $txt = ('ERROR!!! HRC2SecCore136, Could not generate scan results on '.$Time.'! Continuing...');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br('<a style="padding-left:15px;">'.$txt.'</a>'."\n"); }
  if (file_exists($LogFile1)) {  
    $LogFileSize2 = @filesize($LogFile1);
    $LogFileDATA1 = file($LogFile1);
    foreach ($LogFileDATA1 as $LogDATA1) {
      if (strpos($LogDATA1, 'FOUND') == 'true' or $LogFileSize2 >= 3) {
        $INFECTION_DETECTED = 1;
        $WriteClamLogFile = file_put_contents($LogFile1, 'Virus Detected!!!'.PHP_EOL, FILE_APPEND); }
      if (strpos($LogDATA1, 'FOUND') == 'false') {
        $WriteClamLogFile = file_put_contents($LogFile1, ''.PHP_EOL, FILE_APPEND); } }
    $LogTXT = @file_get_contents($LogFile1);
    $WriteClamLogFile = file_put_contents($LogFile, $LogTXT.PHP_EOL, FILE_APPEND);
    $WriteClamLogFile = file_put_contents($LogFile0, $LogTXT.PHP_EOL, FILE_APPEND);
    echo nl2br('<a style="padding-left:15px;">Scanned Cloud Directory.</a>'."\n"); }
  ?><hr /><?php
  // / Perform a ClamScan on the HRCloud2 Installation Directory and cache the results.
  $LogFileSize3 = 0;
  shell_exec(str_replace('  ', ' ', str_replace('   ', ' ', 'clamscan -r '.$Thorough.' '.$HighPerf.' '.$InstLoc.' | grep FOUND >> '.$LogFile2)));
  sleep(1);
  if (!file_exists($LogFile1)) {
    if ($PersistentAV !== '1') {
      $PersistenceEcho = 'Stopping.'; }
    if ($PersistentAV == '1') {
      $PersistenceEcho = 'Continuing...'; 
      $ThoroughRAW = $Thorough;
      if ($ThoroughRAW == '') {
        $Thorough = '-fdpass'; } 
      if ($ThoroughRAW !== '-fdpass') {
        $Thorough = ''; } }
  shell_exec(str_replace('  ', ' ', str_replace('   ', ' ', 'clamscan -r '.$Thorough.' '.$HighPerf.' '.$CloudLoc.' | grep FOUND >> '.$LogFile1))); }
  if (file_exists($LogFile2)) { 
    $LogFileSize4 = @filesize($LogFile2);
    $LogFileDATA2 = file($LogFile2);
    foreach ($LogFileDATA2 as $LogDATA2) {
      if (strpos($LogDATA2, 'FOUND') == 'true' or $LogFileSize4 >= 3) {
        $INFECTION_DETECTED = 1;
        $WriteClamLogFile = file_put_contents($LogFile2, 'Virus Detected!!!'.PHP_EOL, FILE_APPEND); } 
      if (strpos($LogDATA2, 'FOUND') == 'false') {
        $WriteClamLogFile = file_put_contents($LogFile1, ''.PHP_EOL, FILE_APPEND); } }
    $LogTXT = @file_get_contents($LogFile2);
    $WriteClamLogFile = file_put_contents($LogFile, $LogTXT.PHP_EOL, FILE_APPEND);
    $WriteClamLogFile = file_put_contents($LogFile0, $LogTXT.PHP_EOL, FILE_APPEND);
    echo nl2br('<a style="padding-left:15px;">Scanned HRCloud2 Installation Directory.</a>'."\n"); } }
// / Gather results from scans.
if (!is_file($LogFile0) or !is_file($LogFile1) or !is_file($LogFile2)) {
  $txt = ('ERROR!!! HRC2SecCore185, There was a problem generating scan results on '.$Time.'! 
    Try adding user exceptions for ClamAV to the CloudLoc and InstLoc, or disable "ThoroughScanning" in the Settings page.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  die('<a style="padding-left:15px;">'.$txt.'</a>'); }
// / Gather data from ClamAV generated log files.
$LogFileDATA0 = file_get_contents($LogFile0);
$LogFileDATA00 = file($LogFile0);
$LogFileDATA1 = file_get_contents($LogFile1);
$LogFileDATA11 = file($LogFile1);
$LogFileDATA2 = file_get_contents($LogFile2);
$LogFileDATA22 = file($LogFile2);
// / Re-define permissions for files generated by ClamAV, just-in-case.
@system("/bin/chown -R $user $LogFile0");
@system("/bin/chown -R $user $LogFile1");
@system("/bin/chown -R $user $LogFile2");
@system("/bin/chgrp -R $user $LogFile0");
@system("/bin/chgrp -R $user $LogFile1");
@system("/bin/chgrp -R $user $LogFile2");
@system("/bin/chmod -R $user $LogFile0");
@system("/bin/chmod -R $user $LogFile1");
@system("/bin/chmod -R $user $LogFile2");
// / Infection handler will throw the $INFECTION_DETECTED variable to '1' if potential infections were found.
if (strpos($LogFileDATA0, 'Virus Detected') == 'true' or strpos($LogFileDATA1, 'Virus Detected') == 'true' or strpos($LogFileDATA2, 'Virus Detected') == 'true'
  or strpos($LogFileDATA0, 'FOUND') == 'true' or strpos($LogFileDATA1, 'FOUND') == 'true' or strpos($LogFileDATA3, 'FOUND') == 'true') {
  $INFECTION_DETECTED = 1; }
foreach ($LogFileDATA00 as $LogDATA00) {
  if (strpos($LogDATA00, 'Virus Detected') == 'true' or strpos($LogDATA00, 'FOUND') == 'true') {
    $INFECTION_DETECTED = 1; } }
foreach ($LogFileDATA11 as $LogDATA11) {
  if (strpos($LogDATA11, 'Virus Detected') == 'true' or strpos($LogDATA11, 'FOUND') == 'true') {
    $INFECTION_DETECTED = 1; } }
foreach ($LogFileDATA22 as $LogDATA22) {
  if (strpos($LogDATA22, 'Virus Detected') == 'true' or strpos($LogDATA22, 'FOUND') == 'true') {
    $INFECTION_DETECTED = 1; } }
// / If infections were dected, return scan results to the user.
if ($INFECTION_DETECTED == 1) {
  $ThreatCount = substr_count($LogFileDATA0, 'FOUND');
  if ($ThreatCount == '') {
    $ThreatCount = 0; }
  if ($LogFileInc0 == 0) {
    $incEcho = ''; }
  if ($LogFileInc0 !== 0 && $LogFileInc0 !== '') {
    $incEcho = $LogFileInc0.'_'; }
$ClamURL = 'DATA/'.$UserID.'/.AppData/'.$Date.'/VirusLog_'.$incEcho.$Date.'.txt';
  ?><br><div align="center"><?php
  echo nl2br('WARNING!!! HRC2SecCore76, '.$ThreatCount.' Potentially infected files found!'."\n");
  echo nl2br('HRCloud2 DID NOT remove any files. Please see the report below or 
    the logs and verify each file before continuing to use HRCloud2.'."\n");
    ?><p><a href="<?php echo $ClamURL; ?>" target="cloudContents">View logfile</a></p> 
    <br>
    <button id='button' name='button' onclick="goBack()">Go Back</button>
    <br>
    <?php }
// / If infections WERE NOT detected, display a happy notice to the user.
if ($INFECTION_DETECTED !== 1) {
  ?><br><div align="center"><?php
  echo nl2br('HRCloud2 did not find any potentially infected files.'."\n"); ?>
    <br>
    <button id='button' name='button' onclick="goBack()">Go Back</button>
    <br>
    <?php } } 
// / Delete temporary scan cache data.
@unlink ($LogFile1);
@unlink ($LogFile2);
  ?> 
