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
$AppDir = $InstLoc.'/Applications/';
$apps = scandir($AppDir, SCANDIR_SORT_DESCENDING);
$newest_app = $apps[0];
  $appCounter = 0;
foreach ($apps as $appName) {
  if ($appName == '.' or $appName == '..' or in_array($appName, $defaultApps)) continue;
  copy($InstLoc.'/index.html', $AppDir.$appName.'/index.html');
  $appLoc = 'Applications/'.$appName.'/'.$appName.'.php';
  echo nl2br('<div id="app'.$appCounter.'Overview" name="'.$appName.'Overview" style="height:160px; float:left; width:195px; height:195px; border:inset; margin-bottom:2px;"><p><strong>'."\n".$appName.'</strong></p><hr />');
  echo nl2br('<input type="submit" id="launchApplication" name="launchApplication" value="'.$appName.'" onclick="location.href=\''.'Applications/'.$appName.'/'.$appName.'.php\'; toggle_visibility(\'loading\');"></input></div>');
$appCounter++; } 
?>
</div>
</body>
</html>
