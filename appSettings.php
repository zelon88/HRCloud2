<!DOCTYPE html>
<html>
<head>
<title>HRCloud2 | Application Settings </title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php 
$WPFile = '/var/www/html/wp-load.php';
// / Verify that WordPress is installed.
if (!file_exists($WPFile)) {
  echo nl2br('ERROR!!! HRC2AppSettings16, WordPress was not detected on the server.'."\n"); }
  else {
    require($WPFile); } 
$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$UserID = get_current_user_id();
require("config.php");
$UserConfig = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.config.php';
include($UserConfig);
$LogLoc = $InstLoc.'/DATA/'.$UserID.'/.AppLogs';
$LogInc = 0;
$SesLogDir = $LogLoc.'/'.$Date;
$ClamLogDir = ($InstLoc.'/'.'VirusLogs'.'/'.$Date.'.txt');
$LogFile = ($SesLogDir.'/'.$Date.'.txt');
$CloudDir = $CloudLoc.'/'.$UserID;
$CloudTemp = $InstLoc.'/DATA/';
$CloudTempDir = $CloudTemp.$UserID;
if (!file_exists($CloudLoc)) {
  echo ('ERROR!!! HRC2AppSettings27, There was an error verifying the CloudLoc as a valid directory. Please check the config.php file and refresh the page.');
  die(); }
if (!file_exists($CloudDir)) {
  mkdir($CloudDir, 0755); }
if (!file_exists($CloudTempDir)) {
  mkdir($CloudTempDir, 0755); }

$LogInstallDir = 'Applications/displaydirectorycontents_logs/';
$LogInstallDir1 = 'Applications/displaydirectorycontents_logs1/';
$LogInstallFiles = scandir($InstLoc.'/'.$LogInstallDir);
$LogInstallFiles1 = scandir($InstLoc.'/'.$LogInstallDir1);
if (!file_exists($LogLoc)) {
$JICInstallLogs = @mkdir($LogLoc, 0755); 
  foreach ($LogInstallFiles as $LIF) {
    if ($LIF == '.' or $LIF == '..') continue;
      if (!file_exists($LIF)) {
      copy($LogInstallDir.$LIF, $LogLoc.'/'.$LIF); } } }
if (!file_exists($SesLogDir)) {
$JICInstallLogs = @mkdir($SesLogDir, 0755); 
  foreach ($LogInstallFiles1 as $LIF1) {
    if ($LIF1 == '.' or $LIF1 == '..') continue;
      if (!file_exists($LIF1)) {
      copy($LogInstallDir1.$LIF1, $SesLogDir.'/'.$LIF1); } } }

if ($ColorScheme == '1') {
  $CSEcho = 'Blue (Default)'; }
if ($ColorScheme == '2') {
  $CSEcho = 'Red'; }
if ($ColorScheme == '3') {
  $CSEcho = 'Green'; } 
if ($ColorScheme == '4') {
  $CSEcho = 'Purple'; }
if ($ColorScheme == '5') {
  $CSEcho = 'Grey'; }
if ($ColorScheme == '6') {
  $CSEcho = 'Black'; }
if ($ColorScheme == '7') {
  $CSEcho = 'Black/Red'; }

if ($VirusScan == '1') {
  $VSEcho = 'Enabled'; }
if ($VirusScan !== '1') {
  $VSEcho = 'Disabled'; }

$SaltHash = $SaltHash = hash('ripemd160',$Date.$Salts.$UserID);
?>
<body>
  <div align='center'><h3>Application Settings</h3></div>
  <hr />
 <div align='center'>
<div align='left'>
<form action="SAVEappSettings.php" method="post" name='NEWAppSettings' id='NEWAppSettings'> 
<div align="center">
<p>Color Scheme: <select id="NEWColorScheme" name="NEWColorScheme">
  <option value="<?php echo $ColorScheme; ?>">Current (<?php echo $CSEcho; ?>)</option>
  <option value="1">Blue (Default)</option>
  <option value="2">Red</option>
  <option value="3">Purple</option>
  <option value="4">Green</option>
  <option value="5">Grey</option>
  <option value="6">Black</option>
  <option value="7">Black</option>
</select></p>
<p>Virus Scanning (Requires ClamAV on server): <select id="NEWVirusScan" name="NEWVirusScan">
  <option value="<?php echo $VirusScan; ?>">Current (<?php echo $VSEcho; ?>)</option>
  <option value="1">Enabled</option>
  <option value="0">Disabled</option>
</select>
    <input type='submit' name='Scan' id='Scan' value='Scan Cloud' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/></p></div>
<div align="center" id="loading" name="loading" style="display:none;"><p><img src="pacmansmall.gif" /></p></div>
  <script type="text/javascript">
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block'; }
    function reload() {
    window.history.back(); }
</script>
<hr />
<div align='center'>
  <p><input type='submit' name='Save' id='Save' value='Save Changes' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/>
  <input type='submit' name='LoadDefaults' id='LoadDefaults' value='Load Defaults' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/>
  <input type="hidden" name='YUMMYSaltHash' id='YUMMYSaltHash' value="<?php echo $SaltHash; ?>">
</form>
  <input type='submit' name='Clear' id='Clear' value='Clear Changes' style="padding: 2px; border: 1px solid black" onclick="reload();"/></p>
<div id='end' name='end' class='end'></div>
<br>
<hr />
</body>
</html>