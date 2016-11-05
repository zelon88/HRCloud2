<!DOCTYPE html>
<html>
<head>
<title>HRCloud2 | Application Settings</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<script>
function goBack() {
    window.history.back(); }
</script>
<?php
// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2SAS10, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('sanitizeCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2SAS19, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('commonCore.php'); }

// / Secutity related processing.
$SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
$YUMMYSaltHash = $_POST['YUMMYSaltHash'];

if (!isset($YUMMYSaltHash)) {
  echo nl2br('!!! WARNING !!! HRC2SAVEAppSettings43, There was a critical security fault. Login Request Denied.'."\n"); 
  die("Application was halted on $Time".'.'); }
if ($YUMMYSaltHash !== $SaltHash) {
  echo nl2br('!!! WARNING !!! HRC2SAVEAppSettings46, There was a critical security fault. Login Request Denied.'."\n"); 
  die("Application was halted on $Time".'.'); }

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
  echo nl2br('!!! WARNING !!! HRC2SAVEAppSettings76, Potentially infected files found!'."\n");
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
<br>
<?php
if (!isset($_POST['Scan'])) {
if (isset($_POST['Save'])) {
  if (isset($_POST['NEWColorScheme'])) {
    $NEWColorScheme = $_POST['NEWColorScheme'];
    $txt = ('$ColorScheme = \''.$NEWColorScheme.'\';') ;
    $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br('Saved New Color-Scheme Settings.'."\n"); }
  if (isset($_POST['NEWShowHRAI'])) {
    $NEWShowHRAI = $_POST['NEWShowHRAI'];
    $txt = ('$ShowHRAI = \''.$NEWShowHRAI.'\';') ;
    $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br('Saved New HRAI Settings.'."\n"); }
  if (isset($_POST['NEWVirusScan'])) {
    $NEWVirusScan = $_POST['NEWVirusScan'];
    $txt = ('$VirusScan = \''.$NEWVirusScan.'\';') ;
    $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br('Saved New Anti-Virus Settings.'."\n"); }
  if (isset($_POST['NEWWordPressIntegration'])) {
    $NEWVirusScan = $_POST['NEWWordPressIntegration'];
    $txt = ('$WordPressIntegration = \''.$NEWWordPressIntegration.'\';') ;
    $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br('Saved New WordPress Integration Settings.'."\n"); }
?>
<hr />
<?php
echo nl2br("\n".'All settings were saved & applied on '.$Time.'.'."\n");
sleep(3); 
?><div align="center">   
<br>
<form target ="_parent" action="index1.php" method="get"><button id='button' name='home' value="1">Cloud Home</button></form>
<br>
</div>
<?php }
if (isset($_POST['LoadDefaults'])) {
  require('config.php');
  $NEWColorScheme = $ColorScheme; 
  $txt = ('$ColorScheme = \''.$NEWColorScheme.'\';') ;
  $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL , FILE_APPEND); 
  $NEWVirusScan = $VirusScan; 
  $txt = ('$VirusScan = \''.$NEWVirusScan.'\';') ;
  $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL , FILE_APPEND);
  ?><div align="center"><?php echo nl2br("\n".'Reset "Application Settings" to default values on '.$Time.'.'."\n"); } } ?></div>
<br>
<hr />
<div id='end' name='end' class='end'></div>
</body>
</html>