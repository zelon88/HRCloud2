<html>
  <head>
    <title>HRStreamer</title>
  </head>
  <body style="font-family:<?php echo $Font; ?>;">
  <script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
  <script type="text/javascript" src="Applications/HRStreamer/HRStreamerLib.js"></script>  
  <script type="text/javascript" src="Applications/HRStreamer/Resources/visualizer.js"></script>  
  <link rel="stylesheet" href="Applications/displaydirectorycontents_72716/style.css">
<?php 
// / Set global variables.
$hrstreamerAppVersion = 'v1.1';

// / Load the HRCloud2 commonCore.
$CCFile = 'commonCore.php';
if (!file_exists($CCFile)) {
  echo('ERROR!!! HRS26, CommonCore was not detected on the server.'.$br); }
  else require_once($CCFile); 

// / Load the getid3 library.
$getID3File = 'Applications/getid3/getid3/getid3.php';
if (!file_exists($getID3File)) {
  $txt = ('ERROR!!! HRS53, The getID3 module is not installed on the server on '.$Time.'!');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  die($txt); }
  else require_once($getID3File); 

// / Set POST variables.-
if(isset($_GET['playlistSelected']) or isset($_POST['playlistSelected'])) {
  $_POST['playlistSelected'] = $_GET['playlistSelected']; }

