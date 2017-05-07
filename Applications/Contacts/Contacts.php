<!DOCTYPE HTML>
<?php

/*//
HRCLOUD2-PLUGIN-START
App Name: Contacts
App Version: 1.6 (5-6-2017 11:30)
App License: GPLv3
App Author: zelon88
App Description: A simple HRCloud2 App for creating, viewing, and managing contacts!
App Integration: 1 (True)
HRCLOUD2-PLUGIN-END
//*/

?>
<script src="sorttable.js"></script>
<script type="text/javascript">
// / Javascript to clear the newContact text input field onclick &
// / toggle the visibility of things onclick.
    function Clear() {    
      document.getElementById("newContact").value= ""; }
    function toggle_visibility(id) {
      var e = document.getElementById(id);
      if(e.style.display == 'block')
         e.style.display = 'none';
      else
         e.style.display = 'block'; }
    function goBack() {
      window.history.back(); }
</script>
<div id='ContactsAPP' name='ContactsAPP' align='center'><h3>Contacts</h3><hr /><?php
 
// / The follwoing code checks if the sanitizeCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2ContactsApp10, Cannot process the HRCloud2 Sanitization Core file (sanitizeCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  include ('/var/www/html/HRProprietary/HRCloud2/sanitizeCore.php'); }

// / The follwoing code checks if the commonCore.php file exists and 
// / terminates if it does not.
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/commonCore.php')) {
  echo nl2br('</head><body>ERROR!!! HRC2ContactsApp18, Cannot process the HRCloud2 Common Core file (commonCore.php)!'."\n".'</body></html>'); 
  die (); }
else {
  include ('/var/www/html/HRProprietary/HRCloud2/commonCore.php'); }

