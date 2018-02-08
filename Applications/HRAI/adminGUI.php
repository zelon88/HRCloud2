<!DOCTYPE html>
<html>
<head>
<title>HRAI Admin Panel</title>
<link rel="stylesheet" type="text/css" href="http://localhost/HRProprietary/HRAI/HRAI.css">
</head></html>
<?php
session_start();
include '/var/www/html/HRProprietary/HRCloud2/Applications/HRAI/adminINFO.php';

// SECRET: The very first thing we're going to do is verify the credentials being used to log in.
// SECRET: 
if (isset($_POST['adunm'])) {
  $adunm = $_POST['adunm'];
  if ($adunm !== $adunm1 ) {
    die ('The supplied Admin Username was incorrect.'); } }
elseif (!isset($_POST['adunm'])){   
  die ('The supplied Admin Username was blank.'); }

if (isset($_POST['adpwd'])) {
  $adpwd = $_POST['adpwd'];
  if ($adpwd !== $adpwd1 ) {
    die ('The supplied Admin Password was incorrect.'); } }
elseif (!isset($_POST['adpwd'])) {
  die ('The supplied Admin Password was incorrect.'); }

// SECRET: Variables ...
$coreFile = '/var/www/html/HRProprietary/HRAI/core.php';
$langParserfile = '/var/www/html/HRProprietary/HRAI/langPar.php';
$onlineFile = '/var/www/html/HRProprietary/HRAI/online.php';
$coreVarfile = '/var/www/html/HRProprietary/HRAI/coreVar.php';
$coreFuncfile = '/var/www/html/HRProprietary/HRAI/coreFunc.php';
$coreArrfile = '/var/www/html/HRProprietary/HRAI/coreArr.php';
$nodeCache = '/var/www/html/HRProprietary/HRAI/Cache/nodeCache.php';
$varCache = '/var/www/html/HRProprietary/HRAI/Cache/varCache.php';
$coreArrfile = '/var/www/html/HRProprietary/HRAI/coreArr.php';
$CallForHelp = '/var/www/html/HRProprietary/HRAI/CallForHelp.php';
$wpfile = '/var/www/html/wp-load.php';
$date = date("F j, Y, g:i a");
$day = date("d");
$dataScrub = '<!DOCTYPE html>
<html>
<head>
<title>HRAI Core</title>
</head></html>';

require $CallForHelpURL;
require $coreFuncfile;
$user_ID = defineUser_ID();
$inputServerID = defineInputServerID();
$detectWordPress = detectWordPress();
$verifyUser = verifyUser();
$loadAdminInfo = loadAdminInfo();
$input = defineUserInput();
$sesIDhash = hash('sha256', $Salts.$Salts.$user_ID.$day);
$sesID = substr($sesIDhash, -7);
$CreateSesDir = forceCreateSesDir(); 
if ($user_ID == 1) {
  include '/var/www/html/HRProprietary/HRAI/adminINFO.php'; }

  ?>
    <div class="nav">
      <ul>
        <li class="home"><a href="#">Overview</a></li>
        <li class="tutorials"><a href="#">Server</a></li>
        <li class="about"><a href="#">Network</a></li>
        <li class="news"><a href="#">Settings</a></li>
        <li class="contact"><a href="#">Logs</a></li>
      </ul>
    </div>


<div align='center' ><?php echo '<h3>Welcome back, '.$nickname.'!';?></h3></div>
<div align='center' ><h5><hr><?php echo 'ServerID: '.$serverID.'  |  Username: '.$display_name;?></h5></div>


<div style="float: left; ">
  <div style="float: center"><h4>Corefile Output:</h4></div>
  <iframe src="/HRProprietary/HRAI/core.php" name="core_iframer" width="300" height="350" scrolling="yes" margin-top:-4px; margin-left:-4px; border:double;></iframe>
  <form action="http://localhost/HRProprietary/HRAI/core.php#end" id="Corefile Input" method="post" target="core_iframer">
  <input type="hidden" name="user_ID" value="<?php echo $user_ID;?>">
  <input type="hidden" name="sesID" value="<?php echo $sesID;?>">
  <input type="hidden" name="display_name" value="<?php echo $display_name;?>">
  <input type="text" name="input" id="input" value="<?php echo $input; ?>">
  <input type="submit" value="Submit to Core!"></form></div>
<script type="text/javascript">
document.getElementById("Corefile Input").submit();
</script>


<div style="float: left; ">
  <div style="float: center"><h4>LanguageParser Output:</h4></div>
  <iframe src="/HRProprietary/HRAI/langPar.php" name="langpar_iframer" width="300" height="350" margin-top:-4px; margin-left:-4px; border:double;></iframe>
  <form action="http://localhost/HRProprietary/HRAI/langPar.php#end" id="LangPar Input" method="post" target="langpar_iframer">
  <input type="hidden" name="user_ID" value="<?php echo $user_ID;?>">
  <input type="hidden" name="sesID" value="<?php echo $sesID;?>">
  <input type="hidden" name="display_name" value="<?php echo $display_name;?>">
  <input type="text" name="input" value="">
  <input type="submit" value="Submit to LangPar!"></form></div> </div>
<script type="text/javascript">
document.getElementById("LangPar Input").submit();
</script>
<?php
$serverIDCFH = hash('sha256', $serverID.$sesID.$day); 
?>
<div style="float: right; ">
  <div style="float: center"><h4>CallForHelp Output:</h4></div>
  <iframe src="/HRProprietary/HRAI/ForceCallForHelp.php" name="core_iframer" width="300" height="350" scrolling="yes" margin-top:-4px; margin-left:-4px; border:double;></iframe>
  <form action="http://localhost/HRProprietary/HRAI/ForceCallForHelp.php#end" id="Corefile Input" method="post" target="core_iframer">
  <input type="hidden" name="user_ID" value="<?php echo $user_ID;?>">
  <input type="hidden" name="sesID" value="<?php echo $sesID;?>">
  <input type="hidden" name="serverIDCFH" value="<?php echo $serverIDCFH;?>">
  <input type="text" name="input" id="input" value="<?php echo $input; ?>">
  <input type="submit" value="Submit to Core!"></form></div>
<script type="text/javascript">
document.getElementById("Corefile Input").submit();
</script>


</html>


