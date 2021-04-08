<?php

// This file contains the configuration data for the HRCloud2 Server application.
// Make sure to fill out the information below 100% accuratly BEFORE you attempt to run
// any HRCloud2 Server application scripts. Severe filesystem damage could result.

// BE SURE TO FILL OUT ALL INFORMATION ACCURATELY !!!
// PRESERVE ALL SYNTAX AND FORMATTING !!!
// SERIOUS FILESYSTEM DAMAGE COULD RESULT FROM INCORRECT DATABASE OR DIRECTORY INFO !!!
// FOR OFFICIAL DOCUMENTATION VISIT  https://github.com/zelon88/HRCloud2 
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
  // / Setting to allow backups to be run.
  // / This application includes a cron file that administrators can use to schedule automatic backups.
  // / When enabled you must also specify the $BackupLoc in setting in the Directory Locations section.
  // / When enabled this will allow scheduled & administrator backup features.
  // / When disabled all backup related features will be unavailable.
  // / To enable backups, set to '1'.
  // / To disable backups, set to '0'.
  // / Default is '1'.
$EnableBackups = '1';
  // / Setting to prevent the application for being run during maintenance.
  // / When enabled this setting will prevent HRCloud2 from loading.
  // / When disabled HRCloud2 will load and users will be able to access it's features.
  // / To allow HRCloud2 to run normally, set to '0'.
  // / To disable HRCloud2 for maintenance, set to '1'.
  // / Default is '0'.
$EnableMaintenanceMode = '0';
  // / Setting to use as the default timezone. Only applied if a user has not specified their own.
  // / Default is 'America/New_York'.
$defaultTimezone = 'America/New_York';
  // / Setting to be used by HRAI in responses to address the user. 
  // / This is the name HRAI will call the user if they have not specified their own.
  // / Default is 'Commander'.
$defaultNickname = 'Commander';
  // / Setting to specify the default font type to use for displaying text within GUI elements.
  // / These will only function on client systems that have the specified font installed.
  // / Systems that lack the font specified here will display their default system font.
  // / Default is 'Helvetica'.
$defaultFont = 'Helvetica';
  // / Setting to specify the default color scheme until the user sets their own.
  // / Default is '1'.
$defaultColorScheme = '1';
  // / Setting to show HRAI on your Cloud homepage. 
  // / When enabled HRAI will be visible at the top of most pages by default.
  // / When disabled HRAI will only be visible at the top of the Home page by default.
  // / To hide HRAI on most pages by default, set to '0'.
  // / To show HRAI on most pages by default, set to '1'.
  // / Default is '1'.
$defaultShowHRAI = '1';
  // / Setting to specify the default HRAI audio settings until user sets their own.
  // / When enabled HRAI will speak her responses to the user with client speakers & audio devices by default.
  // / When enabled HRAI will not speak using any audio devices. Her responses will be text only by default.
  // / To disable HRAI audio by default, set to '0'.
  // / To enable HRAI audio by default, set to '1'.
  // / Default is '1'.
$defaultHRAIAudio = '1';
  // / Setting to specify the default setting for displaying tooltips at the top of each page.
  // / When enabled tooltips will be displayed at the top of most pages by default.
  // / When disabled tooltips will not be displayed on any pages by default.
  // / To disable tooltips by default, set to '0'.
  // / To enable tooltips by default, set to '1'.
  // / Default is '1'.
$defaultShowTips = '1';
  // / Setting to determine if the Privacy Policy link is enabled.
  // / When enabled users will be shown links to the $defaultPrivacyPolicyURL on the Help page by default.
  // / When disabled users will not be shown links to the $defaultPrivacyPolicyURL on the Help page by default.
  // / To disable the Privacy Policy button on the Help page, se to '0'.
  // / To enable the Privacy Policy button on the Help page, set to '1'.
  // / If enabled the $defaultPrivacyPolicyURL must be set to the destination of your Privacy Policy.
  // / Default is '0'.
