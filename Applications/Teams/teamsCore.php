<?php
// / -----------------------------------------------------------------------------------
/*
This file represents the core logic functions for the HRCloud2 Teams App.

This file outputs (almost) all of it's activity to the logged-in HRCloud2 users standard 
log directories. This script will very minimal output during normal operation. 
The only output a client should ever see from this file are success or error messages.
*/
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets the variables for the session.
$TeamsAppVersion = 'v0.65';
$SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
$TeamsDir = str_replace('//', '/', $CloudLoc.'/Apps/Teams');
$defaultDirs = array('index.html', '_FILES', '_USERS', '_TEAMS');
$UsersDir = str_replace('//', '/', $CloudLoc.'/Apps/Teams/_USERS');
$UserRootDir = str_replace('//', '/', $CloudLoc.'/Apps/Teams/_USERS/'.$UserID.'');
$UserFilesDir = str_replace('//', '/', $CloudLoc.'/Apps/Teams/_USERS/'.$UserID.'/FILES');
$UserCacheFile = str_replace('//', '/', $CloudLoc.'/Apps/Teams/_USERS/'.$UserID.'/'.$UserID.'.php');
$myTeamsList = array();
$teamArray = array();
$userArray = array();
$fileArray = array();
$teamDir = '';
$teamFile = '';
$newTeamFileDATA = '';
$requiredTeamVars = array('$TEAM_CACHE_VERSION', '$TEAM_NAME', '$TEAM_OWNER', '$TEAM_CREATED_BY', '$TEAM_ALIAS', '$TEAM_USERS', 
  '$TEAM_ADMINS', '$TEAM_VISIBILITY', '$TEAM_ALIAS');
$requiredUserVars = array('$USER_CACHE_VERSION', '$USER_ID', 'USER_NAME', '$USER_TITLE', '$USER_TOKEN', '$USER_PHOTO_FILENAME', '$USER_ALIAS', 
  '$USER_TEAMS_OWNED', '$USER_TEAMS', '$USER_PERMISSIONS', '$INTERNATIONAL_GREETINGS', 'UPDATE_INTERVAL', '$USER_EMAIL_1',
  '$USER_EMAIL_2', '$USER_EMAIL_3', '$USER_PHONE_1', '$USER_PHONE_2', '$USER_PHONE_3', '$ACCOUNT_NOTES_USER', '$ACCOUNT_NOTES_ADMIN');
// / -----------------------------------------------------------------------------------

// / ----------------------------------------------------------------------------------- 
// / The following code sets the default variables for the GUI. These values may be modified later in the script.
$teamsGreetings = array('Hi There!', 'Hello!');
$teamsGreetingsInternational = array('Hi There!', 'Hello!', 'Bonjour!', 'Hola!', 'Namaste!', 'Salutations!', 'Konnichiwa!', 'Bienvenidos!', 'Guten Tag!');
if ($settingsInternationalGreetings = '1' or $settingsInternationalGreetings == 1) {
  $teamsGreetings = $teamsGreetingsInternational; }
$greetingKey = array_rand($teamsGreetings);
$teamsHeaderDivNeeded = 'true';
$teamsGreetingDivNeeded = 'true';
$newTeamDivNeeded = 'true';
$newTeamNameEcho = 'New Team Name...';
$newTeamDescriptionEcho = 'New Team Description...';
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code represents the Teams API handler, sanitizing and consolidating inputs.
  // / -New Team inputs.
if (isset($_GET['newTeam'])) {
  $_POST['newTeam'] = $_GET['newTeam']; }
if (!isset($_POST['newTeam'])) {
  $newTeamName = ''; }
if (isset($_POST['newTeam'])) {
  $_POST['newTeam'] = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['newTeam']);
  $newTeamName = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['newTeam']); 
  $newTeamID = hash('sha256', $newTeamName.$SALTS);
  $newTeamDir = str_replace('//', '/', $TeamsDir.'/'.$newTeamID);
  $newTeamFile = str_replace('//', '/', $newTeamDir.'/'.$newTeamID.'.php');
  $newTeamDataDir = str_replace('//', '/', $newTeamDir.'/_DATA'); }
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
  $_POST['editTeam'] = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_GET['editTeam']); }
if (!isset($_POST['deleteTeam'])) {
  $teamToDelete = ''; }
