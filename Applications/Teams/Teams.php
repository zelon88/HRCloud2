<!DOCTYPE HTML>
<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: Teams
App Version: 0.5 (3-24-2017 12:30)
App License: GPLv3
App Author: zelon88
App Description: A simple HRCloud2 App for communicating with team-mates.
App Integration: 1 (True)
HRCLOUD2-PLUGIN-END
//*/

?>
<script src="Scripts/sorttable.js"></script>
<script type="text/javascript">
// / Javascript to clear the newNote text input field onclick.
    function Clear() {    
      document.getElementById("messangeInput").value= ""; }
</script>
<?php
// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2TeamsApp27, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2TeamsApp35, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

// / The following code sets the variables for the session.
$SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
$TeamsDir = $CloudLoc.'/Apps/Teams/';
$UsersDir = $CloudLoc.'/Apps/Teams/Users/';
$FilesDir = $CloudLoc.'/Apps/Teams/Files/';
$UserRootDir = $CloudLoc.'/Apps/Teams/Users/'.$UserID.'/';
$UserCacheFile = $CloudLoc.'/Apps/Teams/Users/'.$UserID.'/'.$UserID.'.php';
$UserFilesDir = $CloudLoc.'/Apps/Teams/Users/'.$UserID.'/Files/';
$teamArray = array();
$userArray = array();
$fileArray = array();

// / The following code represents the Teams API handler, sanitizing and consolidating inputs.
if (isset($_GET['newTeamGUI'])) {
  $newTeamGUI = 1; }
if (isset($_POST['newTeamGUI'])) {
  $newTeamGUI = 1; }

