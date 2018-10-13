<?php

// / --------------------------------------
$CMDcounter++;
set_time_limit(0);
// / Return a specific basic greeting depending on time of day.
if ($user_ID == '0') {
  $output = ('You are not logged in! This session is temporary! <br />'); }

$first6 = substr($input, 0, 6);
if ($first6 == 'please') {
  $output = ('Of course! <br />');  
  $input = preg_replace('/please /', '', $input); 
  $fireOutput = 1; }
$last6 = substr($input, 0, -6);
if ($last6 == 'please') {
  $output = ('Of course! <br />'); 
  $input = str_replace(' please/', '', $input); 
  $fireOutput = 1; }
// / Remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
if (preg_match('/plz/', $input)) {
  $output = ('No problem, '.$nickname.'! <br />');  
  $input = str_replace('plz','',$input); 
  $fireOutput = 1; }
if (preg_match('/please/', $input)) {
  $output = ('Of course, '.$nickname.'! <br />');  
  $input = str_replace('please','',$input); 
  $fireOutput = 1; }
if (preg_match('/thank you/', $input)) {
  $output = ('My pleasure. <br />'); 
  $input = str_replace('/ please/', '', $input); } 
if (preg_match('/thanks/', $input)) {
  $output = ('Anytime, '.$nickname.'! <br />');  
  $input = str_replace('thanks','',$input); 
  $fireOutput = 1; }
if (preg_match('/thx/', $input)) {
  $output = ('No problem, '.$nickname.'! <br />');  
  $input = str_replace('thx','',$input); 
  $fireOutput = 1; }
if (preg_match('/your name/', $input)){
  $output = ('HRAI! <br />');  
  $input = str_replace('your name','',$input); 
  $fireOutput = 1; }
if (preg_match('/whats your name/', $input)) {
  $output = ('HRAI! <br />');  
  $input = str_replace('whats your name','',$input); 
  $fireOutput = 1; }
if (preg_match('/what is your name/', $input)) {
  $output = ('HRAI! <br />');  
  $input = str_replace('what is your name','',$input); 
  $fireOutput = 1; }
// / Remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);

if ($fireOutput == 1) {
  echo($output.'<br />');
  $fireOutput = 0; }
