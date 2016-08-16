<?php
session_start();

// SECRET: Variables ...
$coreFile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/core.php';
$langParserfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/langPar.php';
$onlineFile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/online.php';
$coreVarfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/coreVar.php';
$coreFuncfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/coreFunc.php';
$coreArrfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/coreArr.php';
$nodeCache = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/Cache/nodeCache.php';
$varCache = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/Cache/varCache.php';
$coreArrfile = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/coreArr.php';
$CallForHelpURL = '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/CallForHelp.php';
$wpfile = '/var/www/html/wp-load.php';
$date = date("F j, Y, g:i a");
$day = date("d");

require $CallForHelpURL;
require $coreFuncfile;
$user_ID = defineUser_ID();
$inputServerID = defineInputServerID();
if (file_exists($wpfile)) {
  require_once ($wpfile);
  global $current_user;
    get_currentuserinfo();
    $user_ID = get_current_user_ID(); 
if ($user_ID !== 1) {
  $display_name = get_currentuserinfo() ->$display_name; } }
if ($user_ID == 0) {
  $display_name = $_POST['display_name']; } 
if ($user_ID == 1) {
  include '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/adminINFO.php'; }
$inputServerID = defineInputServerID();
$input = defineUserInput();
$sesIDhash = hash('sha1', $display_name.$day);
$sesID = substr($sesIDhash, -7);
$CreateSesDir = forceCreateSesDir(); 
$DetectWordPress = DetectWordPress();
if ($user_ID == 1) {
  include '/var/www/html/HRProprietary/HRAI/adminINFO.php'; }
