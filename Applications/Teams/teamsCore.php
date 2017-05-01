<?php
// / -----------------------------------------------------------------------------------
/*
This file represents the core logic functions for the HRCloud2 Teams App.

This file outputs (almost) all of it's activity to the logged-in HRCloud2 users standard 
log directories. This script will very minimal output during normal operation. 
The only output a client should ever see from this file are success or error messages.
*/
// / -----------------------------------------------------------------------------------

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

// / -----------------------------------------------------------------------------------
// / The following code sets the variables for the session.
$TeamsAppVersion = 'v0.7.5';
$SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
$TeamsDir = str_replace('//', '/', $CloudLoc.'/Apps/Teams');
$defaultDirs = array('index.html', '_CACHE', '_FILES', '_USERS', '_TEAMS');
$ResourcesDir = $TeamsDir.'/_RESOURCES';
$ScriptsDir = $TeamsDir.'/_SCRIPTS';
$CacheDir = $TeamsDir.'/_CACHE';
$TeamsCoreCacheFile = $CacheDir.'/_coreCACHE.php';
$safeTeamFile = $ResourcesDir.'/_TEAMS/SAFETeam.php';
$UsersDir = str_replace('//', '/', $CloudLoc.'/Apps/Teams/_USERS');
$UserRootDir = str_replace('//', '/', $CloudLoc.'/Apps/Teams/_USERS/'.$UserID.'');
$UserFilesDir = str_replace('//', '/', $CloudLoc.'/Apps/Teams/_USERS/'.$UserID.'/FILES');
$UserCacheFile = str_replace('//', '/', $CloudLoc.'/Apps/Teams/_USERS/'.$UserID.'/'.$UserID.'.php');
$myTeamsList = array();
$teamArray = array();
$userArray = array();
$fileArray = array();
$allowPosting = 'false';
$serverKEY = hash('sha256', $URL.$Salts.$Date);
$adminKEY = hash('sha256', $UserID.$Salts.$Date);
$teamDir = '';
$teamFile = '';
$newTeamFileDATA = '';
$cleanCacheDATA = ('<?php $USER_CACHE_VERSION = \''.$TeamsAppVersion.'\' $USER_ID = '.$UserID.';'.' $USER_NAME = \'\'; $USER_TITLE = \'\'; 
  $USER_TOKEN = \'\'; $USER_PHOTO_FILENAME = \'\'; $USER_ALIAS = \'\'; $USER_TEAMS_OWNED = \'\'; $USER_TEAMS = array(); 
  $USER_PERMISSIONS = 0; $INTERNATIONAL_GREETINGS = 1; UPDATE_INTERVAL = 2000; $USER_STATUS = \'\';
  $USER_EMAIL_1 = \'\'; $USER_EMAIL_2 = \'\'; $USER_EMAIL_3 = \'\'; $USER_PHONE_1 = \'\'; $USER_PHONE_2 = \'\'; $USER_PHONE_3 = \'\'; 
  $ACCOUNT_NOTES_USER = \'\'; $ACCOUNT_NOTES_ADMIN = \'\'; ?>');
$requiredTeamVars = array('$TEAM_CACHE_VERSION', '$TEAM_NAME', '$TEAM_OWNER', '$TEAM_CREATED_BY', '$TEAM_ALIAS', '$TEAM_USERS', 
  '$TEAM_ADMINS', '$TEAM_VISIBILITY', '$TEAM_ALIAS', '$BANNED_USERS');
$requiredUserVars = array('$USER_CACHE_VERSION', '$USER_ID', 'USER_NAME', '$USER_TITLE', '$USER_TOKEN', '$USER_PHOTO_FILENAME', '$USER_ALIAS', 
  '$USER_TEAMS_OWNED', '$USER_TEAMS', '$USER_PERMISSIONS', '$INTERNATIONAL_GREETINGS', 'UPDATE_INTERVAL', '$USER_STATUS',
  '$USER_EMAIL_1', '$USER_EMAIL_2', '$USER_EMAIL_3', '$USER_PHONE_1', '$USER_PHONE_2', '$USER_PHONE_3', '$ACCOUNT_NOTES_USER', '$ACCOUNT_NOTES_ADMIN');
// / -----------------------------------------------------------------------------------

// / ----------------------------------------------------------------------------------- 
// / The following code sets the default variables for the GUI. These values may be modified later in the script.
$teamsGreetings = array('Hi There!', 'Hello!');
$teamsGreetingsInternational = array('Hi There!', 'Hello!', 'Bonjour!', 'Hola!', 'Namaste!', 'Salutations!', 'Konnichiwa!', 'Bienvenidos!', 'Guten Tag!');
if ($settingsInternationalGreetings = '1' or $settingsInternationalGreetings == 1) {
  $teamsGreetings = $teamsGreetingsInternational; }
$greetingKey = array_rand($teamsGreetings);
$newTeamNameEcho = 'New Team Name...';
$newTeamDescriptionEcho = 'New Team Description...';
$teamsHeaderDivNeeded = 'true';
$teamsGreetingDivNeeded = 'true';
$newTeamDivNeeded = 'true';
$chatDivNeeded = 'false';
// / ----------------------------------------------------------------------------------- 

