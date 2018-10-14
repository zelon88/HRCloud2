<?php
function showFeeds($feedFileData) {
  //Read each feed's items
  $entries = array();
  foreach($feedFileData as $feed) {
    $feed = trim($feed);
    if ($feed == "" or $feed == " ") continue;
    $xml = simplexml_load_file($feed);
    $entries = array_merge($entries, $xml->xpath("//item")); }

    //Sort feed entries by pubDate
    usort($entries, function ($feed1, $feed2) {
      return strtotime($feed2->pubDate) - strtotime($feed1->pubDate); });
    ?>

    <ul><?php
    //Print all the entries
    foreach($entries as $entry) { ?>
      <li><a href="<?= $entry->link ?>"><?= $entry->title ?></a> (<?= parse_url($entry->link)['host'] ?>)
      <p><?= strftime('%m/%d/%Y %I:%M %p', strtotime($entry->pubDate)) ?></p>
      <p><?= $entry->description ?></p></li>
      <?php } ?>
    </ul>
<?php } 

