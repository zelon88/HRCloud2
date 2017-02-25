<!doctype HTML>
<html>
<title>Basic Utilization Monitors</title>
<head></head>
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
require('tempvoltUpdater.php');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code displays the HTML body for the Basic Utilization Iframer.
 ?>
<body>
<div>
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
</body>
<?php
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code handles automatic page refresh.
?>
<script type="text/javascript">
    setTimeout(function() {
      location.reload(); }, '<?php echo $UpdateInterval; ?>');
</script>
<html>