<?php

// / This file will retrieve information regarding the server's CPU performance and statistics.

$cpuCacheFile = 'Cache/cpuCACHE.php';
$cpuCacheFile1 = 'Cache/cpuCACHE1.php';

// / The following code will return the server's CPU load percentage average for the past 1 minute.
$exec_loads = sys_getloadavg();
$exec_cores = trim(shell_exec("grep -P '^processor' /proc/cpuinfo|wc -l"));
$cpu = round($exec_loads[0]/($exec_cores + 1)*100, 0);

// / The following code creates a cache file, or returns an error if one cannot be created
if (file_exists($cpuCacheFile)) {
  @chmod('Cache/');
  @chmod($cpuCacheFile, 0755);
  @unlink($cpuCacheFile); }

// / The following code caches the CPU statistics for all filesystems mounted to the server.
$file = file('/proc/cpuinfo');

$cpu_make = $file[1];
$cpu_family = $file[2];
$cpu_model = $file[3];
$cpu_model_name = $file[4];
$cpu_stepping = $file[5];
$cpu_microcode = $file[6];
$cpu_frequency = $file[7];
$cpu_cache_size = $file[8];
$cpu_physical_id = $file[9];
$cpu_siblings = $file[10];
$cpu_core_id = $file[11];
$cpu_cpu_cores = $file[12];

/*
echo nl2br ($cpu_family."\n");
echo nl2br ($cpu_model."\n");
echo nl2br ($cpu_model_name."\n");
echo nl2br ($cpu_stepping."\n");
echo nl2br ($cpu_microcode."\n");
echo nl2br ($cpu_frequency."\n");
echo nl2br ($cpu_cache_size."\n");
echo nl2br ($cpu_physical_id."\n");
echo nl2br ($cpu_siblings."\n");
echo nl2br ($cpu_core_id."\n");
echo nl2br ($cpu_cpu_cores."\n");
*/
?>