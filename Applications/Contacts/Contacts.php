<!DOCTYPE HTML>
<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: Contacts
App Version: 1.0 (11-23-2016 22:20)
App License: GPLv3
App Author: zelon88
App Description: A simple HRCloud2 app for creating, viewing, and managing contacts!
App Integration: 1 (True)
HRCLOUD2-PLUGIN-END
//*/

?>
<script src="sorttable.js"></script>
<script type="text/javascript">
// / Javascript to clear the newContact text input field onclick.
    function Clear() {    
      document.getElementById("newContact").value= ""; }
</script>
<div id='ContactsAPP' name='ContactsAPP' align='center'><h3>Contacts</h3><hr /><?php
 
// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2ConcactsApp10, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  include ('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2ConcactsApp18, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  include ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

// / The following code ensures the Contacts directory exists and creates it if it does not.
$SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
$ContactsDir = $InstLoc.'/DATA/'.$UserID.'/.AppLogs/Contacts/';
$contactsList = scandir($ContactsDir, SCANDIR_SORT_DESCENDING);
$newest_contact = $contactsList[0];
$contactData = '';
$contactTitle = 'New Contact...';
$contactButtonEcho = 'Create Contact';
if (!file_exists($NotesDir)) { 
  $txt = ('OP-Act: Creating user contacts directory on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  mkdir($ContactsDir); }
if (!file_exists($ContactsDir)) { 
  $txt = ('ERROR!!! HRC2N19, There was a problem creating the user contacts directory on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
  die ($txt); } 

// / The following code is performed whenever a user selects to edit a Contact.
if (isset($_GET['editContact'])) {
  $ContactToEdit = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContact']);

  $ContactName = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactName']);
  $ContactEmail1 = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactEmail1']);
  $ContactEmail2 = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactEmail2']);
  $ContactEmail3 = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactEmail3']);
  $ContactEmail4 = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactEmail4']);
  $ContactEmail5 = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactEmail5']);
  $ContactEmail6 = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactEmail6']);
  $ContactPhone1 = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactPhone1']);
  $ContactPhone2 =str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactPhone2']);
  $ContactPhone3 =str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactPhone3']);
  $ContactPhone4 =str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactPhone4']);
  $ContactPhone5 =str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactPhone5']);
  $ContactPhone6 =str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactPhone6']);
  $ContactWebsite1 = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactWebsite1']);
  $ContactWebsite2 = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContacWebsite2']);
  $ContactWebsite3 = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContacWebsite3']);
  $ContactFB = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactFB']);
  $ContactTwitter = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactTwitter']);
  $ContactSnap = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactSnap']);
  $ContactInsta = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactInsta']);
  $ContactLIn = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactLIn']);
  $ContactAdr1 = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactAdr1']);
  $ContactAdr2 = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactAdr2']);
  $ContactAdr3 = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactAdr3']);
  $ContactsNotes = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['editContactNotes']);

  $ContactToEdit = $contactToEdit.'.txt';
  $ContactData = file_get_contents($ContactsDir.$contactToEdit);
  $ContactData = str_replace('<br />', '', $contactData);
  $ContactTitle = $_GET['editContact'];
  $contactButtonEcho = 'Edit Contact';
  $txt = ('OP-Act: Opening Contact '.$contactToDelete.' for editing on '.$Time.'!'); 
  echo 'Editing <i>'.$contactName.'</i>'; 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }

// / The following code is performed whenever a user selects to delete a Contact.
if (isset($_GET['deleteContact'])) {
  $contactToDelete = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_GET['deleteContacts']);
  $contactToDelete = $contactToDelete;
  unlink($ContactsDir.$contactToDelete.'.txt'); 
  $txt = ('OP-Act: Deleting Contacts '.$contactToDelete.' on '.$Time.'!');
  echo 'Deleted <i>'.$contactToDelete.'</i>'; 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); }

// / If the Notes directory exists we check that the API POST variables were set.  
if (is_dir($ContactsDir)) {
  // / If the input POSTS are set, we turn them into a contact.
  if (isset($_POST['newContact'])) {
    $contactName = str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['newContact']);
    if (!isset($_POST['contact'])) {
      $txt = ('ERROR!!! HRC2N26, There was no Contact contect detected on '.$Time.'!'); 
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
      die ($txt); } 
    $contact= str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['contact']); 
    $ContactFile = $ContactsDir.$contactName.'.txt'; 
    $MAKEContactFile = file_put_contents($ContactFile, $contact.PHP_EOL); 
    $txt = ('OP-Act: Contact '.$contactName.' created sucessfully on '.$Time.'!'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    echo nl2br('Created <i>'.$contactName.'</i>'); } 
  // / If the input POSTS are NOT set, we present the user with a New Contact form.
    echo nl2br('<form method="post" action="Contacts.php" type="multipart/form-data">'."\n");
    echo nl2br('<input type="text" id="newContact" name="newContact" value="'.$contactTitle.'" onclick="Clear();">'."\n");
    echo ('<textarea id="contact" name="contact" cols="40" rows="5">'.$contactData.'</textarea>');
    echo nl2br("\n".'<input type="submit" value="'.$contactButtonEcho.'"></form>'); 
     }
?>
<br>
</div><div id="contactsList" name="contactsList" align="center"><strong>My Contacts</strong><hr /></div>
<div align="center">
<table class="sortable">
<thead><tr>
<th>Contact</th>
<th>Edit</th>
<th>Delete</th>
<th>Last Modified</th>
</tr></thead><tbody>
 <?php 
$contactesList2 = scandir($NotesDir); 
$contactCounter = 0;
foreach ($notesList2 as $contact) {
  if ($contact == '.' or $contact == '..' or strpos($contact, '.txt') == 'false' 
    or $contact == '' or $contact == '.txt') continue; 
  $contactCounter++;
  $contactFile = $ContactsDir.$contact; 
  $contactEcho = str_replace('.txt', '', $contact);
  $contactTime = date("F d Y H:i:s.",filemtime($contactFile));
  echo nl2br ('<tr><td><strong>'.$contactCounter.'. </strong><a href="Notes.php?editContact='.$contactEcho.'">'.$contactEcho.'</a></td>');
  echo nl2br('<td><a href="Contacts.php?editContact='.$contactEcho.'"><img id="edit'.$contactCounter.'" name="'.$contact.'" src="'.$URL.'/HRProprietary/HRCloud2/Resources/edit.png"></a></td>');
  echo nl2br('<td><a href="Contacts.php?deleteContact='.$ncontactEcho.'"><img id="delete'.$contactCounter.'" name="'.$contact.'" src="'.$URL.'/HRProprietary/HRCloud2/Resources/deletesmall.png"></a></td>');
  echo nl2br('<td><a><i>'.$contactTime.'</i></a></td></tr>'); } ?>
<tbody>
</table>
</div><?php