// / The following code creates the required CloudLoc directories if they do not exist.
if (!file_exists($CloudLoc.'/Apps')) {
  mkdir($CloudLoc.'/Apps');
  $txt = ('Op-Act: Created the directory "'.$CloudLoc.'/Apps'.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($TeamsDir)) {
  mkdir($TeamsDir);
  $txt = ('Op-Act: Created the directory "'.$TeamsDir.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } 
if (!file_exists($UsersDir)) {
  mkdir($UsersDir);
  $txt = ('Op-Act: Created the directory "'.$UsersDir.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($FilesDir)) {
  mkdir($FilesDir);
  $txt = ('Op-Act: Created the directory "'.$FilesDir.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($UserRootDir)) {
  mkdir($UserRootDir);
  $txt = ('Op-Act: Created the directory "'.$UserRootDir.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($UserFilesDir)) {
  mkdir($UserFilesDir);
  $txt = ('Op-Act: Created the directory "'.$UserFilesDir.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }

// / The following code creates the required user cache files if they do not exist.
if (!file_exists($UserCacheFile)) {
  $cacheDATA = '<?php $USER_ID = '.$UserID.';'.' $USER_NAME = \'\'; $USER_TEAMS = array(); $USER_PERMISSIONS = 0; $INTERNATIONAL_GREETINGS = 1; UPDATE_INTERVAL = 2000; ?>';
  $MAKECacheFile = file_put_contents($UserCacheFile, $cacheDATA.PHP_EOL , FILE_APPEND);
  $txt = ('Op-Act: Created the directory "'.$CloudLoc.'/Apps'.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($UserCacheFile)) {
  $txt = ('ERROR!!! HRC2TeamsApp88, Unable to create the directory "'.$CloudLoc.'/Apps'.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ($txt); }

// / Scan the CloudLoc/Apps/Teams directory for the latest files.
$teamsList = scandir($TeamsDir, SCANDIR_SORT_DESCENDING);
$usersList = scandir($UsersDir, SCANDIR_SORT_DESCENDING);
$filesList = scandir($FilesDir, SCANDIR_SORT_DESCENDING);

// / The following code verifies the User files contained in the CloudLoc are valid.
foreach ($usersList as $usersIDTestRAW) {
  if (is_dir($UsersDir.$userIDTestRAW && $UserID == $userIDTestRAW)) {
    $userFileTESTER = $UsersDir.$userIDTestRAW.'/'.$userIDTestRAW.'.php';
    if (file_exists($userFileTESTER)) { 
      include($userFileTESTER);
      $userIDTestTESTER = hash('sha256', $USER_ID.$Salts);
      if ($userIDTestTESTER == $userFileTESTER && $userFileTESTER == $UserCacheFile) {
        $userArray = array_push($userArray, $USER_ID);
        $currentUserID = $USER_ID; 
        $currentUserName = $USER_NAME; 
        $currentUserTeams = $USER_TEAMS; 
        $currentUserPermissions = $USER_PERMISSIONS; 
        $settingsInternationalGreetings = $INTERNATIONAL_GREETINGS; 
        $settingsUpdateInterval = $UPDATE_INTERVAL; }
      if ($userIDTestTESTER !== $UserCacheFile) {
        $txt = ('Warning!!! HRC2TeamsApp96, There was a problem validating User "'.$userCacheFile.'"" on '.$Time.'!'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
        continue; }
      if ($userIDTestTESTER !== $userFileTESTER) {
        $txt = ('Warning!!! HRC2TeamsApp51, There was a problem validating User "'.$userFileTESTER.'"" on '.$Time.'!'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
        continue; } }
    if (!file_exists($userFileTESTER)) { 
      $txt = ('Warning!!! HRC2TeamsApp49, There was a problem validating User "'.$userFileTESTER.'"" on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
      continue; } } }

// / The following code verifies the Teams files contained in the CloudLoc are valid.
foreach ($teamsList as $teamsNameRAW) {
  if (is_dir($TeamsDir.$teamNameRAW)) {
    $teamFileTESTER = $TeamsDir.$teamNameRAW.'/'.$teamNameRAW.'.php';
    if (file_exists($teamFileTESTER)) { 
      include($teamFileTESTER);
      $teamNameTESTER = hash('sha256', $TEAM_NAME.$Salts);
      if ($teamNameTESTER == $teamFileTESTER) {
        $teamArray = array_push($teamArray, $TEAM_NAME); }
      if ($teamNameTESTER !== $teamFileTESTER) {
        $txt = ('Warning!!! HRC2TeamsApp51, There was a problem validating Team "'.$teamFileTESTER.'"" on '.$Time.'!'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
        continue; } }
    if (!file_exists($teamFileTESTER)) { 
      $txt = ('Warning!!! HRC2TeamsApp49, There was a problem validating Team "'.$teamFileTESTER.'"" on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
      continue; } } }

// / The following code sets more variables for the session now that the cache files have loaded.
if ($currentUserTeams == '') {
  $teamsGreetings = array('Hi There!', 'Hello!');
  $teamsGreetingsInternational = array('Hi There!', 'Hello!', 'Bonjour!', 'Hola!', 'Namaste!', 'Salutations!', 'Konnichiwa!', 'Bienvenidos!', 'Guten Tag!');
  if ($settingsInternationalGreetings = '1' or $settingsInternationalGreetings == 1) $teamsGreetings = $teamsGreetingsInternational;
  $greetingKey = array_rand($teamsGreetings);
  $emptyTeamsECHO = 'It looks like you aren\'t a part of any Teams yet! Let\'s fix that...'."\n\n".'Check out one of the groups below,
    or <a href=\'/?newTeamGUI=1\'>Create A New Team.</a>'; }

// / The following code represents the graphical user-interface (GUI).
?>
<div id='TeamsAPP' name='TeamsAPP' align='center'><h3>Teams</h3><hr />
<?php
if (!isset($newTeamGUI)) {
 }
?>
<h2><?php echo $teamsGreetings[$greetingKey]; ?></h2>
<br />
<p><?php echo nl2br($emptyTeamsECHO); ?><p>

