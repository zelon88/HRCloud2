<!DOCTYPE html>
<html lang="en">
<?php
// / The following code displays the HTML for the advanced gauge monitors. It is made to be loaded 
  // / in an iframer and refreshed at specified intervals.

// / The follwoing code checks if the commonCore.php file exists and terminates if it does not.
if (!file_exists('../../commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2ServMonitorApp18, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  include ('../../commonCore.php'); }

// / The following code loads the ServMonIserCache and sets the variables for the session.
$IncludeCPUFile = 'Cache/cpuINCLUDE.php';
$IncludeRAMFile = 'Cache/ramINCLUDE.php';
$IncludeDiskFile = 'Cache/diskINCLUDE.php';
$IncludeTempVoltFile = 'Cache/tempvoltINCLUDE.php';
$IncludeCPUFile1 = 'Cache/cpuINCLUDE1.php';
$IncludeRAMFile1 = 'Cache/ramINCLUDE1.php';
$IncludeDiskFile1 = 'Cache/diskINCLUDE1.php';
$IncludeTempVoltFile1 = 'Cache/tempvoltINCLUDE1.php';
$ServMonUserCache = $CloudTmpDir.'/.AppData/ServMon.php';
require($ServMonUserCache);
if ($UpdateInterval !== '0' or $UpdateInterval !== 0 or $UpdateInterval !== '') { ?>
<script>
    $(document).ready(function(){
        setInterval(function() {
            $("#cpuGauge").load("cpuUpdate.php #cpuGauge");
        }, <?php echo $UpdateInt; ?>);
    });
</script>
<?php }

// / The following code reads the cache data from the previous session to facilitate guages that start from previous
  // / values.
if (file_exists($IncludeCPUFile1)) {
  require $IncludeCPUFile1; 
  $cpuLAST = $cpu; }
if (!file_exists($IncludeCPUFile1) or $cpuLAST == '') {
  $cpuLAST = 0; }
if (file_exists($IncludeRAMFile1)) {
  require $IncludeRAMFile1; 
  $ramLAST = $ram; }
if (!file_exists($IncludeRAMFile1) or $ramLAST == '') {
  $ramLAST = 0; }
if (file_exists($IncludeDiskFile1)) {
  require $IncludeDiskFile1;
  $diskUsageLAST = $diskUsage[0]; }
if (!file_exists($IncludeDiskFile1) or $diskUsageLAST == '') {
  $diskUsageLAST = 0; }
if (file_exists($IncludeTempVoltFile1)) {
  require $IncludeTempVoltFile1; 
  $thermalSensorArr1LAST = $thermalSensorArr1[1]; }
if (!file_exists($IncludeTempVoltFile1) or $thermalSensorArr1LAST == '') {
  $thermalSensorArr1LAST = 0; }

// / The following code loads the data cache files, which set sensor data related variables for the session.
if (file_exists($IncludeCPUFile)) {
  require $IncludeCPUFile; }
if (!file_exists($IncludeCPUFile) or $cpu == '') {
  $cpu = 0; }
if (file_exists($IncludeRAMFile)) {
  require $IncludeRAMFile; }
if (!file_exists($IncludeRAMFile) or $ram == '') {
  $ram = 0; }
if (file_exists($IncludeDiskFile)) {
  require $IncludeDiskFile; }
if (!file_exists($IncludeDiskFile) or $diskUsage == '') {
  $diskUsage[0] = 0; }
if (file_exists($IncludeTempVoltFile)) {
  require $IncludeTempVoltFile; }
if (!file_exists($IncludeTempVoltFile) or $thermalSensorArr1[1] == '') {
  $thermalSensorArr1[1] = 0; }

// / The following code reads the contents of the Include files and copies them to the Include1 files.
  // / This is to facilitate the previous value in the cache structure, preventing the need for guages to
  // / begin at zero upon each refresh.
$IncludeCPUDATA1 = file_get_contents($IncludeCPUFile);
$WRITEIncludeCPUDATA1 = @file_put_contents($IncludeCPUFile1, $IncludeCPUDATA1);
$IncludeRAMDATA1 = file_get_contents($IncludeRAMFile);
$WRITEIncludeRAMDATA1 = @file_put_contents($IncludeRAMFile1, $IncludeRAMDATA1);
$IncludeDiskDATA1 = file_get_contents($IncludeDiskFile);
$WRITEIncludeDiskDATA1 = @file_put_contents($IncludeDiskFile1, $IncludeDiskDATA1);
$IncludeTempVoltDATA1 = file_get_contents($IncludeTempVoltFile);
$WRITEIncludeTempVoltDATA1 = @file_put_contents($IncludeTempVoltFile1, $IncludeTempVoltDATA1);
?>
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

    <div align="center" id="diskGauge" name="diskGauge" style="border:inset; float:left; width:355px; height:365px;">
        Disk Usage: <?php echo round(str_replace('%', '', $diskUsage[0])); ?>% <img src="Resources/x.png" title="Close Disk Usage Info" alt="Close Disk Usage Info" onclick="toggle_visibility1('diskGauge');" style="float:right; padding-right:2px; padding-top:2px; padding-bottom:2px;">
        <div style="float: center;" id="diskusagegaugeContainer"></div>
    </div>

<?php
// / The following code sets the Javascript requried to display the guages.
  // / Data is inputted from ServMonitor.php so that the guages know where to begin
  // / after each refresh.
?>
    <link rel="stylesheet" href="jqwidgets/styles/jqx.base.css" type="text/css" />

    <script type="text/javascript" src="scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxdraw.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxgauge.js"></script>
    <script type="text/javascript" src="scripts/toggle.visibility.js"></script>
    <script type="text/css" src="jqwidgets/styles/jqx.gaugeValue.js"></script>

    <script type="text/javascript">
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
                value: <?php echo str_replace(str_split('~#[](){};:$!#^&%@>*<abcdefghijklmnopqrstuvwxyz ,'), '', strtolower(str_replace('\'', '', $cpuLAST))); ?>,
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
                value: <?php echo str_replace(str_split('~#[](){};:$!#^&%@>*<abcdefghijklmnopqrstuvwxyz ,'), '', strtolower(str_replace('\'', '', $ramLAST))); ?>,
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
                value: <?php echo str_replace(str_split('~#[](){};:$!#^&%@>*<abcdefghijklmnopqrstuvwxyz ,'), '', strtolower(str_replace(' degrees C   ', '', str_replace('\'', '', $thermalSensorArr1LAST)))); ?>,
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
                value: <?php echo str_replace(str_split('~#[](){};:$!#^&%@>*<abcdefghijklmnopqrstuvwxyz ,'), '', strtolower(str_replace('\'', '', $diskUsageLAST))); ?>,
                colorScheme: 'scheme05',
                animationDuration: 1200
            });
            $('#diskusagegaugeContainer').on('valueChanging', function (e) {
                $('#gaugeValue').text(Math.round(e.args.value) + 'Disk Usage %');
            });
            $('#diskusagegaugeContainer').jqxGauge('value', '<?php echo round(str_replace('%', '', $diskUsage[0])); ?>');
        });
</script>
<script type="text/javascript">
    setTimeout(function() {
      location.reload(); }, '<?php echo $UpdateInterval; ?>');
</script>
