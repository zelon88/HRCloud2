<?php

// / The following code will retrieve information regarding the server's tempvolt.
$tempvoltCacheFile = 'Cache/tempvoltCACHE.php';
$tempvoltCacheFile1 = 'Cache/tempvoltCACHE1.php';

// / The following code creates a cache file, or returns an error if one cannot be created
if (file_exists($tempvoltCacheFile)) {
  @chmod('Cache/');
  @chmod($tempvoltCacheFile, 0755);
  @unlink($tempvoltCacheFile); }
 if (file_exists($tempvoltCacheFile1)) {
  @chmod('Cache/');
  @chmod($tempvoltCacheFile1, 0755);
  @unlink($tempvoltCacheFile1); }

// / The following code retrieves basic statistics related to the server's tempvolt in degrees celcius.
exec('acpi -t -c', $tempvoltDATA);
$MAKETempvoltCacheFile = file_put_contents($tempvoltCacheFile, $tempvoltDATA.PHP_EOL, FILE_APPEND);
// / The following code retrieves basic statistics related to the server's in degrees faranheit.
exec('acpi -t -f', $tempvoltDATA);
$MAKETempvoltCacheFile = file_put_contents($tempvoltCacheFile, $tempvoltDATA.PHP_EOL, FILE_APPEND);
// / The following code retrieves basic statistics related to the server's battery, if one is isntalled.
exec('acpi -t -b', $tempvoltDATA);
$MAKETempvoltCacheFile = file_put_contents($tempvoltCacheFile, $tempvoltDATA.PHP_EOL, FILE_APPEND);
// / The following code retrieves basic statistics related to the server's AC power status, if one can be detected.
exec('acpi -t -a', $tempvoltDATA);
$MAKETempvoltCacheFile = file_put_contents($tempvoltCacheFile, $tempvoltDATA.PHP_EOL, FILE_APPEND);

// / The following code retrieves advanced statistics related to the server's tempvolts using lm-sensors, if it is available.
exec('sensors', $tempvoltDATA1);
$MAKETempvoltCacheFile1 = file_put_contents($tempvoltCacheFile1, $tempvoltDATA1);

/*
WORK STUFF 

CPU
SODIMM
CORE #
GPU

sudo apt-get install acpi
acpi -t

lm-sensors
sudo apt-get install acpi sensors-detect
sensors
*/

?>
