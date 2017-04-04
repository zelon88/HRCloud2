<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: Calculator
App Version: 1.5 (4-4-2017 00:00)
App License: GPLv3
App Author: zelon88
App Description: A simple HRCloud2 App for doing math.
App Integration: 0 (False)
HRCLOUD2-PLUGIN-END
//*/

?>
<script src="sorttable.js"></script>
<script type="text/javascript">
// / Javascript to clear the newNote text input field onclick.
    function Clear() {    
      document.getElementById("calculatorInput").value= ""; }
</script>
<div id='CalculatorAPP' name='CalculatorAPP' align='center'><h3>Calculator</h3><hr />
<form action="Calculator.php" method="post">
<?php 
if (!isset($calculatorInput)) { 
  echo ('<p>Enter an equation to calculate.</p>'); } 
?>
<input id="calculatorInput" name="calculatorInput" value="" type="text">
<input type="submit" id="calculatorSubmit" name="calculatorSubmit" title="Perform Equation" alt="Perform Equation" value="Perform Equation"></form>
<hr />
<?php

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2CalculatorApp26, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  require_once ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

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
  $basicFunctions = str_split('+-xX*/');
  $advancedFunctions = str_split('%');
  $additionFunctions = str_split('+'); 
  $subtractionFunctions = str_split('-');
  $multicationFunctions = str_split('*');
  $divisionFunctions = str_split('/');
  $calculatorInput = str_replace(str_split('[]{};:$!#&@>=<'), '', $_POST['calculatorInput']);
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
  eval('$total = ('.$calculatorInput.');');
  echo ('<p><strong>'.$counter.'.</strong> <i>'.$calculatorInput.'</i> = <u><strong>'.$total.'</strong></u></p>'); } }

?>
</div>