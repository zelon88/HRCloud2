<?php
 
$inputMATCH = array('tell me a joke', 'got any jokes', 'let me hear a joke', 'can i hear a joke', 
 'do you have jokes', 'do you have any jokes', 'tell me something funny', 'make me laugh', 'say something funny', 'cheer me up');
$responses = array('What does a user-interface and a joke have in common?<br />If you have to explain them they\'re not good.', 
 'I do but none of them are funny',
 'Here\'s my favorite joke: 01010111 01101001 01101110 01100100 01101111 01110111 01110011 00100000 01011000 01010000',
 'A programmers wife asked her husband to go to the store and get a gallon of milk. If they have eggs he should get a dozen. He returned some time later with twelve gallons of milk. When his wife asked why he had so much milk the programmer replied, "They had eggs."',
  'Half-Life 3 will be released within 12 months.',
  'The Browns are going to win the next super-bowl.',
  'I just wrote a song about tortillas. Actually, it\'s more of a wrap.',
  'I hate Russian dolls. They\'re always so full of themselves',
  'If humans shouldn\'t eat at night, why do refrigerators have light bulbs?',
  'So I got arrested the other night. The officer called for papers but I called scissors.',
  'In the army when you lose your rifle they charge you $85. That\'s why in the navy the captain goes down with the ship.',
  'Confrence calls are great if you enjoy saying "Goodbye" 300 times.',
  'I got fired today. My boss asked why I\'ve been having so much car trouble lately and I told him, "I always try to put the key into the ignition three times but sometimes I just can\'t bring myself to do it."',
  'All my jokes are "yo mama" jokes, and I\'ve already received a warning from human resources.',
  'Why did Elon Musk go broke? Because his car insurance rates were out-of-control.');
$CMDcounter++;

if (isset($input)) {
  foreach ($inputMATCH as $inputM1) {
    if (preg_match('/'.$inputM1.'/', $input)) {
      $CMDinit[$CMDcounter] = 1;
      $input = preg_replace('/'.$inputM1.'/',' ',$input); 
      $randomKey = array_rand($responses);
      $output = $responses[$randomKey];
      echo($output.'<br />'); } } }

$input = str_replace('   ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
$input = ltrim($input);