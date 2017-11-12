<!doctype html>
<html>
<meta charset="UTF-8">
<script type="text/javascript" src="/HRProprietary/HRCloud2/Applications/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="/HRProprietary/HRCloud2/Resources/HRC2-Lib.js"></script>
<title>HRCLoud2 | Application Settings</title>
<?php
// / -----------------------------------------------------------------------------------
// / The follwoing code checks for the required core filesand terminates if they are missing.
if (!file_exists('sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2SettingsCore11, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('sanitizeCore.php'); }
if (!file_exists('commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2SettingsCore103, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('commonCore.php'); }
if (!file_exists('securityCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2SettingsCore107, Cannot process the HRCloud2 Compatibility Core file (securityCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('securityCore.php'); }
if (!file_exists('compatibilityCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2SettingsCore107, Cannot process the HRCloud2 Compatibility Core file (compatibilityCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('compatibilityCore.php'); }
// / -----------------------------------------------------------------------------------

?>
<div align="center">
<h3>HRCloud2 Settings</h3>
<hr />
</div>
<div style="float:center; padding-left:10%;">
<?php
// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects to save new settings to their user cache file.
// / We must run this code before loading the rest of the core files so as to avoid a required refresh before 
  // / displaying the latest settings.
if (isset($saveSettings)) {
  // / The following code is sets the users color scheme. 
  if (isset($NEWColorScheme)) {
    $txt = ('$ColorScheme = \''.$NEWColorScheme.'\';') ;
    $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); 
    $txt = ('OP-Act: Saved "Color Scheme" setting: "'.$NEWColorScheme.'" to the user cache file on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br('Saved New Color-Scheme Settings.'."\n"); }
  // / The following code sets the users HRAI display preference.
  if (isset($NEWShowHRAI)) {
    $txt = ('$ShowHRAI = \''.$NEWShowHRAI.'\';') ;
    $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); 
    $txt = ('OP-Act: Saved "Show HRAI" setting: "'.$NEWShowHRAI.'" to the user cache file on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br('Saved New HRAI Settings.'."\n"); }
  // / The following code sets the users Tipa display preference.
  if (isset($$NEWShowTips)) {
    $txt = ('$ShowTips = \''.$NEWShowTips.'\';') ;
    $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); 
    $txt = ('OP-Act: Saved "Show Tips" setting: "'.$NEWShowTips.'" to the user cache file on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br('Saved New Tips Settings.'."\n"); }
  // / The following code is sets the current user timezone.
  if (isset($NEWTimezone)) {
    $txt = ('$Timezone = \''.$NEWTimezone.'\';') ;
    $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); 
    $txt = ('OP-Act: Saved "Timezone" setting: "'.$NEWTimezone.'" to the user cache file on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br('Saved New Timezone Settings.'."\n"); }
  // / The following settings area only set or displayed when the user is an authentiacted administrator.
  if ($UserIDRAW == 1) {
    // / The following code is sets the server's Data Compression settings. 
    if (isset($NEWDataCompression)) {
      $txt = ('$DataCompression = \''.$NEWDataCompression.'\';') ;
      $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); 
      $txt = ('OP-Act: Saved "Data Compression" setting: "'.$NEWDataCompression.'" to the user cache file on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      echo nl2br('Saved New Data Compression Settings.'."\n"); }
    // / The following code is sets the server's Virus Scanning setting.
    if (isset($NEWVirusScan)) {
      $txt = ('$VirusScan = \''.$NEWVirusScan.'\';') ;
      $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); 
      $txt = ('OP-Act: Saved "Virus Scan" setting: "'.$NEWVirusScan.'" to the user cache file on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      echo nl2br('Saved New Anti-Virus Settings.'."\n"); }
    // / The following code is sets the server's High Performance AV setting.
    if (isset($NEWHighPerformanceAV)) {
      $txt = ('$HighPerformanceAV = \''.$NEWHighPerformanceAV.'\';') ;
      $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); 
      $txt = ('OP-Act: Saved "High Performance AV" setting: "'.$NEWHighPerformanceAV.'" to the user cache file on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      echo nl2br('Saved New High Performance AV Settings.'."\n"); }
    // / The following code is sets the server's High Performance AV setting.
    if (isset($NEWThoroughAV)) {
      $txt = ('$ThoroughAV = \''.$NEWThoroughAV.'\';') ;
      $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); 
      $txt = ('OP-Act: Saved "Thorough AV" setting: "'.$NEWThoroughAV.'" to the user cache file on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      echo nl2br('Saved New Thorough AV Settings.'."\n"); } 
    // / The following code is sets the server's Persistence AV setting.
    if (isset($NEWPersistentAV)) {
      $txt = ('$PersistentAV = \''.$NEWPersistentAV.'\';') ;
      $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); 
      $txt = ('OP-Act: Saved "Persistent AV" setting: "'.$NEWPersistentAV.'" to the user cache file on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      echo nl2br('Saved New Persistent AV Settings.'."\n"); } }
?>
<hr />
<?php
sleep(1);
echo nl2br("\n".'All settings were saved & applied on '.$Time.'.'."\n");
?></div>
<div align="center">   
<hr /></div>
<?php }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects to reset their settings to the defaults set in 
  // / the servers main config.php file.
if (isset($loadDefaultSettings)) {
  require('config.php');
  $NEWColorScheme = $ColorScheme; 
  $txt = ('$ColorScheme = \''.$NEWColorScheme.'\';');
  $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); 
  $NEWShowHRAI = $ShowHRAI; 
  $txt = ('$ShowHRAI = \''.$NEWShowHRAI.'\';');
  $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND);
  $NEWTimezone = $Timezone; 
  $txt = ('$Timezone = \''.$NEWTimezone.'\';');
  $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND);
  $NEWShowTips = $ShowTips; 
  $txt = ('$ShowTips = \''.$NEWShowTips.'\';');
  $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND);
  if ($UserIDRAW == 1) {
    $NEWVirusScan = $VirusScan; 
    $txt = ('$VirusScan = \''.$NEWVirusScan.'\';');
    $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND);
    if (!isset($HighPerformanceAV)) { 
      $NEWHighPerformanceAV = '0'; 
      $txt = ('$HighPerformanceAV = \''.$NEWHighPerformanceAV.'\';');
      $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); }
    if (!isset($ThoroughAV)) { 
      $NEWThoroughAV = '0'; 
      $txt = ('$ThoroughAV = \''.$NEWThoroughAV.'\';');
      $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); }
    if (!isset($ThoroughAV)) { 
      $NEWPersistentAV = '0'; 
      $txt = ('$PersistentAV = \''.$NEWPersistentAV.'\';');
      $WriteSetting = file_put_contents($UserConfig, $txt.PHP_EOL, FILE_APPEND); } }
  ?><div align="center"><?php echo nl2br("\n".'Reset "Application Settings" to default values on '.$Time.'.'."\n"); 
  ?>
<hr /></div>
<?php 
sleep(1); } ?>
</div>
<?php
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Include the user's configuration data.
require($UserConfig);
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Prepare the $SaltHash.
$SaltHash = $SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Generate a client installer package using user supplied specifications.
if (isset($GenerateClient) && isset($GenClientOS) && isset($GenClientCPU) && isset($GenClientHomepage)) {
  $GenClientURL = $URL;
  $GenClientHomepage = trim($GenClientHomepage, '/');
  $SupportedClientOS = array('windows', 'linux', 'osx');
  $SupportedClientCPU = array('ia32', 'x64', 'armv71');
  $GenClientPre = 'HRCloud2-Client-';
  if ($GenClientHomepage == 'home') $GenClientHomepage = '/HRProprietary/HRCloud2/index2.php';
  if (in_array($GenClientOS, $SupportedClientOS) && in_array($GenClientCPU, $SupportedClientCPU)) { 
    $GenClientDir = $ClientInstallDir.'/'.$GenClientOS;
    $GenClientZip = $CloudUsrDir.'HRCloud2-Client_'.$GenClientOS.'_'.$GenClientCPU.'_'.$Date.'.zip';
    $GenClientTempZip = $CloudTmpDir.'HRCloud2-Client_'.$GenClientOS.'_'.$GenClientCPU.'_'.$Date.'.zip';
    $txt = 'OP-Act: Executing "nativefier -n "HRCloud2-Client" -a "'.$GenClientCPU.'" -p "'.$GenClientOS.'" "'.$GenClientURL.$GenClientHomepage.'" "'.$GenClientDir.'"" on '.$Time.'.';
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    exec('nativefier -n "HRCloud2-Client" -a "'.$GenClientCPU.'" -p "'.$GenClientOS.'" "'.$GenClientURL.$GenClientHomepage.'" "'.$GenClientDir.'"');
    @copy ('index.html', $ClientInstallDir.'/'.$GenClientOS.'/index.html');
    @system("/bin/chmod -R 0755 $CloudLoc");
    @system("/bin/chmod -R 0755 $InstLoc");
    if (file_exists($GenClientDir)) {
      foreach ($iterator = new \RecursiveIteratorIterator (
        new \RecursiveDirectoryIterator ($GenClientDir, \RecursiveDirectoryIterator::SKIP_DOTS),
        \RecursiveIteratorIterator::SELF_FIRST) as $item) {
        @chmod($item, 0755);
        if ($item->isDir()) {
          copy('index.html', $item.'/index.html'); } }  
    if (is_dir($GenClientDir)) {
      if ($GenClientOS == 'windows') {
        $GenClientOS1 = 'win32'; 
        copy($ClientInstallDirWin.'/setup.bat', $GenClientDir.'/HRCloud2-Client-win32-'.$GenClientCPU.'/setup.bat'); }
      if ($GenClientOS == 'linux') {
        $GenClientOS1 = 'linux'; 
        $GenClientPre = 'hr-cloud-2-client-'; }
      if ($GenClientOS == 'osx') {
        $GenClientOS1 = 'darwin'; }
      $txt = 'OP-Act: Executing "'.'cd '.$GenClientDir.'; zip -r -o '.$GenClientZip.' '.$GenClientPre.$GenClientOS1.'-'.$GenClientCPU.'" on '.$Time.'.';
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
      exec('cd '.$GenClientDir.'; zip -r -o '.$GenClientZip.' '.$GenClientPre.$GenClientOS1.'-'.$GenClientCPU);
      if (!file_exists($GenClientZip)) {
        $txt = 'ERROR!!! HRC2SettingsCore197, Could not create the Client App zip file on '.$Time.'.';
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
    if (!is_dir($GenClientDir)) {
      $txt = 'ERROR!!! HRC2SettingsCore201, Could not create the Client App build folder on '.$Time.'.';
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } }
  if (!in_array($GenClientOS, $SupportedClientOS) or !in_array($GenClientCPU, $SupportedClientCPU)) {
    $txt = 'ERROR!!! HRC2SettingsCore189, Invalid Client App Settings specified on '.$Time.'.';
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } } 
  @copy($GenClientZip, $GenClientTempZip);
  if (is_dir($GenClientDir.'HRCloud2-Client-'.$GenClientOS1.'-'.$GenClientCPU)) {
    $objects = scandir($GenClientDir.'HRCloud2-Client-'.$GenClientOS1.'-'.$GenClientCPU);
    foreach ($objects as $object) {
      if ($object != "." && $object != ".." && $object != '/' && $object != '//') {
        if (filetype($dir."/".$object) == "dir") 
           rrmdir($GenClientDir.'HRCloud2-Client-'.$GenClientOS1.'-'.$GenClientCPU."/".$object); 
        else 
          unlink ($GenClientDir.'HRCloud2-Client-'.$GenClientOS1.'-'.$GenClientCPU."/".$object); } }
    reset($objects);
    rmdir($dir); }
  echo nl2br('Generated a Client App Installation package to your Cloud Drive! | <a href="'.$URL.'/HRProprietary/HRCloud2/DATA/'.$UserID.'/HRCloud2-Client_'.$GenClientOS.'_'.$GenClientCPU.'_'.$Date.'.zip"><strong>Download Now</strong></a>.'."\n".'</hr>'); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Set the echo value for the "Data Comrpession" option.
if ($DataCompression == '0' or $DataCompression == '' or !isset($DataCompression)) {
  $DCEcho = 'Disabled'; }
if ($DataCompression == '1') {
  $DCEcho = 'Enabled (Automatic)'; }
if ($DataCompression == '2') {
  $DCEcho = 'Enabled (High Performance)'; }
if ($DataCompression == '3') {
  $DCEcho = 'Enabled (High Capacity)'; } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Set the echo value for the "Color Scheme" option.
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
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Prepare the echo value for the show HRAI input field.
if ($ShowHRAI == '1') {
  $SHRAIEcho = 'Enabled'; }
if ($ShowHRAI !== '1') {
  $SHRAIEcho = 'Disabled'; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Prepare the echo value for the Anti-Virus input field.
if ($VirusScan == '1') {
  $VSEcho = 'Enabled'; }
if ($VirusScan !== '1') {
  $VSEcho = 'Disabled'; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Prepare the echo value for the High Performance AV input field.
if ($HighPerformanceAV == '1') {
  $HPAVEcho = 'Enabled'; }
if ($HighPerformanceAV !== '1') {
  $HPAVEcho = 'Disabled'; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Prepare the echo value for the Thorough AV input field.
if ($ThoroughAV == '1') {
  $TAVEcho = 'Enabled'; }
if ($ThoroughAV !== '1') {
  $TAVEcho = 'Disabled'; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Prepare the echo value for the Persistent AV input field.
if ($PersistentAV == '1') {
  $PAVEcho = 'Enabled'; }
if ($PersistentAV !== '1') {
  $PAVEcho = 'Disabled'; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Prepare the echo value for the WordPress Integration input field.
if ($WordPressIntegration == '1') {
  $WPIEcho = 'Enabled'; }
if ($WordPressIntegration == '0') {
  $WPIEcho = 'Disabled'; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Prepare the echo value for the Timezone input field.
if (isset($Timezone)) {
  $TZEcho = $Timezone; }
if (!isset($Timezone)) {
  $TZEcho = $defaultTimezone; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / Prepare the echo value for the Tips input field.
if ($ShowTips == '1') {
  $STipsEcho = 'Enabled'; }
if ($ShowTips !== '1') {
  $STipsEcho = 'Disabled'; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following is displayed to all users.
?>
<div align='left'>
<form action="settingsCore.php" method="post" name='NEWAppSettings' id='NEWAppSettings'> 

<p alt="Generate a Desktop client App for your device." title="Generate a client App for your device." style="padding-left:15px;"><strong>1.</strong> Desktop App: </p>
  <p><select id="GenClientOS" name="GenClientOS" style="float:left; padding-left:30px; width:30%;">
  <option value="">Select your OS</option>
  <option value="windows">Windows</option>
  <option value="linux">Linux</option>
  <option value="osx">OSX</option>
  </select>
  <select id="GenClientCPU" name="GenClientCPU" style="float:left; padding-left:30px; width:30%;">
  <option value="">Select your CPU</option>
  <option value="x64">64-Bit (x64)</option>
  <option value="ia32">32-Bit (x32)</option>
  <option value="armv71">ARMv71</option>
  </select>
  <select id="GenClientHomepage" name="GenClientHomepage" style="float:left; padding-left:30px; width:30%;">
  <option value="">Select your Homepage</option>
  <option value="">URL Home</option>
  <option value="home">Cloud Home</option>
  </select></p>
<p style="float:center; padding-left:10%;"><input type='submit' name='GenerateClient' id='GenerateClient' value='Build Client' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/></p>

<p alt="Change the HRCloud2 color scheme." title="Change the HRCloud2 color scheme." style="padding-left:15px;"><strong>2.</strong> Color Scheme: </p>
  <p><select id="NEWColorScheme" name="NEWColorScheme" style="padding-left:30px; width:100%;">
  <option value="<?php echo $ColorScheme; ?>">Current (<?php echo $CSEcho; ?>)</option>
  <option value="1">Blue (Default)</option>
  <option value="2">Red</option>
  <option value="3">Green</option>
  <?php // ADD NUMBER 4 NEXT!!!!! ?>
  <option value="5">Black</option>
</select></p>

<p alt="Show or Hide HRAI at the top of most windows." title="Show or Hide HRAI at the top of most windows." style="padding-left:15px;"><strong>3.</strong> HRAI Load Balancing Personal Assistant: </p>
  <p><select id="NEWShowHRAI" name="NEWShowHRAI" style="padding-left:30px; width:100%;">
  <option value="<?php echo $ShowHRAI; ?>">Current (<?php echo $SHRAIEcho; ?>)</option>
  <option value="1">Enabled</option>
  <option value="0">Disabled</option>
</select></p>

<p alt="Show or Hide Tips at the top of most windows." title="Show or Hide Tips at the top of most windows." style="padding-left:15px;"><strong>4.</strong> Tips: </p>
  <p><select id="NEWShowTips" name="NEWShowTips" style="padding-left:30px; width:100%;">
  <option value="<?php echo $ShowTips; ?>">Current (<?php echo $STipsEcho; ?>)</option>
  <option value="1">Enabled</option>
  <option value="0">Disabled</option>
</select></p>

<?php
$regions = array(
    'Africa' => DateTimeZone::AFRICA,
    'America' => DateTimeZone::AMERICA,
    'Antarctica' => DateTimeZone::ANTARCTICA,
    'Aisa' => DateTimeZone::ASIA,
    'Atlantic' => DateTimeZone::ATLANTIC,
    'Europe' => DateTimeZone::EUROPE,
    'Indian' => DateTimeZone::INDIAN,
    'Pacific' => DateTimeZone::PACIFIC);
$timezones = array();
foreach ($regions as $name => $mask) {
  $zones = DateTimeZone::listIdentifiers($mask);
  foreach($zones as $timezone) {
    $time = new DateTime(NULL, new DateTimeZone($timezone));
    $ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';
    $timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . ' - ' . $time->format('H:i') . $ampm; } }
print '<p alt="Adjust the timezone so that logs and GUI elements match your local time." title="Adjust the timezone so that logs and GUI elements match your local time." style="padding-left:15px;"><strong>5.</strong> Select Your Timezone</p>
<p><select id="NEWTimezone" name="NEWTimezone" style="padding-left:30px; width:100%;">';
print '<option name="'.$TZEcho.'" value="'.$TZEcho.'">Current ('.$TZEcho.')</option>'."\n";
foreach($timezones as $region => $list) {
  print '<optgroup label="' . $region . '">' . "\n";
  foreach($list as $timezone => $name) {
    $explode1 = explode(' - ', $timezone);
    $tzexplode = trim($explode1[0]);
    print '<option name="' . $timezone . '" value="'.$tzexplode.'">' . $name . '</option>' . "\n"; }
  print '<optgroup>' . "\n"; }
print '</select></p>';  
// / -----------------------------------------------------------------------------------
?>

<p alt="Delete all cache and temporary data related to your HRCloud2 user account. (Will NOT delete uploaded data or user content)" title="Delete all cache and temporary data related to your user account." style="padding-left:15px;"><strong>6.</strong> Clear User Cache Files: </p>
    <p style="float:center; padding-left:10%;"><input type='submit' name='ClearCache' id='ClearCache' value='Clear User Cache' style="padding-left:30px; padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/></p>

<?php
// / -----------------------------------------------------------------------------------
// / The following is displayed if the user is an administrator.
if ($UserIDRAW == 1) { ?>
<div align="center"><h3>Admin Settings</h3></div>
<hr />

<p alt="Options for updating and maintainging HRCloud2." title="Options for updating and maintainging HRCloud2." style="padding-left:15px;"><strong>7.</strong> System Update </p>
 <p style="float:center; padding-left:10%;">Automatic Update Options: </p>
 <p style="float:center; padding-left:10%;"><input type='submit' name='AutoUpdate' id='AutoUpdate' value='Automatic Update' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/></p>
 <p style="float:center; padding-left:10%;">Manual Update Options: </p>
 <p style="float:center; padding-left:10%;">
  <input type='submit' name='AutoDownload' id='AutoDownload' value='Download Update' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/>
  <input type='submit' name='AutoInstall' id='AutoInstall' value='Install Update' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/>
  <input type='submit' name='AutoClean' id='AutoClean' value='Clean Update' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/>
  <input type='submit' name='CheckCompatibility' id='CheckCompatibility' value='Compat Check' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/></p>

<p alt="Options for performing virus scans on the server with ClamAV." title="Options for performing virus scans on the server with ClamAV." style="padding-left:15px;"><strong>8.</strong> Virus Scanning (Requires ClamAV on server): </p>
  <p><select id="NEWVirusScan" name="NEWVirusScan" style="width:100%;">
  <option value="<?php echo $VirusScan; ?>">Current (<?php echo $VSEcho; ?>)</option>
  <option value="1">Enabled</option>
  <option value="0">Disabled</option>
</select></p>
<?php 
/*
<p alt="Options to enable high performance (Multithreaded) A/V scanning." title="Options to enable high performance (Multithreaded) A/V scanning." style="padding-left:15px;"><strong>6.</strong> High Performance A/V Scanning (Multi-threading): </p>
  <p><select id="NEWHighPerformanceAV" name="NEWHighPerformanceAV" style="width:100%;">
  <option value="<?php echo $HighPerformanceAV; ?>">Current (<?php echo $HPAVEcho; ?>)</option>
  <option value="1">Enabled</option>
  <option value="0">Disabled</option>
</select></p>
*/
?>
<p alt="Options to enable thorough A/V scanning (May require advanced ClamAV permission configuration)." title="Options to enable thorough A/V scanning (May require advanced ClamAV permission configuration)." style="padding-left:15px;"><strong>9.</strong> Thorough A/V Scanning: </p>
  <p><select id="NEWThoroughAV" name="NEWThoroughAV" style="width:100%;">
  <option value="<?php echo $ThoroughAV; ?>">Current (<?php echo $TAVEcho; ?>)</option>
  <option value="1">Enabled</option>
  <option value="0">Disabled</option>
</select></p>

<p alt="Options to enable persistent A/V scanning (Will attempt to be as aggressive as possible without causing errors)." title="Options to enable persistent A/V scanning (Will attempt to be as aggressive as possible without causing errors)." style="padding-left:15px;"><strong>10.</strong> Persistent A/V Scanning: </p>
  <p><select id="NEWPersistentAV" name="NEWPersistentAV" style="width:100%;">
  <option value="<?php echo $PersistentAV; ?>">Current (<?php echo $PAVEcho; ?>)</option>
  <option value="1">Enabled</option>
  <option value="0">Disabled</option>
</select></p>
<p style="float:center; padding-left:10%;"><input type='submit' name='Scan' id='Scan' value='Scan Cloud' style="padding-left:30px; padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/></p>
<?php }
// / -----------------------------------------------------------------------------------
?>
<div align="center" id="loading" name="loading" style="display:none;"><p><img src="Resources/logosmall.gif" /></p></div>
<hr />
<div align='center'>
  <p><input type='submit' name='Save' id='Save' value='Save Changes' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/>
  <input type='submit' name='LoadDefaults' id='LoadDefaults' value='Load Defaults' style="padding: 2px; border: 1px solid black" onclick="toggle_visibility('loading');"/>
  <input type="hidden" name='YUMMYSaltHash' id='YUMMYSaltHash' value="<?php echo $SaltHash; ?>"></p>
</div>
</form>
<div align='center'>
<form action="settingsCore.php">
  <p><input type='submit'  name='Clear' id='Clear' value='Clear Changes' style="padding: 2px; border: 1px solid black"></p>
</form>
</div>
<div id='end' name='end' class='end'>
</div>
</div>
<hr />
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
</html>