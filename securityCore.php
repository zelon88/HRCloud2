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

// / The following code changes the group of certain directories to the www-data group,
@chgrp('/var/www', $user);
@chgrp('/var/www/html', $user);
@chgrp('/var/www/html/HRProprietary', $user);
@chgrp($InstLoc, $user);
@chgrp($InstLoc.'/Applications', $user);
@chgrp($InstLoc.'/Resources', $user);
@chgrp($InstLoc.'/DATA', $user);
@chgrp($InstLoc.'/Screenshots', $user);
@chgrp($UserConfig, $user);
@system("/bin/chgrp -R $user $InstLoc");

// / The following code changes the ownership of certain directories to the www-data user,
@chown('/var/www', $user);
@chown('/var/www/html', $user);
@chown('/var/www/html/HRProprietary', $user);
@chown($InstLoc, $user);
@chown($InstLoc.'/Applications', $user);
@chown($InstLoc.'/Resources', $user);
@chown($InstLoc.'/DATA', $user);
@chown($InstLoc.'/Screenshots', $user);
@chown($UserConfig, $user);
@system("/bin/chown -R $user $InstLoc");

// / The following code changes the permission of certain directories to 0755,
@chmod('/var/www', 0755);
@chmod('/var/www/html', 0755);
@chmod('/var/www/html/HRProprietary', 0755);
@chmod($InstLoc, 0755);
@chmod($InstLoc.'/Applications', 0755);
@chmod($InstLoc.'/Resources', 0755);
@chmod($InstLoc.'/DATA', 0755);
@chmod($InstLoc.'/Screenshots', 0755);
@chmod($UserConfig, 0755);
@system("/bin/chmod -R 0755 $InstLoc");

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
// / To detect viruses, we have ClamAV add specific results to the logfile. By reading the filesize immediately 
// / before and after the scans we can see if ClamAV found anything. If it did, we alert the user to an infection.
?>
<div align="center"><h3>Scan Complete!</h3></div>
<hr />
<?php
// / Handle pre-existing VirusLog files (increment the filename until one is found that doesn't exist).
while (file_exists($LogFile0)) {
  $LogFileInc0++;
  $LogFile0 = $SesLogDir.'/VirusLog_'.$LogFileInc.'_'.$Date.'.txt'; } 
if(!file_exists($LogFile0)) {
  $WriteClamLogFile0 = file_put_contents($LogFile0, ''.PHP_EOL); }

while (file_exists($LogFile1)) {
  $LogFileInc1++;
  $LogFile1 = $SesLogDir.'/VirusLog_'.$LogFileInc1.'_'.$Date.'.txt';  }
if(!file_exists($LogFile1)) {
  $WriteClamLogFile1 = file_put_contents($LogFile1, ''.PHP_EOL); }

while (file_exists($LogFile2)) {
  $LogFileInc2++;
  $LogFile2 = $SesLogDir.'/VirusLog_'.$LogFileInc2.'_'.$Date.'.txt';  }
if(!file_exists($LogFile1)) {
  $WriteClamLogFile2 = file_put_contents($LogFile2, ''.PHP_EOL); }

if (isset($_POST['scanSelected'])) {
  if (isset($_POST['userscanfilename'])) {
    $userscanfilename = $_POST['userscanfilename'];
    // / Update anti-virus definitions from ClamAV.
    @shell_exec('sudo freshclam');
    echo nl2br('<a style="padding-left:15px;">Updated Virus Definitions.</a>'."\n");
    ?><hr /><?php
    // / Perform a ClamScan on the supplied user file and cache the results.
    shell_exec('clamscan -r '.$CloudLoc.'/'.$userscanfilename.' | grep FOUND >> '.'HRCloud2 Detected: '.$LogFile1);
    $LogTXT = file_get_contents($LogFile1);
    $WriteClamLogFile = file_put_contents($LogFile, $LogTXT.PHP_EOL, FILE_APPEND);
    $WriteClamLogFile = file_put_contents($LogFile0, $LogTXT.PHP_EOL, FILE_APPEND);
    echo nl2br('<a style="padding-left:15px;">Scanned Supplied File.</a>'."\n");
    ?><hr /><?php } }

