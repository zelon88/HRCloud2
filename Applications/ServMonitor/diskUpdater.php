<?php

// / The following code will retrieve information regarding the server's network performance and statistics.
$diskCacheFile = 'Cache/diskCACHE.php';

// / The following code sets the POST and GET variables for the session, if there were any.
if (!isset($diskID) or !isset($_GET['diskID']) or !isset($_POST['diskID'])) {
  $diskID = "eth0"; }
if (isset($_GET['diskID'])) {
  $diskID = $_GET['diskID']; }
if (isset($_POST['diskID'])) {
  $diskID = $_POST['diskID']; }

// / The following code creates a cache file, or returns an error if one cannot be created
if (file_exists($diskCacheFile)) {
  @chmod('Cache/');
  @chmod($diskCacheFile, 0755);
  @unlink($diskCacheFile); }

// / The following code caches the disk utilization statistics for all filesystems mounted to the server.
exec('df', $diskDATA);
$MAKEDiskCacheFile = file_put_contents($diskCacheFile, $diskDATA);

$CacheDATA = file_get_contents($diskCacheFile);
$CacheDATAArr = explode('             ', $CacheDATA);
foreach ($CacheDATAArr as $diskDATA) {
  if ($diskDATA == '.' or $diskDATA == '..') die('ERROR!!! HRC2ServMonitorAppDiskUpdater27, There was a critical security fault on'.$Time.'.');
  if (strpos($diskDATA, 'Filesystem')) continue;
  if (!is_array($diskDATA)) continue;  
  // / The following code separates the values returned into useful data.
  $diskDATA1 = explode('        ', $diskDATA);
  $diskCapacity = $diskDATA1[0];
  if (!is_array($networkDATA1)) continue;  
  $diskDATA2 = explode('   ', $diskDATA1);
  $diskUsed = $diskDATA2[0];
  $diskUnused = $diskDATA2[1];
  if (!is_array($networkDATA2)) continue;  
  $diskDATA3 = explode(' ', $diskDATA2);
  $diskUsage = $diskDATA3[0];
  $diskName = $diskDATA3[1]; }