$defaultPPEnableURL = '0';
  // / Setting to determine if the Terms Of Service link is enabled.
  // / When enabled users will be shown links to the $defaultTermsOfServiceURL on the Help page by default.
  // / When disabled users will not be shown links to the $defaultTermsOfServiceURL on the Help page by default.
  // / To disable the Terms Of Service button on the Help page, se to '0'.
  // / To enable the Terms Of Service button on the Help page, set to '1'.
  // / If enabled the $defaultTermsOfServiceURL must be set to the destination of your Terms Of Service.
  // / Default is '0'.
$defaultTOSEnableURL = '0';
  // / Setting to define the URL that users are directed to when they press the Privacy Policy button.
  // / For this setting to have any effect you must also enable the $defaultPPEnableURL setting.
  // / Set this to a resolvable web destination that contains the Privacy Policy for your organiation.
  // / Default is 'https://www.honestrepair.net/index.php/privacy-policy/'.
$defaultPrivacyPolicyURL = 'https://www.honestrepair.net/index.php/privacy-policy';
  // / Setting to define the URL that users are directed to when they press the Terms Of Service button.
  // / For this setting to have any effect you must also enable the $defaultTOSEnableURL setting.
  // / Set this to a resolvable web destination that contains the Terms Of Service for your organiation.
  // / Default is 'https://www.honestrepair.net/index.php/terms-of-service/'.
$defaultTermsOfServiceURL = 'https://www.honestrepair.net/index.php/terms-of-service';
// / ------------------------------

// / ------------------------------  
// / Security Information ... 
  // / HRCloud2 Server can run locally or on a network as a server to serve clients over http using 
  // / standard web browsers. These settings provide HRCloud2 with information it uses to protect itself.

  // / The Salts setting is a string which is used to obfuscate the functionality of the application in a 
  // / manner which is predictable for the server but seemingly random to a malignant observer.
  // / Change the Salts to something completely random and keep it a secret. 
  // / Store your $Salts in hardcopy form or an encrypted drive in case of emergency.
  // / IF YOU LOSE YOUR SALTS YOU WILL BE UNABLE TO DECODE USER ID'S AFTER AN EMEREGENCY.
$Salts = 'secrets-so-fake-my-brain-hurts';
  // / Setting to specify the destination of this HRCloud2 installation. 
  // / Set to an externally or internally accesible domain or IP.
$URL = 'http://localhost';
  // / Setting to specify whether to perform real-time virus scanning during user submitted file operations. 
  // / This setting requires that ClamAV be installed on the server.
  // / Virus scanning with ClamAV is extremely resource intensive. If your server has an old or slow CPU users 
  // / may experience poor performance and high latency when using your HRCloud2 server.
  // / Even if this setting is disabled administrators are given the option to run a one-time bulk scan of the 
  // / server at any time via the Settings page.
  // / When enabled HRCloud2 will perform a virus scan during most user submitted file operations.
  // / When disabled HRCloud2 will not perform a virus scan during any user submitted file operations.
  // / To disable automatic virus scanning during file operations, set to '0'.
  // / To enable automatic virus scanning during file operations, set to '1'.
  // / Default is '0'.
$VirusScan = '1';
  // / Setting to determine if multi-threaded virus scanning is used. 
  // / If you are running an old or slow CPU you should leave this setting disabled.
  // / If you experience extremely long latency during file operations you can test if this setting improves
  // / performance before completely disabling virus scanning.
  // / When enabled the virus scanning components will be allowed to use multiple threads of the host CPU.
  // / When disabled the virus scanning components will only ever use a single CPU thread.
  // / To disable multi-threaded virus scanning, set to '0'.
  // / To enable multi-threaded virus scanning, set to '1'.
$HighPerformanceAV = '1';
  // / Setting to specify if entire files are scanned or only their descriptors. 
  // / Thorough virus scanning requires strict permissions & may require additional ClamAV user, usergroup, 
  // / or permissions configuration. For more information see the official ClamAV documentation.
  // / If you experience errors during virus scan operations disable this setting.
  // / When enabled the virus scanner will perform a deep scan on each target file.
  // / When disabled the virus scanner will only perform a scan of a target file's descriptors.
  // / Disable '0' if you experience errors.
  // / Enable '0' if you experience false-negatives.
