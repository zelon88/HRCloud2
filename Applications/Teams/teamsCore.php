<?php
// / The following code sets the variables for the session.
$SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
$TeamsDir = str_replace('//', '/', $CloudLoc.'/Apps/Teams/');
$UsersDir = str_replace('//', '/', $CloudLoc.'/Apps/Teams/Users/');
$FilesDir = str_replace('//', '/', $CloudLoc.'/Apps/Teams/Files/');
$UserRootDir = str_replace('//', '/', $CloudLoc.'/Apps/Teams/Users/'.$UserID.'/');
$UserCacheFile = str_replace('//', '/', $CloudLoc.'/Apps/Teams/Users/'.$UserID.'/'.$UserID.'.php');
$UserFilesDir = str_replace('//', '/', $CloudLoc.'/Apps/Teams/Users/'.$UserID.'/Files/');
$teamArray = array();
$userArray = array();
$fileArray = array();
$newTeamNameEcho = 'New Team Name...';
$newTeamDescriptionEcho = 'New Team Description...';
$teamDir = '';
$teamFile = '';
$newTeamFileDATA = '';
$teamButtonEcho = 'Edit Team';
$requiredUserVars = array('$USER_ID', 'USER_NAME', '$USER_TITLE', '$USER_TOKEN', '$USER_PHOTO_FILENAME', '$USER_ALIAS', 
  '$USER_TEAMS_OWNED', '$USER_TEAMS', '$USER_PERMISSIONS', '$INTERNATIONAL_GREETINGS', 'UPDATE_INTERVAL', '$USER_EMAIL_1',
  '$USER_EMAIL_2', '$USER_EMAIL_3', '$USER_PHONE_1', '$USER_PHONE_2', '$USER_PHONE_3', '$ACCOUNT_NOTES_USER', '$ACCOUNT_NOTES_ADMIN');

// / The following code represents the Teams API handler, sanitizing and consolidating inputs.
  // / -New Team inputs.
if (isset($_GET['newTeam'])) {
  $_POST['newTeam'] = $_GET['newTeam']; }
if (!isset($_POST['newTeam'])) {
  $newTeamName = ''; }
if (isset($_POST['newTeam'])) {
  $_POST['newTeam'] = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['newTeam']);
  $newTeamName = str_replace(str_split('./,[]{};:$!#^&%@>*<'), '', $_POST['newTeam']); 
  $newTeamDir = str_replace('//', '/', $TeamsDir.'/'.$newTeamName);
  $newTeamFile = str_replace('//', '/', $TeamsDir.'/'.$newTeamName.'/'.$newTeamName.'.php'); }
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

// / The following code creates the required user cache files and if they do not exist.
if (!file_exists($UserCacheFile)) {
  $cacheDATA = ('<?php $USER_ID = '.$UserID.';'.' $USER_NAME = \'\'; $USER_TITLE = \'\'; $USER_TOKEN = \'\'; 
    $USER_PHOTO_FILENAME = \'\'; $USER_ALIAS = \'\'; $USER_TEAMS_OWNED = \'\'; $USER_TEAMS = array(); 
    $USER_PERMISSIONS = 0; $INTERNATIONAL_GREETINGS = 1; UPDATE_INTERVAL = 2000; $USER_EMAIL_1 = \'\'; 
    $USER_EMAIL_2 = \'\'; $USER_EMAIL_3 = \'\'; $USER_PHONE_1 = \'\'; $USER_PHONE_W = \'\'; $USER_PHONE_3 = \'\'; 
    $ACCOUNT_NOTES_USER = \'\'; $ACCOUNT_NOTES_ADMIN = \'\'; ?>');
  $MAKECacheFile = file_put_contents($UserCacheFile, $cacheDATA.PHP_EOL , FILE_APPEND);
  $txt = ('Op-Act: Created the directory "'.$CloudLoc.'/Apps'.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($UserCacheFile)) {
  $txt = ('ERROR!!! HRC2TeamsApp88, Unable to create the directory "'.$CloudLoc.'/Apps'.'" on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ($txt); }

// / The following code updates the required cache files for the session to the latest version, if necessary.
if (file_exists($UserCacheFile)) {
  $cacheDATA = file_get_contents($UserCacheFile);
  foreach ($requiredUserVars as $requiredVar) {
    if (strpos($requiredVar, $cacheDATA) == 'false') {
      $MAKECacheFile = file_put_contents($UserCacheFile, '<?php $requiredVar = \'\';'.PHP_EOL , FILE_APPEND); } } }

// / The following code scans the CloudLoc/Apps/Teams directory for the latest files.
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

// / The following code is performed whenever a user selects to create a new Team.
if (isset($_POST['newTeam'])) {
  $txt = ('OP-Act: Creating Team "'.$teamToEdit.'" on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  if (file_exists($newTeamDir)) {
    $txt = ('ERROR!!! HRC2TeamsApp134, Unable to create the directory "'.$newTeamDir.'" because it already exists on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die ($txt); }  
  if (!file_exists($newTeamDir)) { 
    $txt = ('OP-Act: Creating new Team directory "'.$newTeamDir.'" on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    mkdir($newTeamDir); }
  if (!file_exists($newTeamFile)) { 
    $newTeamFileDATA = ('<?php $TEAM_NAME = \''.$_POST['newTeam'].'\'; $TEAM_OWNER = \''.$UserID.'\' ; $TEAM_CREATED_BY = \''.$UserID.'\'; 
      $TEAM_USERS = array(\''.$UserID.'\'); $TEAM_ADMINS = array(\''.$UserID.'\'); ');
    $MAKEnewTeamFile = file_put_contents($newTeamFile, $newTeamFileDATA.PHP_EOL , FILE_APPEND); 
    $txt = ('OP-Act: Creating new Team file "'.$newTeamFile.'" on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  if (!file_exists($newTeamDir) or !file_exists($newTeamFile)) { 
    $txt = ('ERROR!!! HRC2TeamsApp186 There was a problem creating the new Team "'.$_POST['newTeam'].'"on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    die ($txt); }
  if (file_exists($newTeamFile)) { 
    $txt = ('OP-Act: Sucessfully created the new Team "'.$_POST['newTeam'].'" on '.$Time.'!');  
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
    $teamName = $newTeamName;
    $teamDir = $newTeamDir; 
    $teamFile = $newTeamFile;
    echo ('Created <i>'.$teamName.'</i>'); }

// / The following code is performed whenever a validated user selects to edit a Team.
if (isset($_POST['editTeam'])) {
  $txt = ('OP-Act: Opening Team "'.$teamToEdit.'"" for editing on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  $TeamsFile = $TeamsDir.'/'.$teamToEdit.'.php';
  if (!file_exists($TeamsFile)) {
    $txt = ('ERROR!!! HRC2TeamsApp164 There was a problem validating the files for Team "'.$_POST['newTeam'].'"on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
  include($TeamsFile);
if (in_array($_POST['editTeam'], $currentUserTeams)) {
  $MAKEnewTeamFile = file_put_contents($newTeamFile, $newTeamFileDATA.PHP_EOL , FILE_APPEND); 
  echo ('Edited <i>'.$teamName.'</i>'); } 
if (!in_array($_POST['editTeam'], $currentUserTeams)) {
  $txt = ('ERROR!!! HRC2TeamsApp151, The current user "'.$UserID.'" does not have permission to edit the team "'.$teamToEdit.'" on '.$Time.'!');  
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ($txtl); } }

?>