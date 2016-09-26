<!DOCTYPE html>
<html>
<head>
<title>HRCloud2 | Settings </title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
</head>
<body>
  <?php require 'Applications/HRAI/HRAIHelper.php';
$WPFile = '/var/www/html/wp-load.php';
if (!file_exists($WPFile)) {
  echo nl2br('ERROR HRC265, WordPress was not detected on the server.'."\n"); }
  else {
    require($WPFile); } 

$Date = date("m_d_y");
$Time = date("F j, Y, g:i a"); 
$UserID = get_current_user_id();
$user_ID = get_current_user_id();
$LogLoc = $InstLoc.'/DATA/'.$UserID.'/.AppLogs';
$LogInc = 0;
$SesLogDir = $LogLoc.'/'.$Date;
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
<div id='OptionsDiv' style="float: left; ">
  <br>
  <p name='button' class="button" id='button' style="float: left; ">&#x2699;</p>
  <br>
  <br>
  <p name='button' class="button" style="float: left; " id='button'>+</p>
</div>
<div id="HRAIDiv" style="float: right; ">
  <iframe src="Applications/HRAI/core.php" id="HRAIMini" name="HRAIMini" width="745" height="75" scrolling="yes" margin-top:-4px; margin-left:-4px; border:double; onload="document.getElementById('loading').style.display='none';">></iframe>
  <form action="Applications/HRAI/core.php#end" id="Corefile Input" method="post" target="HRAIMini">
  <input type="hidden" name="user_ID" value="<?php echo $user_ID;?>">
  <input type="hidden" name="sesID" value="<?php echo $sesID;?>">
  <input type="hidden" name="display_name" value="<?php echo $display_name;?>">
  <?php if (!isset($input)) {
    $input = ''; } ?>
  <input type="text" name="input" id="input"  value="<?php echo $input; ?>">
  <input id='submitHRAI' type="submit" value="Hello HRAI"></form></div>
<script type="text/javascript">
document.getElementById("HRAIMini").submit();
</script>

<div id="settingsContentsDiv" align='center'>
  <iframe src="appSettings.php" id="settingsContents" name="settingsContents" style="min-height:350px; max-height:950px;" width="800" scrolling="yes" margin-top:-4px; margin-left:-4px; border:double; onload="document.getElementById('loading').style.display='none';">></iframe>
</div>
<script>
;(function($){
  //Resizes the div to the remaining page size.
    $(document).ready(function(){
        $('#settingsContents').height( $(window).height() - 185 );
        $(window).resize(function(){
            $('#settingsContents').height( $(this).height() - 185 );
        });
    });
})(jQuery);
</script>
</div>
</body>
</html>