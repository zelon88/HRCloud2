<?php
// / This file will retrieve information regarding the server's network performance and statistics.

// / This file was modified from http://www.codejungle.org/site/Realtime+bandwidth+meter+with+php+and+jquery.html
  // / on 12/26/2016 by zelon88 (https://github.com/zelon88) for use in the HRCloud2 ServMonitor App.

if (!isset($adapterNum)) {
  $adapterNum = "wlp12s0"; }

    $int = $adapterNum;
    session_start();
    
    $rx[] = @file_get_contents("/sys/class/net/$int/statistics/rx_bytes");
    $tx[] = @file_get_contents("/sys/class/net/$int/statistics/tx_bytes");
    sleep(1);
    $rx[] = @file_get_contents("/sys/class/net/$int/statistics/rx_bytes");
    $tx[] = @file_get_contents("/sys/class/net/$int/statistics/tx_bytes");
    
    $tbps = $tx[1] - $tx[0];
    $rbps = $rx[1] - $rx[0];

    $round_rx=round($rbps/1024, 2);
    $round_tx=round($tbps/1024, 2);

    $time=date("U")."000";
    $_SESSION['rx'][] = "[$time, $round_rx]";
    $_SESSION['tx'][] = "[$time, $round_tx]";
    $data['label'] = $int;
    $data['data'] = $_SESSION['rx'];

    # to make sure that the graph shows only the
    # last minute (saves some bandwitch to)
    if (count($_SESSION['rx'])>60) {
        $x = min(array_keys($_SESSION['rx']));
        unset($_SESSION['rx'][$x]); }
    
    # json_encode didnt work, if you found a workarround pls write me
    # echo json_encode($data, JSON_FORCE_OBJECT);
    echo '
    {"label":"'.$int.'","data":['.implode($_SESSION['rx'], ",").']}
    ';
    ?>