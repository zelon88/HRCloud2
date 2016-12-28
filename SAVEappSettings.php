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
<div style="margin-left:15px;">
<?php

// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2SAS10, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }

// / The follwoing code checks if the securityCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/securityCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2SAS10, Cannot process the HRCloud2 Secutity Core file (securityCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('/var/www/html/HRProprietary/HRCloud2/securityCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2SAS19, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); } ?>

<br>
<?php
if (isset($_POST['Save'])) {
  if (isset($_POST['NEWColorScheme'])) {
    $NEWColorScheme = $_POST['NEWColorScheme'];
    $txt = ('$ColorScheme = \''.$NEWColorScheme.'\';') ;
    $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br('Saved New Color-Scheme Settings.'."\n"); }
  if (isset($_POST['NEWShowHRAI'])) {
    $NEWShowHRAI = $_POST['NEWShowHRAI'];
    $txt = ('$ShowHRAI = \''.$NEWShowHRAI.'\';') ;
    $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br('Saved New HRAI Settings.'."\n"); }
  if (isset($_POST['NEWVirusScan'])) {
    $NEWVirusScan = $_POST['NEWVirusScan'];
    $txt = ('$VirusScan = \''.$NEWVirusScan.'\';') ;
    $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br('Saved New Anti-Virus Settings.'."\n"); }
  if (isset($_POST['NEWWordPressIntegration'])) {
    $NEWVirusScan = $_POST['NEWWordPressIntegration'];
    $txt = ('$WordPressIntegration = \''.$NEWWordPressIntegration.'\';') ;
    $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br('Saved New WordPress Integration Settings.'."\n"); }
?>
<hr />
<?php
echo nl2br("\n".'All settings were saved & applied on '.$Time.'.'."\n");
sleep(3); 
?><div align="center">   
<br>
<form target ="_parent" action="settings.php" method="get"><button id='button' name='home' value="1">Settings</button></form>
<br>
<form target ="_parent" action="index1.php" method="get"><button id='button' name='home' value="1">Home</button></form>
</div>
<?php }
if (isset($_POST['LoadDefaults'])) {
  require('config.php');
  $NEWColorScheme = $ColorScheme; 
  $txt = ('$ColorScheme = \''.$NEWColorScheme.'\';') ;
  $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); 
  $NEWVirusScan = $VirusScan; 
  $txt = ('$VirusScan = \''.$NEWVirusScan.'\';') ;
  $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND);
  ?><div align="center"><?php echo nl2br("\n".'Reset "Application Settings" to default values on '.$Time.'.'."\n"); } ?></div>
<br>
<hr />
<?php
// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/compatibilityCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2SAS41, Cannot process the HRCloud2 Compatibility Core file (compatibilityCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('/var/www/html/HRProprietary/HRCloud2/compatibilityCore.php'); }
?>
<div id='end' name='end' class='end'></div>
</div>
</body>
</html>