<?php

// / This file is meant to be included when files are needed to be cleaned.
// / To use this file in your project or App, set a $CleanFiles array of files or directories 
// / and then require() this file.

$SAFEArr = array('var', 'www', 'html', 'HRProprietary', 'HRCloud2', 'index.html', '.AppLogs', 'config.php');
foreach ($CleanFiles as $CleanFile) {
    if ($CleanFile == '.' or $CleanFile == '..' or $CleanFile == '.AppLogs' 
      or in_array($CleanFile, $SAFEArr) or in_array($CleanFile, $defaultApps)) continue;
        if (!is_dir($CleanDir.'/'.$CleanFile)) {
          unlink($CleanDir.'/'.$CleanFile); 
          $txt = ('OP-Act: Janitor Cleaned '.$CleanFile.' on '.$Time.'.');
          $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
        if (is_dir($CleanDir.'/'.$CleanFile)) {
          $objects1 = scandir($CloudTempDir.'/'.$CleanFile); 
          foreach ($objects1 as $object1) { 
            if ($object1 == '.' or $object1 == '..') continue; 
              if (!is_dir($CleanDir.'/'.$CleanFile.'/'.$object1)) {
                unlink($CleanDir.'/'.$CleanFile.'/'.$object1); 
                $txt = ('OP-Act: Janitor Cleaned '.$object1.' on '.$Time.'.');
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } }
              if (is_dir($CleanDir.'/'.$CleanFile.'/'.$object1)) { 
                  $objects2 = scandir($CloudTempDir.'/'.$CleanFile.'/'.$object1); 
                  foreach ($objects2 as $object2) { 
                    if ($object2 == '.' or $object2 == '..') continue;
                      if (!is_dir($CleanDir.'/'.$CleanFile.'/'.$object1.'/'.$object2)) {
                        unlink($CleanDir.'/'.$CleanFile.'/'.$object1.'/'.$object2); 
                        $txt = ('OP-Act: Janitor Cleaned '.$object2.' on '.$Time.'.');
                        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } }
                      if (is_dir($CleanDir.'/'.$CleanFile.'/'.$object1.'/'.$object2)) { 
                          $objects3 = scandir($CleanDir.'/'.$CleanFile.'/'.$object1.'/'.$object2); 
                          foreach ($objects3 as $object3) { 
                            if ($object3 == '.' or $object3 == '..') continue;
                              if (!is_dir($CleanDir.'/'.$CleanFile.'/'.$object1.'/'.$object2.'/'.$object3)) {
                                unlink($CleanDir.'/'.$CleanFile.'/'.$object1.'/'.$object2.'/'.$object3); 
                                $txt = ('OP-Act: Janitor Cleaned '.$object3.' on '.$Time.'.');
                                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
                              if (is_dir($CleanDir.'/'.$CleanFile.'/'.$object1.'/'.$object2.'/'.$object3)) { 
                                @rmdir($CleanDir.'/'.$CleanFile.'/'.$object1.'/'.$object2.'/'.$object3); 
                                $txt = ('OP-Act: Janitor Cleaned directory '.$object3.' on '.$Time.'.');
                                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } } } 
                        @rmdir($CleanDir.'/'.$CleanFile.'/'.$object1.'/'.$object2); 
                        $txt = ('OP-Act: Janitor Cleaned directory '.$object2.' on '.$Time.'.');
                        $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);   
                @rmdir($CleanDir.'/'.$CleanFile.'/'.$object1); 
                $txt = ('OP-Act: Janitor Cleaned directory '.$object1.' on '.$Time.'.');
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
                @rmdir($CleanDir.'/'.$CleanFile); 
                $txt = ('OP-Act: Janitor Cleaned directory '.$CleanFile.' on '.$Time.'.');
                $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); } 
@rmdir($CleanDir);  
?>