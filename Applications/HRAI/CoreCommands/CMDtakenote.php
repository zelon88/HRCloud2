<?php

$CMDfile = $InstLoc.'/Applications/HRAI/CoreCommands/CMDtakenote.php'; 
$inputMATCH = array('take a note', 'take note', 'note this', 'make note', 'make a note', 'a note of this', 'create note', 'write');
$CMDcounter++;
$CMDinit[$CMDcounter] = 0;

if (isset($input)) {
  foreach ($inputMATCH as $inputM1) {
    if (preg_match('/'.$inputM1.'/', $input)) {
      $CMDinit[$CMDcounter] = 1;
      $input = preg_replace('/'.$inputM1.'/',' ',$input); } } }
      
if (!isset($input)) {
  $input = ''; }

$input = str_replace('   ',' ',$input);
$input = str_replace('  ',' ',$input);
$input = rtrim($input);
$input = ltrim($input);
if ($CMDinit[$CMDcounter] == 1) {

// / --------------------------------------
$NoteCounter = 0;
$NoteStopper = 1000;
$Result = TRUE;
$input = str_replace(str_split('/\'[]{};:$!#^&%@>*<'), '', $input);
$NotesDir = $InstLoc.'/DATA/'.$UserID.'/.AppData/Notes/';
$NotesDir2 = $CloudUsrDir.'/.AppData/Notes/';
$NoteFilename = 'HRAI_Note_'.$NoteCounter.'.txt';
$NoteFile = $NotesDir.$NoteFilename;
$NoteFile2 = $NotesDir2.$NoteFilename;

while (file_exists($NoteFile) or file_exists($NoteFile2)) {
  if ($NoteCounter >= $NoteStopper) { 
    $Result = FALSE;
  	break; }
  $NoteCounter++;
  $NoteFilename = 'HRAI_Note_'.$NoteCounter.'.txt';
  $NoteFile = $NotesDir.$NoteFilename;
  $NoteFile2 = $NotesDir2.$NoteFilename; } 

if ($Result === TRUE) {
  $MAKENoteFile = file_put_contents($NoteFile, $input);
  $MAKENoteFile2 = file_put_contents($NoteFile2, $input); }

if (!file_exists($NoteFile) or !file_exists($NoteFile2)) $Result = FALSE; 

if ($Result === TRUE) echo('Your note has been saved as: \'<a href="" onclick="window.open(\''.$URL.'/HRProprietary/HRCloud2/Applications/Notes/Notes.php?editNote='.str_replace('.txt', '', $NoteFilename).'\',\'Notes\',\'resizable,height=400,width=650\'); return false;" > '.str_replace('.txt', '', $NoteFilename).'\'</a><br />');

if ($Result === FALSE) echo('There was an error and your note was not taken.<br />'); }