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
// / To run HRCloud2 as a STANDALONE Cloud Platform: Set $WordPressIntegration to '0'.
// / To integrate HRCloud2 into an existing WordPress blog: Set $WordPressIntegration to '1'.
$WordPressIntegration = '1';
// / ------------------------------

// / ------------------------------
// / Admin Login Information ...
  $AdmLogin = 'YourName';
  $AdmPass = 'YourPassword';
  $UniqueServerName = 'YourServer';
// / ------------------------------

// / ------------------------------  
// / Security Information ... 
  // / HRCloud2 Server can run on a local machine or on a network as a server to
  // / serve clients over http using standard web browsers. When running locally it is 
  // / advised to install HRCloud2 in a location that IS NOT hosted. 
  // / Unique Salts.
  $Salts = 'somethingSoRanDoMThatNobod65y_Will_evar+guess+it';
  // / Internal IP Address.
  $InternalIP = '192.168.1.7';
  // / Externally or internally accesible domain or IP.
  $URL = 'localhost';
  // / Scan for viruses during directory scan. Use 1 for true or leave blank for false. 
   // / (ClamAV MUST be installed on the localhost!!!).
  $VirusScan = '0';
// / ------------------------------

// / ------------------------------ 
// / Directory locations ...
// / Use format '/home/justin/Desktop/TestDir'.
  // / YOU MUST INSTALL HRCLOUD2 TO THE FOLLOWING DIRECTORY!!!
  // / DO NOT CHANGE THE DEFAULT INSTALL DIRECTORY!!!
  $InstLoc = '/var/www/html/HRProprietary/HRCloud2';
  // / Directory to be scanned for file dumps (NO SLASH AFTER DIRECTORY!!!) ...  
  $CloudLoc = '/home/justin/Desktop/TestDir/Cloud';
// / ------------------------------ 
