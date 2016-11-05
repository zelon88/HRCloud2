<?php

/*
App Name: Contacts
App Version: 1.0 
App Author: zelon88
App License: GPLv3
App Description: A simple HRCloud2 app for creating, viewing, and managing contacts!
*/

// / The following code ensures the Contacts directory exists and creates it if it does not. Also creates empty Contacts file.
if (!file_exists($UserContacts)) { 
  $ContactsData = ('<?php ?>');
  if (!file_exists($ContactsDir)) {
    mkdir($ContactsDir); }
  $MAKEContactsFile = file_put_contents($UserContacts, $ContactsData.PHP_EOL , FILE_APPEND); 
  $txt = ('Created a user contacts file on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }
if (!file_exists($UserContacts)) { 
  $txt = ('ERROR!!! HRC2162, There was a problem creating the user contacts file on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ('ERROR!!! HRC2162, There was a problem creating the user contacts file on '.$Time.'!'); }
if (file_exists($UserContacts)) {
require ($UserContacts); }
