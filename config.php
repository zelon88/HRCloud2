<?php

// This file contains the configuration data for the HRCloud2 Server application.
// Make sure to fill out the information below 100% accuratly BEFORE you attempt to run
// any HRCloud2 Server application scripts. Severe filesystem damage could result.

// BE SURE TO FILL OUT ALL INFORMATION ACCURATELY !!!
// PRESERVE ALL SYNTAX AND FORMATTING !!!
// SERIOUS FILESYSTEM DAMAGE COULD RESULT FROM INCORRECT DATABASE OR DIRECTORY INFO !!!

// / ------------------------------
// / Admin Login Information ...
  $AdmLogin = 'Justin';
  $AdmPass = 'password';
  $UniqueServerName = 'D620-Server';
// / ------------------------------

// / ------------------------------  
// / Security Information ... 
  
  // / HRCloud2 Server can run on a local machine or on a network as a server to
  // / serve clients over http using standard web browsers. When running locally it is 
  // / advised to install HRCloud2 in a location that IS NOT hosted. If you do not
  // / plan on running an online, externally controllable HRCloud2 Server set the online
  // / setting below to '0' and ignore the rest of the 'Security' settings. HRCloud2 will
  // / automatically deny access or authorization to external or internal IP's other than the
  // / localhost machine. 

  // / If you are an administrator or home power-user you may want to run HRCloud2 in a 
  // / server environment. If you want to make the HRCloud2 admin panel accesible, or if 
  // / you want to execute HRCloud2 scripts from  from outside your home network change
  // / the 'Online' setting to '1' and continue to specify the remaining  'Security Settings'.

  // / If 'Online' setting is '1' DocumnentControl Server will allow network 
  // / users to perform certain tasks and also allow remote admin access from local 
  // / or remote networks (depending on individual network architecture). 
  // / If '1', HRCloud2 folder MUST be on a hosted /var/www/html folder or 
  // / equivilent network accesible location.
  $Online = '1';  
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
// / Windows machines use format 'C:/users/User/Desktop/TestDir'.
// / Linux machines use format '/home/justin/Desktop/TestDir'.
  // / Directory where HRCloud2 was installed. (NO SLASH AFTER DIRECTORY!!!)
  $InstLoc = '/var/www/html/HRProprietary/HRCloud2';
  // / Directory to be scanned for file dumps (NO SLASH AFTER DIRECTORY!!!) ...  
  $CloudLoc = '/home/justin/Desktop/TestDir/Cloud';
  // / If you want HRCloud2 to create and manage a synced copy of your 
   // / Output Location, set AutoBackups below to '1', 
  $AutoBackup = '1';
  // / If you have enabled Auto Backups (set AutoBackups to '1'), select a root directory
   // / for organized backup files (NO SLASH AFTER DIRECTORY!!! Leave blank for none.) ...
  $BackupLoc = '/home/justin/Desktop/TestDir/BACKUP';
  // / If you have enabled Auto Backups (set AutoBackups to '1'), select a root directory
   // / for organized backup files (NO SLASH AFTER DIRECTORY!!! Leave blank for none.) ...
  $ActionLoc = '/home/justin/Desktop/TestDir/ActionItems';
// / ------------------------------ 
