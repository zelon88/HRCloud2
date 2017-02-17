<!DOCTYPE html>
<html lang="en">
<head>
<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: ServMonitor
App Version: 2.0 (2-16-2017 11:30)
App License: GPLv3
App Author: zelon88 (w/special credits)
App Description: A simple HRCloud2 App for monitoring server status.
App Integration: 0 (False)
HRCLOUD2-PLUGIN-END
//*/

// / Special thanks to...
  // / 1. jqWidgets.com (http://jqwidgets.com/jquery-widgets-demo/demos/jqxgauge/index.htm)
  // / 2. IconArchive.com (https://iconarchive.com)
  // / 3. Itzik Gur (http://www.iconarchive.com/artist/itzikgur.html)
  // / 4. StackExchange user "dhaupin" (http://stackoverflow.com/users/2418655/dhaupin), (http://stackoverflow.com/questions/4705759/how-to-get-cpu-usage-and-ram-usage-without-exec/29669238)

// / -----------------------------------------------------------------------------------
// / The follwoing code checks if the commonCore.php file exists and terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2ServMonitorApp18, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  include ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets the variables for the session.
$basicMonitorCounter = 0;
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code ensures a valid update interval is specified.
if (isset($_POST['UpdateInt']) && $_POST['UpdateInt'] !== '') {
  $UpdateInt = str_replace(str_split('_[]{};:$!#^&%@>*<'), '', $_POST['UpdateInt']); }
if (!isset($_POST['UpdateInt']) or $_POST['UpdateInt'] == '') {
  $UpdateInt = 5000; }
