<?php

// / This file will retrieve information regarding the server's specifications and general statistics.
$specCacheFile = 'Cache/specCACHE.php';
$storageCacheFile = 'Cache/storageSpecCACHE.php';
$cpuSpecCacheFile = 'Cache/cpuSpecCACHE.php';
$usbCacheFile = 'Cache/usbCACHE.php';
$pciCacheFile = 'Cache/pciCACHE.php';
$uptimeCacheFile = 'Cache/uptimeCACHE.php';
@chmod($specCacheFile, 0755);
@chown($specCacheFile, 'www-data');
@chgrp($specCacheFile, 'www-data');
@chmod($storageCacheFile, 0755);
@chown($storageCacheFile, 'www-data');
@chgrp($storageCacheFile, 'www-data');
@chmod($cpuCacheFile, 0755);
@chown($cpuCacheFile, 'www-data');
@chgrp($cpuCacheFile, 'www-data');
@chmod($usbCacheFile, 0755);
@chown($usbCacheFile, 'www-data');
@chgrp($usbCacheFile, 'www-data');
@chmod($pciCacheFile, 0755);
@chown($pciCacheFile, 'www-data');
@chgrp($pciCacheFile, 'www-data');
@chmod($uptimeCacheFile, 0755);
@chown($uptimeCacheFile, 'www-data');
@chgrp($uptimeCacheFile, 'www-data');

// / The following code creates a cache file, or returns an error if one cannot be created
if (file_exists($specCacheFile)) {
  @chmod('Cache/');
  @chmod($specCacheFile, 0755);
  @unlink($specCacheFile); }

// / The following code retrievs statistics related to the server's basic hardware devices.
exec('lshw', $HardwareDATA);
$MAKESpecCacheFile = file_put_contents($specCacheFile, $HardwareDATA);
$HardwareDATA = file_get_contents($specCacheFile);
$specHardwareDeviceData = $HardwareDATA.PHP_EOL;

// / The following code retrievs statistics related to the server's basic storage devices.
exec('lsblk', $StorageDATA);
$MAKEStorageCacheFile = file_put_contents($storageCacheFile, $StorageDATA);
$StorageDATA = file_get_contents($storageCacheFile);
$specStorageDeviceData = $StorageDATA.PHP_EOL;

// / The following code retrievs statistics related to the server's basic CPU information.
exec('cat /proc/cpuinfo', $CPUSpecDATA);
$MAKECPUSpecCacheFile = file_put_contents($cpuSpecCacheFile, $CPUSpecDATA);
$CPUSpecDATA = file_get_contents($cpuSpecCacheFile);
$specCPUDeviceData = $CPUSpecDATA.PHP_EOL;

// / The following code retrievs statistics related to the server's basic USB devices.
exec('lsusb', $USBDATA);
$MAKEUSBCacheFile = file_put_contents($usbCacheFile, $USBDATA);
$USBDATA = file_get_contents($usbCacheFile);
$specUSBDeviceData = $USBDATA.PHP_EOL;

// / The following code retrievs statistics related to the server's basic PCI devices.
exec('lspci', $PCIDATA);
$MAKEPCICacheFile = file_put_contents($pciCacheFile, $PCIDATA);
$PCIDATA = file_get_contents($pciCacheFile);
$specPCIDeviceData = $PCIDATA.PHP_EOL;

// / The following code retrievs statistics related to the server's uptime.
exec('lspci', $UptimeDATA);
$MAKEUptimeCacheFile = file_put_contents($uptimeCacheFile, $UptimeDATA);
$UptimeDATA = file_get_contents($uptimeCacheFile);
$specUptimeData = $UptimeDATA.PHP_EOL;

