<?php

if ($input == 'help with' or strpos($input, 'help with') == 'true') {  
echo nl2br('For help with HRCloud2 or HRAI, please visit the official '."\n".'zelon88/HRCloud2 Github repo and open an issue.'."\n".
  '<a href="https://github.com/zelon88/HRCloud2" target="parent"><i>github.com/zelon88/HRCloud2</i></a>'); 
$input = preg_replace('/help with/',' ',$input); }
if ($input == 'help me' or strpos($input, 'help me') == 'true') {  
echo nl2br('For help with HRCloud2 or HRAI, please visit the official '."\n".'zelon88/HRCloud2 Github repo and open an issue.'."\n".
  '<a href="https://github.com/zelon88/HRCloud2" target="parent"><i>github.com/zelon88/HRCloud2</i></a>'); 
$input = preg_replace('/help me/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);

if ($input == 'guidance' or strpos($input, 'guidance') == 'true') {  
echo nl2br('For guidance with HRCloud2 or HRAI, please visit the official '."\n".'zelon88/HRCloud2 Github repo and open an issue.'."\n".
  '<a href="https://github.com/zelon88/HRCloud2" target="parent"><i>github.com/zelon88/HRCloud2</i></a>'); 
$input = preg_replace('/help/',' ',$input); }
if ($input == 'how to' or strpos($input, 'how to') == 'true') {  
echo nl2br('For guidance with HRCloud2 or HRAI, please visit the official '."\n".'zelon88/HRCloud2 Github repo and open an issue.'."\n".
  '<a href="https://github.com/zelon88/HRCloud2" target="parent"><i>github.com/zelon88/HRCloud2</i></a>'); 
$input = preg_replace('/how to/',' ',$input); }
if ($input == 'howto' or strpos($input, 'guidance') == 'true') {  
echo nl2br('For guidance with HRCloud2 or HRAI, please visit the official '."\n".'zelon88/HRCloud2 Github repo and open an issue.'."\n".
  '<a href="https://github.com/zelon88/HRCloud2" target="parent"><i>github.com/zelon88/HRCloud2</i></a>'); 
$input = preg_replace('/howto/',' ',$input); }
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
