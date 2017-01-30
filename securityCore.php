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

$UserConfig = $InstLoc.'/DATA/'.$UserID.'/.AppData/.config.php';

// / The following code changes the ownership of certain directories to the www-data user,
@chown('/var/www/html', 'www-data');
@chown('/var/www/html/HRProprietary', 'www-data');
@chown($InstLoc, 'www-data');
@chown($InstLoc.'/Applications', 'www-data');
@chown($InstLoc.'/Resources', 'www-data');
@chown($InstLoc.'/DATA', 'www-data');
@chown($InstLoc.'/Screenshots', 'www-data');
@@chown($UserConfig, 'www-data');

// / The following code changes the permission of certain directories to 0755,
@chmod('/var/www/html', 0755);
@chmod('/var/www/html/HRProprietary', 0755);
@chmod($InstLoc, 0755);
@chmod($InstLoc.'/Applications', 0755);
@chmod($InstLoc.'/Resources', 0755);
@chmod($InstLoc.'/DATA', 0755);
@chmod($InstLoc.'/Screenshots', 0755);
@@chmod($UserConfig, 0755);

// / The following code changes the group of certain directories to the www-data group,
@chgrp('/var/www/html', 'www-data');
@chgrp('/var/www/html/HRProprietary', 'www-data');
@chgrp($InstLoc, 'www-data');
@chgrp($InstLoc.'/Applications', 'www-data');
@chgrp($InstLoc.'/Resources', 'www-data');
@chgrp($InstLoc.'/DATA', 'www-data');
@chgrp($InstLoc.'/Screenshots', 'www-data');
@@chgrp($UserConfig, 'www-data');

// / Secutity related processing.
$SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
if (isset($_POST['YUMMYSaltHash'])) {
  $YUMMYSaltHash = $_POST['YUMMYSaltHash'];
if ($YUMMYSaltHash !== $SaltHash) {
  echo nl2br('WARNING!!! HRC2SecCore46, There was a critical security fault. Login Request Denied.'."\n"); 
  die("Application was halted on $Time".'.'); } }

// / The following code is performend when an admin selects to scan the Cloud with ClamAV.
if (isset($_POST['Scan'])) { 
// / To detect viruses, we have ClamAV add specific results to the logfile. By reading the filesize immediately 
// / before and after the scans we can see if ClamAV found anything. If it did, we alert the user to an infection.
?>
<div align="center"><h3>Scan Complete!</h3></div>
<hr />
<?php
$LogFile0 = $SesLogDir.'/VirusLog_'.$Date.'.txt';
$LogFile1 = $SesLogDir.'/VirusLog1_'.$Date.'.txt';
$LogFile2 = $SesLogDir.'/VirusLog2_'.$Date.'.txt';
$LogFileInc = 0;
// / Handle pre-existing VirusLog files (increment the filename until one is found that doesn't exist).
if(file_exists($LogFile0)) {
  while (file_exists($LogFile0)) {
  $LogFileInc++;
  $LogFile0 = $SesLogDir.'/VirusLog_'.$LogFileInc.'_'.$Date.'.txt'; } }
// / Update anti-virus definitions from ClamAV.
@shell_exec('sudo freshclam');
echo nl2br('<a style="padding-left:15px;">Updated Virus Definitions.</a>'."\n");
?><hr /><?php
// / Perform a ClamScan on the HRCloud2 Cloud Location Directory and cache the results.
shell_exec('clamscan -r '.$CloudLoc.' | grep FOUND >> '.$LogFile1);
$LogTXT = file_get_contents($LogFile1);
$WriteClamLogFile = file_put_contents($LogFile, $LogTXT.PHP_EOL, FILE_APPEND);
$WriteClamLogFile = file_put_contents($LogFile0, $LogTXT.PHP_EOL, FILE_APPEND);
echo nl2br('<a style="padding-left:15px;">Scanned Cloud Directory.</a>'."\n");
?><hr /><?php
// / Perform a ClamScan on the HRCloud2 Installation Directory and cache the results.
shell_exec('clamscan -r '.$InstLoc.' | grep FOUND >> '.$LogFile2);
$LogTXT = file_get_contents($LogFile2);
$WriteClamLogFile = file_put_contents($LogFile, $LogTXT.PHP_EOL, FILE_APPEND);
$WriteClamLogFile = file_put_contents($LogFile0, $LogTXT.PHP_EOL, FILE_APPEND);
echo nl2br('<a style="padding-left:15px;">Scanned HRCloud2 Installation Directory.</a>'."\n");
// / Gather results from scans.
if (!is_file($LogFile0) or !is_file($LogFile1) or !is_file($LogFile2)) {
  $txt = ('ERROR!!! HRC2SecCore101, Could not generate scan results on '.$Time.'!');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  die('<a style="padding-left:15px;">'.$txt.'</a>'); }
$LogFileSize0 = filesize($LogFile0);
$LogFileSize1 = filesize($LogFile1);
$LogFileSize2 = filesize($LogFile2);
$LogFileDATA0 = file_get_contents($LogFile0);
$LogFileDATA1 = file_get_contents($LogFile1);
$LogFileDATA2 = file_get_contents($LogFile2);
// / Infection handler will throw the $INFECTION variable to '1' if potential infections were found.
if ($LogFileSize0 > 2 or $LogFileSize1 > 2 or $LogFileSize2 > 2) {
  $INFECTION_DETECTED = 1; }
// / Delete temporary scan cache data.
@unlink ($LogFile1);
@unlink ($LogFile2);
// / If infections were dected, return scan results to the user.
if ($INFECTION_DETECTED == 1) {
  if ($LogFileInc == 0) {
    $incEcho = ''; }
  if ($LogFileInc !== 0) {
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
    <?php } }  ?> 
