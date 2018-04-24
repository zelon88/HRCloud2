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
    function hide_visibility_name(name) {
      var e = document.getElementsByName(name);
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
    var songsrc = [];
    var index = 0;