// / The following code ensures the Contacts directory exists and creates it if it does not.
$SaltHash = hash('ripemd160',$Date.$Salts.$UserIDRAW);
$ContactsDir = $InstLoc.'/DATA/'.$UserID.'/.AppData/Contacts/';
$contactData = '';
$contactButtonEcho = 'New Contact';
$contactTitle = 'New Contact...';
if (!file_exists($NotesDir)) { 
  $txt = ('OP-Act: Creating user contacts directory on '.$Time.'.'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  mkdir($ContactsDir); }
if (!file_exists($ContactsDir)) { 
  $txt = ('ERROR!!! HRC2ContactsApp19, There was a problem creating the user contacts directory on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  die ($txt); } 
$contactsList = scandir($ContactsDir, SCANDIR_SORT_DESCENDING);
$newest_contact = $contactsList[0];

// / The following code is performed whenever a user selects to edit a Contact.
if (isset($_GET['editContact']) && $_GET['editContact'] !== '') {
  $ContactToEdit = str_replace(str_split('.//[]{};:$!#^&%@>*<'), '', $_GET['editContact']);
  $ContactToEdit = str_replace(' ', '_', $ContactToEdit);
  $ContactToEdit = $ContactToEdit.'.php';
  $ContactFile = $ContactsDir.$ContactToEdit;
  if (!file_exists($ContactFile)) {
    $txt = ('OP-Act: No contact to show.'); 
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
    die('No contact to show.'); }
  require ($ContactFile);
  $ContactData = file_get_contents($ContactsDir.$contactToEdit);
  $ContactData = str_replace('<br />', '', $contactData);
  $ContactTitle = str_replace('.php', '', $ContactToEdit);
  $contactButtonEcho = 'Edit Contact';
  $txt = ('OP-Act: Opening Contact '.$contactToEdit.' for editing on '.$Time.'!'); 
  echo 'Editing <i>'.$ContactTitle.'</i>'; 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }

// / The following code is performed whenever a user selects to delete a Contact.
if (isset($_GET['deleteContact'])) {
  $contactToDelete = str_replace(str_split('./[]{};:$!#^&%@>*<'), '', $_GET['deleteContact']);
  $ContactToDelete = str_replace(' ', '_', $ContactToDelete);
  if (file_exists($ContactsDir.$contactToDelete.'.php')) {
    @unlink($ContactsDir.$contactToDelete.'.php'); }
  if (file_exists($ContactsDir.$contactToDelete)) {
    @unlink($ContactsDir.$contactToDelete); } 
  $txt = ('OP-Act: Deleting Contacts '.$contactToDelete.' on '.$Time.'!');
  echo 'Deleted <i>'.$contactToDelete.'</i>'; 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); }

// / If the input POSTS are set, we turn them into a contact.
if (isset($_POST['newContact'])) {
  $_POST['newContact'] = str_replace(' ', '_', $_POST['newContact']);
  $contactName = str_replace(str_split('./[]{};:$!#^&%>*<'), '', $_POST['newContact']);
  $ContactFile = $ContactsDir.$contactName.'.php'; 
  $ContactSyntaxStart = file_put_contents($ContactFile, '<?php'.PHP_EOL, FILE_APPEND);
  $contact = file_put_contents($ContactFile, '$contact = \''.str_replace(str_split('[]{};:$!#^&%>*<'), '', $_POST['newContact']).'\';'.PHP_EOL, FILE_APPEND); 
  $ContactName = file_put_contents($ContactFile, '$ContactName = \''.str_replace(str_split('[]{};:$!#^&%>*<'), '', $_POST['newContact']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactEmail1 = file_put_contents($ContactFile, '$ContactEmail1 = \''.str_replace(str_split('[]{};:$!#^&%>*<'), '', $_POST['editContactEmail1']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactEmail2 = file_put_contents($ContactFile, '$ContactEmail2 = \''.str_replace(str_split('[]{};:$!#^&%>*<'), '', $_POST['editContactEmail2']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactEmail3 = file_put_contents($ContactFile, '$ContactEmail3 = \''.str_replace(str_split('[]{};:$!#^&%>*<'), '', $_POST['editContactEmail3']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactEmail4 = file_put_contents($ContactFile, '$ContactEmail4 = \''.str_replace(str_split('[]{};:$!#^&%>*<'), '', $_POST['editContactEmail4']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactEmail5 = file_put_contents($ContactFile, '$ContactEmail5 = \''.str_replace(str_split('[]{};:$!#^&%>*<'), '', $_POST['editContactEmail5']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactEmail6 = file_put_contents($ContactFile, '$ContactEmail6 = \''.str_replace(str_split('[]{};:$!#^&%>*<'), '', $_POST['editContactEmail6']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactPhone1 = file_put_contents($ContactFile, '$ContactPhone1 = \''.str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['editContactPhone1']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactPhone2 = file_put_contents($ContactFile, '$ContactPhone2 = \''.str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['editContactPhone2']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactPhone3 = file_put_contents($ContactFile, '$ContactPhone3 = \''.str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['editContactPhone3']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactPhone4 = file_put_contents($ContactFile, '$ContactPhone4 = \''.str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['editContactPhone4']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactPhone5 = file_put_contents($ContactFile, '$ContactPhone5 = \''.str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['editContactPhone5']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactPhone6 = file_put_contents($ContactFile, '$ContactPhone6 = \''.str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['editContactPhone6']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactWebsite1 = file_put_contents($ContactFile, '$ContactWebsite1 = \''.str_replace(str_split('[]{};$!#^&%@>*<'), '', $_POST['editContactWebsite1']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactWebsite2 = file_put_contents($ContactFile, '$ContactWebsite2 = \''.str_replace(str_split('[]{};$!#^&%@>*<'), '', $_POST['editContactWebsite2']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactWebsite3 = file_put_contents($ContactFile, '$ContactWebsite3 = \''.str_replace(str_split('[]{};$!#^&%@>*<'), '', $_POST['editContactWebsite3']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactFB = file_put_contents($ContactFile, '$ContactFB = \''.str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['editContactFB']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactTwitter = file_put_contents($ContactFile, '$ContactTwitter = \''.str_replace(str_split('[]{};:$!#^&%>*<'), '', $_POST['editContactTwitter']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactSnap = file_put_contents($ContactFile, '$ContactSnap = \''.str_replace(str_split('[]{};:$!#^&%>*<'), '', $_POST['editContactSnap']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactInsta = file_put_contents($ContactFile, '$ContactInsta = \''.str_replace(str_split('[]{};:$!#^&%>*<'), '', $_POST['editContactInsta']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactLIn = file_put_contents($ContactFile, '$ContactLIn = \''.str_replace(str_split('[]{};:$!#^&%>*<'), '', $_POST['editContactLIn']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactAdr1 = file_put_contents($ContactFile, '$ContactAdr1 = \''.str_replace(str_split('[]{};:$!#^&%>*<'), '', $_POST['editContactAdr1']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactAdr2 = file_put_contents($ContactFile, '$ContactAdr2 = \''.str_replace(str_split('[]{};:$!#^&%>*<'), '', $_POST['editContactAdr2']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactAdr3 = file_put_contents($ContactFile, '$ContactAdr3 = \''.str_replace(str_split('[]{};:$!#^&%>*<'), '', $_POST['editContactAdr3']).'\';'.PHP_EOL, FILE_APPEND);
  $ContactNotes = file_put_contents($ContactFile, '$ContactNotes = \''.str_replace(str_split('[]{};:$!#^&%@>*<'), '', $_POST['editContactNotes']).'\';'.PHP_EOL, FILE_APPEND); 
  $ContactSyntaxEnd = file_put_contents($ContactFile, '?>'.PHP_EOL, FILE_APPEND);
  $txt = ('OP-Act: Contact '.$contactName.' created sucessfully on '.$Time.'!'); 
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL, FILE_APPEND); 
  echo nl2br('Saved <i>'.$contactName.'</i>'); }

// / The following code clears the variables for a new Contact after all other relevant operations are complete.
if (!isset($_POST['newContact']) && !isset($_GET['editContact'])) { 
  // / are complete and if no other operations are in-process.
  // / Set variables as blank, to avoid unneccesary PHP errors.
  // / Contact Name
  $contact = '';  $ContactName = '';  
  // / Contact Email Addr's.
  $ContactEmail1 = '';  $ContactEmail2 = '';  $ContactEmail3 = ''; 
  $ContactEmail4 = '';  $ContactEmail5 = '';  $ContactEmail6 = ''; 
  // / Contact Phone #'s.  
  $ContactPhone1 = '';  $ContactPhone2 = '';  $ContactPhone3 = '';  
  $ContactPhone4 = '';  $ContactPhone5 = '';  $ContactPhone6 = '';
  // / Contact Websites.
  $ContactWebsite1 = '';  $ContactWebsite2 = '';  $ContactWebsite3 = '';
  // / Contact Social Media.
  $ContactFB = '';  $ContactTwitter = '';  $ContactSnap = '';
  $ContactInsta = '';  $ContactLIn = '';
  // / Contact Mailing Addr.
  $ContactAdr1 = '';  $ContactAdr2 = '';  $ContactAdr3 = '';
  // / Contact Notes.
  $ContactsNotes = '';  }


echo('<div id="showDetailsButton1" name="showDetailsButton" style="display:block;"><input type="submit" value="Show Details" class="button" onclick="toggle_visibility(\'contactInfo\'); toggle_visibility(\'showDetailsButton1\'); toggle_visibility(\'showDetailsButton2\');"></div>');
echo('<div id="showDetailsButton2" name="showDetailsButton" style="display:none;"><input type="submit" value="Hide Details" class="button" onclick="toggle_visibility(\'contactInfo\'); toggle_visibility(\'showDetailsButton1\'); toggle_visibility(\'showDetailsButton2\');"></div>');

// / The following code presents the user with a fresh Contact form after all other operations 

echo nl2br('<form method="post" action="Contacts.php" type="multipart/form-data">'."\n");


echo nl2br('<div align="left" style="padding-left:15px;"><p><strong>Contact Info</strong></p>');  
echo nl2br('<p><i>Name: </i><input type="text" id="newContact" name="newContact" value="'.$contact.'"></p>'."\n");

echo nl2br('<div id="contactInfo" name="contactInfo" style="display:none;" align="left" style="margin-left:15px;">');

echo nl2br('<strong><p id="showEmailDivButton" name="showEmailDivButton" href="#" onclick="toggle_visibility(\'contactEmailDiv\');" title="Show Email Options" alt="Show Email Options">Email</p></strong>');
echo nl2br('<div name="contactEmailDiv" id="contactEmailDiv" style="display:none;">');  
echo nl2br('<hr />');
echo nl2br('<p><i>Email 1: </i><input type="text" id="editContactEmail1" name="editContactEmail1" value="'.$ContactEmail1.'"></p>'."\n");
echo nl2br('<p><i>Email 2: </i><input type="text" id="editContactEmail2" name="editContactEmail2" value="'.$ContactEmail2.'"></p>'."\n");
echo nl2br('<p><i>Email 3: </i><input type="text" id="editContactEmail3" name="editContactEmail3" value="'.$ContactEmail3.'"></p>'."\n");
echo nl2br('<p><i>Email 4: </i><input type="text" id="editContactEmail4" name="editContactEmail4" value="'.$ContactEmail4.'"></p>'."\n");
echo nl2br('<p><i>Email 5: </i><input type="text" id="editContactEmail5" name="editContactEmail5" value="'.$ContactEmail5.'"></p>'."\n");
echo nl2br('<p><i>Email 6: </i><input type="text" id="editContactEmail6" name="editContactEmail6" value="'.$ContactEmail6.'"></p>'."\n");
echo nl2br('</div><hr />');

echo nl2br('<strong><p id="showPhoneDivButton" name="showPhoneDivButton" href="#" onclick="toggle_visibility(\'contactPhoneDiv\');" title="Show Phone Options" alt="Show Phone Options">Phone</p></strong>');
echo nl2br('<div name="contactPhoneDiv" id="contactPhoneDiv" style="display:none;">');  
echo nl2br('<hr />');
echo nl2br('<p><i>Phone 1: </i><input type="text" id="editContactPhone1" name="editContactPhone1" value="'.$ContactPhone1.'"></p>'."\n");
echo nl2br('<p><i>Phone 2: </i><input type="text" id="editContactPhone2" name="editContactPhone2" value="'.$ContactPhone2.'"></p>'."\n");
echo nl2br('<p><i>Phone 3: </i><input type="text" id="editContactPhone3" name="editContactPhone3" value="'.$ContactPhone3.'"></p>'."\n");
echo nl2br('<p><i>Phone 4: </i><input type="text" id="editContactPhone4" name="editContactPhone4" value="'.$ContactPhone4.'"></p>'."\n");
echo nl2br('<p><i>Phone 5: </i><input type="text" id="editContactPhone5" name="editContactPhone5" value="'.$ContactPhone5.'"></p>'."\n");
echo nl2br('<p><i>Phone 6: </i><input type="text" id="editContactPhone6" name="editContactPhone6" value="'.$ContactPhone6.'"></p>'."\n");
echo nl2br('</div><hr />');

echo nl2br('<strong><p id="showWebsiteDivButton" name="showWebsiteDivButton" href="#" onclick="toggle_visibility(\'contactWebsiteDiv\');" title="Show Website Options" alt="Show Website Options">Website</p></strong>');
echo nl2br('<div name="contactWebsiteDiv" id="contactWebsiteDiv" style="display:none;">');  
echo nl2br('<hr />');
echo nl2br('<p><i>Website 1: </i><input type="text" id="editContactWebsite1" name="editContactWebsite1" value="'.$ContactWebsite1.'"></p>'."\n");
echo nl2br('<p><i>Website 2: </i><input type="text" id="editContactWebsite2" name="editContactWebsite2" value="'.$ContactWebsite2.'"></p>'."\n");
echo nl2br('<p><i>Website 3: </i><input type="text" id="editContactWebsite3" name="editContactWebsite3" value="'.$ContactWebsite3.'"></p>'."\n");
echo nl2br('</div><hr />');

echo nl2br('<strong><p id="showSocialDivButton" name="showSocialDivButton" href="#" onclick="toggle_visibility(\'contactSocialDiv\');" title="Show Social Media Options" alt="Show Social Options">Social Media</p></strong>');
echo nl2br('<div name="contactSocialDiv" id="contactSocialDiv" style="display:none;">');
echo nl2br('<hr />');  
echo nl2br('<p><i>Facebook : </i><input type="text" id="editContactFB" name="editContactFB" value="'.$ContactFB.'"></p>'."\n");
echo nl2br('<p><i>Twitter : </i><input type="text" id="editContactTwitter" name="editContactTwitter" value="'.$ContactTwitter.'"></p>'."\n");
echo nl2br('<p><i>Snapchat : </i><input type="text" id="editContactSnap" name="editContactSnap" value="'.$ContactSnap.'"></p>'."\n");
echo nl2br('<p><i>Instagram : </i><input type="text" id="editContactInsta" name="editContactInsta" value="'.$ContactInsta.'"></p>'."\n");
echo nl2br('<p><i>LinkedIn : </i><input type="text" id="editContactLIn" name="editContactLIn" value="'.$ContactLIn.'"></p>'."\n");
echo nl2br('</div><hr />');

echo nl2br('<strong><p id="showAdrDivButton" name="showAdrDivButton" href="#" onclick="toggle_visibility(\'contactAdrDiv\');" title="Show Address Options" alt="Show Address Options">Mailing Address</strong>');
echo nl2br('<div name="contactAdriv" id="contactAdrDiv" style="display:none;">'); 
echo nl2br('<hr />');
echo nl2br('<p><i>Mailing Address 1: </i><input type="text" id="editContactAdr1" name="editContactAdr1" value="'.$ContactAdr1.'"></p>'."\n");
echo nl2br('<p><i>Mailing Address 2: </i><input type="text" id="editContactAdr2" name="editContactAdr2" value="'.$ContactAdr2.'"></p>'."\n");
echo nl2br('<p><i>Mailing Address 3: </i><input type="text" id="editContactAdr3" name="editContactAdr3" value="'.$ContactAdr3.'"></p>'."\n");
echo nl2br('<p></div><hr />');

echo nl2br('<strong><p id="showNotesButton" name="showNotesButton" href="#" onclick="toggle_visibility(\'contactNotesDiv\');" title="Show Misc Options" alt="Show Misc Options">Notes</p></strong>');
echo nl2br('<div name="contactNotesDiv" id="contactNotesDiv" style="display:none;">');  
echo nl2br('<hr />');
echo ('<p><textarea id="editContactNotes" name="editContactNotes" cols="40" rows="5">'.$ContactNotes.'</textarea></p>');
echo nl2br('</div><hr />');

echo nl2br('<div align="center"><input type="submit" value="'.$contactButtonEcho.'"></div>');

echo nl2br('</div></form>');

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
$contactsList2 = scandir($ContactsDir); 
$contactCounter = 0;
foreach ($contactsList2 as $contact) {
  if ($contact == '.' or $contact == '..' or strpos($contact, '.php') == 'false' 
    or $contact == '' or $contact == '.php') continue; 
  $contactCounter++;
  $contactFile = $ContactsDir.$contact; 
  $contactEcho = str_replace('.php', '', $contact);
  $contactTime = date("F d Y H:i:s.",filemtime($contactFile));
  echo nl2br ('<tr><td><strong>'.$contactCounter.'. </strong><a href="Contacts.php?editContact='.$contactEcho.'">'.$contactEcho.'</a></td>');
  echo nl2br('<td><a href="Contacts.php?editContact='.$contactEcho.'"><img id="edit'.$contactCounter.'" name="'.$contact.'" src="'.$URL.'/HRProprietary/HRCloud2/Resources/edit.png"></a></td>');
  echo nl2br('<td><a href="Contacts.php?deleteContact='.$contactEcho.'"><img id="delete'.$contactCounter.'" name="'.$contact.'" src="'.$URL.'/HRProprietary/HRCloud2/Resources/deletesmall.png"></a></td>');
  echo nl2br('<td><a><i>'.$contactTime.'</i></a></td></tr>'); } ?>
<tbody>
</table>
</div><?php
