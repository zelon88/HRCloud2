// / Send the user back to the page they came from.
function goBack() {
  window.history.back(); }
  
function goBack() {
  window.location.reload(); }

// / Toggle the visibility of the specified Div.
function toggle_visibility(id) {
  var e = document.getElementById(id);
  if(e.style.display == 'block')
    e.style.display = 'none';
    else
      e.style.display = 'block'; }