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

// / Toggle the border on the console button.
function toggle_border(id) {
  var f = document.getElementById(id);
  if(f.style.border == 'inset')
    f.style.border = 'outset';
    else
      f.style.border = 'inset'; }