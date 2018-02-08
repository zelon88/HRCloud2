<?php

// / This is a special CoreCommand file that DOES NOT conform to the
  // / HRAI CoreCommand "CMD" format. 

// / NOTE TO DEVELOPERS !!!
// / Apps that parse cleanly, without any echo's, can ignore the HRAI "CMD" plugin
  // / format. Be aware that the code will be parsed, and if conditions are not set
  // / carefully they will be executed !!!

// / --------------------------------------
set_time_limit(0);
$CoreGreetings = array('hello','hi','hey','sup',);
$BasicTimeofDay = array('morning','noon','afternoon','evening','night');
// / Return a specific basic greeting depending on time of day.
if ($user_ID == '0') {
  $output = ('You are not logged in! This session is temporary! '."\r"); }
// / Set time specific basic responses.
$timeGreeting = 'Hello, ';
$StopTime = '0';
// / Code for modning specific responses.
  if (date("H") <= '12' && date("H") > '3') {
    if (preg_match('/good morning/',$input)) { 
      $output = ($output.'Good morning, '.$nickname.'!'."\r"); 
      $input = preg_replace('/good morning/','',$input);
      $input = str_replace('good morning','',$input); }
    if (preg_match('/good afternoon/',$input)) {
      $output = ($output.'It\'s only '.$hour.', '.$nickname.'.'."\r"); 
      $input = preg_replace('/good afternoon/','',$input);
      $input = str_replace('good afternoon','',$input); }
    if (preg_match('/good day/',$input)) {
      $output = ($output.'It\'s only '.$hour.', '.$nickname.'.'."\r");  
      $input = preg_replace('/good day/','',$input);
      $input = str_replace('good day ','',$input); }
    if (preg_match('/good evening/',$input)) {
      $output = ($output.'It\'s only '.$hour.', '.$nickname.'.'."\r"); 
      $input = preg_replace('/good evening/','',$input);
      $input = str_replace('good evening','',$input); }
    if (preg_match('/good night/',$input)) {
      $output = ($output.'Goodnight, '.$nickname.'.'."\r"); 
      $input = preg_replace('/good night/','',$input);
      $input = str_replace('goodnight','',$input); }
    if (preg_match('/goodnight/',$input)) { 
      $output = ($output.'Goodnight, '.$nickname.'.'."\r"); 
      $input = preg_replace('/goodnight/','',$input);
      $input = str_replace('goodnight','',$input); }
    $timeGreeting = 'Good morning, '; }
// / Code for afternoon specific responses.
if ($StopTime == '0') {
  if (date("H") >= '12' && date("H") <= '18') {  
    if (preg_match('/good afternoon/',$input)) {
      $output = ($output.'It has been so far, '.$nickname.'!'."\r"); 
      $input = preg_replace('/good afternoon/','',$input);
      $input = str_replace('good afternoon','',$input); }
    if (preg_match('/good day/',$input)) {
      $output = ($output.'It has been so far, '.$nickname.'!'."\r"); 
      $input = preg_replace('/good day/','',$input);
      $input = str_replace('good day ','',$input); }
    if (preg_match('/good morning/',$input)) {
      $output = ($output.'It\'s '.$hour.', '.$nickname.'.'."\r"); 
      $input = preg_replace('/good morning/','',$input);
      $input = str_replace('good morning','',$input); }
    if (preg_match('/good evening/',$input)) {
      $output = ($output.'It\'s still only '.$hour.', '.$nickname.'.'."\r"); 
      $input = preg_replace('/good evening/','',$input);
      $input = str_replace('good evening','',$input); }
    if (preg_match('/good night/',$input)) {
      $output = ($output.'Goodnight, although it\'s only '.$hour.', '.$nickname.'.'."\r"); 
      $input = preg_replace('/good night/','',$input);
      $input = str_replace('good night','',$input); }
    if (preg_match('/goodnight/',$input)) {
      $output = ($output.'Goodnight, although it\'s only '.$hour.', '.$nickname.'.'."\r"); 
      $input = preg_replace('/goodnight/','',$input);
      $input = str_replace('goodnight','',$input); }
    $timeGreeting = 'Good afternoon, '; 
    $StopTime++; } }
