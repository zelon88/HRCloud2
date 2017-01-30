<?php

// / This file will retrieve information regarding the server's network performance and statistics.

$networkCacheFile = 'Cache/networkCACHE.php';
$networkCacheFile1 = 'Cache/networkCACHE1.php';
$integerArr = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
$letterArr = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

// / The following code sets the POST and GET variables for the session, if there were any.
if (!isset($adapterNum) or !isset($_GET['adapterNum']) or !isset($_POST['adapterNum'])) {
  $adapterNum = "eth0"; }
if (isset($_GET['adapterNum'])) {
  $adapterNum = $_GET['adapterNum']; }
if (isset($_POST['adapterNum'])) {
  $adapterNum = $_POST['adapterNum']; }

// / The following code creates a cache file, or returns an error if one cannot be created
if (file_exists($networkCacheFile)) {
  @chmod('Cache/');
  @chmod($networkCacheFile, 0755);
  @unlink($networkCacheFile); }
if (file_exists($networkCacheFile1)) {
  @chmod('Cache/');
  @chmod($networkCacheFile1, 0755);
  @unlink($networkCacheFile1); }

// / The following code retrievs statistics related to the server's network devices.
exec('ifconfig', $networkDATA);
$MAKENetworkCacheFile = file_put_contents($networkCacheFile, $networkDATA);
$CacheDATA = file_get_contents($networkCacheFile);
$networkDeviceData = $CacheDATA;

// / The following code retrievs statistics related to the server's network connections.
exec('netstat -s', $networkDATA1);
$MAKENetworkCacheFile1 = file_put_contents($networkCacheFile1, $networkDATA1);
$CacheDATA1 = file_get_contents($networkCacheFile1);
$networkConnectionData = $CacheDATA1;

?>