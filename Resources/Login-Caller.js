/* 
HonestRepair Diablo Engine  -  Login Caller Script
https://www.HonestRepair.net
https://github.com/zelon88

Licensed Under GNU GPLv3
https://www.gnu.org/licenses/gpl-3.0.html

Author: Justin Grimes
Date: 1/15/2021
<3 Open-Source

This file is for negotiating login requests & processing the response from the server.

Also provides login related UI functionality.
*/

// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / A function to take the password typed by the user and create a SHA256 hash of it.
function hashCreds(RawPassword) {
  var passwordBits = sjcl.hash.sha256.hash(RawPassword);  
  var PasswordInput = sjcl.codec.hex.fromBits(passwordBits);
  return (PasswordInput); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / A function to perform the client-side encryption of the users password before they send it to the server.
function secureLogin(RawPassword) {
  var PasswordInput = hashCreds(RawPassword);
  changeValue('PasswordInput', PasswordInput);  
  document.getElementById("RawPassword").required = false;
  clearInput('RawPassword');
  return(PasswordInput); }
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / A funciton function to submit the Navigation Bar login form with AJAX & update the UI elements.
// / Also replaces the User input modal with the Password input modal after a Username has been sent.
$('#loginFormNav').on('submit', function (loginAjax) {
    loginAjax.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'core.php',
      data: $(this).serialize(),
      success: function(loginReponse) {
        var UserInput = document.getElementById('UserInput').value;
        var ClientTokenInput = loginReponse;
        toggleVisibility('loginModal');
        toggleVisibility('passwordModal');
        changeValue('ClientTokenInput', ClientTokenInput);
        changeValue('UserInput', UserInput); } }); });
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / A funciton function to submit the Navigation Bar login form with AJAX & update the UI elements.
$('#passwordFormNav').on('submit', function (loginAjax) { 
    loginAjax.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'core.php',
      data: $(this).serialize(),
      success: function(passwordResponse) {
        var responseArray = passwordResponse.split('\n');
        var UserInput = responseArray[0];
        var SessionID = responseArray[1];
        var ClientToken = responseArray[2];
        toggleVisibility('passwordContainer');
        toggleVisibility('successMessage');
        sleep(1000).then(() => {
          toggleVisibility('passwordModal'); }) },
      error: function(passwordResponse) {

        }, 
      complete: function(passwordResponse) { 

      } }); });
// / -----------------------------------------------------------------------------------

// / -----------------------------------------------------------------------------------
// / A function to test that JQuery is functional.
// / To test JQuery using this code, uncomment it and place an <a>TEST</a> somewhere on the page
  // / you want to test. If JQuery is working the <a> element should slowly disappear when clicked.
//$("a").click(function( event ) { 
  //event.preventDefault();
  //$(this).hide("slow"); });
// / -----------------------------------------------------------------------------------
