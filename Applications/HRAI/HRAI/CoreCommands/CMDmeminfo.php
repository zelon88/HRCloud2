<?php

function getMemInfo() {
  $infoCachefile = '/var/www/html/infoCache.php';
  $memFree = shell_exec("more /proc/meminfo | grep MemFree"); 
  $memTotal = shell_exec("more /proc/meminfo | grep MemTotal"); 
    $infoCachefileO = fopen("$infoCachefile", "a+");
    $txt = ("$memTotal"."\r"."$memFree");
    $compCachefile = file_put_contents($infoCachefile, $txt.PHP_EOL , FILE_APPEND);
    return $txt; }

$GetMemInfo = getMemInfo();
    echo nl2br('Memory Information:'."\r");
    echo nl2br("$GetMemInfo \r");
    echo nl2br("--------------------------------\r");