<?php

/*
App Name: Notes
App Version: 1.0 
App License: GPLv3
App Author: zelon88
App Description: A simple HRCloud2 app for creating, viewing, and managing notes and to-do lists!
*/

// / The following code ensures the Notes directory exists and creates it if it does not.
if (!file_exists($NotesDir)) { 
  mkdir($NotesDir); }
if (!file_exists($NotesDir)) { 
  $txt = ('ERROR!!! HRC2186, There was a problem creating the user notes directory on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ('ERROR!!! HRC2186, There was a problem creating the user notes directory on '.$Time.'!'); } 