if (isset($_POST['deleteTeam'])) {
  $_POST['deleteTeam'] = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['deleteTeam']); 
  $teamToDelete = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['deleteTeam']); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code creates the required CloudLoc directories if they do not exist.
if (!file_exists($TeamsDir)) {
  mkdir($TeamsDir);
  copy('index.html', $TeamsDir.'/index.html');
  $txt = ('Op-Act: Created the directory "'.$TeamsDir.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } 
if (!file_exists($UsersDir)) {
  mkdir($UsersDir);
  copy('index.html', $UsersDir.'/index.html');
  $txt = ('Op-Act: Created the directory "'.$UsersDir.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($UserRootDir)) {
  mkdir($UserRootDir);
  copy('index.html', $UserRootDir.'/index.html');
  $txt = ('Op-Act: Created the directory "'.$UserRootDir.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($UserFilesDir)) {
  mkdir($UserFilesDir);
  copy('index.html', $UserFilesDir.'/index.html');
  $txt = ('Op-Act: Created the directory "'.$UserFilesDir.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code creates that the user cache files if they do not exist.
if (!file_exists($UserCacheFile)) {
  $cacheDATA = ('<?php $USER_CACHE_VERSION = \''.$TeamsAppVersion.'\' $USER_ID = '.$UserID.';'.' $USER_NAME = \'\'; $USER_TITLE = \'\'; 
    $USER_TOKEN = \'\'; $USER_PHOTO_FILENAME = \'\'; $USER_ALIAS = \'\'; $USER_TEAMS_OWNED = \'\'; $USER_TEAMS = array(); 
    $USER_PERMISSIONS = 0; $INTERNATIONAL_GREETINGS = 1; UPDATE_INTERVAL = 2000; $USER_EMAIL_1 = \'\'; 
    $USER_EMAIL_2 = \'\'; $USER_EMAIL_3 = \'\'; $USER_PHONE_1 = \'\'; $USER_PHONE_W = \'\'; $USER_PHONE_3 = \'\'; 
    $ACCOUNT_NOTES_USER = \'\'; $ACCOUNT_NOTES_ADMIN = \'\'; ?>');
  $MAKECacheFile = file_put_contents($UserCacheFile, $cacheDATA.PHP_EOL , FILE_APPEND);
  $txt = ('Op-Act: Created a new User Cache File '.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($UserCacheFile)) {
  $txt = ('ERROR!!! HRC2TeamsApp88, Unable to create a User Cache File at "'.$UserCacheFile.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  echo nl2br($txt."\n");
  die (); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code verifies that the User files contained in the CloudLoc are valid.
if (file_exists($UserCacheFile)) {
  $cacheDATA = file_get_contents($UserCacheFile);
  foreach ($requiredUserVars as $requiredVar) {
    if (strpos($requiredVar, $cacheDATA) == 'false') {
      $MAKECacheFile = file_put_contents($UserCacheFile, '<?php $requiredVar = \'\';'.PHP_EOL , FILE_APPEND); } } } 
$usersList = scandir($UsersDir, SCANDIR_SORT_DESCENDING);
foreach ($usersList as $usersIDTestRAW) {
  if (is_dir($UsersDir.$userIDTestRAW) && $UserID == $userIDTestRAW) {
    $userFileTESTER = $UsersDir.$userIDTestRAW.'/'.$userIDTestRAW.'.php';
    if (file_exists($userFileTESTER)) { 
      include($userFileTESTER);
      $userIDTestTESTER = hash('sha256', $USER_ID.$Salts);
      if ($userIDTestTESTER !== $UserCacheFile) {
        $txt = ('Warning!!! HRC2TeamsApp96, There was a problem validating User "'.$userCacheFile.'"" on '.$Time.'!'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
        continue; }
      if ($userIDTestTESTER !== $userFileTESTER) {
        $txt = ('Warning!!! HRC2TeamsApp51, There was a problem validating User "'.$userFileTESTER.'"" on '.$Time.'!'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
        echo nl2br($txt."\n");
        continue; } }
      if ($userIDTestTESTER == $userFileTESTER && $userFileTESTER == $UserCacheFile) {
        $userArray = array_push($userArray, $USER_ID);
        $currentUserID = $USER_ID; 
        $currentUserName = $USER_NAME; 
        $currentUserTeams = $USER_TEAMS; 
        $currentUserPermissions = $USER_PERMISSIONS; 
        $settingsInternationalGreetings = $INTERNATIONAL_GREETINGS; 
        $settingsUpdateInterval = $UPDATE_INTERVAL; }
    if (!file_exists($userFileTESTER)) { 
      $txt = ('Warning!!! HRC2TeamsApp49, There was a problem validating User "'.$userFileTESTER.'"" on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
      echo nl2br($txt."\n");
      continue; } } }
$userslist = null;
unset ($usersList);
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
  if (is_dir($TeamsDir.$teamName)) {
    $teamFileTESTER = $TeamsDir.$teamID.'/'.$teamID.'.php';
    if (file_exists($teamFileTESTER)) { 
      include($teamFileTESTER);
      $teamsCounter++;
      $teamIDTESTER = hash('sha256', $TEAM_NAME.$Salts);
      if ($teamIDTESTER == $teamFileTESTER) {
        $teamArray = array_push($teamArray, $TEAM_NAME); }
      if ($teamNameTESTER !== $teamFileTESTER) {
        $teamsCounter--;
        $txt = ('Warning!!! HRC2TeamsApp51, There was a problem validating Team "'.$teamFileTESTER.'"" on '.$Time.'!'); 
        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
        echo nl2br($txt."\n");
        continue; } }
    if (!file_exists($teamFileTESTER) or $teamID == '') { 
      $teamsCounter--;      
      $txt = ('Warning!!! HRC2TeamsApp179, There was a problem validating Team "'.$teamFileTESTER.'"" on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
      echo nl2br($txt."\n");
      continue; } } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects to create a new Team.
if (isset($_GET['newTeam']) or isset($_POST['newTeam'])) {
  $txt = ('OP-Act: Creating Team "'.$teamToEdit.'" on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  if (file_exists($newTeamDir)) {
    $txt = ('ERROR!!! HRC2TeamsApp134, Unable to create the directory "'.$newTeamDir.'" because it already exists on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br($txt."\n");
    die (); }  
  if (!file_exists($newTeamDir)) { 
    $txt = ('OP-Act: Creating new Team directory "'.$newTeamDir.'" on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    mkdir($newTeamDir); }
  if (!file_exists($newTeamFile)) { 
    $newTeamFileDATA = ('<?php $TEAM_NAME = \''.$_POST['newTeam'].'\'; $TEAM_OWNER = \''.$UserID.'\' ; $TEAM_CREATED_BY = \''.$UserID.'\'; 
      $TEAM_ALIAS = array(\'\'); $TEAM_USERS = array(\''.$UserID.'\'); $TEAM_ADMINS = array(\''.$UserID.'\'); $TEAM_VISIBILITY=\'1\'; ?>');
    $MAKEnewTeamFile = file_put_contents($newTeamFile, $newTeamFileDATA.PHP_EOL , FILE_APPEND); 
    $txt = ('OP-Act: Creating new Team file "'.$newTeamFile.'" on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  if (!file_exists($newTeamDataDir)) { 
    mkdir($newTeamDataDir);
    $txt = ('OP-Act: Creating new Team DATA directory "'.$newTeamDataDir.'" on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  if (!file_exists($newTeamDir) or !file_exists($newTeamFile)) { 
    $txt = ('ERROR!!! HRC2TeamsApp186 There was a problem creating the new Team "'.$_POST['newTeam'].'"on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    echo nl2br($txt."\n");
    die (); }
  if (file_exists($newTeamFile)) { 
    $teamName = $newTeamName;
    $teamDir = $newTeamDir; 
    $teamFile = $newTeamFile;
    $txt = ('OP-Act: Sucessfully created the new Team "'.$teamName.'" on '.$Time.'!');  
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
    echo nl2br('Created <i>'.$teamName.'</i>'."\n"); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a validated user selects to edit a Team.
if (isset($_POST['editTeam']) or isset($_POST['editTeam'])) {
  $txt = ('OP-Act: Opening Team "'.$teamToEdit.'" for editing on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  $teamFile = $TeamsDir.'/'.$teamToEdit.'.php';
  if (!file_exists($teamFile)) {
    $txt = ('ERROR!!! HRC2TeamsApp164 There was a problem validating the files for Team "'.$teamToEdit.'"on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br($txt."\n"); 
    die(); }
  include($teamFile);
  $teamAlias = $TEAM_NAME;
if (in_array($_POST['editTeam'], $currentUserTeams)) {
  $newTeamFileDATA = ('<?php $TEAM_NAME = \''.$_POST['newTeam'].'\'; $TEAM_OWNER = \''.$UserID.'\' ; $TEAM_CREATED_BY = \''.$UserID.'\'; 
    $TEAM_USERS = array(\''.$UserID.'\'); $TEAM_ADMINS = array(\''.$UserID.'\'); $TEAM ALIAS = \''.$teamAlias.'\'; ?>');
  $MAKEnewTeamFile = file_put_contents($newTeamFile, $newTeamFileDATA.PHP_EOL , FILE_APPEND); 
  echo nl2br('Edited <i>'.$teamName.'</i>'."\n"); } 
if (!in_array($teamToEdit, $currentUserTeams)) {
  $txt = ('ERROR!!! HRC2TeamsApp151, The current user "'.$UserID.'" does not have permission to edit the Team "'.$teamToEdit.'" on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  echo nl2br($txt."\n"); 
  die(); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a user selects to delete a Team.
if (isset($_GET['deleteTeam']) or isset($_POST['deleteTeam'])) {
  $txt = ('OP-Act: Opening Team "'.$teamToDelete.'" for validation on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  $teamDir = $TeamsDir.'/'.$teamToDelete; 
  $teamFile = $teamDir.'/'.$teamToDelete.'.php';
  if (!file_exists($teamFile)) {
    $txt = ('ERROR!!! HRC2TeamsApp212 There was a problem validating the files for Team "'.$teamToDelete.'"on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br($txt."\n"); 
    die(); }
  include($teamFile);
  if ($UserID !== $TEAM_OWNER) {
    $txt = ('ERROR!!! HRC2TeamsApp221, The current user "'.$UserID.'" does not have permission to delete the Team "'.$teamToDelete.'" on '.$Time.'!');  
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br($txt."\n");
    die(); }
  @unlink($teamFile);
  @rmdir($teamDir); 
  if (file_exists($teamDir) or file_exists($teamFile)) { 
    $txt = ('ERROR!!! HRC2TeamsApp227 There was a problem deleting the Team "'.$teamToDelete.'" on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    echo nl2br($txt."\n");
    die (); }
  if (!file_exists($teamDir)) { 
    $txt = ('OP-Act: Deleting Team '.$teamToDelete.' on '.$Time.'!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br('Deleted <i>'.$teamToDelete.'</i>'."\n"); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code is performed whenever a validated user selects to edit their account.
if (isset($_POST['editUser']) or isset($_POST['editUser'])) {
  $txt = ('OP-Act: Opening User "'.$teamToEdit.'" for editing on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  $userFile = $UserDir.'/'.$userToEdit.'.php';
  if (!file_exists($userFile)) {
    $txt = ('ERROR!!! HRC2TeamsApp164 There was a problem validating the files for User "'.$usersToEdit.'"on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br($txt."\n"); 
    die(); }
  include($teamFile);
if (in_array($_POST['editUser'], $currentUserTeams)) {
    $newUserFileDATA = ('<?php $USER_CACHE_VERSION = \''.$TeamsAppVersion.'\' $USER_NAME = \'\'; $USER_TITLE = \'\'; 
    $USER_PHOTO_FILENAME = \'\'; $USER_TEAMS_OWNED = \'\'; $USER_TEAMS = array(); 
    $INTERNATIONAL_GREETINGS = 1; UPDATE_INTERVAL = 2000; $USER_EMAIL_1 = \'\'; $USER_EMAIL_2 = \'\'; $USER_EMAIL_3 = \'\'; 
    $USER_PHONE_1 = \'\'; $USER_PHONE_2 = \'\'; $USER_PHONE_3 = \'\'; 
    $ACCOUNT_NOTES_USER = \'\'; ?>');
  $MAKEnewUserFile = file_put_contents($newUserFile, $newUserFileDATA.PHP_EOL , FILE_APPEND); 
  echo nl2br('Edited <i>'.$userName.'</i>'."\n"); } 
if (!in_array($userToEdit, $currentUserTeams)) {
  $txt = ('ERROR!!! HRC2TeamsApp151, The current user "'.$UserID.'" does not have permission to edit the User "'.$userToEdit.'" on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  echo nl2br($txt."\n"); 
  die(); } }
// / -----------------------------------------------------------------------------------

?>