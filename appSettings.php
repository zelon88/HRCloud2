<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="Applications/displaydirectorycontents_72716/favicon.ico">
   <title>HRCLoud2 | Application Settings</title>
<?php
if (!file_exists('config.php')) {
  echo nl2br('<head><title>HRCloud2 | Settings - ERROR AS9</title></head>ERROR!!! AS9, Cannot process the HRCloud2 configuration file (config.php)!'."\n"); 
  die (); }
else {
  require('config.php'); }
// / HRAI Requires a helper to collect some information to complete HRCloud2 API calls (if HRAI is enabled).
if ($ShowHRAI == '1') {
  if (!file_exists('Applications/HRAI/HRAIHelper.php')) {
    echo nl2br('<head><title>HRCloud2 | Settings - ERROR AS16</title></head>ERROR!!! AS16, Cannot process the HRAI Helper file!'."\n"); }
  else {
    require('Applications/HRAI/HRAIHelper.php'); } }
// / Verify that WordPress is installed.
$WPFile = '/var/www/html/wp-load.php';
if (!file_exists($WPFile)) {
  echo nl2br('<head><title>HRCloud2 | Settings - ERROR AS22</title></head>ERROR!!! AS22, WordPress was not detected on the server!'."\n"); 
  die (); }
else {
    require($WPFile); } 
$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$UserIDRAW = get_current_user_id();
$UserID = hash('ripemd160', $UserIDRAW.$Salts);
$LogLoc = $InstLoc.'/DATA/'.$UserID.'/.AppLogs';
$LogInc = 0;
$SesLogDir = $LogLoc.'/'.$Date;
$CloudTemp = $InstLoc.'/DATA/';
$CloudTempDir = $CloudTemp.$UserID;
$UserConfig = $CloudTemp.$UserID.'/'.'.AppLogs/.config.php';
// / appSettings.php requires log locations. The following code creates the log files and directories if they
// / do not exist (if cloudCore.php hasn't made them yet).
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
// / Load the user cache file;
if (!file_exists($UserConfig)) {
  echo nl2br('</head>ERROR!!! AS27, User Cache file was not detected on the server!'."\n"); 
  die (); }
else {
    require($UserConfig); } 
if ($ColorScheme == '0' or $ColorScheme == '' or !isset($ColorScheme)) {
  $ColorScheme = '1'; }
if ($ColorScheme == '1') {
  echo ('<link rel="stylesheet" type="text/css" href="style.css">'); }
if ($ColorScheme == '2') {
  echo ('<link rel="stylesheet" type="text/css" href="styleRED.css">'); }
if ($ColorScheme == '3') {
  echo ('<link rel="stylesheet" type="text/css" href="styleGREEN.css">'); }
if ($ColorScheme == '4') {
  echo ('<link rel="stylesheet" type="text/css" href="styleGREY.css">'); }
if ($ColorScheme == '5') {
  echo ('<link rel="stylesheet" type="text/css" href="styleBLACK.css">'); } 
// / Prepare the echo value for the color input field.
if ($ColorScheme == '1') {
  $CSEcho = 'Blue (Default)'; }
if ($ColorScheme == '2') {
  $CSEcho = 'Red'; }
if ($ColorScheme == '3') {
  $CSEcho = 'Green'; } 
if ($ColorScheme == '4') {
  $CSEcho = 'Grey'; }
if ($ColorScheme == '5') {
  $CSEcho = 'Black'; }
// / Prepare the echo value for the virus input field.
if ($VirusScan == '1') {
  $VSEcho = 'Enabled'; }
if ($VirusScan !== '1') {
  $VSEcho = 'Disabled'; }
// / Prepare the echo value for the show HRAI input field.
if ($ShowHRAI == '1') {
  $SHRAIEcho = 'Enabled'; }
if ($ShowHRAI !== '1') {
  $SHRAIEcho = 'Disabled'; }

$SaltHash = $SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);

?>
    <script type="text/javascript">
    function Clear() {    
      document.getElementById("search").value= ""; }
    function toggle_visibility(id) {
      var e = document.getElementById(id);
      if(e.style.display == 'block')
         e.style.display = 'none';
      else
         e.style.display = 'block'; }
    function goBack() {
      window.history.back(); }
    </script>
</head>
<body>
<div align="center">
<h3>HRCloud2 Settings</h3>
<hr />
</div>
<div align='left'>
<form action="SAVEappSettings.php" method="post" name='NEWAppSettings' id='NEWAppSettings'> 

<?php if ($UserIDRAW !== '1' && $UserIDRAW !== '0') { ?>
<p style="padding-left:15px;"><strong>1.</strong> Color Scheme: </p>
  <p><select id="NEWColorScheme" name="NEWColorScheme" style="padding-left:30px; width:100%;"></p>
  <option value="<?php echo $ColorScheme; ?>">Current (<?php echo $CSEcho; ?>)</option>
  <option value="1">Blue (Default)</option>
  <option value="2">Red</option>
  <option value="3">Green</option>
  <?php // ADD NUMBER 4 NEXT!!!!! ?>
  <option value="5">Black</option>

</select></p>

<p style="padding-left:15px;"><strong>2.</strong> HRAI Load Balancing Personal Assistant: </p>
  <p><select id="NEWShowHRAI" name="NEWShowHRAI" style="padding-left:30px; width:100%;">
  <option value="<?php echo $ShowHRAI; ?>">Current (<?php echo $SHRAIEcho; ?>)</option>
  <option value="1">Enabled</option>
  <option value="0">Disabled</option>
</select></p>
</div>

<?php } 
if ($UserIDRAW == '1') { ?>
<p style="padding-left:15px;"><strong>3.</strong> Virus Scanning (Requires ClamAV on server): </p>
  <p><select id="NEWVirusScan" name="NEWVirusScan" style="padding-left:30px; width:100%;"><p>
  <option value="<?php echo $VirusScan; ?>">Current (<?php echo $VSEcho; ?>)</option>
  <option value="1">Enabled</option>
  <option value="0">Disabled</option>
</select>
<p style="float:center; padding-left:25%;"><input type='submit' name='Scan' id='Scan' value='Scan Cloud' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/></p>
<?php } ?>

<div align="center" id="loading" name="loading" style="display:none;"><p><img src="Resources/logosmall.gif" /></p></div>
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

<div id='end' name='end' class='end'>
</div>
<hr />
</body>
</html>