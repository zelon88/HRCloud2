<?php
// / -----------------------------------------------------------------------------------
// / Functions
function file_scan($folder, $defs, $debug) {
  // Hunts files/folders recursively for scannable items.
  $defData = hash_file('sha256', 'virus.def');
  global $dircount, $report, $memoryLimit;
  $dircount++;
  if ($debug)
    $report .= '<p class="d">Scanning folder $folder ...</p>';
    if ($d = @dir($folder)) {
      while (false !== ($entry = $d->read())) {
        $isdir = @is_dir($folder.'/'.$entry);
        if (!$isdir and $entry!='.' and $entry!='..') {
          virus_check($folder.'/'.$entry, $defs, $debug, $defData); } 
        elseif ($isdir  and $entry !='.' and $entry!='..') {
          file_scan($folder.'/'.$entry, $defs, $debug, $defData); } }
      $d->close(); } }

function load_defs($file, $debug) {
  // Reads tab-delimited defs file.
  $defs = file($file);
  $counter = 0;
  $counttop = sizeof($defs);
  while ($counter < $counttop) {
	$defs[$counter] = explode('	', $defs[$counter]);
	$counter++; }
if ($debug)
  echo '<p>Loaded '.sizeof($defs).' virus definitions</p>';
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
  global $memoryLimit, $chunkSize, $filecount, $infected, $report, $CONFIG;
	$filecount++;
	if ($file !== $InstLoc.'/Applications/PHP-AV/virus.def') {
	  if (file_exists($file)) { 
	  	$filesize = filesize($file);
      // / Scan files larger than the memory limit by breaking them into chunks.
      if ($filesize >= $memoryLimit && file_exists($file)) {
        $handle = @fopen($file, "r");
          if ($handle) {
            while (($buffer = fgets($handle, $chunkSize)) !== false) {
              $data = $buffer;
              foreach ($defs as $virus) {
                if ($virus[1] !== '') {
                  if (strpos($data, $virus[1]) or strpos($file, $virus[1])) {
                   // File matches virus defs.
                   $report .= '<p class="r">Infected: '.$file.' ('.$virus[0].', Data Match: '.$virus[1].')</p>';
                   $infected++;
                   $clean = 0; } } } }
            if (!feof($handle)) {
              echo 'ERROR!!! PHPAV160, Unable to open '.$file.' on '.$Time.'.'.\n; }
          fclose($handle); } 
          if ($virus[2] !== '') {
            if (strpos($data1, $virus[2])) {
                // File matches virus defs.
              $report .= '<p class="r">Infected: '.$file.' ('.$virus[0].', MD5 Hash Match: '.$virus[2].')</p>';
              $infected++;
              $clean = 0; } }
           if ($virus[3] !== '') {
            if (strpos($data2, $virus[3])) {
                // File matches virus defs.
              $report .= '<p class="r">Infected: '.$file.' ('.$virus[0].', SHA256 Hash Match: '.$virus[3].')</p>';
              $infected++;
              $clean = 0; } } } } }
      // / Scan files smaller than the memory limit by fitting the entire file into memory.
      if ($filesize < $memoryLimit && file_exists($file)) {
        $data = file($file);
	      $data = implode('\r\n', $data); }
	    if (file_exists($file)) {
        $data1 = md5_file($file);
	      $data2 = hash_file('sha256', $file); }
      if (!file_exists($file)) {
        $data1 = '';
        $data2 = ''; }
      if ($defData !== $data2) {
	       $clean = 1;
	      foreach ($defs as $virus) {
	        $filesize = @filesize($file);
		      if ($virus[1] !== '') {
		        if (strpos($data, $virus[1])) {
			       // File matches virus defs.
			       $report .= '<p class="r">Infected: '.$file.' ('.$virus[0].', Data Match: '.$virus[1].')</p>';
			       $infected++;
			       $clean = 0; } }
		      if ($virus[2] !== '') {
            if (strpos($data1, $virus[2])) {
			          // File matches virus defs.
			        $report .= '<p class="r">Infected: '.$file.' ('.$virus[0].', MD5 Hash Match: '.$virus[2].')</p>';
			        $infected++;
			        $clean = 0; } }
		       if ($virus[3] !== '') {
            if (strpos($data2, $virus[3])) {
			          // File matches virus defs.
			        $report .= '<p class="r">Infected: '.$file.' ('.$virus[0].', SHA256 Hash Match: '.$virus[3].')</p>';
			        $infected++;
			         $clean = 0; } } }
	       if (($debug)&&($clean)) {
		      $report .= '<p class="g">Clean: '.$file.'</p>'; } } } 
// / -----------------------------------------------------------------------------------
?>