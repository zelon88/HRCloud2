<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="Applications/displaydirectorycontents_72716/favicon.ico">
   <title>HRCLoud2 | App Launcher</title>
<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
<script type="text/javascript">
function toggle_visibility(id) {
    var e = document.getElementById(id);
      if(e.style.display == 'block')
        e.style.display = 'none';
      else
        e.style.display = 'block'; }
function goBack() {
    window.history.back(); }
</script>

<?php
// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2AppIndex20, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require ('sanitizeCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2AppIndex28, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require ('commonCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('appCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2AL34, Cannot process the HRCloud2 App Core file (appCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require ('appCore.php'); }
?>
</head>
<body>
<div align="center">
 <h3>HRCloud2 Apps</h3>
</div>
<hr />
<div align="center" id='loading' name='loading' style="display:none;"><img src="Resources/pacmansmall.gif"></div>
<div align="center">
<?php 
// / Secutity related processing.
$SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
$YUMMYSaltHash = $_POST['YUMMYSaltHash'];
$uninstallApp = $_POST['uninstallApplication'];
$AppDir = $InstLoc.'/Applications/';
$apps = scandir($AppDir, SCANDIR_SORT_DESCENDING);
$appCounter = 0;

if (isset($uninstallApp)) {
  if (!isset($YUMMYSaltHash)) {
  echo nl2br('!!! WARNING !!! HRC2AppIndex60, There was a critical security fault. Login Request Denied.'."\n"); 
  die("Application was halted on $Time".'.'); }
if ($YUMMYSaltHash !== $SaltHash) {
  echo nl2br('!!! WARNING !!! HRC2AppIndex60, There was a critical security fault. Login Request Denied.'."\n"); 
  die("Application was halted on $Time".'.'); }
  $CleanDir = $InstLoc.'/Applications/'.$uninstallApp;
  @chmod($CleanDir, 0755);
  $CleanFiles = scandir($CleanDir);
  include ('janitor.php');
  unlink($CleanDir.'/index.html');
  rmdir($CleanDir);
  if (!file_exists($InstLoc.'/Applications/'.$uninstallApp)) {
    $txt = ('ERROR!!! HRC2AppIndex71 Could not clean directory '.$CleanFile.' on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }

$apps = scandir($AppDir, SCANDIR_SORT_DESCENDING);
foreach ($apps as $appName) {
  if ($appName == '.' or $appName == '..' or in_array($appName, $defaultApps)) continue;
  copy($InstLoc.'/index.html', $AppDir.$appName.'/index.html');
  $appLoc = 'Applications/'.$appName.'/'.$appName.'.php';
  echo nl2br('<div id="app'.$appCounter.'Overview" name="'.$appName.'Overview" style="height:160px; float:left; width:195px; height:195px; border:inset; margin-bottom:2px;"><strong>'."\n".$appName.'</strong>');
  if ($UserIDRAW == '1') {
      echo nl2br('<div id="deleteApp'.$appCounter.'Button" name="deleteApp'.$appCounter.'Button" align="right" style="display:block;" onclick="toggle_visibility(\'deleteApp'.$appCounter.'Button\'); toggle_visibility(\'XdeleteApp'.$appCounter.'Button\'); toggle_visibility(\'uninstallApp'.$appCounter.'Div\');">');
      echo nl2br('<img src="Resources/deletesmall.png" alt="Delete '.$appName.'" title="Delete '.$appName.'"></div>'); 
      echo nl2br('<div id="XdeleteApp'.$appCounter.'Button" name="XdeleteApp'.$appCounter.'Button" align="right" style="display:none;" onclick="toggle_visibility(\'deleteApp'.$appCounter.'Button\'); toggle_visibility(\'XdeleteApp'.$appCounter.'Button\'); toggle_visibility(\'uninstallApp'.$appCounter.'Div\'); ">');
      echo nl2br('<img src="Resources/x.png" alt="Close '.$appName.'" title="Close '.$appName.'"></div>'); 
      echo nl2br('<div align="center" id="uninstallApp'.$appCounter.'Div" name="uninstallApp'.$appCounter.'Div" style="display:none;">');
      echo nl2br('<form action="appIndex.php" method="post"><input type="submit" id="uninstallApp'.$appCounter.'" name="uninstallApp'.$appCounter.'" value="Confirm Delete" alt="Confirm Delete '.$appName.'" title="Confirm Delete '.$appName.'" onclick="toggle_visibility(\'loading\');">');
      echo nl2br('<input type="hidden" id="uninstallApplication" name="uninstallApplication" value="'.$appName.'">');
      echo nl2br('<input type="hidden" id="YUMMYSaltHash" name="YUMMYSaltHash" value="'.$SaltHash.'"></form></div>'); }
  echo nl2br ('<hr />');
  echo nl2br('<input type="submit" id="launchApplication" name="launchApplication" value="'.$appName.'" onclick="location.href=\''.'Applications/'.$appName.'/'.$appName.'.php\'; toggle_visibility(\'loading\');">');
  echo nl2br('</div>');     
$appCounter++; } 
?>
</div>
</body>
</html>
