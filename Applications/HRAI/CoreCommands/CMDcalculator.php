<?php

$CMDfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcalculator.php'; 
$inputMATCH = array('calculator', 'the sum of', 'quotient of', 'plus', 'add', 'subtract', 'minus', 'take away', 
  'divided by', 'multiplied by', 'times', '\+', '\-', '\/', '\*', 'x', 'X');
$CMDcounter++;
$CMDinit[$CMDcounter] = 0;

if (isset($input)) {
  foreach ($inputMATCH as $inputM1) {
    if (preg_match('/'.$inputM1.'/', $input)) {
      $CMDinit[$CMDcounter] = 1;
      $input = preg_replace('/'.$inputM1.'/',' ',$input); } } } 

// / This CMDcommand was copied from the HRC2 Calculator App on 8/8/2017.
if ($CMDinit[$CMDcounter] == 1) {
  $calculatorInput = $_POST['input'];
  $calculatorInput = strtolower($calculatorInput);

  // / The following code defines a function originally written by Justin Cook...
  // / http://www.justin-cook.com/wp/2006/03/31/php-parse-a-string-between-two-strings/
    function get_string_between($string, $start, $end) {
      $string = ' ' . $string;
      $ini = strpos($string, $start);
      if ($ini == 0) return '';
      $ini += strlen($start);
      $len = strpos($string, $end, $ini) - $ini;
      return substr($string, $ini, $len); } 

  // / The following code sets the global variables for the session.
  $numbers = range(0, 9);
  // / Note that the letter "x" is missing from the $letters array.
  $letters = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
  $basicFunctions = array('+', '-', '*', '/');
  $advancedFunctions = '%';
  $additionFunctions = '+';
  $subtractionFunctions = '-';
  $multicationFunctions = '*';
  $divisionFunctions = '/';
  $calculatorInput = str_replace(str_split('[]{};:$!#&@>=<?\'",'), '', $calculatorInput);
  $calculatorInput = str_replace('multiplied by', '*', $calculatorInput);
  $calculatorInput = str_replace('plus', '+', $calculatorInput);
  $calculatorInput = str_replace('minus', '-', $calculatorInput);
  $calculatorInput = str_replace('take away', '-', $calculatorInput);
  $calculatorInput = str_replace('times', '*', $calculatorInput);
  $calculatorInput = str_replace('divided by', '/', $calculatorInput);
  $calculatorInput = str_replace(str_split('abcdefghijklmnopqrstuvwxyz'), '', $calculatorInput);
  $calculatorInput = str_replace(str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), '', $calculatorInput);  
  $calculatorInput = str_replace(' ', '', $calculatorInput);

  // / The following code cleans the user input for the math interpreter.
  $counter = 0; 
  foreach ($numbers as $number) {
    $calculatorInput = str_replace($number.'(', $number.'*(', $calculatorInput);
    $calculatorInput = str_replace(')'.$number, ')*'.$number, $calculatorInput); }
  $priorityFunctions = get_string_between($calculatorInput, '(', ')');
  $priorityFunctions = str_replace(str_split('()'), '', $priorityFunctions);

  // / The following code prepares ONLY ONE (the first encountered) nested equation before proceeding.  
  if ($priorityFunctions !== '') {
    $counter++;
    echo ('<i>'.$calculatorInput.'</i>');
    eval('$priorityTotal = ('.$priorityFunctions.');');
    echo ('<p><strong>'.$counter.'.</strong> <i>('.$priorityFunctions.')</i> = <strong>'.$priorityTotal.'</strong></p>');
    $calculatorInput = str_replace($priorityFunctions, $priorityTotal, $calculatorInput); }

// / The following code parses upper-level equations.
if ($calculatorInput !== '') {
  $counter++;
  foreach($basicFunctions as $bfunc) {
    $calculatorInput = trim($calculatorInput, $bfunc); }
  eval('$total = ('.$calculatorInput.');');
  echo ('<p><strong>'.$counter.'.</strong> <i>'.$calculatorInput.'</i> = <u><strong>'.$total.'</strong></u></p>'); } } 

?>
