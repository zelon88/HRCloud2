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
  // / Leave '1' for default and to allow individual users to modify their own color-schemes.
$ColorScheme = '1';
  // / To show HRAI in your Cloud homepage, set $ShowHRAI to '1'. To hide HRAI in your Cloud
  // / homepage set $ShowHRAI to '0'. Default is '1'.
$ShowHRAI = '1';
  // / To hide tooltips at the top of each page, set $ShowTips to '0'.
$ShowTips = '1';
// / ------------------------------

// / ------------------------------  
// / Security Information ... 
  // / HRCloud2 Server can run on a local machine or on a network as a server to
  // / serve clients over http using standard web browsers.

  // / Secret Salts.
    // / Change these to something completely random and keep it a secret. Store your $Salts
    // / in hardcopy form or an encrypted drive in case of emergency.
    // / IF YOU LOSE YOUR SALTS YOU WILL BE UNABLE TO DECODE USER ID'S AFTER AN EMEREGENCY.
  // / Unique Salts.
$Salts = 'somethingSoRanDoMThatNobod65y_Will_evar+guess+it';
  // / Externally or internally accesible domain or IP.
$URL = 'https://www.YOUR_URL_HERE.net';
  // / Scan for viruses during directory scan. Use 1 for default. 
   // / (ClamAV MUST be installed on the localhost!!!).
$VirusScan = '0';
  // / Use multi-threaded virus scanning. Virus scanning is extremely resource intensive. 
    // / If you are running an older machine (Rpi, CoreDuo, or any single-core CPU) leave 
    // / this setting disabled ('0').
$HighPerformanceAV = '0';
  // / Thorough A/V scanning requires stricter permissions, and may require additional 
    // / ClamAV user, usergroup, and permissions configuration.
    // / Disable ('0') if you experience errors.
    // / Enable ('0') if you experience false-negatives.
$ThoroughAV = '0';
  // / Persistent A/V scanning will try to achieve the highest level of scanning that is
    // / possible with available permissions. 
    // / When enabled; If errors are encountered ANY AND EVERY attempt to recover from the 
      // / error will be made. No expense will be spared to complete the operation.
    // / When disabled; If errors are encountered, NO ATTEMPTS to recover from the error
      // / will be made. The operation will be abandoned and abort after reasonable effort.
$PersistentAV = '1';
// / ------------------------------

// / ------------------------------ 
// / Directory locations ...
  // / Use format '/home/YOUR_USERNAME/Desktop/TestDir'.
  // / YOU MUST INSTALL HRCLOUD2 TO THE FOLLOWING DIRECTORY!!!
  // / DO NOT CHANGE THE DEFAULT INSTALL DIRECTORY!!!
$InstLoc = '/var/www/html/HRProprietary/HRCloud2';
  // / Directory to be scanned for file dumps (NO SLASH AFTER DIRECTORY!!!) ...  
$CloudLoc = '/home/YOUR_USERNAME/Desktop/TestDir/Cloud';
// / ------------------------------ 

// / ------------------------------ 
// / Default Timezone
  // / This timezone will be the default one used if a user has not specified there own.
$defaultTimezone = 'America/New_York';
// / ------------------------------ 
