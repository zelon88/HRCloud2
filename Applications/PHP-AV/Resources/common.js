function Clear() {    
  document.getElementById("AVScanTarget").value= ""; }

function toggle_visibility(id) {
  var e = document.getElementById(id);
  if(e.style.display == 'block')
    e.style.display = 'none';
  else
    e.style.display = 'block'; }

function goBack() {
  window.history.back(); }

function refreshIframe() {
  var frame = document.getElementById("consoleFrame");
  frame.src = frame.src; }