<!doctype HTML>
<html>
<title>Basic Specification Monitors</title>
<?php
$noStyles = 1;

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
// / The following code will return the server's specifications.
require('specUpdater.php');
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code displays the HTML body for the Basic Utilization Iframer.
 ?>
<body>
<script type="text/javascript">
    setTimeout(function() {
      location.reload(); }, '<?php echo $UpdateInterval; ?>');
</script>
<div>
<a style="padding-left:5px;"><strong><img src="Resources/gauge.png" title="General Hardware Specs" alt="General Hardware Specs"> • General Hardware Specs: </strong>  <i><?php echo $specHardwareDeviceData; ?></i></a><hr />
<a style="padding-left:5px;"><strong><img src="Resources/gauge.png" title="Storage Specs" alt="Storage Specs"> • Storage Specs: </strong>  <i><?php echo $specStorageDeviceData; ?></i></a><hr />
<a style="padding-left:5px;"><strong><img src="Resources/gauge.png" title="CPU Specs" alt="CPU Specs"> • CPU Specs: </strong>  <i><?php echo $specCPUDeviceData; ?></i></a><hr />
<a style="padding-left:5px;"><strong><img src="Resources/gauge.png" title="Device Specs" alt="Device Specs"> • Device Specs: </strong>  <i><?php echo $specPCIDeviceData; ?></i></a><hr />
<a style="padding-left:5px;"><strong><img src="Resources/gauge.png" title="Uptime" alt="Uptime"> • Uptime: </strong>  <i><?php echo $specUptimeData; ?></i></a><hr />
</div>
</body>
</html>