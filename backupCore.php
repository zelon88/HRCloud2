<?php
// / This file represents the HRCloud2 Backup Core. It is responsible for backing up all Cloud User Data to whatever location is specified in the config.php file. 
// / If no $BackupLocation is set in config.php this file will produce a backupWarning.log file in the root HRCloud2 directory which triggers the HRCloud2 Settings Core to display a warning to the administrator.
// / It can safely be run from a local terminal or cron at any time, however large Cloud instances can take A LONG TIME to sync. 

// / -----------------------------------------------------------------------------------
// / The following code sets variables for the session.
$ExecuteBackup = FALSE;
$BackupDate = date("m_d_y");
$BackupTime = date("F j, Y, g:i a"); 
$BackupConfigFile = realpath(dirname(__FILE__)).'/config.php';
$backupWarningLogFile = realpath(dirname(__FILE__)).'/backupWARNING.log'; 
$backupWarningLogData = 'This file was generated on '.$BackupDate.' at '.$BackupTime.' by backupCore.php to notify you that automatic backups cannot run until the $BackupLoc is set in '.$BackupConfigFile.'.';
$BackupScannedFilesCloud = $BackupScannedFilesBackup = $BackupCreatedFiles = $BackupRemovedFiles = $BackupCreatedFolders = $BackupRemovedFolders = $BackupReplacedFiles = 0;
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code loads the HRCloud2 configuration file.
if (!file_exists($BackupConfigFile)) die('ERROR!!! HRC2BackupCore15, Cannot process the HRCloud2 Config file ('.$BackupConfigFile.') on '.$BackupTime.'!'.PHP_EOL); 
else require_once($BackupConfigFile); 
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the script is being run as a cron task or shell script.
if (!isset($_POST['backupUserDataNow']) && !isset($_POST['backupNowToken']) && !isset($UserID)) {
  if (!isset($EnableBackups) or $EnableBackups !== '1') die();
  // / The following code checks if the $BackupLoc is defined in config.php and creates a $backupWarningLogFile if not. Also kills the script.
  if ((!isset($BackupLoc) or $BackupLoc == '') && !file_exists($backupWarningLogFile)) { 
  	file_put_contents($backupWarningLogFile, $backupWarningLogData); 
    die(); }
  // / The following code checks if the $backupWarningLogFile is still needed and deletes it if not.
  if (isset($BackupLoc) && file_exists($backupWarningLogFile)) unlink($backupWarningLogFile); 
  // / The following code checks if any CLI arguments are set and sets the execution flag if all checks have passed.
  if (isset($argv)) { 
    if ($argv[1] == 'execute') $ExecuteBackup = TRUE; } }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code checks if the script is being run via the API and checks that the session is authentic.
if (isset($_POST['backupUserDataNow']) && isset($_POST['backupNowToken']) && isset($UserID) && isset($UserIDRAW)) { 
  $BackupTokenHASH = hash('ripemd160', $Salts.$BackupLoc.$BackupDate.$UserID.$UserIDRAW);
  if ($_POST['backupNowToken'] !== $BackupTokenHASH or $UserIDRAW !== 1) die('ERROR!!! HRC2BackupCore31, The backup token was not valid on '.$BackupTime.'!'.PHP_EOL);
  $ExecuteBackup = TRUE; }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / The following code sync's the user data between the CloudLoc and the BackupLoc.
if ($ExecuteBackup == TRUE) { 
  // / The following code checks to be sure that the required directories exist before attempting to copy anything.
  if (!file_exists($BackupLoc))	@mkdir($BackupLoc);
  if (!file_exists($BackupLoc)) die('ERROR!!! HRC2BackupCore48, There was a problem creating a new BackupLoc on '.$BackupTime.'!'.PHP_EOL);   
  if (!file_exists($CloudLoc)) die('ERROR!!! HRC2BackupCore49, There was a problem creating a sync\'d copy of the Cloud directory in the BackupLoc on '.$BackupTime.'!'.PHP_EOL); 
  // / The following loop is what actually creates the sync'd copy of folders and files.
  foreach ($iterator = new \RecursiveIteratorIterator (
    new \RecursiveDirectoryIterator ($CloudLoc, \RecursiveDirectoryIterator::SKIP_DOTS),
    \RecursiveIteratorIterator::SELF_FIRST) as $item) {
    $BUL = $BackupLoc.DIRECTORY_SEPARATOR.$iterator->getSubPathName();
    $BackupScannedFilesCloud++;
    // / The following code checks if the selected item is a directory, and creates a backup copy if it is.
    if (is_dir($item)) {
      if (!is_dir($BUL)) {
        mkdir($BUL); 
        $BackupCreatedFolders++;
        continue; } }
    // / The following code checks if the selected item is a file, and creates a backup copy if it is.
    else if (file_exists($item) && !is_link($item) && !file_exists($BUL) && !is_link($BUL)) {
      copy($item, $BUL);
      $BackupCreatedFiles++; } }
  // / The following loop makes sure that the backup contains only the latest copy of files, and only files that still exist in the CloudLoc.
  foreach ($iterator = new \RecursiveIteratorIterator (
    new \RecursiveDirectoryIterator ($BackupLoc, \RecursiveDirectoryIterator::SKIP_DOTS),
    \RecursiveIteratorIterator::SELF_FIRST) as $item) {
    $CUL = $CloudLoc.DIRECTORY_SEPARATOR.$iterator->getSubPathName(); 
    $BackupScannedFilesBackup++;
    // / The following code checks if the selected item is a folder and if a matching Cloud folder is missing.
    if (!file_exists($CUL) && is_dir($item)) { 
      $CULFiles = @scandir($item); 
      // / The following code checks if the folder is empty, and deletes it if so.
      if (count($CULFiles) == 2) { 
      	rmdir($item); 
        $BackupRemovedFolders++; }
    // / The following code checks if the original user file was deleted and deletes the backup if needed.
    if (!file_exists($CUL) && file_exists($item) && !is_dir($item)) {
      unlink($item); 
      $BackupRemovedFiles++; }
    // / The following code checks if the Cloud file is newer than the Backup file, and replaces the backup if so.
    if (!is_link($CUL) && @filemtime($CUL) > @filemtime($item)) {
      unlink($item);
      copy($CUL, $item); 
      $BackupReplacedFiles++; } } } } 
  // / -----------------------------------------------------------------------------------
