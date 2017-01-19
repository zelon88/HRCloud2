<!DOCTYPE html>
<html>
<head>
<title>HRCloud2 | Home </title>
<?php 

// / Before we begin we will sanitize API inputs.
if (isset($_GET['UserDirPOST'])) {
  $_GET['UserDirPOST'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['UserDirPOST']);
  $_POST['UserDirPOST'] = $_GET['UserDirPOST'];
  $_POST['UserDir'] = $_GET['UserDirPOST']; }

if (isset($_GET['UserDir'])) {
  $_GET['UserDirPOST'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['UserDir']);
  $_POST['UserDirPOST'] = $_GET['UserDir'];
  $_POST['UserDir'] = $_GET['UserDir']; }

set_time_limit(0);

// / The follwoing code checks if the configuration file.php file exists and 
// / terminates if it does not.
if (!file_exists('config.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2Index3-19, Cannot process the HRCloud2 configuration file (config.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('config.php'); }

// / HRAI Requires a helper to collect some information to complete HRCloud2 API calls (if HRAI is enabled).
if ($ShowHRAI == '1') {
  if (!file_exists('Applications/HRAI/HRAIHelper.php')) {
    echo nl2br('</head><body>ERROR!!! HRC2Index13, Cannot process the HRAI Helper file!'."\n".'</body></html>'); }
  else {
    require('Applications/HRAI/HRAIHelper.php'); } }

// / Verify that WordPress is installed.
$WPFile = '/var/www/html/wp-load.php';
if (!file_exists($WPFile) or if ($WordPressIntegration == '0')) {
  $WPFile = $InstLoc.'/Applications/wordpress_11717/wp-load.php'; }
if (!file_exists($WPFile)) {
  echo nl2br('</head>ERROR!!! HRC2Index3-20, WordPress was not detected on the server.'."\n"); }
  else {
    require($WPFile); } 

// / The following code sets the variables for the session.
$UserIDRAW = get_current_user_id();
$UserID = hash('ripemd160', $UserIDRAW.$Salts);
$CloudDir = $CloudLoc.'/'.$UserID;
$CloudTemp = $InstLoc.'/DATA/';
$CloudTempDir = $CloudTemp.$UserID;
$UserConfig = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.config.php';
$CreateUserFiles = 'createUserFiles.php';
if (isset($_POST['UserDir'])) {
$UserDirPOST = ('/'.$_POST['UserDir'].'/'); }
if (!isset($_POST['UserDir'])) {
$UserDirPOST = ('/'); }
$CloudUsrDir = $CloudDir.$UserDirPOST; 
$CloudTmpDir = $CloudTempDir.$UserDirPOST; 
$UserContacts = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.contacts.php';
$UserNotes = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.notes.php';
$UserConfig = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.config.php';

if (!file_exists($UserConfig)) { 
  $CacheData = ('$ColorScheme = \'0\'; $VirusScan = \'0\'; $ShowHRAI = \'1\';');
  $MAKECacheFile = file_put_contents($UserConfig, $CacheData.PHP_EOL, FILE_APPEND); 
  $txt = ('Created a user config file on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
if (!file_exists($UserConfig)) { 
  $txt = ('ERROR!!! HRC2Index3-151, There was a problem creating the user config file on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  die ('ERROR!!! HRC2Index3-151, There was a problem creating the user config file on '.$Time.'!'); }
if (file_exists($UserConfig)) {
require ($UserConfig); }

if ($ColorScheme == '0' or $ColorScheme == '' or !isset($ColorScheme)) {
  $ColorScheme = '1'; }
if ($ColorScheme == '1') {
  echo ('<link rel="stylesheet" type="text/css" href="style.css">'); }
if ($ColorScheme == '2') {
  echo ('<link rel="stylesheet" type="text/css" href="styleRED.css">'); }
if ($ColorScheme == '3') {
  echo ('<link rel="stylesheet" type="text/css" href="styleGREEN.css">'); }
if ($ColorScheme == '4') {
  echo ('<link rel="stylesheet" type="text/css" href="styleGREY.css">'); }
if ($ColorScheme == '5') {
  echo ('<link rel="stylesheet" type="text/css" href="styleBLACK.css">'); }

?>
<script type="text/javascript" src="/HRProprietary/HRCloud2/Applications/jquery-3.1.0.min.js"></script>
<script type="text/javascript">
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block'; }
    function Clear() {    
      document.getElementById("input").value= ""; }
</script>
</head>
<body>
<div id="nav" align="center">
    <div class="nav">
      <ul>
        <li class="Cloud"><a href="index1.php">Cloud</a></li>
        <li class="Settings"><a href="settings.php"> Settings</a></li>
        <li class="Logs"><a href="logs.php">Logs</a></li>
        <li class="Help"><a href="help.php">Help</a></li>
      </ul>
    </div>

<div id="centerdiv" align='center' style="margin: 0 auto; max-width:815px;">
<?php if ($ShowHRAI == '1') {  ?>
<div id="HRAIDiv" style="float: center; ">
  <iframe src="Applications/HRAI/core.php" id="HRAIMini" name="HRAIMini" width="810" height="75" scrolling="yes" margin-top:-4px; margin-left:-4px; border:double; onload="document.getElementById('loading').style.display='none';"></iframe>
  <div id='HRAIButtons1' name='HRAIButtons1' style="margin-left:15%;">
  <button id='button0' name='button0' class="button" style="float: left; display: block;" onclick="toggle_visibility('button0'); toggle_visibility('button1'); toggle_visibility('button2'); document.getElementById('HRAIMini').style.height = '0px';" >-</button>
  <button id='button1' name='button1' class="button" style="float: left; display: none;" onclick="toggle_visibility('button0'); toggle_visibility('button1'); toggle_visibility('button2'); document.getElementById('HRAIMini').style.height = '75px';" >+</button>
  <button id='button2' name='button2' class="button" style="float: left; display: block;" onclick="toggle_visibility('button0'); toggle_visibility('button2'); toggle_visibility('button3'); document.getElementById('HRAIMini').style.height = '100%';">+</button>
  <button id='button3' name='button3' class="button" style="float: left; display: none;" onclick="toggle_visibility('button0'); toggle_visibility('button2'); toggle_visibility('button3'); document.getElementById('HRAIMini').style.height = '75px';">-</button>
  <button id='button4' name='button4' class="button" style="float: left; display: block;" onclick="window.open('HRAIMiniGui.php','HRAI','resizable,height=400,width=650'); return false;">++</button>
  <form action="index1.php"><button id="button" name="button5" class="button" style="float:left;" href="#" onclick="toggle_visibility('loadingCommandDiv');">&#x21BA</button></form>
  </div>
  <form action="Applications/HRAI/core.php#end" id="Corefile Input" method="post" target="HRAIMini">
  <input type="hidden" name="user_ID" value="<?php echo $UserID;?>">
  <input type="hidden" name="sesID" value="<?php echo $sesID;?>">
  <input type="hidden" name="display_name" value="<?php echo $display_name;?>">
  <?php if (!isset($input)) {
    $input = ''; } ?>
  <div id='HRAIButtons2' name='HRAIButtons2' style="margin-right:15%;">
  <input type="text" name="input" id="input"  value="<?php echo $input; ?>" onclick="Clear();">
  <input id='submitHRAI' type="submit" value="Hello HRAI"></form>
  </div>
</div>
<script type="text/javascript">
document.getElementById("HRAIMini").submit;
</script>
<?php } ?>
<div id="cloudContentsDiv" align='center'>
  <iframe src="cloudCore.php" id="cloudContents" name="cloudContents" style="min-height:350px; max-height:950px;" width="815" scrolling="yes" margin-top:-4px; margin-left:-4px; border:double; onload="document.getElementById('loading').style.display='none';">></iframe>
</div>
<?php 
if ($ShowHRAI == '1') {
  $HRAIHeight = '185'; }
if ($ShowHRAI !== '1') {
  $HRAIHeight = '80'; } ?>
<script>
;(function($){
    $(document).ready(function(){
        $('#cloudContents').height( $(window).height() - <?php echo $HRAIHeight; ?> );
        $(window).resize(function(){
            $('#cloudContents').height( $(this).height() - <?php echo $HRAIHeight; ?> );
        });
    });
})(jQuery);
</script>
</div>
</body>
</html>