<?php
// Example configuration file for PHP AntiVirus v1.3
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

// MEMORY LIMITS
// -----------------
// These options can be used to specify memory restrictions for
// PHP-AV. Anything larger than $memoryLimit (bytes) in bytes will be 
// chopped into $chunkSize (bytes). Each chunk is then scanned separately.

$memoryLimit = 4000000;
$chunkSize = 1000000;
?>