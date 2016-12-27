<?php
// / This file was modified from http://www.codejungle.org/site/Realtime+bandwidth+meter+with+php+and+jquery.html
  // / on 12/26/2016 by zelon88 (https://github.com/zelon88) for use in the HRCloud2 ServMonitor App.

// / The following code will retrieve information regarding the server's network performance and statistics.
if (!isset($adapterNum) or !isset($_GET['$adapterNum'])) {
  $adapterNum = "eth0"; }
if (isset($_GET['adapterNum'])) {
  $adapterNum = $_GET['adapterNum']; }

    ?>