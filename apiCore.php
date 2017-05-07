<?php

// / -----------------------------------------------------------------------------------
// / The follwoing code checks if the required core files exists, and terminates if they do not.
if (!file_exists('sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2Index1-10, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('sanitizeCore.php'); }
if (!file_exists('commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2Index1-19, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('commonCore.php'); }
if (!file_exists('securityCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2Index1-19, Cannot process the HRCloud2 Security Core file (securityCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require('securityCore.php'); } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sets the global variables for the session.
$ServerKeyDir = $CloudLoc.'/Keys/'.$ServerID;
$ServerKeyFile = $ServerKeyDir.'/'.$ServerID.'.key';
$UserKey = $Salts.$UserID;
$UserKeyDir = $CloudDir.'/Keys';
$UserKeyFile = $UserKeyDir.'/'.$UserID.'.key';
// / -----------------------------------------------------------------------------------



// / -----------------------------------------------------------------------------------
// / The following code checks that required encryption key files exist when they are necessary.
if ($SFTP == '1') {
  if ($_POST['RegenServerKey'] == 'Regenerate Server Key' && $UserIDRAW == 1) {
    @unlink($ServerKeyFile); 
    $txt = ('OP-Act: Deleted the Server Key Directory at "'.$ServerKeyFile.' on '.$Time.'!');  
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if ($_POST['RegenUserKey'] == 'Regenerate User Key' && $UserIDRAW == 1) {
    @unlink($UserKeyFile);
    $txt = ('OP-Act: Deleted the User Key Directory at "'.$UserKeyFile.' on '.$Time.'!');  
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND);  }
  // -----
  // / Make a new server Key directory.
  if (!file_exists($ServerKeyDir)) {
    mkdir($ServerKeyDir, 0755);
    $txt = ('OP-Act: Created a new Server Key Directory at "'.$ServerKeyFile.'" on '.$Time.'!');  
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  // -----
  // / Make a new server Key file.  
  if (!file_exists($ServerKeyFile)) {
    $ServerKeyDATA = hash('sha256', $ServerID.$Salts.$CloudLoc);
    $MAKECacheFile = file_put_contents($ServerKeyFile, $ServerKeyDATA); 
    $txt = ('OP-Act: Created a new Server Key File at "'.$ServerKeyFile.'" on '.$Time.'!');  
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL); }
  // -----
  // / Make a new user Key directory.  
  if (!file_exists($UserKeyDir)) {
    mkdir($ServerKeyDir, 0755);
    $txt = ('OP-Act: Created a new User Key Directory at "'.$UserKeyDir.'" on '.$Time.'!');  
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL); }
  // -----
  // / Make a new User Key file.  
  if (!file_exists($UserKeyFile)) { 
    $UserKeyDATA = hash('sha256', $UserID.$Salts.$CloudLoc);
    $MAKECacheFile = file_put_contents($UserKeyFile, $UserKeyDATA); 
    $txt = ('OP-Act: Created a new User Key File at "'.$UserKeyFile.'" on '.$Time.'!');  
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL); } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code reads the required encryption keys when they are necessary.
if ($SFTP == '1') {
  // / Server Key input POST handler.
  if (file_exists($ServerKeyFile)) {
    $ServerKeyDATA = file_get_contents($ServerKeyFile); 
    $txt = ('ERROR!!! HRC2ApiCore68, Could not verify the ServerKey file at "'.$ServerKeyFile.'" on '.$Time.'!');  
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (isset($_POST['ServerKeyPOST'])) {
    $SKPDATA = base64_decode($ServerKeyPOST); 
    if ($ServerKeyDATA == $SKPDATA) { 
      $ApprovedServerAPI_[$ServerID] = 1; }
  // / Server Key input POST handler.
  if (file_exists($ServerKeyFile)) {
    $ServerKeyDATA = file_get_contents($ServerKeyFile); 
    $txt = ('ERROR!!! HRC2ApiCore68, Could not verify the ServerKey file at "'.$ServerKeyFile.'" on '.$Time.'!');  
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (isset($_POST['ServerKeyPOST'])) {
    $SKPDATA = base64_decode($ServerKeyPOST); 
    if ($ServerKeyDATA == $SKPDATA) { 
      $ApprovedServerAPI_[$ServerID] = 1; } \
  // / User Key input POST handler.
  if (file_exists($UserKeyFile)) {
    $UserKeyDATA = file_get_contents($UserKeyFile); 
    $txt = ('ERROR!!! HRC2ApiCore68, Could not verify the UserKey file at "'.$UserKeyFile.'" on '.$Time.'!');  
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }
  if (isset($_POST['UserKeyPOST'])) {
    $UKPDATA = base64_decode($UserKeyPOST); 
    if ($UserKeyDATA == $UKPDATA) { 
      $ApprovedUserAPI_[$UserID] = 1; } } 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code handles creation, deletion and management of custom user SFTP & app authentication & resource allocation.
if ($SFTP == '1') { 
  $UserSFTPDir = $SFTPDir.'/'.$UserID
  $sshConfigFile = '/etc/ssh/sshd_config';
if (file_exists($sshConfigFile)) {
  $sshConfigDATA = 
    'Match Group sftponly
    ChrootDirectory %h
    ForceCommand internal-sftp
    AllowTcpForwarding no';
  $MAKEsshConfigFile = file_put_contents($LogFile, $sshConfigDATA.PHP_EOL, FILE_APPEND); }
exec('groupadd sftponly');
exec('usermod '.$UserID.' -g sftponly');
exec('usermod '.$UserID.' -s /bin/false');
exec('usermod '.$UserID.' -d '.$UserSFTPDir);
}

// / -----------------------------------------------------------------------------------




// / Add sudo apt-get install ssh to the readme.md file and dependency requirements.

// / A settings entry needs to be added to settingsCore.php giving admins the ability to enable global SFTP. 

// / A settings entry needs to be added to settingsCore.php giving users the ability to enable/disable their private SFTP (for security).



// / This file should check for the existence of a User API Key, and create one if one does not exist and if global and private SFTP are enabled.



// / This file should provide the user a means to view/refresh their API Key.

// / This file should check that the SFTP server is running and start one if it is not.

// / This file should create a new SFTP user, set their home directory. 
  // / Use http://stackoverflow.com/questions/23099860/create-a-sftp-user-to-access-only-one-directory) as a guide.

// / This file should destroy the SFTP usergroup and all users when SFTP is disabled by an administrator.

// / Modify the cis-yogesh.github.io project so that it looks for .key files provided by the user instead of the system.

// / Modify the HRCloud2-Client to use the cis-yogesh library for SFTP instead of whatever it's using.

// / Modify the HRCloud2-Client to allow users to provide their own API keys.