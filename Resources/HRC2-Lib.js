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
function allowDrop(ev) {
  ev.preventDefault(); }
function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.id); }
function drop(ev) {
  ev.preventDefault();
  var data = ev.dataTransfer.getData("text");
  ev.target.appendChild(document.getElementById(data)); }