<?php

$input = preg_replace('/howto/',' ',$input); 
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);

if ($input == 'help with' or strpos($input, 'help with') == 'true' or $input == 'help me' or strpos($input, 'help me') == 'true') {  
  $output = $output.'For help with HRCloud2 or HRAI, please visit the official '."\n".'zelon88/HRCloud2 Github repo and open an issue.'."\n"; 
  echo nl2br ($output);
  echo nl2br ('<a href="https://github.com/zelon88/HRCloud2" target="parent"><i>github.com/zelon88/HRCloud2</i></a>'); }

if ($input == 'guidance' or strpos($input, 'guidance') == 'true' or $input == 'how to' or strpos($input, 'how to') == 'true' or
 $input == 'howto' or strpos($input, 'guidance') == 'true') {  
  $output = $output.'For guidance with HRCloud2 or HRAI, please visit the official '."\n".'zelon88/HRCloud2 Github repo and open an issue.'."\n"; 
  echo nl2br ($output);
  echo nl2br ('<a href="https://github.com/zelon88/HRCloud2" target="parent"><i>github.com/zelon88/HRCloud2</i></a>'); }