function toggle_visibility(id) {
  var e = document.getElementById(id);
  if(e.style.display == 'block')
     e.style.display = 'none';
  else
     e.style.display = 'block'; }
function goBack() {
  window.history.back(); }
function Clear() {    
  document.getElementById("input").value= ""; }
function ClearSearch() {    
  document.getElementById("search").value= ""; }
document.getElementById("HRAIMini").submit;