$ThoroughAV = '1';
  // / Setting to specify if persistent virus scanning should be used.
  // / Persistent virus scanning attempts to achieve the highest level of scanning that is permissable. 
  // / When enabled the virus scanner will reconfigure & retry a failed operation with reduced permissions.
  // / When disabled the virus scanner will abort an operation as soon as it fails.
  // / To disable persistent virus scanning, set to '0'.
  // / To enable persistent virus scanning, set to '1'.
  // / Default is '1'.
$PersistentAV = '1';
// / ------------------------------

// / ------------------------------ 
// / Directory Locations ...
  // / This setting should be pointed at the root of your web server directory.
  // / DO NOT USE TRAILING SLASH AFTER DIRECTORY!!!
  // / Default is '/var/www/html',  
$ServerRootDir = '/var/www/html';
  // / This setting should be pointed at the subfolder of your web server where HRCloud2 is installed.
  // / DO NOT USE TRAILING SLASH AFTER DIRECTORY!!!
  // / This setting is for reference only and SHOULD NOT be modified. 
  // / Unexpected behaviour may occur if you alter this setting.
  // / If you NEED to change this setting, you should try to adjust your web server configuration instead.
  // / The www-data user needs to have read & write permissions granted to this directory. 
  // / Default is '/var/www/html/HRProprietary/HRCloud2'.
$InstLoc = '/var/www/html/HRProprietary/HRCloud2';
  // / This setting should be pointed to wherever your permanent Cloud files are stored.
  // / When users submit files to your server or modify their settings, they will be stored in a user specific
  // / subdirectory within this location. This is the final resting place for all user supplied data.
  // / DO NOT USE TRAILING SLASH AFTER DIRECTORY!!!
  // / You can point this at any storage location, but it is advised to ensure that is is mounted at boot.
  // / The www-data user needs to have read & write permissions granted to this directory. 
  // / Default is a placeholder which is designed to fail if left unmodified. 
  // / This setting is unique to every system. You MUST specify a custom location. 
  // / Example is '/CloudStorage/UserData'.
$CloudLoc = '/testCloud';
  // / This setting should be pointed to wherever your backup files are stored.
  // / When scheduled backups occur, or when an administrator performs a manual backup, the contents of the 
  // / Cloud Location will be copied to the Backup Location.
  // / DO NOT USE TRAILING SLASH AFTER DIRECTORY!!!
  // / You can point this at any storage location, but it is advised to ensure that is is mounted at boot.
  // / The www-data user needs to have read & write permissions granted to this directory. 
  // / Default is a placeholder which is designed to fail if left unmodified. 
  // / This setting is unique to every system. You MUST specify a custom location. 
$BackupLoc = '/testCloudBackup';
// / ------------------------------ 

// / ------------------------------ 
// / Filesystem Permission Settings ...
  // / This setting should match the user that the Apache server uses when it writes to the filesystem.
  // / This setting is for reference only and SHOULD NOT be modified. 
  // / Unexpected behaviour may occur if you alter this setting.
  // / Default is 'www-data'.
$ApacheUser = 'www-data';
  // / This setting should match the user group that the Apache server uses when it writes to the filesystem.
  // / This setting is for reference only and SHOULD NOT be modified. 
  // / Unexpected behaviour may occur if you alter this setting.
  // / Default is 'www-data'.
$ApacheGroup = 'www-data';
  // / This setting defines the permissions settings that are enforced on the Cloud Location.
  // / This setting is for reference only and SHOULD NOT be modified. 
  // / Unexpected behaviour may occur if you alter this setting.
  // / Default is '0755'.
$CLPerms = '0755';
  // / This setting defines the permissions settings that are enforced on the Installation Location.
  // / This setting is for reference only and SHOULD NOT be modified. 
  // / Unexpected behaviour may occur if you alter this setting.
  // / Default is '0755'.
$ILPerms = '0755';
// / ------------------------------ 
