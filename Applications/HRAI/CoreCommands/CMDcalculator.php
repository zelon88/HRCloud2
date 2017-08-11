<?php

$CMDfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDcalculator.php'; 
$inputMATCH = array('calculator', 'the sum of', 'quotient of', 'plus', 'add', 'subtract', 'minus', 'take away', 
  'divided by', 'multiplied by', 'times', '+', '-', '/', '*');
$CMDcounter++;

if (!isset($input)) {
  $input = ''; }

$input = str_replace('   ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
$input = ltrim($input);

// / This CMDcommand was copied from the HRC2 Calculator App on 8/8/2017.

// / HRAI Specific Code.
$_POST['calculatorInput'] = $_POST['input'];
$calculatorInput = $_POST['calculatorInput'];
if (isset($calculatorInput) && $calculatorInput == '') {
  echo ('There was no equation to calculate!'); }

// / Copy/Pasta code from 8/8/2017 HRC2 Calculator App..... Word-for-word.
if (isset($_POST['calculatorInput']) && $_POST['calculatorInput'] !== '') {
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
  $numbers = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
  $basicFunctions = array('+', '-', 'x', 'X', '*', '/');
  $advancedFunctions = '%';
  $additionFunctions = '+';
  $subtractionFunctions = '-';
  $multicationFunctions = '*';
  $divisionFunctions = '/';
  $calculatorInput = str_replace(str_split('[]{};:$!#&@>=<?,'), '', $calculatorInput);
  $calculatorInput = strtolower($calculatorInput);
  $calculatorInput = str_replace(str_split('xX'), '*', $calculatorInput);
  $calculatorInput = str_replace('multiplied by', '*', $calculatorInput);
  $calculatorInput = str_replace('plus', '+', $calculatorInput);
  $calculatorInput = str_replace('and', '+', $calculatorInput);
  $calculatorInput = str_replace('minus', '-', $calculatorInput);
  $calculatorInput = str_replace('take away', '-', $calculatorInput);
  $calculatorInput = str_replace('times', '*', $calculatorInput);
  $calculatorInput = str_replace('divided by', '/', $calculatorInput);
  $calculatorInput = str_replace(str_split('abcdefghijklmnopqrstuvwyz'), '', $calculatorInput);
  $calculatorInput = str_replace(' ', '', $calculatorInput);
  $calculatorArguments = str_replace(str_split('[]{};:$!#&@><'), '', $calculatorInput);
  // / The following code cleans the user input for the math interpreter.
  $counter = 0; 
  foreach ($numbers as $number) {
    $calculatorInput = str_replace($number.'(', $number.'*(', $calculatorInput);
    $calculatorInput = str_replace(')'.$number, ')*'.$number, $calculatorInput); }
  if ($calculatorInput == '') {
    echo ('There was no equation to calculate!'); }
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
