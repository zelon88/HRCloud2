<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="favicon.ico">
   <title>HRCLoud2 | App Launcher</title>
<script type="text/javascript" src="/HRProprietary/HRCloud2/Applications/jquery-3.1.0.min.js"></script>
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
</head>
<?php
// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists(realpath(dirname(__FILE__)).'/sanitizeCore.php')) {
  echo nl2br('<body>ERROR!!! HRC2AppIndex20, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once (realpath(dirname(__FILE__)).'/sanitizeCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists(realpath(dirname(__FILE__)).'/commonCore.php')) {
  echo nl2br('<body>ERROR!!! HRC2AppIndex28, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once (realpath(dirname(__FILE__)).'/commonCore.php'); }

// / The follwoing code checks if the appCore.php file exists and 
// / terminates if it does not.
if (!file_exists(realpath(dirname(__FILE__)).'/appCore.php')) {
  echo nl2br('<body>ERROR!!! HRC2AppIndex34, Cannot process the HRCloud2 App Core file (appCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once (realpath(dirname(__FILE__)).'/appCore.php'); } 

// / The follwoing code checks if the securityCore.php file exists and 
// / terminates if it does not.
if (!file_exists(realpath(dirname(__FILE__)).'/securityCore.php')) {
  echo nl2br('<body>ERROR!!! HRC2AppIndex47, Cannot process the HRCloud2 Security file (securityCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once (realpath(dirname(__FILE__)).'/securityCore.php'); } ?>

<body style="font-family:<?php echo $Font; ?>;">
<div align="center">
<p><strong>HRCloud2 Apps</strong> <?php 
// / Secutity related processing.\
$appCounter = 0;

    if ($UserIDRAW == 1) { 
      echo '<button id="showInstallAppButton" name="showInstallAppButton" class="button" alt="Install App" title="Install App" style="display:block; float:right;" onclick="toggle_visibility(\'showInstallAppButton\'); toggle_visibility(\'XshowInstallAppButton\'); toggle_visibility(\'installAppForm\');">+</button>';
      echo '<img id="XshowInstallAppButton" name="XshowInstallAppButton" style="margin-right:5px; display:none; float:right;" onclick="toggle_visibility(\'showInstallAppButton\'); toggle_visibility(\'XshowInstallAppButton\'); toggle_visibility(\'installAppForm\');" src="Resources/x.png" alt="Close \'Install App\'" title="Close \'Install App\'"></p>'; 
      echo '<div id="installAppForm" name="installAppForm" style="display:none;"><form method="post" action="appIndex.php" enctype="multipart/form-data"><input type="file" id="appToUpload" name="appToUpload[]" class="uploadbox" multiple>';
      echo '<input type="hidden" id="YUMMYSaltHash" name="YUMMYSaltHash" value="'.$SaltHash.'"><input type="submit" id="installApplication" name="installApplication" class="button" value="Install App"></form></div>'; }
    if ($UserIDRAW !== 1) { 
      echo '</p>'; } ?>
</div>
<hr />
<div align="center" id='loading' name='loading' style="display:none;"><img src="Resources/pacmansmall.gif"></div>
<div align="center">
<?php 
// / The following code detects and displays each valid App in the "Applications" directory.
foreach ($apps as $appName) {
  if (in_array($appName, $defaultApps)) continue;
  if ($appName == '.' or $appName == '..' or in_array($appName, $defaultApps)) continue;
  @copy($InstLoc.'/index.html', $AppDir.$appName.'/index.html');
  $appLoc = 'Applications/'.$appName.'/'.$appName.'.php';
  $appIcon = 'Applications/'.$appName.'/'.$appName.'.png';
  if (!file_exists($appIcon)) {
    $appIcon = 'Resources/appicon.png'; }
  // / The folloiwing code declares the AppInfo for the app being displayed by scanning for the 
    // / HRCLOUD2-PLUGIN declaration contained within each HRC2 App.
    if (!file_exists($appLoc)) continue;
    $lines = file($appLoc);
    $lineCounter = 0;
    $ApplicationName = ''; 
    $ApplicationVersion = '';
    $ApplicationLicense = '';
    $ApplicationAuthor = '';
    $ApplicationDescription = '';
    $ApplicationWebsite = '';
    $ApplicationIntegration = '';
      foreach ($lines as $line) {
        if (strpos($line, 'App Name: ') == 'true') {
          $ApplicationName = str_replace('App Name: ', '', $line); 
          $ApplicationName = trim($ApplicationName); } 
        if (strpos($line, 'App Version: ') == 'true') {
          $ApplicationVersion = str_replace('App Version: ', '', $line);  } 
        if (strpos($line, 'App License: ') == 'true') {
          $ApplicationLicense = str_replace('App License: ', '', $line);  
          $ApplicationLicense = trim($ApplicationLicense); }
        if (strpos($line, 'App Author: ') == 'true') { 
          $ApplicationAuthor = str_replace('App Author: ', '', $line); 
          $ApplicationAuthor = trim($ApplicationAuthor); } 
        if (strpos($line, 'App Description: ') == 'true') {
          $ApplicationDescription = str_replace('App Description: ', '', $line); 
          $ApplicationDescription = trim($ApplicationDescription); } 
        if (strpos($line, 'App Website: ') == 'true') { 
          $ApplicationWebsite = str_replace('App Website: ', '', $line); 
          $ApplicationWebsite = trim($ApplicationWebsite); } 
        if (strpos($line, 'App Integration: ') == 'true') {
          $ApplicationIntegration = str_replace('App Integration: ', '', $line); 
          $ApplicationIntegration = trim($ApplicationIntegration); }
        if (strpos($line, 'App Permission: 0') == 'true' or strpos($line, 'App Permission: admin') == 'true' 
          or strpos($line, 'App Permission: Admin') == 'true') {
            if ($UserIDRAW !== 1) continue 2; }
        $lineCounter++; }

  echo nl2br('<div id="app'.$appCounter.'Overview" name="'.$appName.'Overview" style="overflow-y:auto; height:160px; float:left; width:190px; height:195px; border:inset; margin-bottom:2px;">');
  echo ('<div align="center">');
  echo nl2br('<br><input type="submit" id="launchApplication" name="launchApplication" value="'.$appName.'" onclick="location.href=\''.'Applications/'.$appName.'/'.$appName.'.php\'; toggle_visibility(\'loading\');"><p>');

  // / The following code displays administrator specific buttons.
  if ($UserIDRAW == 1) {
    echo ('<img id="deleteApp'.$appCounter.'Button" name="deleteApp'.$appCounter.'Button" style="cursor:pointer; padding-left:6px; padding-bottom:2px; float:right; display:block;" onclick="toggle_visibility(\'deleteApp'.$appCounter.'Button\'); toggle_visibility(\'app'.$appName.'Icon\'); toggle_visibility(\'XdeleteApp'.$appCounter.'Button\'); toggle_visibility(\'uninstallApp'.$appCounter.'Div\');" src="Resources/deletesmall.png" alt="Delete \''.$appName.'\'" title="Delete \''.$appName.'\'">'); 
    echo ('<img id="XdeleteApp'.$appCounter.'Button" name="XdeleteApp'.$appCounter.'Button" style="cursor:pointer; padding-left:6px; padding-bottom:2px; float:right; display:none;" onclick="toggle_visibility(\'deleteApp'.$appCounter.'Button\'); toggle_visibility(\'app'.$appName.'Icon\'); toggle_visibility(\'XdeleteApp'.$appCounter.'Button\'); toggle_visibility(\'uninstallApp'.$appCounter.'Div\'); " src="Resources/x.png" alt="Close \'Delete '.$appName.'\'" title="Close \'Delete '.$appName.' \'">'); }

  // / The followind code displays the App image and Launch button to all users.
  echo ('<img id="infoApp'.$appCounter.'Button" name="infoApp'.$appCounter.'Button" style="cursor:pointer; padding-left:6px; padding-bottom:2px; float:right; display:block;" src="Resources/info.png" alt="Show \''.$appName.'\' Info" title="Show \''.$appName.'\' Info" onclick="toggle_visibility(\'infoApp'.$appCounter.'Button\'); toggle_visibility(\'app'.$appName.'Icon\'); toggle_visibility(\'XinfoApp'.$appCounter.'Button\'); toggle_visibility(\'infoApp'.$appCounter.'Div\');">'); 
  echo ('<img id="XinfoApp'.$appCounter.'Button" name="XinfoApp'.$appCounter.'Button" style="cursor:pointer; padding-left:6px; padding-bottom:2px; float:right; display:none;" onclick="toggle_visibility(\'infoApp'.$appCounter.'Button\'); toggle_visibility(\'app'.$appName.'Icon\'); toggle_visibility(\'XinfoApp'.$appCounter.'Button\'); toggle_visibility(\'infoApp'.$appCounter.'Div\'); " src="Resources/x.png" alt="Close \''.$appName.'\' Info" title="Close \''.$appName.'\' Info">'); 
  echo ('<img src="Resources/newwindow.png" style="cursor:pointer; padding-left:6px; padding-bottom:2px; float:right;" alt="Launch \''.$appName.'\' in a new window" title="Launch \''.$appName.'\' in a new window" onclick="window.open(\''.$appLoc.'\',\''.$appName.'\',\'resizable,height=400,width=650\'); return false;">');
  echo ('</p></div>');
  echo nl2br ('<hr />');

  // / The following code displays administrator specific buttons.
  if ($UserIDRAW == 1) {
    echo nl2br('<div align="center" id="uninstallApp'.$appCounter.'Div" name="uninstallApp'.$appCounter.'Div" style="display:none;">');
    echo nl2br('<form action="appIndex.php" method="post" enctype="multipart/form-data"><input type="submit" id="uninstallApp'.$appCounter.'" name="uninstallApp'.$appCounter.'" value="Confirm Delete" alt="Confirm Delete '.$appName.'" title="Confirm Delete '.$appName.'" onclick="toggle_visibility(\'loading\');">');
    echo ('<input type="hidden" id="uninstallApplication" name="uninstallApplication" value="'.$appName.'">');
    echo ('<input type="hidden" id="YUMMYSaltHash" name="YUMMYSaltHash" value="'.$SaltHash.'"></form><br></div>'); }
  
  // / The followind code displays the App image and Launch button to all users.
  echo nl2br('<div align="center" id="infoApp'.$appCounter.'Div" name="infoApp'.$appCounter.'Div" style="cursor:pointer; display:none;" onclick="toggle_visibility(\'appSelector'.$appCounter.'\');">' );
  echo ('<div align="center"><a style="cursor:pointer;" onclick="toggle_visibility(\'appBasic'.$appCounter.'\');"><strong>Info</strong></a> | <a style="cursor:pointer;" onclick="toggle_visibility(\'appDescription'.$appCounter.'\'); "><strong>Description</strong></a></div>');
  
  // / The following code displays the Basic App information, when clicked.
  echo ('<div align="left" id="appBasic'.$appCounter.'" name="appBasic'.$appCounter.'" style="display:none;"><hr />');
  echo ('<div align="center"><strong>App Info</strong></div>');
  echo ('<p>App Name: <i>'.$ApplicationName.'</i></p>');
  echo ('<p>App Version: <i>'.$ApplicationVersion.'</i></p>');
  echo ('<p>App Author: <i>'.$ApplicationAuthor.'</i></p>');
  echo ('<p>App Website: <i>'.$ApplicationWebsite.'</i></p>');
  echo ('<p>App License: <i>'.$ApplicationLicense.'</i></p>');
  echo ('</div>');

  // / The following code displays the App description, when clicked.
  echo ('<div align="left" id="appDescription'.$appCounter.'" name="appDescription'.$appCounter.'" style="display:none;"><hr />');
  echo ('<div align="center"><strong>App Description</strong></div>');
  echo ('<p><i>'.$ApplicationDescription.'</i></p>');
  echo ('</div></div>');

  // / The followind code displays the App icon, if one exits in the App Directory.
  if (file_exists($appIcon)) {
    echo nl2br('<p><img src="'.$appIcon.'" maxwidth="75px" max-height="75px" id="app'.$appName.'Icon" name="app'.$appName.'Icon" style="cursor:pointer; display:block;" title="'.$appName.'" alt="'.$appName.'" onclick="location.href=\''.'Applications/'.$appName.'/'.$appName.'.php\';"></p> '); }
  
  // / The following code signifies the end of each App Div in the appIndex. DO NOT ADD APP-SPECIFIC CODE BELOW THIS LINE!!!
  echo nl2br('</div>');     
$appCounter++; } 
?>
</div>
</body>
</html>
