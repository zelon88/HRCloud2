<?php

// / This file will retrieve information regarding the server's disk performance and statistics.
$diskCacheFile = 'Cache/diskCACHE.php';
$diskIncludeFile = 'Cache/diskINCLUDE.php';
@chmod($diskCacheFile, 0755);
@chown($diskCacheFile, 'www-data');
@chgrp($diskCacheFile, 'www-data');

// / The following code resets the cache file.
if (file_exists($diskCacheFile)) {
  @chmod($diskCacheFile, 0755);
  @unlink($diskCacheFile); }

// / The following code sets the POST and GET variables for the session, if there were any.
if (!isset($diskID) or !isset($_GET['diskID']) or !isset($_POST['diskID'])) {
  $diskID = ""; }
if (isset($_GET['diskID'])) {
  $diskID = $_GET['diskID']; }
if (isset($_POST['diskID'])) {
  $diskID = $_POST['diskID']; }

// / The following code caches the disk utilization statistics for all filesystems mounted to the server.
exec('df -k /tmp | tail -1 | tr -s \' \' | cut -d\' \' -f1', $diskName);
exec('df -k /tmp | tail -1 | tr -s \' \' | cut -d\' \' -f2', $diskName);
exec('df -k /tmp | tail -1 | tr -s \' \' | cut -d\' \' -f3', $diskUsed);
exec('df -k /tmp | tail -1 | tr -s \' \' | cut -d\' \' -f4', $diskFree);
exec('df -k /tmp | tail -1 | tr -s \' \' | cut -d\' \' -f5', $diskUsage);
$WRITEdiskIncludeFile = @file_put_contents($diskIncludeFile, '<?php $diskName = \''.$diskName[0].'\'; $diskName = \''.$diskName[0].'\'; $diskUsed = \''.$diskUsed[0].'\'; $diskFree = \''.$diskFree[0].'\'; $diskUsage = \''.$diskUsage[0].'\'; ?>');
