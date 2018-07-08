  <!doctype HTML>
<html>
<title>Advanced CPU Monitor</title>
<head></head>
<?php
// / -----------------------------------------------------------------------------------
// / The follwoing code checks if the commonCore.php file exists and terminates if it does not.
if (!file_exists('../../commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2ServMonitorApp18, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  include ('../../commonCore.php'); }
// / -----------------------------------------------------------------------------------

 // / -----------------------------------------------------------------------------------
// / The following code sets the variables for the session and loads the cache file.
$ServMonUserCache = $CloudTmpDir.'/.AppData/ServMon.php';
require($ServMonUserCache);
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will return the required data for the CPU Guage.
require('cpuUpdater.php');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code displays the HTML body for the CPU Guage Iframer.
 ?>
<body>
<div>
      CPU Usage: <?php echo $cpu; ?>% <img src="Resources/x.png" title="Close CPU Info" alt="Close CPU Info" onclick="toggle_visibility1('cpuGauge');" style="float:right; padding-right:2px; padding-top:2px; padding-bottom:2px;">
        <div style="float: center;" id="cpugaugeContainer"></div>
    </div>
</body>
</html>