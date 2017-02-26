<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
  <script type="text/javascript">
    function toggle_visibility(id) {
       var e = document.getElementById(id); 
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block'; }
  </script>
<div>
 <div id="HRAIScanOptions0" name="HRAIScanOptions0" style="display: block;">
<?php
if ($user_ID == '0') {
echo nl2br('Unfortunately I cannot scan files for you at this time. Try logging in. '."\r".' I appologize, Commander.'); }
if ($user_ID > '0') {  ?>
<p><a id="nextbutton" name="nextbutton" href="#top" target="HRAIMini" style="max-width:100px; border-style: solid; border-color: MidnightBlue;" onclick="toggle_visibility('HRAIScanSubmit'); toggle_visibility('HRAIScanOptions1'); toggle_visibility('HRAIScanOptions0');">Next &#x2192</a></p>
  <p>Please enter a Cloud directory/filename to scan:</p>
  <p><input type="text" name='scanSelected' id='scanSelected' value=""></p> 
<?php } ?>

<script type="text/javascript">
$(document).ready(function () {
$("#HRAIScanSubmit").click(function(){
$.ajax( {
    type: 'POST',
    url: '/HRProprietary/HRCloud2/securityCore.php',
    data: { scanSelected : $("#scanSelected").val(),
        userscanfilename : $("#userscanfilename").val()
      },

    success: function(data) {
        window.location.href = "core.php";
    }
} );
});
});
</script>
</div>