// / The following code is performed whnenever there is a playlistSelected.
if(isset($_GET['playlistSelected']) or isset($_POST['playlistSelected'])) {
  $RandomImageFile = 'Applications/HRStreamer/Resources/RandomImageFile.png';
  $PlaylistName = $_POST['playlistSelected'];  
  $PlaylistDir = $CloudTempDir.'/'.$PlaylistName;
  $PlaylistCloudDir = $CloudDir.'/'.$PlaylistName;
  $PlaylistURL = $URL.'/HRProprietary/HRCloud2/DATA/'.$UserID.'/'.$PlaylistName;
  $NotStreamable = array('.', '..', '/', 'index.php', 'index.html', '.Cache');
  if (!file_exists($PlaylistDir)) {
    mkdir($PlaylistDir, $ILPerms);
    copy($InstLoc.'/index.html', $PlaylistDir.'/index.html');
    foreach ($iterator = new \RecursiveIteratorIterator (
      new \RecursiveDirectoryIterator ($PlaylistCloudDir, \RecursiveDirectoryIterator::SKIP_DOTS),
      \RecursiveIteratorIterator::SELF_FIRST) as $item) {
      $PD = $PlaylistDir.DIRECTORY_SEPARATOR.$iterator->getSubPathName();
        if (is_dir($item)) {
          if (!is_dir($PD)) {
            mkdir($PD, $CLPerms); 
            continue; } }
        else {
            if (!is_link($item) && !file_exists($PD)) {
              symlink($item, $PD); } } } }
    if (!file_exists($PlaylistDir)) {
      $txt = ('ERROR!!! HRS86, The PlaylistDir does not exist on '.$Time.'!');
      $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
      die($txt); }
  $PlaylistNameRAW = str_replace('.Playlist', '', $PlaylistName); }
  else {
    $txt = ('ERROR!!! HRS70, There was no playlist selected on '.$Time.'!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    die($txt); }
?>
  <div align="center">
  <h3><?php echo $PlaylistNameRAW; ?></h3>
  </div>
  <hr />
<?php  
  // / If the selected playlist name does not contain .playlist, kill the script.
  if (strpos($PlaylistDir, '.Playlist') == FALSE) {
    $txt = ('ERROR!!! HRS60, The selected playlist is not a valid HRCloud2 ".playlist" file on '.$Time.'!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    die('ERROR!!! HRS60, The selected playlist is not a valid HRCloud2 ".playlist" file on '.$Time.'!'); }
// If the playlist file exists, read the album art and song data to separate arrays.
if (file_exists($PlaylistDir)) {
  $txt = ('OP-Act: User '.$UserID.' initiated HRStreamer on '.$Time.'.');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  $PLImageArr = array('jpg', 'jpeg', 'bmp', 'png', 'gif');  
  $PLAudioArr =  array('mp3', 'mp4', 'wma', 'wav', 'aac', 'avi', 'm4a');
  $PLAudioOGGArr =  array('ogg');  
  $PlaylistArtArr = array();
  $PlaylistSongArr = array();
  $PlaylistCacheDir = $PlaylistDir.'/.Cache';
  $PlaylistCacheFile = $PlaylistCacheDir.'/cache.php';
  $PlaylistFiles = scandir($PlaylistDir); 
  if (!file_exists($PlaylistCacheFile)) {
    $txt = ('ERRPR!!! HRS79, This Playlist does not contain a valid cache file on '.$Time.'.');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND); 
    die($txt); }
  if (strpos($PlaylistDir, '.Playlist') == FALSE) {
    $txt = ('ERROR!!! HRS68, '.$PlaylistDir.' is not a valid .Playlist file!');
    $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
    die($txt); }
  require($PlaylistCacheFile);
  // / Separate the album art from the songs within the $PlaylistFiles.
    $PLCount = 0;
    $PLImageCount = 0;
    $PLSongCount = 0;
  foreach ($PlaylistFiles as $PlaylistFile) {
    if (is_dir($PlaylistFile) or in_array($PlaylistFile, $NotStreamable)) continue;     
      $PLCount++; 
      $pathname = $PlaylistDir.'/'.$PlaylistFile;
      $newPathname = $PlaylistDir.'/'.$PlaylistName.'.ogg';
      $filename = pathinfo($pathname, PATHINFO_FILENAME);
      $oldExtension = pathinfo($pathname, PATHINFO_EXTENSION);
    if (in_array($oldExtension, $PLAudioOGGArr)) {
      array_push($PlaylistSongArr, $PlaylistFile); 
      $PLSongCount++;}
    if (in_array($oldExtension, $PLImageArr)) {
      array_push($PlaylistArtArr, $PlaylistFile); 
      $PLImageCount++; } } }
if (!file_exists($PlaylistDir)) { 
  $txt = ('ERROR!!! HRS122, The selected playlist does not exist on '.$Time.'!');
  $MAKELogFile = file_put_contents($LogFile, $txt.PHP_EOL , FILE_APPEND);
  die('ERROR!!! HRS122, The selected playlist does not exist on '.$Time.'!'); }
?>      
<div>
<?php
$SongCount = 0;
echo ('<div align="center" style="padding-bottom:2px; width:200px; float:right; clear:right;"><strong>Music</strong>');
foreach ($PlaylistSongArr as $PlaylistSong) {
  $SongCount++; 
  $imageCorrupt = FALSE;
  if (is_dir($PlaylistSong) or in_array($PlaylistSong, $NotStreamable)) continue;
  $PlaylistImageURL = $PlaylistURL.'/.Cache/'.$SongCount.'.jpg';
  $PlaylistSongImageFile = $PlaylistCacheDir.'/'.$SongCount.'.jpg';
  // / Check if the image is corrupt. If it is, use a default one instead.
  if (!file_exists($PlaylistSongImageFile)) $imageCorrupt = TRUE;
  if ($imageCorrupt == FALSE) if (getimagesize($PlaylistSongImageFile) === FALSE) $imageCorrupt = TRUE;
  if ($imageCorrupt == TRUE) { 
    $PlaylistSongImageFile = $InstLoc.'/'.$RandomImageFile;
    $PlaylistImageURL = $URL.'/HRProprietary/HRCloud2/'.$RandomImageFile; }
  echo('</div><div id="PlaylistSong'.$SongCount.'" name="PlaylistSong'.$SongCount.'" style="display:block; width:200px; float:right; clear:right;"><hr />'); ?>

  <script type="text/javascript">window.AudioContext = window.AudioContext || window.webkitAudioContext || window.mozAudioContext;
    function visualizeSong<?php echo $SongCount; ?>() {
      var audio<?php echo $SongCount; ?> = document.getElementById('song<?php echo $SongCount; ?>');
      var ctx<?php echo $SongCount; ?> = new AudioContext();
      var analyser<?php echo $SongCount; ?> = ctx<?php echo $SongCount; ?>.createAnalyser();
      var audioSrc<?php echo $SongCount; ?> = ctx<?php echo $SongCount; ?>.createMediaElementSource(audio<?php echo $SongCount; ?>);
      audioSrc<?php echo $SongCount; ?>.connect(analyser<?php echo $SongCount; ?>);
      analyser<?php echo $SongCount; ?>.connect(ctx<?php echo $SongCount; ?>.destination);
      var frequencyData<?php echo $SongCount; ?> = new Uint8Array(analyser<?php echo $SongCount; ?>.frequencyBinCount);

      var canvas<?php echo $SongCount; ?> = document.getElementById('VisualizerCanvas'),
          cwidth<?php echo $SongCount; ?> = canvas<?php echo $SongCount; ?>.width,
          cheight<?php echo $SongCount; ?> = canvas<?php echo $SongCount; ?>.height - 2,
          meterWidth<?php echo $SongCount; ?> = 10,
          gap<?php echo $SongCount; ?> = 2, 
          capHeight<?php echo $SongCount; ?> = 2,
          capStyle<?php echo $SongCount; ?> = '#fff',
          meterNum<?php echo $SongCount; ?> = 800 / (10 + 2), 
          capYPositionArray<?php echo $SongCount; ?> = []; 
      ctx<?php echo $SongCount; ?> = canvas<?php echo $SongCount; ?>.getContext('2d'),
      gradient<?php echo $SongCount; ?> = ctx<?php echo $SongCount; ?>.createLinearGradient(0, 0, 0, 300);
      gradient<?php echo $SongCount; ?>.addColorStop(1, '#0f0');
      gradient<?php echo $SongCount; ?>.addColorStop(0.5, '#ff0');
      gradient<?php echo $SongCount; ?>.addColorStop(0, '#f00');
      function renderFrame<?php echo $SongCount; ?>() {
          var array<?php echo $SongCount; ?> = new Uint8Array(analyser<?php echo $SongCount; ?>.frequencyBinCount);
          analyser<?php echo $SongCount; ?>.getByteFrequencyData(array<?php echo $SongCount; ?>);
          var step<?php echo $SongCount; ?> = Math.round(array<?php echo $SongCount; ?>.length / meterNum<?php echo $SongCount; ?>); 
          ctx<?php echo $SongCount; ?>.clearRect(0, 0, cwidth<?php echo $SongCount; ?>, cheight<?php echo $SongCount; ?>);
          for (var i<?php echo $SongCount; ?> = 0; i<?php echo $SongCount; ?> < meterNum<?php echo $SongCount; ?>; i<?php echo $SongCount; ?>++) {
              var value<?php echo $SongCount; ?> = array<?php echo $SongCount; ?>[i<?php echo $SongCount; ?> * step<?php echo $SongCount; ?>];
              if (capYPositionArray<?php echo $SongCount; ?>.length < Math.round(meterNum<?php echo $SongCount; ?>)) {
                  capYPositionArray<?php echo $SongCount; ?>.push(value<?php echo $SongCount; ?>);
              };
              ctx<?php echo $SongCount; ?>.fillStyle = capStyle<?php echo $SongCount; ?>;
              if (value<?php echo $SongCount; ?> < capYPositionArray<?php echo $SongCount; ?>[i<?php echo $SongCount; ?>]) {
                  ctx<?php echo $SongCount; ?>.fillRect(i<?php echo $SongCount; ?> * 12, cheight<?php echo $SongCount; ?> - (--capYPositionArray<?php echo $SongCount; ?>[i<?php echo $SongCount; ?>]), meterWidth<?php echo $SongCount; ?>, capHeight<?php echo $SongCount; ?>);
              } else {
                  ctx<?php echo $SongCount; ?>.fillRect(i<?php echo $SongCount; ?> * 12, cheight<?php echo $SongCount; ?> - value<?php echo $SongCount; ?>, meterWidth<?php echo $SongCount; ?>, capHeight<?php echo $SongCount; ?>);
                  capYPositionArray<?php echo $SongCount; ?>[i<?php echo $SongCount; ?>] = value<?php echo $SongCount; ?>;
              };
              ctx<?php echo $SongCount; ?>.fillStyle = gradient<?php echo $SongCount; ?>;
              ctx<?php echo $SongCount; ?>.fillRect(i<?php echo $SongCount; ?> * 12 /*meterWidth+gap*/ , cheight<?php echo $SongCount; ?> - value<?php echo $SongCount; ?> + capHeight<?php echo $SongCount; ?>, meterWidth<?php echo $SongCount; ?>, cheight<?php echo $SongCount; ?>); 
          }
      requestAnimationFrame(renderFrame<?php echo $SongCount; ?>);
      }
      renderFrame<?php echo $SongCount; ?>();
    };</script>
  <div align="left"><p><strong><i><a style="float:left;"><?php echo $SongCount.'. '; ?></a></i></strong><img id="hideplay<?php echo $SongCount; ?>" name="hideplay<?php echo $SongCount; ?>" 
    onclick="hide_visibility_name('buttonbar'); stopAllAudio(); hide_visibility('hideplay<?php echo $SongCount; ?>'); show_visibility('play<?php echo $SongCount; ?>');  
      toggle_visibility('buttonbar<?php echo $SongCount; ?>');" 
    style="float:left; padding-right:5px; padding-left:5px; display:none;" src="Applications/HRStreamer/Resources/streamflipped.png">
  <img id="play<?php echo $SongCount; ?>" name="play<?php echo $SongCount; ?>" 
    onclick="visualizeSong<?php echo $SongCount; ?>(); hide_visibility_name('buttonbar'); startAudio('song<?php echo $SongCount; ?>'); toggle_visibility('hideplay<?php echo $SongCount; ?>'); toggle_visibility('play<?php echo $SongCount; ?>'); 
      toggle_visibility('buttonbar<?php echo $SongCount; ?>'); document.getElementById('AlbumImage').src='<?php echo $PlaylistImageURL; ?>';" 
    style="float:left; padding-right:5px; padding-left:5px; display:block;" src="Applications/HRStreamer/Resources/stream.png"></p></div>
<?php
  echo($br.'<strong>'.$PlaylistSong.'</strong>'.$br); 
  echo('<div align="center"><p id="moreInfoLink'.$SongCount.'" style="display:block;" onclick="toggle_visibility(\'PlaylistSongInfo'.$SongCount.'\'); toggle_visibility(\'moreInfoLink'.$SongCount.'\');"><i>More Info</i></p></div>'); ?>
  <div id="PlaylistSongInfo<?php echo $SongCount; ?>" name="PlaylistSongInfo<?php echo $SongCount; ?>" style="display:none;"><?php 
  echo('<div align="center"><p onclick="toggle_visibility(\'PlaylistSongInfo'.$SongCount.'\'); toggle_visibility(\'moreInfoLink'.$SongCount.'\');"><i>Less Info</i></p></div>');
  echo('<a id="moreInfo" name="moreInfo"><i>Artist: </i>'.${'PLSongArtist'.$SongCount}.$br.'<i>Title: </i>'.${'PLSongTitle'.$SongCount}.$br.'<i>Album: </i>'.${'PLSongAlbum'.$SongCount}.'</a>'); ?>

<div align="center"><img id="FileImage" src="<?php echo $PlaylistImageURL;?>" style="max-width:100px; max-height:100px;" onclick="document.getElementById('AlbumImage').src='<?php echo $PlaylistImageURL;?>'"></div>
</div></div>
<?php } ?>
<div id="artwork" name="artwork" align="center" style="max-width:65%;">
  <div id="Visualizer" name="Visualizer" style="display:none;">
    <canvas id="VisualizerCanvas" name="VisualizerCanvas" width="400px" height="300px"></canvas>
  </div>
  <img id="AlbumImage" name="AlbumImage" style="display:block; max-width:400px; padding-left:15px; padding-top:15px;" src="<?php echo $RandomImageFile; ?>">
</div> 

<div id="media" name="media" align="center" style="max-width:65%;">
  <?php  
  $SongCount = 0;    
  foreach ($PlaylistFiles as $PlaylistFile) {
    if (is_dir($PlaylistFile) or in_array($PlaylistFile, $NotStreamable)) continue;  
    $SongCount++; 
    $pathname = $PlaylistDir.'/'.$PlaylistFile; ?>
  <div align="center" class="buttonbar" id="buttonbar<?php echo $SongCount; ?>" name="buttonbar" style="display:none;">
    <strong><?php echo $PlaylistFile; ?></strong>
    <hr />
    <div align="center" id='autosong' name='autosong'>
      <audio id="song<?php echo $SongCount; ?>" name='song<?php echo $SongCount; ?>' preload="auto" onended="toggle_visibility('play<?php echo ($SongCount + 1); ?>'); toggle_visibility('hideplay<?php echo ($SongCount + 1); ?>'); toggle_visibility('play<?php echo $SongCount; ?>'); toggle_visibility('hideplay<?php echo $SongCount; ?>'); show_visibility('buttonbar<?php echo ($SongCount + 1); ?>'); hide_visibility('buttonbar<?php echo $SongCount; ?>'); document.getElementById('song<?php echo ($SongCount + 1); ?>').play();" controls="true" src="<?php echo 'DATA/'.$UserID.'/'.$PlaylistName.'/'.$PlaylistFile; ?>" type="audio/ogg" style="width:390px;"></audio>
      <hr />
    </div> 
  </div>        
      <?php } ?> 
  <div id="ShowVisualizerButtonBar" name="ShowVisualizerButtonBar" style="float:center;">
    <img id="ShowVisualizerButton" name="ShowVisualizerButton" alt="Show Visualizer (Hide Artwork)" title="Show Visualizer (Hide Artwork)" style="display:block;" onclick="toggle_visibility('Visualizer'); toggle_visibility('AlbumImage'); toggle_visibility('HideVisualizerButton'); toggle_visibility('ShowVisualizerButton');" src="Applications/HRStreamer/Resources/visualizer.png">
    <img id="HideVisualizerButton" name="HideVisualizerButton" alt="Show Artwork (Hide Visualizer)" title="Show Artwork (Hide Visualizer)" style="display:none;" onclick="toggle_visibility('Visualizer'); toggle_visibility('AlbumImage'); toggle_visibility('ShowVisualizerButton'); toggle_visibility('HideVisualizerButton');" src="Applications/HRStreamer/Resources/image.png">
  </div>
</div>

  </body>
</html>