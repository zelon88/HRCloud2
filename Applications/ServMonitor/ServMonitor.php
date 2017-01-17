<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: ServMonitor
App Version: 1.4 (1-16-2017 00:00)
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


// / The follwoing code checks if the commonCore.php file exists and terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2ServMonitorApp18, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  include ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

// / The following code sets the variables for the session.
$basicMonitorCounter = 0;

// / The following code creates a cache dir, or returns an error if one cannot be created.
if (!is_dir('Cache/')) {
  @mkdir('Cache/', 0755); 
  @copy($InstLoc.'/index.html', 'Cache/index.html'); }
if (!is_dir('Cache/')) {
  $txt = ('ERROR!!! HRC2ServMonitorApp16, Could not create a Cache directory on '.$Time.'! Check permission and ownership of the HRC2 $InstLoc foun in "config.php!"'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  die($txt); }

// / The following code creates a user-specific cache file for the user, if one does not alreay exist.
  // / This cache file will store user-specific data relating to ServMonitor settings and preferences.
$ServMonUserCache = $CloudTmpDir.'/.AppData/ServMon.php';
if (!file_exists($ServMonUserCache)) {
  

}


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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="jqwidgets/styles/jqx.base.css" type="text/css" />

<script>
    $(document).ready(function(){
        setInterval(function() {
            $("#cpuGauge").load("cpuUpdate.php #cpuGauge");
        }, 5000);
    });
</script>
    <script type="text/javascript" src="scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxdraw.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxgauge.js"></script>
    <script type="text/javascript" src="scripts/toggle.visibility.js"></script>
    <script type="text/css" src="jqwidgets/styles/jqx.gaugeValue.js"></script>

    <script type="text/javascript">
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
            $('#cpugaugeContainer').jqxGauge('value', <?php echo $cpu; ?>);
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
            $('#ramgaugeContainer').jqxGauge('value', <?php echo $ram; ?>);
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
            $('#cputempgaugeContainer').jqxGauge('value', <?php echo round(str_replace(' degrees C', '', $thermalSensorArr1[1])); ?>);
        });
</script>

</head>
<body style="background:white;">

<div align="center" id="basicMonitorsSHOWbutton" name="basicMonitorsSHOWbutton" onclick="toggle_visibility1('basicMonitors'); toggle_visibility1('basicMonitorsSHOWbutton');" style="clear:both; display:none;">Show "Basic Monitors"</div>
<div style="display:block; float:center;" id='basicMonitors' name="Monitors">  
<?php
// / The following code displays the basic monitoring analytics for the session.
?>
<div id="basicMonitors" name="basicMonitors" align="center" style="float:center; clear:both; display:block; float:center;">
<p><a style="margin-left:5%;"><strong>Basic Server Monitors</strong></a><a onclick="toggle_visibility1('basicMonitors'); toggle_visibility1('basicMonitorsSHOWbutton');" style="float:right; margin-right:3%;"><i>Hide</i></p></a>
<hr />
<div align="center" id="basicMonitorsheader" name="basicMonitorsheader" style="clear:both"><p><a onclick="toggle_visibility1('basicutilizationMonitors');">Utilization</a> | <a onclick="toggle_visibility1('basictemperatureMonitors');">Status</a> | <a>Specifications</a></p></div>

<div id="basicutilizationMonitors" name="basicutilizationMonitors" style="overflow:scroll; float:left; display:none; width:30%; height:300px; border:inset; margin-left:3%;">
<a style="padding-left:5px;" onclick="toggle_visibility('cpuGauge');"><strong><img src="Resources/gauge.png" title="More CPU Info" alt="More CPU Info">  1. CPU Usage: </strong>  <i><?php echo $cpu; ?>% </i></a><hr />
<a style="padding-left:5px;" onclick="toggle_visibility('ramGauge');"><strong><img src="Resources/gauge.png" title="More RAM Info" alt="More RAM Info">  2. RAM Usage: </strong>  <i><?php echo $ram; ?>% </i></a><hr />
</div>

<div id="basictemperatureMonitors" name="basictemperatureMonitors" style="overflow:scroll; float:left; display:none; width:30%; height:300px; border:inset; margin-left:3%;">
<a style="padding-left:5px;" onclick="toggle_visibility('cpuTemperatureGauge');"><strong><img src="Resources/gauge.png" title="CPU Temperature" alt="CPU Temperature">  1. CPU Temperature: </strong>  <i><?php echo $thermalSensorArr[0]; ?> </i></a><hr />
<?php
foreach ($thermalSensorArr as $thermalSensorDATA) { 
  if ($thermalSensorDATA == $thermalSensorArr[0]) continue; 
  $basicMonitorCounter++; ?>
<a style="padding-left:5px;" onclick="toggle_visibility('acc<?php echo $basicMonitorCounter; ?>TemperatureGauge');"><strong><img src="Resources/gauge.png" title="Accessory <?php echo $basicMonitorCounter; ?> Temperature" alt="Accessory <?php echo $basicMonitorCounter; ?> Temperature">  <?php echo $basicMonitorCounter; ?>. Accessory Temperature: </strong>  <i><?php echo implode(', ', explode('   ,   ', $thermalSensorDATA)); ?></i></a><hr />
<?php } ?>
<a style="padding-left:5px;" onclick="toggle_visibility('batteryGauge');"><strong><img src="Resources/gauge.png" title="Battery Status" alt="Battery Status"> <?php echo $basicMonitorCounter; ?>. Battery Status: </strong>  <i><?php echo $batterySensorArr[0]; ?></i></a><hr />
<a style="padding-left:5px;" onclick="toggle_visibility('adpterGauge');"><strong><img src="Resources/gauge.png" title="Power Status" alt="Power Status"> <?php echo $basicMonitorCounter; ?>. Power Status: </strong>  <i><?php echo $adapterSensorArr[0]; ?></i></a><hr />

</div>
</div>
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
        CPU Temperature: <?php echo round(str_replace(' degrees C', '', $thermalSensorArr1[1])); ?>&#8451 <img src="Resources/x.png" title="Close CPU Temp Info" alt="Close CPU Temp Info" onclick="toggle_visibility1('cputemperatureGauge');" style="float:right; padding-right:2px; padding-top:2px; padding-bottom:2px;">
        <div style="float: center;" id="cputempgaugeContainer"></div>
    </div>
</div>
<hr />
</body>
</html>