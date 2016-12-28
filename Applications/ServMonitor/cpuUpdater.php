<?php

// / The following code will retrieve information regarding the server's CPU performance and statistics.
$cpuCacheFile = 'Cache/cpuCACHE.php';
$cpuCacheFile1 = 'Cache/cpuCACHE1.php';

// / The following code will return the server's CPU load percentage average for the past 5 minutes.
$exec_loads = sys_getloadavg();
$exec_cores = trim(shell_exec("grep -P '^processor' /proc/cpuinfo|wc -l"));
$cpu = round($exec_loads[0]/($exec_cores + 1)*100, 0);

// / The following code creates a cache file, or returns an error if one cannot be created
if (file_exists($cpuCacheFile)) {
  @chmod('Cache/');
  @chmod($cpuCacheFile, 0755);
  @unlink($cpuCacheFile); }

// / The following code caches the CPU statistics for all filesystems mounted to the server.
exec('cat /proc/cpuinfo', $cpuDATA);
$MAKECPUCacheFile = file_put_contents($cpuCacheFile, $cpuDATA);
?>
