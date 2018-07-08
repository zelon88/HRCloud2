<!DOCTYPE html>
<html lang="en">
<head>
<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: ServMonitor
App Version: v3.1 (7-7-2018 00:00)
App License: GPLv3
App Author: zelon88 (w/special credits)
App Description: A simple HRCloud2 App for monitoring server status.
App Integration: 0 (False)
App Permission: 0 (Admin)
HRCLOUD2-PLUGIN-END
//*/

// / Special thanks to...
  // / 1. jqWidgets.com (http://jqwidgets.com/jquery-widgets-demo/demos/jqxgauge/index.htm)
  // / 2. IconArchive.com (https://iconarchive.com)
  // / 3. Itzik Gur (http://www.iconarchive.com/artist/itzikgur.html)
  // / 4. StackExchange user "dhaupin" (http://stackoverflow.com/users/2418655/dhaupin), (http://stackoverflow.com/questions/4705759/how-to-get-cpu-usage-and-ram-usage-without-exec/29669238)
  // / 5. Also check out the ICON_CREDITS.txt for more props to amazing designers and developers!!!

// / -----------------------------------------------------------------------------------
// / The follwoing code checks if the commonCore.php file exists and terminates if it does not.
if (!file_exists('../../commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2ServMonitorApp18, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  include ('../../commonCore.php'); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets the variables for the session.
$basicMonitorCounter = 0;
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code ensures a valid update interval is specified.
if (isset($_POST['UpdateInterval']) && $_POST['UpdateInterval'] !== '') {
  $UpdateInterval = str_replace(str_split('_[]{};:$!#^&%@>*<'), '', $_POST['UpdateInterval']); }
if (!isset($_POST['UpdateInterval']) or $_POST['UpdateInterval'] == '') {
  $UpdateInterval = 5000; }
if ($UpdateInterval <= 2000) {
  $txt = ('WARNING!!! HRC2ServMonitorApp32, The "Update Interval" must be greater than 2000ms on '.$Time.'! Please increase the "Update Interval" to a value greater than 2000ms (or 2s).'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  $UpdateInterval = 2000; }
if ($UpateInt == '' or !(isset($UpdateInterval))) {
  $UpateInt = 5000; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code creates a cache dir, or returns an error if one cannot be created.
// / -Take ownership of cache files
@chown('Cache/', $ILPerms);
// / -Change the group of cache files-
@chgrp('Cache', $ILPerms);
// / -Restrict cache files-
@chmod('Cache/', $ILPerms);
// / -Check for the existence of required dirs and files. Copy a new index if needed-
if (!is_dir('Cache/')) {
  @mkdir('Cache/', $ILPerms); 
  @copy($InstLoc.'/index.html', 'Cache/index.html'); }
// / -Report erros-
if (!is_dir('Cache/')) {
  $txt = ('ERROR!!! HRC2ServMonitorApp16, Could not create a Cache directory on '.$Time.'! Check permission and ownership of the HRC2 $InstLoc foun in "config.php!"'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  die($txt); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code creates a user-specific cache file for the user, if one does not alreay exist.
  // / This cache file will store user-specific data relating to ServMonitor settings and preferences.
$ServMonUserCache = $CloudTmpDir.'/.AppData/ServMon.php';
if (!file_exists($ServMonUserCache)) {
  $txt = '';
  file_put_contents($ServMonUserCache, $txt); }
if (isset($_POST['UpdateInterval'])) {
  $txt = '<?php $UpdateInterval = '.$UpdateInterval.' ?>';
  file_put_contents($ServMonUserCache, $txt.PHP_EOL, FILE_APPEND); }
require($ServMonUserCache);
$UpateInt = $UpdateInterval;
$valueRAW = $UpdateInterval;
$valuePretty = ($UpdateInterval / 1000).'s';
// / -----------------------------------------------------------------------------------
?>
<script type="text/javascript" src="scripts/toggle.visibility.js"></script>
</head>
<body style="background:white;">
<div align="left" id="settingsGearDIV" name="settingsGearDIV" style="display:block;" ><img id="settingsGear" name="settingsGear" src="Resources/gear.png" onclick="toggle_visibility('settingsDisplay'); toggle_visibility('settingsXDIV'); toggle_visibility('settingsGearDIV');"></img></div>
<div align="left" id="settingsXDIV" name="settingsXDIV" style="display:none;"><img id="settingsX" name="settingsX" src="Resources/x.png" onclick="toggle_visibility('settingsDisplay'); toggle_visibility('settingsXDIV'); toggle_visibility('settingsGearDIV');"></img></div>
<div id="settingsDisplay" name="settingsDisplay" style="display:none;">
<form enctype="multipart/form-data" method="post" action="ServMonitor.php">
  <select id="UpdateInterval" name="UpdateInterval">
    <option value="<?php echo $valueRAW; ?>">Current (<?php echo $valuePretty; ?>)</option>
    <option value="5000">Default (5s)</option>
    <option value="2000">2s</option>
    <option value="3000">3s</option>
    <option value="4000">4s</option>
    <option value="5000">5s</option>
    <option value="7000">7s</option>
    <option value="10000">10s</option>
    <option value="15000">15s</option>
    <option value="30000">30s</option>
    <option value="60000">60s</option>
    <option value="90000">90s</option>
    <option value="120000">120s</option></select>
    <input type="submit" value="Apply Settings"></form>
</div>
<div align="center" id="basicMonitorsSHOWbutton" name="basicMonitorsSHOWbutton" onclick="toggle_visibility1('basicMonitors'); toggle_visibility1('basicMonitorsSHOWbutton');" style="clear:both; display:none;">Show "Basic Monitors"</div>
<div style="display:block; float:center;" id='basicMonitors' name="Monitors">  
<?php
// / -----------------------------------------------------------------------------------
// / The following code displays the basic monitoring analytics for the session.
?>
<div id="basicMonitors" name="basicMonitors" align="center" style="float:center; clear:both; display:block; float:center;">
<a style="margin-left:5%;"><strong>Basic Server Monitors</strong></a><a onclick="toggle_visibility1('basicMonitors'); toggle_visibility1('basicMonitorsSHOWbutton');" style="float:right; margin-right:3%;"><i>Hide</i></a>
<hr />
<div align="center" id="basicMonitorsheader" name="basicMonitorsheader" style="clear:both"><p><a onclick="toggle_visibility1('basicutilizationMonitors');">Utilization</a> | <a onclick="toggle_visibility1('basictemperatureMonitors');">Status</a> | <a onclick="toggle_visibility1('basicspecificationsMonitors');">Specifications</a></p></div>

<iframe id="basicutilizationMonitors" name="basicutilizationMonitors" style="overflow:scroll; float:left; display:none; width:30%; height:300px; border:inset; margin-left:1%;" src="butil.php?UpdateInterval=$UpdateInterval"></iframe>

<iframe id="basictemperatureMonitors" name="basictemperatureMonitors" style="overflow:scroll; float:left; display:none; width:30%; height:300px; border:inset; margin-left:1%;" src="btemp.php?UpdateInterval=$UpdateInterval"></iframe>

<iframe id="basicspecificationsMonitors" name="basicspecificationsMonitors" style="overflow:scroll; float:left; display:none; width:30%; height:300px; border:inset; margin-left:1%;" src="bspec.php"></iframe>
<?php
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code displays the basic monitoring analytics for the session.
?>
</div></div>
<hr />
<div align="center" id="advancedMonitorsSHOWbutton" name="advancedMonitorsSHOWbutton" onclick="toggle_visibility1('advancedMonitors'); toggle_visibility1('advancedMonitorsSHOWbutton');" style="clear:both; display:none;">Show "Advanced Monitors"</div>
<div id="advancedMonitors" name="advancedMonitors" align="center" style="clear:both; display:block; float:center;">
    <p><a style="margin-left:5%;"><strong>Advanced Server Monitors</strong></a><a onclick="toggle_visibility1('advancedMonitors'); toggle_visibility1('advancedMonitorsSHOWbutton');" style="float:right; margin-right:3%;"><i>Hide</i></a></p>
    <hr />
<iframe id="advancedMonitors" name="advancedMonitors" style="overflow:scroll; float:left; width:98%; height:750px; border:inset; margin-left:1%;" src="agauges.php"></iframe>
</div>
<?php
// / -----------------------------------------------------------------------------------
?>
</body>
</html>