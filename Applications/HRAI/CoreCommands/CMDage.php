<?php

$inputMATCH = array('how old are you', 'what is your age', 'whats your age', 'when were you born', 'what is your birthday');
$responses = array('My first stable version was written in 2015. I was developed as a closed-source experiment in automated network integration, load balancing, and human-language command processing for the HonestRepair Cloud network.', 
 'I was born in 2015. I am '.(date("Y")-2015).' years old.',
 'I prefer to think of myself in terms of version number. I am '.$HRAI_VERSION.'.');
$CMDcounter++;
$CMDinit[$CMDcounter] = 0;

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