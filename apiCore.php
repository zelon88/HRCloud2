<?php

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