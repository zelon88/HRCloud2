<!doctype HTML>
<html>
<title>Basic Utilization Monitors</title>
<?php
// / -----------------------------------------------------------------------------------
// / The follwoing code checks if the commonCore.php file exists and terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2ServMonitorApp18, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  include ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }
// / -----------------------------------------------------------------------------------

 // / -----------------------------------------------------------------------------------
// / The following code sets the variables for the session and loads the cache file.
$ServMonUserCache = $CloudTmpDir.'/.AppData/ServMon.php';
require($ServMonUserCache);
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will return the server's CPU load percentage average for the past 5 minutes.
require('cpuUpdater.php');
// / The following code will return the server's RAM usage percentage.
require('ramUpdater.php');
// / The following code will return the server's network load information.
require('networkUpdater.php');
// / The following code will return the server's disk load information.
require('diskUpdater.php');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code displays the HTML body for the Basic Utilization Iframer.
 ?>
<body>
<script type="text/javascript">
    setTimeout(function() {
      location.reload(); }, '<?php echo $UpdateInterval; ?>');
</script>
<div id='butils' name='butils'>
<a style="padding-left:5px;" onclick="parent.toggle_visibility('cpuGauge');" target="_parent"><strong><img src="Resources/gauge.png" title="More CPU Info" alt="More CPU Info">  • CPU Usage: </strong>  <i><?php echo $cpu; ?>% </i></a><hr />
<a style="padding-left:5px;" onclick="parent.toggle_visibility('ramGauge');" target="_parent"><strong><img src="Resources/gauge.png" title="More RAM Info" alt="More RAM Info">  • RAM Usage: </strong>  <i><?php echo $ram; ?>% </i></a><hr />
<a style="padding-left:5px;" onclick="parent.toggle_visibility('diskGauge'); " target="_parent"><strong><img src="Resources/gauge.png" title="More DISK Info" alt="More RAM Info">  • Disk Usage: </strong>  <i><?php echo $diskUsage[0]; ?></i></a><hr />
</div>
</body>
</html>