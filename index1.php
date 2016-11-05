
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
  echo nl2br('</head><body>ERROR!!! Index19, Cannot process the HRCloud2 configuration file (config.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('config.php'); }

// / HRAI Requires a helper to collect some information to complete HRCloud2 API calls (if HRAI is enabled).
if ($ShowHRAI == '1') {
  if (!file_exists('Applications/HRAI/HRAIHelper.php')) {
    echo nl2br('</head><body>ERROR!!! Index13, Cannot process the HRAI Helper file!'."\n".'</body></html>'); }
  else {
    require('Applications/HRAI/HRAIHelper.php'); } }

// / The following code verifies that WordPress is installed.
$WPFile = '/var/www/html/wp-load.php';
if (!file_exists($WPFile)) {
  echo nl2br('</head><body>ERROR!!! Index26, WordPress was not detected on the server!'."\n".'</body></html>'); 
  die (); }
else {
    require($WPFile); } 

// / The following code sets variables for the session.
$UserIDRAW = get_current_user_id();
$UserID = hash('ripemd160', $UserIDRAW.$Salts);
$CloudDir = $CloudLoc.'/'.$UserID;
$CloudTemp = $InstLoc.'/DATA/';
$CloudTempDir = $CloudTemp.$UserID;
$UserConfig = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.config.php';
if (isset($_POST['UserDir'])) {
$UserDirPOST = ('/'.$_POST['UserDir'].'/'); }
if (!isset($_POST['UserDir'])) {
$UserDirPOST = ('/'); }
$CloudUsrDir = $CloudDir.$UserDirPOST; 
$CloudTmpDir = $CloudTempDir.$UserDirPOST; 
$AppDir = $InstLoc.'/Applications/';
$ContactsDir = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/Contacts/';
$NotesDir = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/Notes/';
$UserContacts = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/Contacts/contacts.php';
$UserNotes = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/Notes/notes.php';
$UserConfig = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/.config.php';
$defaultApps = array('.', '..', '', 
'jquery-3.1.0.min.js', 'index.html', 'HRAI', 'HRConvert2', 'HRStreamer', 'getID3-1.9.12', 'displaydirectorycontents_logs', 'displaydirectorycontents_logs1', 'displaydirectorycontents_72716');

// / The following code checks to see that the user is logged in.
if ($UserIDRAW == '') {
  echo nl2br('ERROR!!! HRC2Index100, You are not logged in!'."\n"); 
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }
if ($UserIDRAW == '0') {
  echo nl2br('ERROR!!! HRC2Index103, You are not logged in!'."\n");
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }
if (!isset($UserIDRAW)) {
  echo nl2br('ERROR!!! HRC2Index106, You are not logged in!'."\n");
  wp_redirect('/wp-login.php?redirect_to=' . $_SERVER["REQUEST_URI"]);
  die(); }

// / The following code verifies that a user config file exists and creates one if it does not.
if (!file_exists($UserConfig)) { 
  $CacheData = ('$ColorScheme = \'0\'; $VirusScan = \'0\'; $ShowHRAI = \'1\';');
  $MAKECacheFile = file_put_contents($UserConfig, $CacheData.PHP_EOL , FILE_APPEND); 
  $txt = ('Created a user config file on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($UserConfig)) { 
  $txt = ('ERROR!!! HRC2Index174, There was a problem creating the user config file on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ('ERROR!!! HRC2Index174, There was a problem creating the user config file on '.$Time.'!'); }
if (file_exists($UserConfig)) {
require ($UserConfig); }

// / The following code ensures the Contacts directory exists and creates it if it does not. Also creates Contacts directory.
if (!file_exists($UserContacts)) { 
  $ContactsData = ('<?php ?>');
  if (!file_exists($ContactsDir)) {
    mkdir($ContactsDir); }
  $MAKEContactsFile = file_put_contents($UserContacts, $ContactsData.PHP_EOL , FILE_APPEND); 
  $txt = ('Created a user contacts file on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($UserContacts)) { 
  $txt = ('ERROR!!! HRC2162, There was a problem creating the user contacts file on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ('ERROR!!! HRC2Index162, There was a problem creating the user contacts file on '.$Time.'!'); }
if (file_exists($UserContacts)) {
require ($UserContacts); }

// / The following code ensures the Notes directory exists and creates it if it does not.
if (!file_exists($NotesDir)) {
  mkdir($NotesDir); }
if (!file_exists($NotesDir)) { 
  $txt = ('ERROR!!! HRC2Index186, There was a problem creating the user notes directory on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ('ERROR!!! HRC2Index186, There was a problem creating the user notes directory on '.$Time.'!'); } 

// / The following code returns the newest file or folder for each Cloud module. 
$files = scandir($CloudDir, SCANDIR_SORT_DESCENDING);
$newest_file = $files[0];
$apps = scandir($AppDir, SCANDIR_SORT_DESCENDING);
$newest_app = $apps[0];
$contacts = scandir($ContactsDir, SCANDIR_SORT_DESCENDING);
$newest_contact = $contacts[0];
$notes = scandir($NotesDir, SCANDIR_SORT_DESCENDING);
$newest_note = $notes[0];
if ($newest_file == '.' or $newest_file == '..') {
  $newest_file = 'No files to show!'; }
if ($newest_app == '.' or $newest_app == '..' or in_array($newest_app, $defaultApps)) {
  $newest_app = 'No apps to show!'; }
if ($newest_contact == '.' or $newest_contact == '..') {
  $newest_contact = 'No contacts to show!'; }
if ($newest_note == '.' or $newest_note == '..') {
  $newest_note = 'No notes to show!'; }

// / The following code determines the color scheme that the user has selected. 
// / May require a refresh to take effect.
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
        <li class="Drive"><a href="index2.php">Drive</a></li>
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
<div id="cloudContentsDiv" align='center' style="width:404px; padding-top: 5px;">
<div id="filesOverview" name="filesOverview" style="height:160px; float:left; width:195px; border:inset; margin-bottom:2px;">
<div align="left" style="margin-left: 10px;"><p><h3>Files</h3></p></div>
  <div id="filesOverview1" name="fileOverview1">
    <form action="index2.php">
    <p><input type="submit" value="Go To Drive"></input></form></p>
    <p>Recent Files: <a href="index2.php"><i><?php echo $newest_file; ?></i></a></p>
  </div>
</div>
<div id="appsOverview" name="appsOverview" style="height:160px; float:right; width:195px; border:inset; margin-bottom:2px;">
<div align="left" style="margin-left: 10px;"><p><h3>Apps</h3></p></div>
  <div id="appsOverview1" name="appsOverview1">
    <form action="appLauncher.php">
    <p><input type="submit" value="Go To Apps"></input></form></p>
    <p>Recent Apps: <a href="index2.php"><i><?php echo $newest_app; ?></i></a></p>
  </div>
</div>
<div align="center" id="notesOverview" name="notesOverview" style="width:400px; border:inset; margin-top:170px; margin-bottom:2px;">
<div align="left" style="margin-left: 20px;"><p><h3>Notes</h3></p></div>  
  <div id="notesOverview1" name="notesOverview1">
    <p><input type="submit" value="Go To Notes"></input></form></p>
    <p>Recent Notes: <a href=""><i></i><?php echo $newest_note; ?></a></p>
  </div>
</div>
<div align="center" id="overview" name="overview" style="width:400px; border:inset;">
<div align="left" style="margin-left: 20px;"><p><h3>Contacts</h3></p></div>
  <div id="contactsOverview" name="contactsOverview">
  <p><p><input type="submit" value="Go To Contacts"></input></form></p>  
  <p>Recent Contacts: <a href=""><i><?php echo $newest_contact; ?></i></a></p>
  </div>
</div>
</div>
</body>
</html>