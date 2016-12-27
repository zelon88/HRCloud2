<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: ServPerf
App Version: 1.0 (12-26-2016 09:35)
App License: GPLv3
App Author: zelon88
App Description: A simple HRCloud2 App for monitoring server status.
App Integration: 0 (False)
HRCLOUD2-PLUGIN-END
//*/

// / Special thanks to...
  // / 1. jqWidgets.com (http://jqwidgets.com/jquery-widgets-demo/demos/jqxgauge/index.htm)
  // / 2. IconArchive.com (https://iconarchive.com)
  // / 3. Itzik Gur (http://www.iconarchive.com/artist/itzikgur.html)
  // / 4. StackExchange user "dhaupin" (http://stackoverflow.com/users/2418655/dhaupin), (http://stackoverflow.com/questions/4705759/how-to-get-cpu-usage-and-ram-usage-without-exec/29669238)

// / The following will reurn the servers current RAM usage percentage and current RAM usage in gigabytes (GB).
require('ramUpdater.php');
// / The following code will return the server's CPU load percentage average for the past 5 minutes.
require('cpuUpdater.php');
// / The following code will return the server's network load information.
require('networkUpdater.php');

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
    </script>
</head>
<body style="background:white;">

<div align="center" id="basicMonitorsSHOWbutton" name="basicMonitorsSHOWbutton" onclick="toggle_visibility1('basicMonitors'); toggle_visibility1('basicMonitorsSHOWbutton');" style="display:none;">Show "Basic Monitors"</div>
<div style="display:block; float:center;" id='basicMonitors' name="basicMonitors">  
<?php
// / The following code displays the basic monitoring analytics for the session.
?>
<div id="basicMonitors" name="basicMonitors" align="center" style="display:block; float:center;">
<p><a style="margin-left:5%;"><strong>Basic Server Monitors</strong></a><a onclick="toggle_visibility1('basicMonitors'); toggle_visibility1('basicMonitorsSHOWbutton');" style="float:right; margin-right:3%;"><i>Hide</i></p></a>
<hr />
<div align="center" id="basicMonitorsheader" name="basicMonitorsheader"><p><a onclick="toggle_visibility1('basicutilizationMonitors');">Utilization</a> | <a>Temperature</a> | <a>Voltage</a> | <a>Specifications</a></p></div>

<div id="basicutilizationMonitors" name="basicutilizationMonitors" style="overflow:scroll; display:none; width:30%; height:300px; border:inset; margin-left:3%;">
<a style="padding-left:5px;" onclick="toggle_visibility('cpuGauge');"><strong><img src="Resources/gauge.png" title="More CPU Info" alt="More CPU Info">  1. CPU Usage: </strong>  <i><?php echo $cpu; ?>% </i></a><hr />
<a style="padding-left:5px;" onclick="toggle_visibility('ramGauge');"><strong><img src="Resources/gauge.png" title="More RAM Info" alt="More RAM Info">  2. RAM Usage: </strong>  <i><?php echo $ram; ?>%, (<?php echo $mem; ?>) </i></a><hr />
</div>

</div>

</div>
<hr />
<div align="center" id="advancedMonitorsSHOWbutton" name="advancedMonitorsSHOWbutton" onclick="toggle_visibility1('advancedMonitors'); toggle_visibility1('advancedMonitorsSHOWbutton');" style="display:none;">Show "Advanced Monitors"</div>
<div id="advancedMonitors" name="advancedMonitors" align="center" style="display:block; float:center;">
    <p><a style="margin-left:5%;"><strong>Advanced Server Monitors</strong></a><a onclick="toggle_visibility1('advancedMonitors'); toggle_visibility1('advancedMonitorsSHOWbutton');" style="float:right; margin-right:3%;"><i>Hide</i></a></p>
    <hr />
    <div align="center" id="cpuGauge" name="cpuGauge" style="border:inset; float:left; width:355px; height:365px;">
        <?php echo $cpu; ?>% CPU Usage <img src="Resources/x.png" title="Close CPU Info" alt="Close CPU Info" onclick="toggle_visibility1('cpuGauge');" style="float:right; padding-right:2px; padding-top:2px; padding-bottom:2px;">
        <div style="float: center;" id="cpugaugeContainer"></div>
    </div>

    <div align="center" id="ramGauge" name="ramGauge" style="border:inset; float:left; width:355px; height:365px;">
        <?php echo $ram; ?>% RAM Usage <img src="Resources/x.png" title="Close RAM Info" alt="Close RAM Info" onclick="toggle_visibility1('ramGauge');" style="float:right; padding-right:2px; padding-top:2px; padding-bottom:2px;">
        <div style="float: center;" id="ramgaugeContainer"></div>
    </div>
</div>
<hr />
</body>
</html>