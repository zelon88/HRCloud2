<?php

// / The following code is perofmed whenever an administrator selects to install a new App.
if (isset($_POST['installApp'])) {
  if ($UserID == '1') {
  $_POST['installApp'] = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['installApp']);
  $appToInstall = $_POST['installApp']; } } 

// / The following code returns the random file or folder for each Cloud module. 
$files = scandir($CloudUsrDir, SCANDIR_SORT_DESCENDING);
$random_file = array_rand($files, 1);
$random_file = $files[$random_file];
if ($random_file == '.' or $random_file == '..') {
  $random_file = $files[$random_file]; }
if ($random_file == '.' or $random_file == '..') {
  $random_file = $files[$random_file]; }  
if ($random_file == '.' or $random_file == '..') {
  $random_file = $files[$random_file]; }
if ($random_file == '.' or $random_file == '..') {
  $random_file = 'No files to show!'; } 
if ($random_file == '') {
  $random_file = 'No files to show!'; } 

$apps = scandir($AppDir, SCANDIR_SORT_DESCENDING);
$random_app = array_rand($apps);
$random_app = $apps[$random_app];
if ($random_app == '.' or $random_app == '..' or in_array($random_app, $defaultApps)) {
  $random_app = array_rand($apps);
  $random_app = $apps[$random_app]; }
if ($random_app == '.' or $random_app == '..' or in_array($random_app, $defaultApps)) {
  $random_app = array_rand($apps);
  $random_app = $apps[$random_app]; }
if ($random_app == '.' or $random_app == '..' or in_array($random_app, $defaultApps)) {
  $random_app = array_rand($apps);
  $random_app = $apps[$random_app]; }
if ($random_app == '.' or $random_app == '..' or in_array($random_app, $defaultApps)) {
  $random_app = array_rand($apps);
  $random_app = $apps[$random_app]; }
if ($random_app == '.' or $random_app == '..' or in_array($random_app, $defaultApps)) {
  $random_app = array_rand($apps);
  $random_app = $apps[$random_app]; }
if ($random_app == '.' or $random_app == '..' or in_array($random_app, $defaultApps)) {
  $random_app = array_rand($apps);
  $random_app = $apps[$random_app]; }
if ($random_app == '.' or $random_app == '..' or in_array($random_app, $defaultApps)) {
  $random_app = 'No apps to show!'; }

$contacts = scandir($ContactsDir, SCANDIR_SORT_DESCENDING);
$random_contact = array_rand($contacts);
$random_contact = $contacts[$random_contact];
if ($random_contact == '.' or $random_contact == '..' or strpos($random_contact, 'contacts.php') == 'true') {
  $random_contact = 'No contacts to show!'; }
if ($random_contact == 'contacts.php') { 
  $random_contact = 'No contacts to show!'; }

$notes = scandir($NotesDir, SCANDIR_SORT_DESCENDING);
$random_note = array_rand($notes);
$random_note = $notes[$random_note];
if ($random_note == '.' or $random_note == '..') {
  $random_note = array_rand($notes);
  $random_note = $notes[$random_note]; }
if ($random_note == '.' or $random_note == '..') {
  $random_note = array_rand($notes);
  $random_note = $notes[$random_note]; }
if ($random_note == '.' or $random_note == '..') {
  $random_note = array_rand($notes);
  $random_note = $notes[$random_note]; }
$random_note = str_replace('.txt', '', $random_note);
if ($random_note == '.' or $random_note == '..' or $random_note == '') {
  $random_note = 'No notes to show!'; }
?>