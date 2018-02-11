<?php

// / --------------------------------------
$CMDcounter++;
set_time_limit(0);
$CoreGreetings = array('hello', 'hi', 'hey', 'sup',);
$BasicTimeofDay = array('morning', 'noon', 'afternoon', 'evening', 'night');
// / Return a specific basic greeting depending on time of day.
if ($user_ID == '0') {
  $output = ('You are not logged in! This session is temporary! '."\r"); }
// / Set time specific basic responses.
$timeGreeting = 'Hello, ';
$StopTime = '0';
// / Code for modning specific responses.
if (date("H") <= '12' && date("H") > '3') {
  if (preg_match('/good morning/', $input)) { 
    $output = ('Good morning, '.$nickname.'!'."\r"); 
    $input = preg_replace('/good morning/', '', $input); 
    $fireOutput = 1; }
  if (preg_match('/good afternoon/', $input)) {
    $output = ('It\'s only '.$hour.', '.$nickname.'.'."\r"); 
    $input = preg_replace('/good afternoon/', '', $input); 
    $fireOutput = 1; }
  if (preg_match('/good day/', $input)) {
    $output = ('It\'s only '.$hour.', '.$nickname.'.'."\r");  
    $input = preg_replace('/good day/', '', $input); 
    $fireOutput = 1; }
  if (preg_match('/good evening/', $input)) {
    $output = ('It\'s only '.$hour.', '.$nickname.'.'."\r"); 
    $input = preg_replace('/good evening/', '', $input); 
    $fireOutput = 1; }
  if (preg_match('/good night/', $input)) {
    $output = ('Goodnight, '.$nickname.'.'."\r"); 
    $input = preg_replace('/good night/', '', $input); 
    $fireOutput = 1; }
  if (preg_match('/goodnight/', $input)) { 
    $output = ('Goodnight, '.$nickname.'.'."\r"); 
    $input = preg_replace('/goodnight/', '', $input); 
    $fireOutput = 1; }
  $timeGreeting = 'Good morning, '; }
// / Code for afternoon specific responses.
if ($StopTime == '0') {
  if (date("H") >= '12' && date("H") <= '17') {  
    if (preg_match('/good afternoon/', $input)) {
      $output = ('It has been so far, '.$nickname.'!'."\r"); 
      $input = preg_replace('/good afternoon/', '', $input); 
      $fireOutput = 1; }
    if (preg_match('/good day/', $input)) {
      $output = ('It has been so far, '.$nickname.'!'."\r"); 
      $input = preg_replace('/good day/', '', $input); 
      $fireOutput = 1; }
    if (preg_match('/good morning/', $input)) {
      $output = ('It\'s '.$hour.', '.$nickname.'.'."\r"); 
      $input = preg_replace('/good morning/', '', $input); 
      $fireOutput = 1; }
    if (preg_match('/good evening/', $input)) {
      $output = ('It\'s still only '.$hour.', '.$nickname.'.'."\r"); 
      $input = preg_replace('/good evening/', '', $input); 
      $fireOutput = 1; }
    if (preg_match('/good night/', $input)) {
      $output = ('Goodnight, although it\'s only '.$hour.', '.$nickname.'.'."\r"); 
      $input = preg_replace('/good night/', '', $input); 
      $fireOutput = 1; }
    if (preg_match('/goodnight/', $input)) {
      $output = ('Goodnight, although it\'s only '.$hour.', '.$nickname.'.'."\r"); 
      $input = preg_replace('/goodnight/', '', $input); 
      $fireOutput = 1; }
    $timeGreeting = 'Good afternoon, '; 
    $StopTime++; } }
// / Code for evening specific responses.
if ($StopTime == '0') {
  if (date("H") >= '17' or date("H") <= '3') {
    if (preg_match('/good evening/', $input)) {
      $output = ('Yes, '.$nickname.'. It has been.'."\r"); 
      $input = preg_replace('/good evening/', '', $input); 
      $fireOutput = 1; }
    if (date("H") >= '3' && date("H") <= '12') {
      if (preg_match('/good morning/', $input)) {
        $output = ('Yes, '.$nickname.'. It has been.'."\r"); 
        $input = preg_replace('/good morning/', '', $input); 
        $fireOutput = 1; } }
    if (date("H") >= '3' or date("H") <= '12' or date("H") > '20') {
      if (preg_match('/good morning/', $input)) {      
      $output = ('It\'s '.$hour.', '.$nickname.'.'."\r"); 
      $input = preg_replace('/good morning/', '', $input); 
      $fireOutput = 1; } }
    if (preg_match('/good afternoon/', $input)) {
      $output = ('It\'s '.$hour.', '.$nickname.'.'."\r"); 
      $input = preg_replace('/good afternoon/', '', $input);
      $fireOutput = 1; }
    if (preg_match('/good day/', $input)) {
      $output = ('It\'s '.$hour.', '.$nickname.'.'."\r");  
      $input = preg_replace('/good day/', '', $input);
      $fireOutput = 1; }
    if (preg_match('/good night/', $input)) {
      $output = ('Yes, it was. Goodnight, '.$nickname.'.'."\r"); 
      $input = preg_replace('/good night/', '', $input); 
      $fireOutput = 1; }
    if (preg_match('/goodnight/', $input)) {
      $output = ('Yes, it was. Goodnight, '.$nickname.'.'."\r"); 
      $input = preg_replace('/goodnight/', '', $input); 
      $fireOutput = 1; }
    $timeGreeting = 'Good evening, '; 
    $StopTime++; } }
// / Remove any incidental double spaces.
$input = str_replace('  ', ' ', $input);
$input = str_replace('  ', ' ', $input);
// / Respond to basic greetings.
if (preg_match('/hello/', $input)) {
  $output = ($timeGreeting.''.$nickname.'! '."\r"); 
  $input = preg_replace('/hello/', '', $input); 
  $fireOutput = 1; }
if (preg_match('/hi/', $input)) {
  $output = ($timeGreeting.''.$nickname.'! '."\r");
  $input = preg_replace('/hi/', '', $input);  
  $fireOutput = 1; }
if (preg_match('/hey/', $input)){
  $output = ($timeGreeting.''.$nickname.'! '."\r");
  $input = preg_replace('/hey/', '', $input); 
  $fireOutput = 1; }
if (preg_match('/sup/', $input)) {
  $output = ($timeGreeting.''.$nickname.'! '."\r");
  $input = preg_replace('/sup/', '', $input); 
  $fireOutput = 1; }

if ($fireOutput == 1) {
  echo nl2br ($output);
  $fireOutput = 0; }
