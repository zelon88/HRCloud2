<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="Applications/displaydirectorycontents_72716/favicon.ico">
   <title>HRCLoud2 | App Launcher</title>
<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
<script type="text/javascript">
function goBack() {
    window.history.back(); }
</script>
<?php
// / This file was meant to be a resource to help users find useful 
// / documentation about HRCloud2.

// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2AppIndex20, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('sanitizeCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2AppIndex28, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('commonCore.php'); }

// / The following code detects the existence of installed apps for the app launcher.
// / This code also checks that the plugin file is a valid HRCloud2 app.
$AppDir = $InstLoc.'/Applications/';
$apps = scandir($AppDir, SCANDIR_SORT_DESCENDING);
$newest_app = $apps[0];
foreach ($apps as $app) { 
  if ($app == '.' or $app == '..' or in_array($app, $defaultApps)) continue;
    $app = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $app); 
    $appName = $app;
    $appFile = $app.'.php';
    $appLoc = $appDir.$appFile; 
    if (!file_exists($appLoc)) {
      $txt = ('ERROR!!! HRC2AppIndex110, There was an error initializing app '.$appName.' on '.$Time.'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } 
    if (file_exists($appLoc)) {
      $appFileData = file_get_contents($appFile);
      if (strpos($appFileData, 'Name:') == 'false' or strpos($appFileData, 'Version:') == 'false' or strpos($appFileData, 'Author:') == 'false' 
        or strpos($appFileData, 'License: GPLv3') == 'false') die;
      require ($appLoc); 
      $txt = ('Op-Act: Initialized app '.$appName.' on '.$Time.'.'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } }
 ?>
</head>
<body>
<div align="center">
 <h3>HRCloud2 Apps</h3>
</div>
<hr />
<div align="center">
<?php 
foreach ($apps as $appName) {
  if ($appName == '.' or $appName == '..' or in_array($appName, $defaultApps)) continue;
  $appCounter = 0;
  echo nl2br('<div id="app'.$appCounter.'Overview" name="'.$appName.'Overview" style="height:160px; float:left; width:195px; height:195px; border:inset; margin-bottom:2px;"><p><strong>'."\n".$appName.'</strong></p><hr /></div>');
$appCounter++; }
?>
</div>
