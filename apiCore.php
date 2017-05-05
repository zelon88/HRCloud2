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
$UserKeyFile = $UserKeyDir.'/'.$UserID.'/key';
// / -----------------------------------------------------------------------------------

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