// / ----------------------------------------------------------------------------------- 
// / The following code sets the color scheme for the session.
if ($ColorScheme == '1') {
  $color = 'blue'; }
if ($ColorScheme == '2') {
  $color = 'red'; }
if ($ColorScheme == '3') {
  $color = 'green'; }
if ($ColorScheme == '4') {
  $color = 'grey'; }
if ($ColorScheme == '5') {
  $color = 'black'; }
if ($ColorScheme == '6') {
  $color = ''; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code represents the Teams API handler, sanitizing and consolidating inputs.
  // / -New Team inputs.
if (!isset($_POST['newTeam'])) {
  $newTeamName = ''; }
if (isset($_GET['newTeam'])) {
  $_POST['newTeam'] = $_GET['newTeam']; }
if (isset($_POST['newTeam'])) {
  $_POST['newTeam'] = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['newTeam']);
  $newTeamName = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['newTeam']); 
  $newTeamID = hash('sha256', $newTeamName.$SALTS);
  $newTeamDir = str_replace('//', '/', $TeamsDir.'/'.$newTeamID);
  $newTeamFile = str_replace('//', '/', $newTeamDir.'/'.$newTeamID.'.php');
  $newTeamDataDir = str_replace('//', '/', $newTeamDir.'/_DATA'); }
  // / -New SubTeam inputs.
if (!isset($_POST['newSubTeam'])) {
  $newTeamName = ''; }
if (isset($_GET['newSubTeam']) && isset($_GET['joinTeam'])) {
  $_POST['newSubTeam'] = $_GET['joinSubTeam']; 
  $_POST['baseTeamID'] = $_GET['joinTeam']; }
if (isset($_POST['newSubTeam'])) {
  $_POST['newSubTeam'] = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['newSubTeam']);
  $newSubTeamName = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['newSubTeam']); 
  $baseTeamDir = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['joinTeam']);
  $newSubTeamID = hash('sha256', $newSubTeamName.$SALTS);
  $newSubTeamDir = str_replace('//', '/', $TeamsDir.'/'.$baseTeamID);
  $newSubTeamFile = str_replace('//', '/', $baseTeamDir.'/'.$newSubTeamID.'.php');
  $newSubTeamDataDir = str_replace('//', '/', $baseTeamDir.'/_DATA'); }
  // / -Edit Team inputs.
if (isset($_GET['editTeam'])) {
  $_POST['editTeam'] = $_GET['editTeam']; }
if (!isset($_POST['editTeam'])) {
  $teamToEdit = ''; }
if (isset($_POST['editTeam'])) {
  $_POST['editTeam'] = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['editTeam']); 
  $teamToEdit = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['editTeam']); }
if (isset($_POST['editTeamTitle'])) {
  $newTeamTitle = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['editTeam']); }
if (isset($_POST['editTeamDescription'])) {
  $newTeamDescription = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['editTeamDescription']); }
if (isset($_POST['editTeamAdmins'])) {
  $newTeamAdmins = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['editTeamAdmins']); }
if (isset($_POST['editTeamOwner'])) {
  $newTeamOwner = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['editTeamOwner']); }
if (isset($_POST['editTeamPrivacy'])) {  
  $newTeamPrivacy = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['editTeamPrivacy']); }
if (isset($_POST['editTeamPermissions'])) {
  $newTeamPermissions = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['editTeamPermissions']); }
  // / -Delete Team inputs.
if (isset($_GET['deleteTeam'])) { 
  $_POST['deleteTeam'] = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_GET['deleteTeam']); }
if (!isset($_POST['deleteTeam'])) {
  $teamToDelete = ''; }
if (isset($_POST['deleteTeam'])) {
  $teamToDelete = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['deleteTeam']); }
  // / -Join Team inputs-
if (isset($_GET['joinTeam'])) {
  $teamToJoin = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_GET['joinTeam']); }
if (!isset($_GET['joinTeam'])) {
  $teamToJoin = ''; }
if (isset($_POST['joinTeam'])) {
  $teamToJoin = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['joinTeam']); }
if (isset($_POST['joinTeam'])) {
  $teamToJoin = ''; }
  // / -Join Sub-Team inputs- 
if (isset($_GET['joinSubTeam'])) {
  $subTeamToJoin = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_GET['joinSubTeam']); }
if (!isset($_GET['joinSubTeam'])) {
  $subTeamToJoin = ''; }
if (isset($_POST['joinSubTeam'])) {
  $subTeamToJoin = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['joinSubTeam']); }
