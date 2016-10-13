<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="Applications/displaydirectorycontents_72716/favicon.ico">
   <title>HRCLoud2 | Application Settings</title>
<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
<script type="text/javascript">
function goBack() {
    window.history.back(); }
</script>

<?php
// / This file was meant to be a resource to help users find useful 
// / documentation about HRCloud2.

if (!file_exists('config.php')) {
  echo nl2br('</head>ERROR!!! Helper12, Cannot process the HRCloud2 configuration file (config.php).'."\n"); 
  die (); }
else {
  require('config.php'); }
$WPFile = '/var/www/html/wp-load.php';

// / Verify that WordPress is installed.
if (!file_exists($WPFile)) {
  echo nl2br('</head>ERROR!!! Helper20, WordPress was not detected on the server.'."\n"); }
  else {
    require($WPFile); } 

$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$UserID = get_current_user_id();
$LogLoc = $InstLoc.'/DATA/'.$UserID.'/.AppLogs';
$LogInc = 0;
$SesLogDir = $LogLoc.'/'.$Date;
$ClamLogDir = ($InstLoc.'/'.'VirusLogs'.'/'.$Date.'.txt');
$LogFile = ($SesLogDir.'/'.$Date.'.txt');
$CloudDir = $CloudLoc.'/'.$UserID;
$CloudTemp = $InstLoc.'/DATA/';
$CloudTempDir = $CloudTemp.$UserID;
if (!file_exists($CloudLoc)) {
  echo ('</head>ERROR!!! Helper36, There was an error verifying the CloudLoc as a valid directory. Please check the config.php file and refresh the page.');
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

if (isset($_POST['UserDir'])) {
$UserDirPOST = ('/'.$_POST['UserDir'].'/'); }
if (!isset($_POST['UserDir'])) {
$UserDirPOST = ('/'); }
$CloudUsrDir = $CloudDir.$UserDirPOST; 
$CloudTmpDir = $CloudTempDir.$UserDirPOST; 
if (!file_exists($CloudUsrDir)) {
  mkdir($CloudUsrDir, 0755); }
if (!file_exists($CloudTmpDir)) {
  mkdir($CloudTmpDir, 0755); }
$UserConfig = $CloudTemp.$UserID.'/'.'.AppLogs/.config.php';
if (!file_exists($UserConfig)) {
  echo nl2br('</head>ERROR!!! Settings27, User Cache file was not detected on the server!'."\n"); 
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
 ?>
</head>
<body>
<div align="center">
 <h3>HRCloud2 Help</h3>
</div>
<hr />
<div align="center">
<p>NOTE: Selecting a help topic will bring you to the official HRCloud2 Github documentation!</p>
<form action="https://github.com/zelon88/HRCloud2/wiki" target="_parent" method"post">
<p><input type="submit" id="wikibutton" name="submitsmall" value="Official Wiki"></input></p></form>
<form action="https://github.com/zelon88/HRCloud2/wiki/About-HRCloud2" target="_parent" method"post">
<p><input type="submit" id="aboutbutton" name="submitsmall" value="About HRCloud2"></input></p></form>
<form action="https://github.com/zelon88/HRCloud2/commits/master" target="_parent" method"post">
<p><input type="submit" id="latestcommitsbutton" name="submitsmall" value="Latest Commits"></input></p></form>
<form action="https://github.com/zelon88/HRCloud2/wiki/Dependency-Requirements" target="_parent" method"post">
<p><input type="submit" id="dependencybutton" name="submitsmall" value="Dependency Info"></input></p></form>
<form action="https://github.com/zelon88/HRCloud2/wiki/Technical-Description-and-Breakdown" target="_parent" method"post">
<p><input type="submit" id="techbreakdownbutton" name="submitsmall" value="Technical Breakdown"></input></p></form>
<form action="https://github.com/zelon88/HRCloud2/wiki/FAQ" target="_parent" method"post">
<p><input type="submit" id="faqbutton" name="submitsmall" value="FAQ"></input></p></form>
<form action="https://github.com/zelon88/HRCloud2/issues/new" target="_parent" method"post">
<p><input type="submit" id="bugbutton" name="submitsmall" value="Report A Bug"></input></p></form>
<form action="mailto:zelon88@gmail.com" method"post">
<p><input type="submit" id="contactbutton" name="submitsmall" value="Contact zelon88"></input></p></form>
</form>
</div>
</body>
</html>