if (!isset($_POST['scanSelected'])) {
  // / Update anti-virus definitions from ClamAV.
  @shell_exec('sudo freshclam');
  echo nl2br('<a style="padding-left:15px;">Updated Virus Definitions.</a>'."\n");
  ?><hr /><?php
  // / Perform a ClamScan on the HRCloud2 Cloud Location Directory and cache the results.
  $LogFileSize3 = @filesize($LogFile1);
  if ($LogFileSize1 == '') {
    $LogFileSize1 = 0; }
  shell_exec('clamscan -r '.$CloudLoc.' | grep FOUND >> '.$LogFile1);
  $LogFileSize2 = filesize($LogFile1);
  if (($LogFileSize2 - $LogFileSize1) >= 2 ) {
    $WriteClamLogFile = file_put_contents($LogFile1, 'Virus Detected!!!'.PHP_EOL, FILE_APPEND); }
  if (($LogFileSize2 - $LogFileSize1) < 2 ) {
    $WriteClamLogFile = file_put_contents($LogFile1, ''.PHP_EOL, FILE_APPEND); } 
  $LogTXT = @file_get_contents($LogFile1);
  $WriteClamLogFile = file_put_contents($LogFile, $LogTXT.PHP_EOL, FILE_APPEND);
  $WriteClamLogFile = file_put_contents($LogFile0, $LogTXT.PHP_EOL, FILE_APPEND);
  echo nl2br('<a style="padding-left:15px;">Scanned Cloud Directory.</a>'."\n");
  ?><hr /><?php
  // / Perform a ClamScan on the HRCloud2 Installation Directory and cache the results.
  $LogFileSize3 = @filesize($LogFile2);
  if ($LogFileSize3 == '') {
    $LogFileSize3 = 0; }
  shell_exec('clamscan -r '.$InstLoc.' | grep FOUND >> '.$LogFile2);
  $LogFileSize4 = filesize($LogFile2);
  if (($LogFileSize4 - $LogFileSize3) >= 2 ) {
    $WriteClamLogFile = file_put_contents($LogFile2, 'Virus Detected!!!'.PHP_EOL, FILE_APPEND); } 
  if (($LogFileSize4 - $LogFileSize3) < 2 ) {
    $WriteClamLogFile = file_put_contents($LogFile1, ''.PHP_EOL, FILE_APPEND); }
  $LogTXT = @file_get_contents($LogFile2);
  $WriteClamLogFile = file_put_contents($LogFile, $LogTXT.PHP_EOL, FILE_APPEND);
  $WriteClamLogFile = file_put_contents($LogFile0, $LogTXT.PHP_EOL, FILE_APPEND);
  echo nl2br('<a style="padding-left:15px;">Scanned HRCloud2 Installation Directory.</a>'."\n"); }
// / Gather results from scans.
if (!is_file($LogFile0) or !is_file($LogFile1)) {
  $txt = ('ERROR!!! HRC2SecCore101, Could not generate scan results on '.$Time.'!');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  die('<a style="padding-left:15px;">'.$txt.'</a>'); }
// / Gather data from ClamAV generated log files.
$LogFileDATA0 = file_get_contents($LogFile0);
$LogFileDATA1 = file_get_contents($LogFile1);
$LogFileDATA2 = file_get_contents($LogFile2);
// / Infection handler will throw the $INFECTION_DETECTED variable to '1' if potential infections were found.
if (strpos($LogFileDATA0, 'Virus Detected!!!') == 'true' or strpos($LogFileDATA1, 'Virus Detected!!!') == 'true' or strpos($LogFileDATA2, 'Virus Detected!!!') == 'true'
  or strpos($LogFileDATA0, 'FOUND') == 'true' or strpos($LogFileDATA1, 'FOUND') == 'true' or strpos($LogFileDATA2, 'FOUND') == 'true') {
  $INFECTION_DETECTED = 1; }
// / If infections were dected, return scan results to the user.
if ($INFECTION_DETECTED == 1) {
  if ($LogFileInc0 == 0) {
    $incEcho = ''; }
  if ($LogFileInc0 !== 0) {
    $incEcho = $LogFileInc.'_'; }
$ClamURL = 'DATA/'.$UserID.'/.AppData/'.$Date.'/VirusLog_'.$incEcho.$Date.'.txt';
  ?><br><div align="center"><?php
  echo nl2br('WARNING!!! HRC2SecCore76, Potentially infected files found!'."\n");
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
