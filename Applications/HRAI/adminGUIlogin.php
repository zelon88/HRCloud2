<?php 


session_start();
include ('/var/www/html/HRProprietary/HRAI/adminINFO.php');

$coreFuncfile = '/var/www/html/HRProprietary/HRAI/coreFunc.php';
$adminGUI = '/var/www/html/HRProprietary/HRAI/adminGUI.php';
$wpfile = '/var/www/html/wp-load.php';
require $coreFuncfile;
require $wpfile;
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
  include '/var/www/html/HRProprietary/HRAI/adminINFO.php'; }
$sesIDhash = hash('sha256', $Salts.$user_ID.$day);
$sesID = substr($sesIDhash, -7);
$sesLogfile = ('/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/HRAI-'.$sesID.'.txt');
$CreateSesDir = forceCreateSesDir(); 
$DetectWordPress = DetectWordPress(); ?> 
<form action="/HRProprietary/HRAI/adminGUI.php" method="post">
	<p>Username: <input type="text" name="adunm" value=""></p>
	<p>Password: <input type="password" name="adpwd" value=""></p>
	<p><input type="submit" value="Start Core!"></p>
  <input type="hidden" name="user_ID" value="<?php echo $user_ID;?>">
  <input type="hidden" name="display_name" value="<?php echo $display_name;?>">
  <input type="hidden" name="sesID" value="<?php echo $sesID;?>">

</form>