<?php
// Example configuration file for PHP AntiVirus v1.0.2
// Please read INSTALL before editing this file.

// DEBUG MODE
// ----------
// Uncomment this option to enable 'debug' mode
// You will receive verbose reports including clean & infected
// files, as well as debug information for file reading and
// database connections.
// Default: Off (0)

$CONFIG['debug'] = 0;

// ROOT PATH TO SCAN
// -----------------
// This can be a relative or full path WITHOUT a trailing
// slash. All files and folders will be recursively scanned
// within this path. NB: Due to your web host's configuration
// it is likely this script will be terminated after 30-60
// seconds of continuous operation. Please keep an eye on
// the number of files inside this directory - if it is too
// large it may fail.
// Default: Document root defined in Apache

$CONFIG['scanpath'] = $CONFIG['scanpath'];

// SCANABLE FILES
// --------------
// The next few lines tell PHP AntiVirus what files to scan
// within the directory set above. It does it by file
// extension (the text after the period or dot in the file
// name) - for example "htm", "html" or "php" files.
// Default: None

// Static files? This should be a comprehensive list, add
// more if required.

$CONFIG['extensions'][] = 'htm';
$CONFIG['extensions'][] = 'html';
$CONFIG['extensions'][] = 'shtm';
$CONFIG['extensions'][] = 'shtml';
$CONFIG['extensions'][] = 'css';
$CONFIG['extensions'][] = 'js';
$CONFIG['extensions'][] = 'vbs';

// PHP files? This should be a comprehensive list, add more
// if required.

$CONFIG['extensions'][] = 'php';
$CONFIG['extensions'][] = 'php3';
$CONFIG['extensions'][] = 'php4';
$CONFIG['extensions'][] = 'php5';

// Text files? Virus code is harmless but invasive,
// although uncommenting these lines may cause false
// positives.

$CONFIG['extensions'][] = 'txt';
$CONFIG['extensions'][] = 'rtf';
$CONFIG['extensions'][] = 'doc';
$CONFIG['extensions'][] = 'conf';
$CONFIG['extensions'][] = 'dat';

// Flat file data? Only enable these if you regularly store
// data in flat files.

$CONFIG['extensions'][] = 'conf';
$CONFIG['extensions'][] = 'config';
$CONFIG['extensions'][] = 'csv';
$CONFIG['extensions'][] = 'tab';
$CONFIG['extensions'][] = 'sql';

// CGI scripts? Unlikely but entirely possible.

$CONFIG['extensions'][] = 'pl';
$CONFIG['extensions'][] = 'perl';
$CONFIG['extensions'][] = 'cgi';
$CONFIG['extensions'][] = '';
?>