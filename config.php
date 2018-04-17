<?php

// This file contains the configuration data for the HRCloud2 Server application.
// Make sure to fill out the information below 100% accuratly BEFORE you attempt to run
// any HRCloud2 Server application scripts. Severe filesystem damage could result.

// BE SURE TO FILL OUT ALL INFORMATION ACCURATELY !!!
// PRESERVE ALL SYNTAX AND FORMATTING !!!
// SERIOUS FILESYSTEM DAMAGE COULD RESULT FROM INCORRECT DATABASE OR DIRECTORY INFO !!!
// / ------------------------------


// / ------------------------------
// / License Information ...
  // / To continue, please accept the included GPLv3 license by changing the following 
  // / variable to '1'. By changing the '$Accept_GPLv3_OpenSource_License' variable to '1'
  // / you aknowledge that you have read and agree to the terms of the included LICENSE file.
$Accept_GPLv3_OpenSource_License = '1';
// / ------------------------------

// / ------------------------------
// / General Information ... 
  // 

  // / This timezone will be the default one used if a user has not specified there own.
$defaultTimezone = 'America/New_York';
  // / This Nickname will be the default one used if a user has not specified there own.
$defaultNickname = 'Commander';
  // / The default font type to use for displaying text within GUI elements.
$defaultFont = 'Helvetica';
  // / Leave '1' for default and to allow individual users to modify their own color-schemes.
$defaultColorScheme = '1';
  // / To show HRAI in your Cloud homepage, set $ShowHRAI to '1'. To hide HRAI in your Cloud
  // / Default is '1'.
$defaultShowHRAI = '1';
  // / To have HRAI read most outputs out loud using client speakers and audio device, set to '1'.
  // / Default is '1'.
$defaultHRAIAudio = '1';
  // / To hide tooltips at the top of each page, set $ShowTips to '0'.
  // / Default is '1'.
$defaultShowTips = '1';
  // / The default URL for the Privacy-Policy that applies to this installation.
  // / Default is '0'.
$defaultPPEnableURL = 'https://www.honestrepair.net/privacy-policy';
  // / The defaultTOSEURL will set the defauly.
  // / Default is '0'.
$defaultTOSEnableURL = 'https://www.honestrepair.net/terms-of-service';
  // / The default URL for the Privacy-Policy that applies to this installation.
  // / Default is 'https://www.honestrepair.net/index.php/privacy-policy/'.
$defaultPrivacyPolicyURL = 'https://www.honestrepair.net/index.php/privacy-policy';
  // / The default URL for the Terms-Of-Service that applies to this installation.
  // / Default is 'https://www.honestrepair.net/index.php/terms-of-service/'.
$defaultTermsOfServiceURL = 'https://www.honestrepair.net/index.php/terms-of-service';
// / ------------------------------

// / ------------------------------  
// / Security Information ... 
  // / HRCloud2 Server can run on a local machine or on a network as a server to
  // / serve clients over http using standard web browsers. These settings tell
  // / HRCloud2 information about protecting itself.

  // / Change the Salts to something completely random and keep it a secret. 
    // / Store your $Salts
    // / in hardcopy form or an encrypted drive in case of emergency.
    // / IF YOU LOSE YOUR SALTS YOU WILL BE UNABLE TO DECODE USER ID'S AFTER AN EMEREGENCY.
$Salts = 'somethingSoRanDoMThatNobod65y_Will_evar+guess+it';
  // / Externally or internally accesible domain or IP.
$URL = 'https://www.YOUR_URL_HERE.net';
  // / Scan for viruses during directory scan. Use '1' for default. 
    // / (ClamAV MUST be installed on the localhost!!!).
$VirusScan = '0';
  // / Use multi-threaded virus scanning. Virus scanning is extremely resource intensive. 
    // / If you are running an older machine (Rpi, CoreDuo, or any single-core CPU) leave 
    // / this setting disabled '0'.
$HighPerformanceAV = '1';
  // / Thorough A/V scanning requires stricter permissions, and may require additional 
    // / ClamAV user, usergroup, and permissions configuration.
    // / Disable '0' if you experience errors.
    // / Enable '0' if you experience false-negatives.
$ThoroughAV = '1';
  // / Persistent A/V scanning will try to achieve the highest level of scanning that is
    // / possible with available permissions. 
    // / When enabled; If errors are encountered ANY AND EVERY attempt to recover from the 
      // / error will be made. No expense will be spared to complete the operation.
    // / When disabled; If errors are encountered, NO ATTEMPTS to recover from the error
      // / will be made. The operation will be abandoned and abort after reasonable effort.
$PersistentAV = '1';
// / ------------------------------

// / ------------------------------ 
// / Directory Locations ...
// / The ServerRootDir should be pointed at the root of your web server directory.
  // / (NO SLASH AFTER DIRECTORY!!!) ...  
$ServerRootDir = '/var/www/html';
  // / Use format '/home/YOUR_USERNAME/Desktop/TestDir'. (NO SLASH AFTER DIRECTORY!!!) ...  
  // / NOT OPTIMIZED FOR ALTERNATE INSTALL LOCATIONS!!! (NO SLASH AFTER DIRECTORY!!!) ...
$InstLoc = '/var/www/html/HRProprietary/HRCloud2';
  // / The CloudLoc is where permanent Cloud files are stored. (NO SLASH AFTER DIRECTORY!!!) ...  
$CloudLoc = '/mnt/23E43FN6A95F784A/Cloud';
// / ------------------------------ 

// / ------------------------------ 
// / Filesystem Permission Settings ...
  // / Set the user for the Apache server to use when it writes to the filesystem.
  // / Default is 'www-data'.
$ApacheUser = 'www-data';
  // / Set the user group for the Apache server to use when it writes to the filesystem.
  // / Default is 'www-data'.
$ApacheGroup = 'www-data';
  // / Select the permission level of the $CloudLoc.
$CLPerms = '0755';
  // / Select the permission level of the $InstLoc.
$ILPerms = '0755';
// / ------------------------------ 