if ($UpdateInt <= 2000) {
  $txt = ('WARNING!!! HRC2ServMonitorApp32, The "Update Interval" must be greater than 2000ms on '.$Time.'! Please increase the "Update Interval" to a value greater than 2000ms (or 2s).'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  $UpdateInt = 2000; }
if ($UpateInt == '' or !(isset($UpdateInt))) {
  $UpateInt = 5000; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code creates a cache dir, or returns an error if one cannot be created.
if (!is_dir('Cache/')) {
  @mkdir('Cache/', 0755); 
  @copy($InstLoc.'/index.html', 'Cache/index.html'); }
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
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will return the server's CPU load percentage average for the past 5 minutes.
require('cpuUpdater.php');
// / The following will reurn the servers current RAM usage percentage and current RAM usage in gigabytes (GB).
require('ramUpdater.php');
// / The following code will return the server's network load information.
require('networkUpdater.php');
// / The following code will return the server's disk load information.
require('diskUpdater.php');
// / The following code will return the server's temperature and voltage information.
require('tempvoltUpdater.php');
// / The following code will return the server's hardware specification information.
require('specUpdater.php');
// / -----------------------------------------------------------------------------------
?>
    <link rel="stylesheet" href="jqwidgets/styles/jqx.base.css" type="text/css" />

    <script type="text/javascript" src="scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxdraw.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxgauge.js"></script>
    <script type="text/javascript" src="scripts/toggle.visibility.js"></script>
    <script type="text/css" src="jqwidgets/styles/jqx.gaugeValue.js"></script>

    <script type="text/javascript">
    // / The following code handles automatic page refresh.
    //setTimeout(function() {
      //location.reload(); }, '<?php echo $UpdateInterval; ?>');
    // / The following code handles the scroll level of the page upon refresh.
    document.addEventListener("DOMContentLoaded", function(event) { 
      var scrollpos = localStorage.getItem('scrollpos');
    if (scrollpos) window.scrollTo(0, scrollpos); });
      window.onbeforeunload = function(e) {
      localStorage.setItem('scrollpos', window.scrollY); };
        // / The following code displays the CPU gauge.
         $(document).ready(function () {    
            $('#cpugaugeContainer').jqxGauge({
                ranges: [{ startValue: 0, endValue: 15, style: { fill: '#4bb648', stroke: '#4bb648' }, endWidth: 5, startWidth: 1 },
                         { startValue: 15, endValue: 40, style: { fill: '#fbd109', stroke: '#fbd109' }, endWidth: 10, startWidth: 5 },
                         { startValue: 40, endValue: 70, style: { fill: '#ff8000', stroke: '#ff8000' }, endWidth: 13, startWidth: 10 },
                         { startValue: 70, endValue: 100, style: { fill: '#e02629', stroke: '#e02629' }, endWidth: 16, startWidth: 13 }],
                ticksMinor: { interval: 5, size: '5%' },
                ticksMajor: { interval: 10, size: '9%' },
                value: 0,
                colorScheme: 'scheme05',
                animationDuration: 1200
            });
            $('#cpugaugeContainer').on('valueChanging', function (e) {
                $('#gaugeValue').text(Math.round(e.args.value) + '% CPU');
            });
            $('#cpugaugeContainer').jqxGauge('value', '<?php echo $cpu; ?>');
        });

        // / The following code displays the RAM gauge.
        $(document).ready(function () {
            $('#ramgaugeContainer').jqxGauge({
                ranges: [{ startValue: 0, endValue: 15, style: { fill: '#4bb648', stroke: '#4bb648' }, endWidth: 5, startWidth: 1 },
                         { startValue: 15, endValue: 40, style: { fill: '#fbd109', stroke: '#fbd109' }, endWidth: 10, startWidth: 5 },
                         { startValue: 40, endValue: 70, style: { fill: '#ff8000', stroke: '#ff8000' }, endWidth: 13, startWidth: 10 },
                         { startValue: 70, endValue: 100, style: { fill: '#e02629', stroke: '#e02629' }, endWidth: 16, startWidth: 13 }],
                ticksMinor: { interval: 5, size: '5%' },
                ticksMajor: { interval: 10, size: '9%' },
                value: 0,
                colorScheme: 'scheme05',
                animationDuration: 1200
            });
            $('#ramgaugeContainer').on('valueChanging', function (e) {
                $('#gaugeValue').text(Math.round(e.args.value) + '% RAM');
            });
            $('#ramgaugeContainer').jqxGauge('value', '<?php echo $ram; ?>');
        });

        // / The following code displays the CPU temperature gauge.
        $(document).ready(function () {    
            $('#cputempgaugeContainer').jqxGauge({
                ranges: [{ startValue: 0, endValue: 15, style: { fill: '#4bb648', stroke: '#4bb648' }, endWidth: 5, startWidth: 1 },
                         { startValue: 15, endValue: 40, style: { fill: '#fbd109', stroke: '#fbd109' }, endWidth: 10, startWidth: 5 },
                         { startValue: 40, endValue: 70, style: { fill: '#ff8000', stroke: '#ff8000' }, endWidth: 13, startWidth: 10 },
                         { startValue: 70, endValue: 100, style: { fill: '#e02629', stroke: '#e02629' }, endWidth: 16, startWidth: 13 }],
                ticksMinor: { interval: 5, size: '5%' },
                ticksMajor: { interval: 10, size: '9%' },
                value: 0,
                colorScheme: 'scheme05',
                animationDuration: 1200
            });
            $('#cputempgaugeContainer').on('valueChanging', function (e) {
                $('#gaugeValue').text(Math.round(e.args.value) + 'CPU Degrees Celcius');
            });
            $('#cputempgaugeContainer').jqxGauge('value', '<?php echo round(str_replace(' Degrees C', '', $thermalSensorArr1[1])); ?>');
        });

        // / The following code displays the disk usage gauge.
        $(document).ready(function () {    
            $('#diskusagegaugeContainer').jqxGauge({
                ranges: [{ startValue: 0, endValue: 15, style: { fill: '#4bb648', stroke: '#4bb648' }, endWidth: 5, startWidth: 1 },
                         { startValue: 15, endValue: 40, style: { fill: '#fbd109', stroke: '#fbd109' }, endWidth: 10, startWidth: 5 },
                         { startValue: 40, endValue: 70, style: { fill: '#ff8000', stroke: '#ff8000' }, endWidth: 13, startWidth: 10 },
                         { startValue: 70, endValue: 100, style: { fill: '#e02629', stroke: '#e02629' }, endWidth: 16, startWidth: 13 }],
                ticksMinor: { interval: 5, size: '5%' },
                ticksMajor: { interval: 10, size: '9%' },
                value: 0,
                colorScheme: 'scheme05',
                animationDuration: 1200
            });
            $('#diskusagegaugeContainer').on('valueChanging', function (e) {
                $('#gaugeValue').text(Math.round(e.args.value) + 'Disk Usage %');
            });
            $('#diskusagegaugeContainer').jqxGauge('value', '<?php echo round(str_replace(' % Disk Usage', '', $diskUsage)); ?>');
        });
</script>

</head>
<body style="background:white;">

<div align="center" id="basicMonitorsSHOWbutton" name="basicMonitorsSHOWbutton" onclick="toggle_visibility1('basicMonitors'); toggle_visibility1('basicMonitorsSHOWbutton');" style="clear:both; display:none;">Show "Basic Monitors"</div>
<div style="display:block; float:center;" id='basicMonitors' name="Monitors">  
<?php
// / -----------------------------------------------------------------------------------
// / The following code displays the basic monitoring analytics for the session.
?>
<div id="basicMonitors" name="basicMonitors" align="center" style="float:center; clear:both; display:block; float:center;">
<p><a style="margin-left:5%;"><strong>Basic Server Monitors</strong></a><a onclick="toggle_visibility1('basicMonitors'); toggle_visibility1('basicMonitorsSHOWbutton');" style="float:right; margin-right:3%;"><i>Hide</i></a></p>
<hr />
<div align="center" id="basicMonitorsheader" name="basicMonitorsheader" style="clear:both"><p><a onclick="toggle_visibility1('basicutilizationMonitors');">Utilization</a> | <a onclick="toggle_visibility1('basictemperatureMonitors');">Status</a> | <a onclick="toggle_visibility1('basicspecificationsMonitors');">Specifications</a></p></div>

<div id="basicutilizationMonitors" name="basicutilizationMonitors" style="overflow:scroll; float:left; display:none; width:30%; height:300px; border:inset; margin-left:1%;">
<a style="padding-left:5px;" onclick="toggle_visibility('cpuGauge');"><strong><img src="Resources/gauge.png" title="More CPU Info" alt="More CPU Info">  • CPU Usage: </strong>  <i><?php echo $cpu; ?>% </i></a><hr />
<a style="padding-left:5px;" onclick="toggle_visibility('ramGauge');"><strong><img src="Resources/gauge.png" title="More RAM Info" alt="More RAM Info">  • RAM Usage: </strong>  <i><?php echo $ram; ?>% </i></a><hr />
<a style="padding-left:5px;" onclick="toggle_visibility('diskGauge');"><strong><img src="Resources/gauge.png" title="More DISK Info" alt="More RAM Info">  • Disk Usage: </strong>  <i><?php echo $diskUsage[0]; ?></i></a><hr />
</div>

<div id="basictemperatureMonitors" name="basictemperatureMonitors" style="overflow:scroll; float:left; display:none; width:30%; height:300px; border:inset; margin-left:1%;">
<a style="padding-left:5px;" onclick="toggle_visibility('cpuTemperatureGauge');"><strong><img src="Resources/gauge.png" title="CPU Temperature" alt="CPU Temperature">  • CPU Temperature: </strong>  <i><?php echo $thermalSensorArr[0]; ?> </i></a><hr />
<?php
foreach ($thermalSensorArr as $thermalSensorDATA) { 
  if ($thermalSensorDATA == $thermalSensorArr[0]) continue; ?>
<a style="padding-left:5px;" onclick="toggle_visibility('acc<?php echo $basicMonitorCounter; ?>TemperatureGauge');"><strong><img src="Resources/gauge.png" title="Accessory Temperature" alt="Accessory Temperature"> • Accessory Temperature: </strong>  <i><?php echo $thermalSensorDATA; ?></i></a><hr />
<?php } ?>
<a style="padding-left:5px;" onclick="toggle_visibility('batteryGauge');"><strong><img src="Resources/gauge.png" title="Battery Status" alt="Battery Status"> • Battery Status: </strong>  <i><?php echo $batterySensorArr[0]; ?></i></a><hr />
<a style="padding-left:5px;" onclick="toggle_visibility('poweradapterGauge');"><strong><img src="Resources/gauge.png" title="Power Status" alt="Power Status"> • Power Status: </strong>  <i><?php echo $adapterSensorArr[0]; ?></i></a><hr />
<a style="padding-left:5px;" onclick="toggle_visibility('networkadapterGauge');"><strong><img src="Resources/gauge.png" title="Network Status" alt="Network Status"> • Network Status: </strong>  <i><?php echo $networkDeviceData; ?></i></a><hr />
</div>

<div id="basicspecificationsMonitors" name="basicspecificationsMonitors" style="overflow:scroll; float:left; display:none; width:30%; height:300px; border:inset; margin-left:1%;">
<a style="padding-left:5px;"><strong><img src="Resources/gauge.png" title="General Hardware Specs" alt="General Hardware Specs"> • General Hardware Specs: </strong>  <i><?php echo $specHardwareDeviceData; ?></i></a><hr />
<a style="padding-left:5px;"><strong><img src="Resources/gauge.png" title="Storage Specs" alt="Storage Specs"> • Storage Specs: </strong>  <i><?php echo $specStorageDeviceData; ?></i></a><hr />
<a style="padding-left:5px;"><strong><img src="Resources/gauge.png" title="CPU Specs" alt="CPU Specs"> • CPU Specs: </strong>  <i><?php echo $specCPUDeviceData; ?></i></a><hr />
<a style="padding-left:5px;"><strong><img src="Resources/gauge.png" title="USB Specs" alt="USB Specs"> • USB Specs: </strong>  <i><?php echo $specPCIDeviceData; ?></i></a><hr />
<a style="padding-left:5px;"><strong><img src="Resources/gauge.png" title="PCI Specs" alt="PCI Specs"> • PCI Specs: </strong>  <i><?php echo $specUptimeData; ?></i></a><hr />
</div>
<?php
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code displays the basic monitoring analytics for the session.
?>
</div>
<hr />
<div align="center" id="advancedMonitorsSHOWbutton" name="advancedMonitorsSHOWbutton" onclick="toggle_visibility1('advancedMonitors'); toggle_visibility1('advancedMonitorsSHOWbutton');" style="clear:both; display:none;">Show "Advanced Monitors"</div>
<div id="advancedMonitors" name="advancedMonitors" align="center" style="clear:both; display:block; float:center;">
    <p><a style="margin-left:5%;"><strong>Advanced Server Monitors</strong></a><a onclick="toggle_visibility1('advancedMonitors'); toggle_visibility1('advancedMonitorsSHOWbutton');" style="float:right; margin-right:3%;"><i>Hide</i></a></p>
    <hr />
    <div align="center" id="cpuGauge" name="cpuGauge" style="border:inset; float:left; width:355px; height:365px;">
        CPU Usage: <?php echo $cpu; ?>% <img src="Resources/x.png" title="Close CPU Info" alt="Close CPU Info" onclick="toggle_visibility1('cpuGauge');" style="float:right; padding-right:2px; padding-top:2px; padding-bottom:2px;">
        <div style="float: center;" id="cpugaugeContainer"></div>
    </div>

    <div align="center" id="ramGauge" name="ramGauge" style="border:inset; float:left; width:355px; height:365px;">
        RAM Usage: <?php echo $ram; ?>% <img src="Resources/x.png" title="Close RAM Info" alt="Close RAM Info" onclick="toggle_visibility1('ramGauge');" style="float:right; padding-right:2px; padding-top:2px; padding-bottom:2px;">
        <div style="float: center;" id="ramgaugeContainer"></div>
    </div>

    <div align="center" id="cpuTemperatureGauge" name="cpuTemperatureGauge" style="border:inset; float:left; width:355px; height:365px;">
        CPU Temperature: <?php echo round(str_replace(' degrees C', '', $thermalSensorArr1[1])); ?>&#8451; <img src="Resources/x.png" title="Close CPU Temp Info" alt="Close CPU Temp Info" onclick="toggle_visibility1('cpuTemperatureGauge');" style="float:right; padding-right:2px; padding-top:2px; padding-bottom:2px;">
        <div style="float: center;" id="cputempgaugeContainer"></div>
    </div>
</div>
<?php
// / -----------------------------------------------------------------------------------
?>
</div>
</body>
</html>