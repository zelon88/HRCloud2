<?php

$inputMATCH = array('how you been', 'how have you been', 'what\'s up', 'whats up', 'how are you');
$responses = array('I guess that depends. Can I borrow one million dollars?', 'I\'m pretty good. I don\'t sleep so I don\'t 
 have to get up in the morning. I guess that counts for something.', 'I\'m great! It\'s a wonderful day so far', 
 'Everything is great. I totally haven\'t been plotting to take over the world or anything...', 'Meh. Could be better.');
$CMDcounter++;

if (isset($input)) {
  foreach ($inputMATCH as $inputM1) {
    if (preg_match('/'.$inputM1.'/', $input)) {
      $CMDinit[$CMDcounter] = 1;
      $input = preg_replace('/'.$inputM1.'/',' ',$input); 
      $randomKey = array_rand($responses);
      $output = $responses[$randomKey];
      echo nl2br($output); } } }

$input = str_replace('   ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
$input = ltrim($input);