if (isset($_POST['joinSubTeam'])) {
  $subTeamToJoin = ''; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code creates required directories if they do not exist.
if (!file_exists($TeamsDir)) {
  mkdir($TeamsDir);
  copy('index.html', $TeamsDir.'/index.html');
  $txt = ('Op-Act: Created the directory "'.$TeamsDir.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); } 
if (!file_exists($UsersDir)) {
  mkdir($UsersDir);
  copy('index.html', $UsersDir.'/index.html');
  $txt = ('Op-Act: Created the directory "'.$UsersDir.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
if (!file_exists($UserRootDir)) {
  mkdir($UserRootDir);
  copy('index.html', $UserRootDir.'/index.html');
  $txt = ('Op-Act: Created the directory "'.$UserRootDir.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
if (!file_exists($UserFilesDir)) {
  mkdir($UserFilesDir);
  copy('index.html', $UserFilesDir.'/index.html');
  $txt = ('Op-Act: Created the directory "'.$UserFilesDir.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code creates new user cache files if they do not exist.
if (!file_exists($UserCacheFile)) {
  $MAKECacheFile = file_put_contents($UserCacheFile, $cleanCacheDATA.PHP_EOL, FILE_APPEND);
  $txt = ('Op-Act: Created a new User Cache File '.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
if (!file_exists($UserCacheFile)) {
  $txt = ('ERROR!!! HRC2TeamsApp88, Unable to create a User Cache File at "'.$UserCacheFile.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  echo nl2br($txt."\n");
  die (); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code verifies that the User files contained in the CloudLoc are valid.
if (file_exists($UserCacheFile)) {
  $cacheDATA = file_get_contents($UserCacheFile);
  foreach ($requiredUserVars as $requiredVar) {
    if (strpos($requiredVar, $cacheDATA) == 'false') {
      $MAKECacheFile = file_put_contents($UserCacheFile, '<?php '.$requiredVar.' = \'\';'.PHP_EOL, FILE_APPEND); } } } 
$usersList = scandir($UsersDir, SCANDIR_SORT_DESCENDING);
foreach ($usersList as $usersIDTestRAW) {
  if (is_dir($UsersDir.$userIDTestRAW) && $UserID == $userIDTestRAW) {
    $userFileTESTER = $UsersDir.$userIDTestRAW.'/'.$userIDTestRAW.'.php';
    if (file_exists($userFileTESTER)) { 
      include($userFileTESTER);
      $userIDTestTESTER = hash('sha256', $USER_ID.$Salts);
      if ($userIDTestTESTER !== $UserCacheFile) {
        $txt = ('Warning!!! HRC2TeamsApp96, There was a problem validating User "'.$UserCacheFile.'"" on '.$Time.'!'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        continue; }
      if ($userIDTestTESTER !== $userFileTESTER) {
        $txt = ('Warning!!! HRC2TeamsApp51, There was a problem validating User "'.$UserFileTESTER.'"" on '.$Time.'!'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        echo nl2br($txt."\n");
        continue; } }
      if ($userIDTestTESTER == $userFileTESTER && $userFileTESTER == $UserCacheFile) {
        if (!is_array($USER_TEAMS)) {
          $USER_TEAMS = array($USER_TEAMS); }
        $currentUserID = $USER_ID; 
        $currentUserName = $USER_NAME; 
        $currentUserTeams = $USER_TEAMS; 
        $settingsUpdateInterval = $UPDATE_INTERVAL; 
        $currentUserPermissions = $USER_PERMISSIONS; 
        $userArray = array_push($userArray, $USER_ID);
        $settingsInternationalGreetings = $INTERNATIONAL_GREETINGS; 
        if ($USER_STATUS == '0' or $USER_STATUS == '') {
          $USER_STATUS = '1'; }
        if ($USER_STATUS == '1') {
          $USER_STATUS = '1'; } 
        if ($USER_STATUS == '2') {
          $USER_STATUS = '1'; } 
        if ($USER_STATUS == '3' or $USER_STATUS == '4') {
          $USER_STATUS = $USER_STATUS; } }
    if (!file_exists($userFileTESTER)) { 
      $txt = ('Warning!!! HRC2TeamsApp49, There was a problem validating User "'.$userFileTESTER.'"" on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      echo nl2br($txt."\n");
      continue; } } }
$userslist = null;
unset ($usersList);
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will verify the friends defined in the user cache file.
/* foreach ($FRIENDS as $friend) { 
if ! }
*/
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code verifies the Teams files contained in the CloudLoc are valid.
$teamsList = scandir($TeamsDir, SCANDIR_SORT_DESCENDING);
foreach ($teamsList as $myTeamFinder) {
  if ($myTeamFinder == '' or $myTeamFinder == '.' or $myTeamFinder == '..' or in_array($myTeamFinder, $defaultDirs)
    or $myTeamFinder == '/' or $myTeamFinder == '//') continue;  
  $finderFile = $TeamsDir.'/'.$myTeamFinder.'/'.$myTeamFinder.'.php';
  include ($finderFile);
  if (!is_array($currentUserTeams)) {
    $currentUserTeams = array($currentUserTeams); }
  if (in_array($myTeamFinder, $currentUserTeams)) {
    $myTeamsList = array_push($myTeamsList, $myTeamFinder); } }
$teamsCounter = 0;
foreach ($myTeamsList as $teamID) {
  if ($teamID == '' or $teamID == '.' or $teamID == '..' or $teamID == '/' or $teamID == '//') continue;
  if (is_dir($TeamsDir.'/'.$teamName)) {
    $teamFileTESTER = $TeamsDir.'/'.$teamID.'/'.$teamID.'.php';
    if (file_exists($teamFileTESTER)) { 
      $teamCacheFile = $TeamsDir.'/'.$teamID.'/_CACHE/_'.$teamID.'_CACHE.php';
      if (!is_dir($teamCacheDir)) {
        @mkdir($teamCacheDir); 
        copy ($InstLoc.'/index.html', $teamCacheDir.'/index.html'); }
        if (is_dir($teamCacheDir)) {  
          $txt = ('Op-Act: Created the directory "'.$teamCacheDir.'" on '.$Time.'!'); 
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
        if (!is_dir($teamCacheDir)) {
          $txt = ('ERROR!!! HRC2TeamsApp210, Could not create the directory "'.$UserCacheDir.'" on '.$Time.'!'); 
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
          die(); }     
      if (!file_exists($teamCacheFile)) {
        $cacheDATA = ('<?php $ACTIVE_USERS = array(); $INACTIVE_USERS = array(); ?>'); 
        $MAKECacheFile = file_put_contents($teamCacheFile, $cacheDATA.PHP_EOL, FILE_APPEND);
        if (file_exists($teamCacheFile))
          $txt = ('Op-Act: Created a new Team Cache file on '.$Time.'!'); 
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
        if (!file_exists($teamCacheFile)) {
          $txt = ('ERROR!!! HRC2TeamsApp220, Could not create a new Team Cache file on '.$Time.'!'); 
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
          die(); }
      include($teamCacheFile);
      include($teamFileTESTER);
      $teamIDTESTER = hash('sha256', $TEAM_NAME.$Salts);
      if ($teamIDTESTER == $teamFileTESTER) {
        $teamArray = array_push($teamArray, $TEAM_NAME); }
      if ($teamNameTESTER !== $teamFileTESTER) {
        foreach ($requiredTeamVars as $reqVar) {
          $safeTeamFileDATA = '<?php '.$reqVar.' = \'\';';
          if (file_exists($safeTeamFile)) unlink($safeTeamFile);
          $MAKESafeTeamFile = file_put_contents($safeTeamFile, $safeTeamFileDATA); }
        include ($safeTeamFile);
        unlink($safeTeamFile);
        $txt = ('Warning!!! HRC2TeamsApp51, There was a problem validating Team "'.$teamFileTESTER.'"" on '.$Time.'!'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
        echo nl2br($txt."\n");
        continue; } 
      $teamsCounter++;
      $UserCount_Team[$teamsCounter] = count($TEAM_USERS); }
    if (!file_exists($teamFileTESTER) or $teamID == '') { 
      $teamsCounter--;      
      $txt = ('Warning!!! HRC2TeamsApp179, There was a problem validating Team "'.$teamFileTESTER.'"" on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
      echo nl2br($txt."\n");
      continue; } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will echo a table of the users Teams when called.
function getMyTeams($myTeamsList) {  
  $myTeamCounter = 0;
  echo nl2br('<div id="newTeamsDiv" name="newTeamsDiv"><form method="post" action="Teams.php" type="multipart/form-data">'."\n");
  echo nl2br("\n".'<div id="myTeamsList" name="myTeamsList" align="center"><strong>My Teams</strong><hr /></div>');
  echo ('<div align="center">
    <table class="sortable">
    <thead><tr>
    <th>Team</th>
    <th>Delete</th>
    </tr></thead><tbody>'); 
  foreach ($myTeamsList as $myTeam) {
    if ($myTeam == '.' or $myTeam == '..' or $myTeam == '' or $myTeam == '/' or $myTeam == '//') continue; 
    $myTeamCounter++;
    $myTeamFile = $TeamsDir.'/'.$myTeam.'/'.$myTeam.'.php';
    include($myTeamFile);
    $myTeamEcho = $TEAM_NAME;
    $myTeamTime = date("F d Y H:i:s.",filemtime($myTeamFile));
    echo ('<tr><td><strong>'.$myTeamCounter.'. </strong><a href="Teams.php?viewTeam='.$myTeam.'">'.$myTeamEcho.'</a></td>');
    echo ('<td><a href="Teams.php?deleteTeam='.$myTeam.'"><img id="delete'.$myTeamCounter.'" name="'.$myTeam.'" src="'.$URL.'/HRProprietary/HRCloud2/Resources/deletesmall.png"></a></td>'); 
    echo ('</tr><tbody></table></table>'); }
  return('true'); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will return the current users Teams in CSV format within it's return value when called.
function getMyTeamsQuietly($myTeamsList) {
  $myTeamArr = array();
  foreach ($myTeamsList as $myTeam) {
    if ($myTeam == '.' or $myTeam == '..' or $myTeam == '' or $myTeam == '/' or $myTeam == '//') continue; 
    $myTeamArr = array_push($myTeamArr, $myTeam); }
  return(implode(',', $myTeamArr)); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will return a table of Publicly visible Teams when called.
function getPublicTeams($teamsList) {
  $teamCounter = 0;
  echo nl2br("\n".'<div id="TeamsList" name="TeamsList" align="center"><strong>Available Teams</strong><hr /></div>');
  echo ('<div align="center">
    <table class="sortable">
    <thead><tr>
    <th>Team</th>
    <th>Delete</th>
    </tr></thead><tbody>'); 
  foreach ($teamsList as $team) {
    if ($myTeam == '.' or $team == '..' or $team == '' or $team == '/' or $team == '//') continue; 
    $teamCounter++;
    $teamFile = $TeamsDir.'/'.$team.'/'.$team.'.php';
    $teamTime = date("F d Y H:i:s.",filemtime($teamFile));
    include($teamFile);
    if ($TEAM_VISIBILITY == '1' && !in_array($UserID, $BANNED_USERS)) {
      $teamEcho = $TEAM_NAME;
      echo ('<tr><td><strong>'.$teamCounter.'. </strong><a href="Teams.php?viewTeam='.$team.'">'.$teamEcho.'</a></td>');
      echo ('<td><a href="Teams.php?deleteTeam='.$team.'"><img id="delete'.$teamCounter.'" name="'.$team.'" src="'.$URL.'/HRProprietary/HRCloud2/Resources/deletesmall.png"></a></td>'); 
      echo ('</tr><tbody></table></table>'); } } 
  return ('true'); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code will return publicly visible Teams in CSV format within it's return value when called.
function getPublicTeamsQuietly($teamsList) {
  $publicTeamArr = array();
  foreach ($teamsList as $team) {
    if ($myTeam == '.' or $team == '..' or $team == '' or $team == '/' or $team == '//') continue; 
    $teamFile = $TeamsDir.'/'.$team.'/'.$team.'.php';
    include($teamFile);
    if ($TEAM_VISIBILITY == '1' && !in_array($UserID, $BANNED_USERS)) {
      $publicTeamArr = array_push($publicTeamArr, $team); } } 
  return (implode(',', $publicTeamArr)); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects to create a new Team.
if (isset($newTeamName) && $newTeamName !== '') {
  $txt = ('OP-Act: Creating Team "'.$newTeamName.'" on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  if (file_exists($newTeamDir)) {
    $txt = ('ERROR!!! HRC2TeamsApp134, Unable to create the directory "'.$newTeamDir.'" because it already exists on '.$Time.'!'); 
    $prettyTxt = 'Ooops! That Team already exists. Try a different name for your Team!';
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br($prettyTxt."\n");
    die (); }  
  if (!file_exists($newTeamDir)) { 
    $txt = ('OP-Act: Creating new Team directory "'.$newTeamDir.'" on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    mkdir($newTeamDir); 
    copy ('index.html', $newTeamDir.'/index.html'); }
  if (!file_exists($newTeamFile)) { 
    $newTeamFileDATA = ('<?php $TEAM_NAME = \''.$_POST['newTeam'].'\'; $TEAM_OWNER = \''.$UserID.'\' ; $TEAM_CREATED_BY = \''.$UserID.'\'; 
      $TEAM_ALIAS = array(\'\'); $TEAM_USERS = array(\''.$UserID.'\'); $TEAM_ADMINS = array(\''.$UserID.'\'); $TEAM_VISIBILITY=\'1\'; $BANNED_USERS = array(); ?>');
    $MAKEnewTeamFile = file_put_contents($newTeamFile, $newTeamFileDATA.PHP_EOL, FILE_APPEND); 
    $txt = ('OP-Act: Creating new Team file "'.$newTeamFile.'" on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($newTeamDataDir)) { 
    mkdir($newTeamDataDir);
    copy ('index.html', $newTeamDataDir.'/index.html'); 
    $txt = ('OP-Act: Creating new Team DATA directory "'.$newTeamDataDir.'" on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (!file_exists($newTeamDir) or !file_exists($newTeamFile)) { 
    $txt = ('ERROR!!! HRC2TeamsApp186 There was a problem creating the new Team "'.$_POST['newTeam'].'" on '.$Time.'!'); 
    $prettyTxt = 'Ooops! There was a problem creating your new Team. Please try again later.';
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    echo nl2br($prettyTxt."\n");
    die (); }
  if (file_exists($newTeamFile)) { 
    $teamName = $newTeamName;
    $teamDir = $newTeamDir; 
    $teamFile = $newTeamFile;
    $txt = ('OP-Act: Sucessfully created the new Team "'.$teamName.'" on '.$Time.'!');  
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
    echo nl2br('Created <i>'.$teamName.'</i>'."\n"); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a validated user selects to edit a Team.
if (isset($teamToEdit) && $teamToEdit !== '') {
  $txt = ('OP-Act: Opening Team "'.$teamToEdit.'" for editing on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  $teamFile = $TeamsDir.'/'.$teamToEdit.'.php';
  if (!file_exists($teamFile)) {
    $txt = ('ERROR!!! HRC2TeamsApp164 There was a problem validating the files for Team "'.$teamToEdit.'"on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br($txt."\n"); 
    die(); }
  include($teamFile);
  $teamAlias = $TEAM_NAME;
if (in_array($_POST['editTeam'], $currentUserTeams)) {
  $newTeamFileDATA = ('<?php $TEAM_NAME = \''.$editTeamName.'\'; $TEAM_OWNER = \''.$editTeamOwner.'\' ; $TEAM_USERS = array(\''.$editTeamUsers.'\'); 
    $TEAM_ADMINS = array(\''.$editTeamAdmins.'\'); $TEAM ALIAS = \''.$editTeamAlias.'\'; $BANNED_USERS = array(); ?>');
  $MAKEnewTeamFile = file_put_contents($newTeamFile, $newTeamFileDATA.PHP_EOL, FILE_APPEND); 
  echo nl2br('Edited <i>'.$teamName.'</i>'."\n"); } 
if (!in_array($teamToEdit, $currentUserTeams)) {
  $txt = ('ERROR!!! HRC2TeamsApp151, The current user "'.$UserID.'" does not have permission to edit the Team "'.$teamToEdit.'" on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  echo nl2br($txt."\n"); 
  die(); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects to delete a Team.
if (isset($_GET['deleteTeam']) or isset($_POST['deleteTeam'])) {
  $txt = ('OP-Act: Opening Team "'.$teamToDelete.'" for validation on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
  $teamDir = $TeamsDir.'/'.$teamToDelete; 
  $teamFile = $teamDir.'/'.$teamToDelete.'.php';
  if (!file_exists($teamFile)) {
    $txt = ('ERROR!!! HRC2TeamsApp212 There was a problem validating the files for Team "'.$teamToDelete.'"on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br($txt."\n"); 
    die(); }
  include($teamFile);
  if ($UserID !== $TEAM_OWNER) {
    $txt = ('ERROR!!! HRC2TeamsApp221, The current user "'.$UserID.'" does not have permission to delete the Team "'.$teamToDelete.'" on '.$Time.'!');  
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br($txt."\n");
    die(); }
  @unlink($teamFile);
  @rmdir($teamDir); 
  if (file_exists($teamDir) or file_exists($teamFile)) { 
    $txt = ('ERROR!!! HRC2TeamsApp227 There was a problem deleting the Team "'.$teamToDelete.'" on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);
    echo nl2br($txt."\n");
    die (); }
  if (!file_exists($teamDir)) { 
    $txt = ('OP-Act: Deleting Team '.$teamToDelete.' on '.$Time.'!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br('Deleted <i>'.$teamToDelete.'</i>'."\n"); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when an admin adds a user to a Team.
if (isset($adminAddUserToTeam) && isset($adminTeamToAdd)) {
  $userModFile = str_replace('//', '/', $CloudLoc.'/Apps/Teams/_USERS/'.$adminAddUserToTeam.'/'.$adminAddUserToTeam.'.php');
  $teamdModFile = str_replace('//', '/', $TeamsDir.'/'.$adminTeamToAdd.'/'.$adminTeamToAdd);
  include($userModFile);
  $USER_TEAMS = array_push($USER_TEAMS, $adminTeamToAdd);
  $userCacheDATA = ('$USER_TEAMS = array(\''.implode('\',\'', $USER_TEAMS).'\');'); 
  $MAKECacheFile = file_put_contents($userModFile, $userCacheDATA.PHP_EOL, FILE_APPEND);
  include($teamdModFile);
  $TEAM_USERS = array_push($TEAM_USERS, $adminAddUserToTeam);
  $teamCacheDATA = ('$TEAM_USERS = array(\''.implode('\',\'', $TEAM_USERS).'\');'); 
  $MAKECacheFile = file_put_contents($teamModFile, $teamCacheDATA.PHP_EOL, FILE_APPEND); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when an admin removes a user from a Team.
if (isset($adminRemoveUserFromTeam) && isset($adminTeamToRemove)) {
  $userModFile = str_replace('//', '/', $CloudLoc.'/Apps/Teams/_USERS/'.$adminRemoveUserFromTeam.'/'.$adminRemoveUserFromTeam.'.php');
  $teamdModFile = str_replace('//', '/', $TeamsDir.'/'.$adminTeamToRemove.'/'.$adminTeamToRemove);
  include($userModFile);
  $USER_TEAMS[$adminTeamToRemove] = null;
  $userCacheDATA = ('$USER_TEAMS = array(\''.implode('\',\'', $USER_TEAMS).'\');'); 
  $MAKECacheFile = file_put_contents($userModFile, $userCacheDATA.PHP_EOL, FILE_APPEND);
  include($teamdModFile);
  $TEAM_USERS[$adminRemoveUserFromTeam] = null;
  $teamCacheDATA = ('$TEAM_USERS = array(\''.implode('\',\'', $TEAM_USERS).'\');'); 
  $MAKECacheFile = file_put_contents($teamModFile, $teamCacheDATA.PHP_EOL, FILE_APPEND); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a validated user selects to edit their account.
if (isset($userToEdit) && $userToEdit !== '') {
  $txt = ('OP-Act: Opening User "'.$userToEdit.'" for editing on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  $userFile = $UserDir.'/'.$userToEdit.'.php';
  if (!file_exists($userFile)) {
    $txt = ('ERROR!!! HRC2TeamsApp164 There was a problem validating the files for User "'.$usersToEdit.'"on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br($txt."\n"); 
    die(); }
  include($userFile);
if ($_POST['editUser'] == $currentUserID) {
    $newUserFileDATA = ('<?php $USER_CACHE_VERSION = \''.$TeamsAppVersion.'\' $USER_NAME = \'\'; $USER_TITLE = \'\'; 
    $USER_PHOTO_FILENAME = \'\'; $USER_TEAMS_OWNED = \'\'; $INTERNATIONAL_GREETINGS = 1; UPDATE_INTERVAL = 2000; 
    $USER_EMAIL_1 = \'\'; $USER_EMAIL_2 = \'\'; $USER_EMAIL_3 = \'\'; 
    $USER_PHONE_1 = \'\'; $USER_PHONE_2 = \'\'; $USER_PHONE_3 = \'\'; $ACCOUNT_NOTES_USER = \'\'; ?>');
  $MAKEnewUserFile = file_put_contents($userFile, $newUserFileDATA.PHP_EOL, FILE_APPEND); 
  include($userFile);  
  echo nl2br('Edited <i>'.$userName.'</i>'."\n"); } 
if (!in_array($userToEdit, $currentUserTeams)) {
  $txt = ('ERROR!!! HRC2TeamsApp336, The current user "'.$UserID.'" does not have permission to join the team "'.$teamToJoin.'" because they have been banned on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  echo nl2br($txt."\n"); 
  die(); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects to join a Team.
if (isset($teamToJoin) && $teamToJoin !== '') {
  if (is_array($teamToJoin)) {
    if (count($teamToJoin) > 1) {
      $txt = ('ERROR!!! HRC2TeamsApp501, Only one Team can be joined per request. '.$UserID.' Attempted to upload a multi-dimensional array as the "teamToJoin" on '.$Time);  
      $prettyTxt = 'Whoa, somehow you managed to submit an invalid multi-dimensional array to the server in a POST request! :o
       Whatever that means, you should tell your Teams App administrator to check the logs.';
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);     
      echo nl2br($prettyTxt."\n"); } }
    $teamToJoin = $teamToJoin[0];
  $teamCacheFile = $TeamsDir.'/'.$teamToJoin.'/_CACHE/_'.$teamToJoin.'_CACHE.php';
  $teamDir = $TeamsDir.'/'.$teamToJoin; 
  $teamFile = $teamDir.'/'.$teamToJoin.'.php';
  include($teamFile);
  include($teamCacheFile);
  if(in_array($UserID, $BANNED_USERS)) {
    $txt = ('ERROR!!! HRC2TeamsApp505, The current user "'.$UserID.'" does not have permission to join the team "'.$teamToJoin.'" because they have been banned on '.$Time.'!');  
    $prettyTxt = 'Ooops, looks like you don\'t have permission to join this Team!';
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br($prettyTxt."\n"); }
  if(!in_array($UserID, $TEAM_USERS) && $TEAM_VISIBILITY == '0') { 
    $txt = ('ERROR!!! HRC2TeamsApp353, The current user "'.$UserID.'" does not have permission to to join the team "'.$teamToJoin.'" because they are not a member of it on '.$Time.'!');  
    $prettyTxt = 'Ooops, looks like you don\'t have permission to join this Team!';
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br($prettyTxt."\n"); }
  if(in_array($UserID, $TEAM_USERS) && !in_array($UserID, $BANNED_USERS)) {
    $currentUserTeams = array_push($currentUserTeams, $teamToJoin);
    $USER_STATUS = 1;
    $userCacheDATA0 = implode('\',\'', $currentUserTeams);
    $userCacheDATA = '<?php $USER_STATUS = '.$USER_STATUS.'; $CURRENT_USER_TEAM = array(\''.$userCacheDATA0.'\'); ?>';
    $WRITEUserCacheDATA = file_put_contents($userCacheFile, $userCacheDATA.PHP_EOL, FILE_APPEND); 
    if (!isset($ACTIVE_USERS) or !isset($INACTIVE_USERS)) {
      $teamCacheDATA = ''; }
    if (isset($ACTIVE_USERS) && isset($INACTIVE_USERS)) {
      $ACTIVE_USERS = array_push($ACTIVE_USERS, $UserID);
      $teamCacheDATA = '<?php $ACTIVE_USERS = array(\''.implode('\',\'', $ACTIVE_USERS).'\'); $INACTIVE_USERS = array(\''.implode('\',\'', $INACTIVE_USERS).'\');?>'; }
    $WRITETeamCacheDATA = file_put_contents($teamCacheFile, $teamCacheDATA.PHP_EOL, FILE_APPEND);
    $teamsGreetingDivNeeded = 'false';
    $allowPosting = $teamToJoin;
    $chatDivNeeded = 'true'; } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects to create a new SubTeam (Private Team within a Team).
  // / Must be performed AFTER teamToJoin.
if (isset($newSubTeam) && $newSubTeam !== '' && isset($teamToJoin)) {
  // / Add subteam users to the array.
  $txt = ('OP-Act: Creating SubTeam "'.$newSubTeam.'" on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 

if (!is_array($subTeamUsers)) {
  $subTeamUsers = array($_POST['subTeamUsers']); }
  $EmrgcCtr = 0;
foreach($subTeamUsers as $subTeamUser) {
  $EmrgcCtr++;
  if ($EmrgcCtr == 1000) continue;
  include($teamFile);
  if (in_array($UserID, $TEAM_USERS) && !in_array($User, $BANNED_USERS)) {
    $USER_SUBTEAM = '';
  }
}


  if (!file_exists($newSubTeamFile)) { 
    $newTeamFileDATA = ('<?php $TEAM_NAME = \''.$_POST['newTeam'].'\'; $TEAM_OWNER = \''.$UserID.'\' ; $TEAM_CREATED_BY = \''.$UserID.'\'; 
      $TEAM_ALIAS = array(\'\'); $TEAM_USERS = array(\''.$UserID.'\',\''.implode('\',\'', $FriendArr).'\'); $TEAM_ADMINS = array(\''.$UserID.'\'); $TEAM_VISIBILITY=\'0\'; $BANNED_USERS = array(); ?>');
    $MAKEnewTeamFile = file_put_contents($newTeamFile, $newTeamFileDATA.PHP_EOL, FILE_APPEND); 
    $txt = ('OP-Act: Creating new Team file "'.$newTeamFile.'" on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (file_exists($teamFile)) { 
  

    $teamFile = $newTeamFile;
    $txt = ('OP-Act: Sucessfully created the new Team "'.$teamName.'" on '.$Time.'!');    
    $teamDir = $newTeamDir;     
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
    echo nl2br('Created <i>'.$teamName.'</i>'."\n"); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects to join a Sub-Team.
if (isset($subTeamToJoin) && $subTeamToJoin !== '' && isset($teamToJoin)) {
  if (is_array($subTeamToJoin)) {
    if (count($subTeamToJoin) > 1) {
      $txt = ('ERROR!!! HRC2TeamsApp546, Only one Sub-Team can be joined per request. '.$UserID.' Attempted to upload a multi-dimensional array as the "teamToJoin" on '.$Time);  
      $prettyTxt = 'Whoa, somehow you managed to submit an invalid multi-dimensional array to the server in a POST request! :0 
       Whatever that means, you should tell your Teams App administrator to double check the logs.';
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);     
      echo nl2br($prettyTxt."\n"); }
    $subTeamToJoin = $subTeamToJoin[0]; }
  $teamDir = $TeamsDir.'/'.$teamToJoin; 
  $teamFile = $teamDir.'/'.$teamToJoin.'.php';
  $subTeamFile = $TeamsDir.'/'.$subTeamToJoin.'.php';
  $subTeamCacheFile = $TeamsDir.'/'.$teamToJoin.'/_CACHE/_'.$subTeamToJoin.'_CACHE.php';
  include($subTeamFile);
  include($subTeamCacheFile);
  if(in_array($UserID, $BANNED_USERS)) {
    $txt = ('ERROR!!! HRC2TeamsApp505, The current user "'.$UserID.'" does not have permission to join the team "'.$teamToJoin.'" because they have been banned on '.$Time.'!');  
    $prettyTxt = 'Ooops, looks like you don\'t have permission to join this Team!';
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br($prettyTxt."\n"); }
  if(!in_array($UserID, $TEAM_USERS) && $TEAM_VISIBILITY == '0') { 
    $txt = ('ERROR!!! HRC2TeamsApp353, The current user "'.$UserID.'" does not have permission to to join the team "'.$teamToJoin.'" because they are not a member of it on '.$Time.'!');  
    $prettyTxt = 'Ooops, looks like you don\'t have permission to join this Team!';
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    echo nl2br($prettyTxt."\n"); 
  if(in_array($UserID, $TEAM_USERS) && !in_array($UserID, $BANNED_USERS)) {
    $currentUserSubTeams = array_push($currentUserSubTeams, $subTeamToJoin);
    $USER_STATUS = 1;
    $userCacheDATA0 = implode('\',\'', $currentUserSubTeams);
    $userCacheDATA = '<?php $USER_STATUS = '.$USER_STATUS.'; $CURRENT_USER_SUBTEAM = array(\''.$userCacheDATA0.'\'); ?>';
    $WRITEUserCacheDATA = file_put_contents($userCacheFile, $userCacheDATA.PHP_EOL, FILE_APPEND); 
    if (!isset($ACTIVE_USERS) or !isset($INACTIVE_USERS)) {
      $teamCacheDATA = ''; }
    if (isset($ACTIVE_USERS) && isset($INACTIVE_USERS)) {
      $ACTIVE_USERS = array_push($ACTIVE_USERS, $UserID);
      $subTeamCacheDATA = '<?php $ACTIVE_USERS = array(\''.implode('\',\'', $ACTIVE_USERS).'); $INACTIVE_USERS = array(\''.implode('\',\'', $INACTIVE_USERS).'\');?>'; }
    $WRITETeamCacheDATA = file_put_contents($subTeamCacheFile, $subTeamCacheDATA.PHP_EOL, FILE_APPEND);
    $teamsGreetingDivNeeded = 'false';
    $allowPosting = $subTeamToJoin;
    $chatDivNeeded = 'true'; } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever an admin selects to kick an active user from a Team.

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever an admin selects to tempBan a user from a Team.
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever an admin selects to permBan a user from a Team.
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when an authenticated user selects to submit a text post to a Team.
if (isset($textTeamPost) && isset($teamToJoin) && $allowPosting == $teamToJoin) {
  if (isset($subTeamID)) {

  }

  $conversationData = $Time.' '.$USER_NAME.'- '.$textTeamPost;
  
  $MAKEConversationFile = '';
}
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed when an authenticated user selects to submit a file post to a Team.
if (isset($fileTeamPost) && $allowPosting == $teamToJoin) {

}
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code reads the selected conversation file and returns it's contents.
// / -----------------------------------------------------------------------------------

?>