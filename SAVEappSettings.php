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
// / Verify that WordPress is installed.
$WPFile = '/var/www/html/wp-load.php';
if (!file_exists($WPFile)) {
  echo nl2br('ERROR!!! HRC2SAVEAppSettings16, WordPress was not detected on the server.'."\n"); }
  else {
    require($WPFile); } 
require("config.php");
$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$UserIDRAW = get_current_user_id();
$UserID = hash('ripemd160', $UserIDRAW.$Salts);
if ($UserIDRAW == '0' or $UserIDRAW == '') {
  echo nl2br('</head><body>ERROR!!! HRC2SAVEAppSettings24, You are not logged in!'."\n".'</body></html>'); 
  die (); }
$UserConfig = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.config.php';
if (!file_exists($UserConfig)) {
  die('ERROR!!! HRC2SAVEAppSettings29, There was no user cachefile found on '.$Time.'!'); }
include($UserConfig);
$LogLoc = $InstLoc.'/DATA/'.$UserID.'/.AppLogs';
$LogInc = 0;
$SesLogDir = $LogLoc.'/'.$Date;
$LogFile = ($SesLogDir.'/'.$Date.'.txt');
$LogFile1 = ($SesLogDir.'/'.$Date.'.TEMPVIRUSLOG.txt');
$CloudDir = $CloudLoc.'/'.$UserID;
$CloudTemp = $InstLoc.'/DATA/';
$CloudTempDir = $CloudTemp.$UserID;
$SaltHash = $SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
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
  if (isset($_POST['NEWVirusScan'])) {
    $NEWVirusScan = $_POST['NEWVirusScan'];
    $txt = ('$VirusScan = \''.$NEWVirusScan.'\';') ;
    $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br('Saved New Anti-Virus Settings.'."\n"); }
  if (isset($_POST['NEWShowHRAI'])) {
    $NEWShowHRAI = $_POST['NEWShowHRAI'];
    $txt = ('$ShowHRAI = \''.$NEWShowHRAI.'\';') ;
    $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br('Saved New HRAI Settings.'."\n"); }
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