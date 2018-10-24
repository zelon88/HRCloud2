    function toggle_visibility(id) {
      var e = document.getElementById(id);
      if(e.style.display == 'block')
        e.style.display = 'none';
      else
        e.style.display = 'block'; }
    function show_visibility(id) {
      var e = document.getElementById(id);
      e.style.display = 'block'; }
    function hide_visibility(id) {
      var e = document.getElementById(id);
      e.style.display = 'none'; }
    function goBack() {
      window.history.back(); }
    function stopAllAudio() {
      var sounds = document.getElementsByTagName('audio');
      for(i=0; i<sounds.length; i++) sounds[i].pause(); }
    function startStopSelectedAudio(id) {
      var myAudio = document.getElementById(id);
      if (myAudio.paused) {
        myAudio.play(); } 
      else {
        myAudio.pause(); } }
    function startAudio(id) {
      var myAudio = document.getElementById(id);
      myAudio.play(); }
    var songsrc = [];
    var index = 0;
    function hide_visibility_class(ele) {
    let divs = document.getElementsByClassName(ele);
    for (let x = 0; x < divs.length; x++) {
      let div = divs[x];
      div.style.display = 'none'; } }
    function hide_visibility_name(ele) {
    let divs = document.getElementsByName(ele);
    for (let x = 0; x < divs.length; x++) {
      let div = divs[x];
      div.style.display = 'none'; } }