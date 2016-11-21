<?php 

if (!file_exists('config.php')) {
  echo nl2br('ERROR!!! HRC2SecCore35, Cannot process the HRCloud2 Config file (config.php).'."\n"); 
  die (); }
else {
  require_once('config.php'); }

chmod($InstLoc, 0755);
chmod($InstLoc.'/Applications', 0755);
chmod($InstLoc.'/Resources', 0755);
chmod($InstLoc.'/DATA', 0755);
chmod($InstLoc.'/Screenshots', 0755);

// / Secutity related processing.
$SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
if (isset($_POST['YUMMYSaltHash'])) {
  $YUMMYSaltHash = $_POST['YUMMYSaltHash'];
if ($YUMMYSaltHash !== $SaltHash) {
  echo nl2br('!!! WARNING !!! HRC2SecCore46, There was a critical security fault. Login Request Denied.'."\n"); 
  die("Application was halted on $Time".'.'); } }

// / The following code is performend when an admin selects to scan the Cloud with ClamAV.
if (isset($_POST['Scan'])) { 
// / To detect viruses, we have ClamAV add specific results to the logfile. By reading the filesize immediately 
// / before and after the scans we can see if ClamAV found anything. If it did, we alert the user to an infection.
?>
<div align="center"><h3>Scan Complete!</h3></div>
<hr />
<?php
$LogFileSize1 = filesize($LogFile);
@shell_exec('sudo freshclam');
echo nl2br('<a style="padding-left:15px;">Updated Virus Definitions.</a>'."\n");
?><hr /><?php
shell_exec("clamscan -r $CloudLoc | grep FOUND >> $LogFile1");
$LogTXT = file_get_contents($LogFile1);
$WriteClamLogFile = file_put_contents($LogFile, $LogTXT.PHP_EOL, FILE_APPEND);
echo nl2br('<a style="padding-left:15px;">Scanned Cloud Directory.</a>'."\n");
?><hr /><?php
shell_exec("clamscan -r $InstLoc | grep FOUND >> $LogFile1");
$LogTXT = file_get_contents($LogFile1);
$WriteClamLogFile = file_put_contents($LogFile, $LogTXT.PHP_EOL, FILE_APPEND);
echo nl2br('<a style="padding-left:15px;">Scanned HRCloud2 Installation Directory.</a>'."\n");
unlink ($LogFile1);
$LogFileSize2 = filesize($LogFile);
$LogFileSize3 = ($LogFileSize2 - $LogFileSize1);
if ($LogFileSize3 > 2) {
    $ClamURL = 'DATA/'.$UserID.'/.AppLogs/'.$Date.'/'.$Date.'.txt';
  ?><br><div align="center"><?php
  echo nl2br('!!! WARNING !!! HRC2SecCore76, Potentially infected files found!'."\n");
  echo nl2br('HRCloud2 DID NOT remove any files. Please see the report below or 
    the logs and verify each file before continuing to use HRCloud2.'."\n");
    ?><p><a href="<?php echo $ClamURL; ?>" target="cloudContents">View logfile</a></p> 
    <br>
    <button id='button' name='button' onclick="goBack()">Go Back</button>
    <br>
    <?php }
if (filesize($ClamLog) <= 1) {
  ?><br><div align="center"><?php
  echo nl2br('HRCloud2 did not find any potentially infected files.'."\n"); ?>
    <br>
    <button id='button' name='button' onclick="goBack()">Go Back</button>
    <br>
    <?php } }  ?> 
