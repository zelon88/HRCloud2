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
$BasicTimeofDay = array('moirning','noon','afternoon','evening','night');
// / Return a specific basic greeting depending on time of day.
if ($user_ID == '0') {
  echo nl2br('You are not logged in! This session is temporary! '."\r"); 
  echo nl2br ('<form action="core.php"><div align="center"><p><input type="submit" name="refresh" id="refresh" href="#" target="_parent" value="&#x21BA" class="button" onclick="toggle_visibility("loadingCommandDiv");"></p></div></form>'); }
// / Set time specific basic responses.
$timeGreeting = 'Hello, ';
$StopTime = '0';
// / Code for modning specific responses.
  if (date("H") <= '15' && date("H") > '3'){
    if (preg_match('/good morning/',$input)) { 
      echo nl2br('Good morning, Commander!'."\r"); 
      $input = preg_replace('/good morning/','',$input);
      $input = str_replace('good morning','',$input); }
    if (preg_match('/good afternoon/',$input)) {
      echo nl2br('It\'s only '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/good afternoon/','',$input);
      $input = str_replace('good afternoon','',$input); }
    if (preg_match('/good day/',$input)) {
      echo nl2br('It\'s only '.$hour.', Commander.'."\r");  
      $input = preg_replace('/good day/','',$input);
      $input = str_replace('good day ','',$input); }
    if (preg_match('/good evening/',$input)) {
      echo nl2br('It\'s only '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/good evening/','',$input);
      $input = str_replace('good evening','',$input); }
    if (preg_match('/good night/',$input)) {
      echo nl2br('Goodnight, Commander.'."\r"); 
      $input = preg_replace('/good night/','',$input);
      $input = str_replace('goodnight','',$input); }
    if (preg_match('/goodnight/',$input)) { 
      echo nl2br('Goodnight, Commander.'."\r"); 
      $input = preg_replace('/goodnight/','',$input);
      $input = str_replace('goodnight','',$input); }
    $timeGreeting = 'Good morning, '; }
// / Code for afternoon specific responses.
if ($StopTime == '0') {
  if (date("H") >= '15' && date("H") <= '20'){  
    if (preg_match('/good afternoon/',$input)) {
      echo nl2br('It has been so far, Commander!'."\r"); 
      $input = preg_replace('/good afternoon/','',$input);
      $input = str_replace('good afternoon','',$input); }
    if (preg_match('/good day/',$input)) {
      echo nl2br('It has been so far, Commander!'."\r"); 
      $input = preg_replace('/good day/','',$input);
      $input = str_replace('good day ','',$input); }
    if (preg_match('/good morning/',$input)) {
      echo nl2br('It\'s '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/good morning/','',$input);
      $input = str_replace('good morning','',$input); }
    if (preg_match('/good evening/',$input)) {
      echo nl2br('It\'s still only '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/good evening/','',$input);
      $input = str_replace('good evening','',$input); }
    if (preg_match('/good night/',$input)) {
      echo nl2br('Goodnight, although it\'s only '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/good night/','',$input);
      $input = str_replace('good night','',$input); }
    if (preg_match('/goodnight/',$input)) {
      echo nl2br('Goodnight, although it\'s only '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/goodnight/','',$input);
      $input = str_replace('goodnight','',$input); }
    $timeGreeting = 'Good afternoon, '; 
    $StopTime++; } }
// / Code for evening specific responses.
if ($StopTime == '0') {
  if (date("H") >= '20' or date("H") <= '3') {
    if (preg_match('/good evening/',$input)){
      echo nl2br('Yes, Commander. It has been.'."\r"); 
      $input = preg_replace('/good evening/','',$input);
      $input = str_replace('good evening','',$input); }
    if (date("H") >= '3' && date("H") <= '12') {
      if (preg_match('/good morning/',$input)){
        echo nl2br('Yes, Commander. It has been.'."\r"); 
        $input = preg_replace('/good morning/','',$input);
        $input = str_replace('good morning','',$input); } }
    if (date("H") >= '3' && date("H") <= '12' or date("H") > '20') {
      if (preg_match('/good morning/',$input)){      
      echo nl2br('It\'s '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/good morning/','',$input);
      $input = str_replace('good morning','',$input); } }
    if (preg_match('/good afternoon/',$input)){
      echo nl2br('It\'s '.$hour.', Commander.'."\r"); 
      $input = preg_replace('/good afternoon/','',$input);
      $input = str_replace('good afternoon','',$input); }
    if (preg_match('/good day/',$input)){
      echo nl2br('It\'s '.$hour.', Commander.'."\r");  
      $input = preg_replace('/good day/','',$input);
      $input = str_replace('good day ','',$input); }
    if (preg_match('/good night/',$input)){
      echo nl2br('Yes, it was. Goodnight, Commander.'."\r"); 
      $input = preg_replace('/good night/','',$input);
      $input = str_replace('good night','',$input); }
    if (preg_match('/goodnight/',$input)){
      echo nl2br('Yes, it was. Goodnight, Commander.'."\r"); 
      $input = preg_replace('/goodnight/','',$input);
      $input = str_replace('goodnight','',$input); }
    $timeGreeting = 'Good evening, '; 
    $StopTime++; } }
// /a First we respond to basic greetings.
if ($input == 'hello'){
  echo nl2br($timeGreeting.'Commander! '."\r"); 
$input = preg_replace('/hello/','',$input);
$input = str_replace('hello ','',$input); }
if ($input == 'hi'){
  echo nl2br($timeGreeting.'Commander! '."\r");
$input = preg_replace('/hi/','',$input); 
$input = str_replace('hi ','',$input); }
if ($input == 'hey'){
  echo nl2br($timeGreeting.'Commander! '."\r");
$input = preg_replace('/hey/','',$input);
$input = str_replace('hey ','',$input); }
if ($input == 'sup'){
  echo nl2br($timeGreeting.'Commander! '."\r");
$input = preg_replace('/sup/','',$input);
$input = str_replace('sup ','',$input); }
// / Then we subtract basic greetings from the rest of the input, incase there is a command
// / behind the greeting. Again, this is very simple stuff.
$first3 = substr($input, 0, 3);
if ($first3 == 'hi '){
  echo nl2br('Hello, Commander! '."\r"); 
$input = str_replace('hi ','',$input); }
// / Now that we've condensed our input a bit we remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$first4 = substr($input, 0, 4);
if ($first4 == 'hey '){ 
  echo nl2br('Hello, Commander! '."\r"); 
$input = str_replace('hey ','',$input); }
if ($first4 == 'sup '){
  echo nl2br('Hello, Commander! '."\r"); 
$input = str_replace('sup ', '', $input); }
// / Now that we've condensed our input a bit we remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$first5 = substr($input, 0, 5);
if ($first5 == 'hello'){
  echo nl2br('Hello, Commander! '."\r"); 
$input = str_replace('hello ','',$input); }
// / Now that we've condensed our input a bit we remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$first6 = substr($input, 0, 6);
if ($first6 == 'please'){
  echo nl2br('Of course! '."\r");  
$input = preg_replace('/please /', '', $input); }
$last6 = substr($input, 0, -6);
if ($last6 == 'please'){
  echo nl2br('Of course! '."\r"); 
$input = str_replace(' please/', '', $input); }
// / Now that we've condensed our input a bit we remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
if (preg_match('/plz/', $input)){
  echo nl2br('No problem, Commander! '."\r");  
$input = str_replace('plz','',$input); }
if (preg_match('/please/', $input)){
  echo nl2br('Of course, Commander! '."\r");  
$input = str_replace('please','',$input); }
if (preg_match('/thank you/', $input)){
  echo nl2br('My pleasure. '."\r"); 
$input = str_replace('/ please/', '', $input); } 
if (preg_match('/thanks/', $input)){
  echo nl2br('Anytime, Commander! '."\r");  
$input = str_replace('thanks','',$input); }
if (preg_match('/thx/', $input)){
  echo nl2br('No problem, Commander! '."\r");  
$input = str_replace('thx','',$input); }
if (preg_match('/your name/', $input)){
  echo nl2br('HRAI! '."\r");  
$input = str_replace('your name','',$input); }
if (preg_match('/whats your name/', $input)){
  echo nl2br('HRAI! '."\r");  
$input = str_replace('whats your name','',$input); }
if (preg_match('/what is your name/', $input)){
  echo nl2br('HRAI! '."\r");  
$input = str_replace('what is your name','',$input); }
// / Now that we've condensed our input a bit we remove any incidental double spaces.
$input = str_replace('  ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);