// / Code for evening specific responses.
if ($StopTime == '0') {
  if (date("H") >= '18' or date("H") <= '3') {
    if (preg_match('/good evening/',$input)) {
      $output = ($output.'Yes, '.$nickname.'. It has been.'."\r"); 
      $input = preg_replace('/good evening/','',$input);
      $input = str_replace('good evening','',$input); }
    if (date("H") >= '3' && date("H") <= '12') {
      if (preg_match('/good morning/',$input)) {
        $output = ($output.'Yes, '.$nickname.'. It has been.'."\r"); 
        $input = preg_replace('/good morning/','',$input);
        $input = str_replace('good morning','',$input); } }
    if (date("H") >= '3' or date("H") <= '12' or date("H") > '20') {
      if (preg_match('/good morning/',$input)) {      
      $output = ($output.'It\'s '.$hour.', '.$nickname.'.'."\r"); 
      $input = preg_replace('/good morning/','',$input);
      $input = str_replace('good morning','',$input); } }
    if (preg_match('/good afternoon/',$input)) {
      $output = ($output.'It\'s '.$hour.', '.$nickname.'.'."\r"); 
      $input = preg_replace('/good afternoon/','',$input);
      $input = str_replace('good afternoon','',$input); }
    if (preg_match('/good day/',$input)) {
      $output = ($output.'It\'s '.$hour.', '.$nickname.'.'."\r");  
      $input = preg_replace('/good day/','',$input);
      $input = str_replace('good day ','',$input); }
    if (preg_match('/good night/',$input)) {
      $output = ($output.'Yes, it was. Goodnight, '.$nickname.'.'."\r"); 
      $input = preg_replace('/good night/','',$input);
      $input = str_replace('good night','',$input); }
    if (preg_match('/goodnight/',$input)) {
      $output = ($output.'Yes, it was. Goodnight, '.$nickname.'.'."\r"); 
      $input = preg_replace('/goodnight/','',$input);
      $input = str_replace('goodnight','',$input); }
    $timeGreeting = 'Good evening, '; 
    $StopTime++; } }
// / First we respond to basic greetings.
if (preg_match('/hello/',$input)) {
  $output = ($output.$timeGreeting.''.$nickname.'! '."\r"); 
  $input = preg_replace('/hello/','',$input);
  $input = str_replace('hello ','',$input); }
if (preg_match('/hi/',$input)) {
  $output = ($output.$timeGreeting.''.$nickname.'! '."\r");
  $input = preg_replace('/hi/','',$input); 
  $input = str_replace('hi ','',$input); }
if (preg_match('/hey/',$input)){
  $output = ($output.$timeGreeting.''.$nickname.'! '."\r");
  $input = preg_replace('/hey/','',$input);
  $input = str_replace('hey ','',$input); }
if (preg_match('/sup/',$input)) {
  $output = ($output.$timeGreeting.''.$nickname.'! '."\r");
  $input = preg_replace('/sup/','',$input);
  $input = str_replace('sup ','',$input); }
// / Remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$first6 = substr($input, 0, 6);
if ($first6 == 'please') {
  $output = ($output.'Of course! '."\r");  
  $input = preg_replace('/please /', '', $input); }
$last6 = substr($input, 0, -6);
if ($last6 == 'please') {
  $output = ($output.'Of course! '."\r"); 
  $input = str_replace(' please/', '', $input); }
// / Remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
if (preg_match('/plz/', $input)) {
  $output = ($output.'No problem, '.$nickname.'! '."\r");  
  $input = str_replace('plz','',$input); }
if (preg_match('/please/', $input)) {
  $output = ($output.'Of course, '.$nickname.'! '."\r");  
  $input = str_replace('please','',$input); }
if (preg_match('/thank you/', $input)) {
  $output = ($output.'My pleasure. '."\r"); 
  $input = str_replace('/ please/', '', $input); } 
if (preg_match('/thanks/', $input)) {
  $output = ($output.'Anytime, '.$nickname.'! '."\r");  
  $input = str_replace('thanks','',$input); }
if (preg_match('/thx/', $input)) {
  $output = ($output.'No problem, '.$nickname.'! '."\r");  
  $input = str_replace('thx','',$input); }
if (preg_match('/your name/', $input)){
  $output = ($output.'HRAI! '."\r");  
  $input = str_replace('your name','',$input); }
if (preg_match('/whats your name/', $input)) {
  $output = ($output.'HRAI! '."\r");  
  $input = str_replace('whats your name','',$input); }
if (preg_match('/what is your name/', $input)) {
  $output = ($output.'HRAI! '."\r");  
  $input = str_replace('what is your name','',$input); }
// / Remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);

echo nl2br ($output);