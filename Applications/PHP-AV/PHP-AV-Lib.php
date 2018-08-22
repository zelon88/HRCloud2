<?php
// / -----------------------------------------------------------------------------------
// / Functions
function file_scan($folder, $defs, $debug) {
  // Hunts files/folders recursively for scannable items.
  global $dircount, $report, $memoryLimit, $AVLogFile;  
  $defData = hash_file('sha256', 'virus.def');
  $dircount++;
  $txt = 'Scanning folder '.$folder.' ... ';
  $MAKELogFile = file_put_contents($AVLogFile, $txt.PHP_EOL, FILE_APPEND);
  if ($d = @dir($folder)) {
    while (false !== ($entry = $d->read())) {
      $isdir = @is_dir($folder.'/'.$entry);
      if (!$isdir and $entry != '.' and $entry != '..') {
        virus_check($folder.'/'.$entry, $defs, $debug, $defData); } 
      elseif ($isdir and $entry != '.' and $entry != '..') {
        file_scan($folder.'/'.$entry, $defs, $debug, $defData); } }
    $d->close(); } }

function load_defs($file, $debug) {
  // Reads tab-delimited defs file.
  global $AVLogFile;
  $defs = file($file);
  $counter = 0;
  $counttop = sizeof($defs);
  while ($counter < $counttop) {
    $defs[$counter] = explode('  ', $defs[$counter]);
    $counter++; }
  $txt = 'Loaded '.sizeof($defs).' virus definitions.';
  $MAKELogFile = file_put_contents($AVLogFile, $txt.PHP_EOL, FILE_APPEND);
  return $defs; }

function check_defs($file) {
  // Check for >755 perms on virus defs.
  clearstatcache();
  $perms = substr(decoct(fileperms($file)),-2);
  if ($perms > 55)
  return false;
  else
  return true; }

function virus_check($file, $defs, $debug, $defData) {
  // Hashes and checks files/folders for viruses against static virus defs.
  global $memoryLimit, $chunkSize, $filecount, $infected, $report, $CONFIG, $AVLogFile;
  $filecount++;
  if ($file !== $InstLoc.'/Applications/PHP-AV/virus.def') {
    if (file_exists($file)) { 
      $txt = 'Scanning file '.$file.' ... ';
      $MAKELogFile = file_put_contents($AVLogFile, $txt.PHP_EOL, FILE_APPEND);
      $filesize = filesize($file);
      $data1 = hash_file('md5', $file);
      $data2 = hash_file('sha256', $file);
      // / Scan files larger than the memory limit by breaking them into chunks.
      if ($filesize >= $memoryLimit && file_exists($file)) { 
        $txt = 'Chunking file ... ';
        $MAKELogFile = file_put_contents($AVLogFile, $txt.PHP_EOL, FILE_APPEND);
        $handle = @fopen($file, "r");
          if ($handle) {
            while (($buffer = fgets($handle, $chunkSize)) !== false) {
              $data = $buffer; 
              if ($debug) { 
                $txt = 'Scanning chunk ... ';
                $MAKELogFile = file_put_contents($AVLogFile, $txt.PHP_EOL, FILE_APPEND); }
              foreach ($defs as $virus) {
                $virus = explode("\t", $virus[0]);
                if (isset($virus[1]) && $virus[1] !== '' && $virus[1] !== ' ') {
                  if (strpos($data, $virus[1]) or strpos($file, $virus[1])) {
                    // File matches virus defs.
                    $txt = 'Infected: '.$file.' ('.$virus[0].', Data Match: '.$virus[1].')';
                    $MAKELogFile = file_put_contents($AVLogFile, $txt.PHP_EOL, FILE_APPEND);
                    $report .= '<p class="r">'.$txt.'</p>';
                    $infected++;
                    $clean = 0; } } } }
            if (!feof($handle)) {
              $txt = 'ERROR!!! PHPAV160, Unable to open '.$file.' on '.$Time.'!';
              $MAKELogFile = file_put_contents($AVLogFile, $txt.PHP_EOL, FILE_APPEND);
              $report .= '<p class="r">'.$txt.'</p>'; }
          fclose($handle); } 
          if (isset($virus[2]) && $virus[2] !== '' && $virus[2] !== ' ') {
            if (strpos($data1, $virus[2])) {
              // File matches virus defs.
              $txt = 'Infected: '.$file.' ('.$virus[0].', MD5 Hash Match: '.$virus[2].')';
              $MAKELogFile = file_put_contents($AVLogFile, $txt.PHP_EOL, FILE_APPEND);
              $report .= '<p class="r">'.$txt.'</p>';
              $infected++;
              $clean = 0; } }
           if (isset($virus[3]) && $virus[3] !== '' && $virus[3] !== ' ') {
            if (strpos($data2, $virus[3])) {
              // File matches virus defs.
              $txt = 'Infected: '.$file.' ('.$virus[0].', SHA256 Hash Match: '.$virus[3].')';
              $MAKELogFile = file_put_contents($AVLogFile, $txt.PHP_EOL, FILE_APPEND);
              $report .= '<p class="r">'.$txt.'</p>';
              $infected++;
              $clean = 0; } } } } }
      // / Scan files smaller than the memory limit by fitting the entire file into memory.
      if ($filesize < $memoryLimit && file_exists($file)) {
        $data = file_get_contents($file); }
      if ($defData !== $data2) {
         $clean = 1;
        foreach ($defs as $virus) {
          $virus = explode("\t", $virus[0]);
          $filesize = @filesize($file);
          if (isset($virus[1]) && $virus[1] !== '' && $virus[1] !== ' ') {
            if (strpos($data, $virus[1])) {
             // File matches virus defs.
              $txt = 'Infected: '.$file.' ('.$virus[0].', Data Match: '.$virus[1].')';
              $MAKELogFile = file_put_contents($AVLogFile, $txt.PHP_EOL, FILE_APPEND);
              $report .= '<p class="r">'.$txt.'</p>';
              $infected++;
              $clean = 0; } }
          if (isset($virus[2]) && $virus[2] !== '' && $virus[2] !== ' ') {
            if (strpos($data1, $virus[2])) {
                // File matches virus defs.
              $txt = 'Infected: '.$file.' ('.$virus[0].', MD5 Hash Match: '.$virus[2].')';
              $MAKELogFile = file_put_contents($AVLogFile, $txt.PHP_EOL, FILE_APPEND);
              $report .= '<p class="r">'.$txt.'</p>';
              $infected++;
              $clean = 0; } }
           if (isset($virus[3]) && $virus[3] !== '' && $virus[3] !== ' ') {
            if (strpos($data2, $virus[3])) {
                // File matches virus defs.
              $txt = 'Infected: '.$file.' ('.$virus[0].', SHA256 Hash Match: '.$virus[3].')';
              $MAKELogFile = file_put_contents($AVLogFile, $txt.PHP_EOL, FILE_APPEND);
              $report .= '<p class="r">'.$txt.'</p>';
              $infected++;
               $clean = 0; } } }
         if (($debug) && ($clean)) {
          $report .= '<p class="g">Clean: '.$file.'</p>'; } } }
// / -----------------------------------------------------------------------------------
?>