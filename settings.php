<!DOCTYPE html>
<html>
<head>
<title>HRCloud2 | Settings </title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
</head>
<body>
  <?php
// / The follwoing code checks if the configuration file.php file exists and 
// / terminates if it does not.
if (!file_exists('config.php')) {
  echo nl2br('ERROR!!! Settings19, Cannot process the HRCloud2 configuration file (config.php)!'."\n"); 
  die (); }
else {
  require('config.php'); }
// / HRAI Requires a helper to collect some information to complete HRCloud2 API calls (if HRAI is enabled).
if ($ShowHRAI == '1') {
  if (!file_exists('Applications/HRAI/HRAIHelper.php')) {
    echo nl2br('ERROR!!! Settings13, Cannot process the HRAI Helper file!'."\n"); }
  else {
    require('Applications/HRAI/HRAIHelper.php'); } }
// / Verify that WordPress is installed.
$WPFile = '/var/www/html/wp-load.php';
if (!file_exists($WPFile)) {
  echo nl2br('ERROR!!! Settings26, WordPress was not detected on the server!'."\n"); 
  die (); }
else {
    require($WPFile); } 

$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$UserID = get_current_user_id();
$LogLoc = $InstLoc.'/DATA/'.$UserID.'/.AppLogs';
$LogInc = 0;
$SesLogDir = $LogLoc.'/'.$Date;
$CloudTemp = $InstLoc.'/DATA/';
$CloudTempDir = $CloudTemp.$UserID;
$UserConfig = $CloudTemp.$UserID.'/'.'.AppLogs/.config.php';
if (!file_exists($UserConfig)) {
  echo nl2br('ERROR!!! Settings31, User Cache file was not detected on the server!'."\n"); 
  die (); }
else {
    require($UserConfig); } 
  ?>
<div id="nav" align="center">
    <div class="nav">
      <ul>
        <li class="Cloud"><a href="index1.php">Cloud</a></li>
        <li class="Settings"><a href="settings.php"> Settings</a></li>
        <li class="Logs"><a href="logs.php">Logs</a></li>
        <li class="Help"><a href="">Help</a></li>
      </ul>
    </div>
<script type="text/javascript">
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block'; }
</script>

<div id="centerdiv" align='center' style="margin: 0 auto; max-width:800px;">
<?php if ($ShowHRAI == '1') {  ?>
<div id="HRAIDiv" style="float: center; ">
  <iframe src="Applications/HRAI/core.php" id="HRAIMini" name="HRAIMini" width="810" height="75" scrolling="yes" margin-top:-4px; margin-left:-4px; border:double; onload="document.getElementById('loading').style.display='none';">></iframe>
  <form action="Applications/HRAI/core.php#end" id="Corefile Input" method="post" target="HRAIMini">
  <input type="hidden" name="user_ID" value="<?php echo $UserID;?>">
  <input type="hidden" name="sesID" value="<?php echo $sesID;?>">
  <input type="hidden" name="display_name" value="<?php echo $display_name;?>">
  <?php if (!isset($input)) {
    $input = ''; } ?>
  <div id='HRAIButtons1' name='HRAIButtons1' style="margin-left:15%;">
  <button id='button1' name='button1' class="button" style="float: left; display: block;" onclick="toggle_visibility('button2'); toggle_visibility('button1'); document.getElementById('HRAIMini').style.height = '100%';">+</button>
  <button id='button2' name='button2' class="button" style="float: left; display: none;" onclick="toggle_visibility('button2'); toggle_visibility('button1'); document.getElementById('HRAIMini').style.height = '75px';">-</button>
  </div>
  <div id='HRAIButtons2' name='HRAIButtons2' style="margin-right:15%;">
  <input type="text" name="input" id="input"  value="<?php echo $input; ?>">
  <input id='submitHRAI' type="submit" value="Hello HRAI"></form>
  </div>
</div>
<script type="text/javascript">
document.getElementById("HRAIMini").submit;
</script>
<?php } ?>
<div id="settingsContentsDiv" align='center'>
  <iframe src="appSettings.php" id="settingsContents" name="settingsContents" style="min-height:350px; max-height:950px;" width="800" scrolling="yes" margin-top:-4px; margin-left:-4px; border:double; onload="document.getElementById('loading').style.display='none';">></iframe>
</div>
<?php 
if ($ShowHRAI == '1') {
  $HRAIHeight = '185'; }
if ($ShowHRAI !== '1') {
  $HRAIHeight = '80'; } ?>
<script>
;(function($){
  //Resizes the div to the remaining page size.
    $(document).ready(function(){
        $('#settingsContents').height( $(window).height() - <?php echo $HRAIHeight; ?> );
        $(window).resize(function(){
            $('#settingsContents').height( $(this).height() - <?php echo $HRAIHeight; ?> );
        });
    });
})(jQuery);
</script>
</div>
</body>
</html>