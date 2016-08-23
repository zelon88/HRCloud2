<?php
session_start();
// / This is the english language parser for HRAI written by Justin Grimes starting on 3/28/2016.
// / The goal of this file is to break down complex sentences into a complex identifier that can
// / be fed to a set of algorithms that break down human speech into a set of satisfiable conditions.
// / Through the parsing process we will incorporate statistical relational learning, as well as 
// / machine reading and machine learning abilities to create databases of information we can use.
// / 
// / This file is also capable of detecting the available system resources and outsourcing work
// / to an established member of the HRAI network. When outsourcing work, the language parser will
// / POST data to other HRAI servers for processing. We may also POST out some data if we need to
// / perform concurrent research and/or learning functions and we anticipate not having enough 
// / resources. Because the language parser only receives and sends data to the userGUI, we don't
// / are able to POST data to and from scripts as many times as we like before giving a response
// / to the user.
$coreVarfile = '/var/www/html/HRProprietary/HRAI/coreVar.php';
$coreFuncfile = '/var/www/html/HRProprietary/HRAI/coreFunc.php';
$CallForHelpURL = '/var/www/html/HRProprietary/HRAI/CallForHelp.php';
$coreFile = 'http://localhost/HRProprietary/HRAI/core.php';
$nodeCache = 'http://localhost/HRProprietary/HRAI/Cache/nodeCache.php';

require_once($coreFuncfile);
  $user_ID = defineUser_ID();
if (file_exists($wpfile)){
require_once($wpfile);
global $current_user;
get_currentuserinfo();
$user_ID = get_current_user_id();
if ($user_ID == 1) {
include '/var/www/html/HRProprietary/HRAI/adminINFO.php'; }
if ($user_ID !== 1) {
$display_name = get_currentuserinfo() ->$display_name; } }
if ($user_ID == 0) {
  $display_name = $_POST['display_name']; }
  $input = defineUserInput(); 
  $inputServerID = defineInputServerID();
  $sesIDhash = hash('sha1', $display_name.$day);
  $sesID = substr($sesIDhash, -7); 
if(isset($_POST['sesID'])) {
  $sesID = $_POST['sesID']; }
  if(isset($_POST['user_ID'])) {
  $user_ID = $_POST['user_ID']; }
  if(isset($_POST['sesID'])) {
  $display_name = $_POST['display_name']; }

$ForceCreateSesDir = forceCreateSesDir();

$sesLogfile = ('/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.$sesID.'.txt');
require_once ($coreVarfile);
require_once ($onlineFile);
// / We call this function now because it gathers fresh info about the network and stores it in the nodeCache.
$n0stat = getNetStat();
// / Now that the nodeCache is up-to-date we can include it.
include_once ($nodeCache);
$serverID = getServIdent();
$dataArr = array('user_ID' =>  "$user_ID",
            'input' => "$input",
            'display_name' =>  '$display_name',
            'sesID' => '$sesID',
            'serverID' => '$serverID');
// / If we have a logfile we continue the script. If not we pass the variables we've got to core.php
// / to establish a session. 
if (!file_exists($sesLogfile)) {
// / We can POST a file by prefixing with an @ (for <input type="file"> fields)
  $handle = curl_init($coreFile);
  curl_setopt($handle, CURLOPT_POST, true);
  curl_setopt($handle, CURLOPT_POSTFIELDS, $dataArr);
  curl_exec($handle); 
  if (!file_exists($sesLogfile)) {
  echo nl2br('The core is not synced!'."\r"); } 
  die ('Sent data to coreFile to generate a session ID.'); }

// / Node0 is the server currently running this script. If it reports that it is busy from we will
// / check for other nodes to handle our request, and gather if they are busy or not. If they are 
// / also busy we skip them and remove them from the nodeCache.
include($nodeCache);
if ($node0Busy == 1) {
  // / Check to see if our nodes are busy. If they are we drop the nodeCount and try again.
  if ($nodeCount <= 1) {
    $useNodeBusy = ${"node" . $nodeCount. "Busy"};
      if ($useNodeBusy = 1) {
        $nodeCount = ($nodeCount - 1);
        $useNodeBusy = ${"node" . $nodeCount. "Busy"}; }
  if ($nodeCache <= 1) {
    $useNodeBusy = ${"node" . $nodeCount. "Busy"};
      if ($useNodeBusy = 1) {
        $nodeCount = ($nodeCount - 1);
        $useNodeBusy = ${"node" . $nodeCount. "Busy"}; }
  if ($nodeCache <= 1) {
    $useNodeBusy = ${"node" . $nodeCount. "Busy"};
      if ($useNodeBusy = 1) {
        $nodeCount = ($nodeCount - 1);
        $useNodeBusy = ${"node" . $nodeCount. "Busy"}; }
  if ($nodeCache <= 1) {
    $useNodeBusy = ${"node" . $nodeCount. "Busy"};
      if ($useNodeBusy = 1) {
        $nodeCount = ($nodeCount - 1);
        $useNodeBusy = ${"node" . $nodeCount. "Busy"}; }
  if ($nodeCache <= 1) {
    $useNodeBusy = ${"node" . $nodeCount. "Busy"};
      if ($useNodeBusy = 1) {
        $nodeCount = ($nodeCount - 1);
        $useNodeBusy = ${"node" . $nodeCount. "Busy"}; }
  if ($nodeCache <= 1) {
    $useNodeBusy = ${"node" . $nodeCount. "Busy"};
      if ($useNodeBusy = 1) {
        $nodeCount = ($nodeCount - 1);
        $useNodeBusy = ${"node" . $nodeCount. "Busy"}; }
  if ($nodeCache <= 1) {
    $useNodeBusy = ${"node" . $nodeCount. "Busy"};
      if ($useNodeBusy = 1) {
        $nodeCount = ($nodeCount - 1);
        $useNodeBusy = ${"node" . $nodeCount. "Busy"}; }
  if ($nodeCache <= 1) {
    $useNodeBusy = ${"node" . $nodeCount. "Busy"};
      if ($useNodeBusy = 1) {
        $nodeCount = ($nodeCount - 1);
        $useNodeBusy = ${"node" . $nodeCount. "Busy"}; }
  if ($nodeCache <= 1) {
    $useNodeBusy = ${"node" . $nodeCount. "Busy"};
      if ($useNodeBusy = 1) {
        $nodeCount = ($nodeCount - 1);
        $useNodeBusy = ${"node" . $nodeCount. "Busy"}; 
    // / Now that we've eliminated servers that are busy, we send the request to the next available node.
    $useNode = ${"node" . $nodeCount. "URL"};
    $handle = curl_init($useNode.'/langPar.php');
    curl_setopt($handle, CURLOPT_POST, true);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $dataArr);
    curl_exec($handle); 
    // / And write an entry to the sesLog.
    $sesLogfile0 = fopen("$sesLogfile", "a+");
    $txt = ('LangPar: '."User $display_name".','." $user_ID during $sesID on $date".'. Node0 is busy. 
      Sending request to node '.$useNode.'. NodeCount is '.$nodeCount.'.');
    $compLogfile = file_put_contents($sesLogfile, $txt.PHP_EOL , FILE_APPEND); 
    // / Before we kill the script on this server we update our nodeCache file.
    $n0stat = getNetStat();
    // / And finally we can give this server a break to finish doing what it's doing.
    die ('This request was sent to node '.$useNode.' for processing. '); } } } } } } } } } } }  

// / Before we begin, we define and create a convCache.php file in the sesDir to store our input hash 
// / variables. The lines below create a blank cacheFile and makes sure it begins with <?php.
$convCachefile = ('/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.'convCache.php');
  if (!file_exists($convCachefile)) {
    $convCachefile = ('/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.'convCache.php');
    $convCache0 = fopen("$convCachefile", "a+");
    $txt = ("<?php"."\r");
    $compConvCachefile = file_put_contents($convCachefile, $txt.PHP_EOL , FILE_APPEND); }

// / We read and echo the contents of our convLog for this sesID. We also post any inputs to the convLog as well.
$convLogfile = ('/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.'convLog.txt');
if (isset($input)) {  
    $convLog0 = fopen("$convLogfile", "a+");
    $txt = ("$display_name".': '."$input"."\r");
    $compConvLogfile = file_put_contents($convLogfile, $txt.PHP_EOL , FILE_APPEND); }
echo nl2br("\r");
echo nl2br(file_get_contents($convLogfile));

// / Define the start of a langPar request by defining the base sentVariables. These should all default to
// / zero and then be adjusted by server mood and emotion, then modified furthur by the structure of each
// / fragment, sentence, and word (and the combined structure/architecture of each).
$langParVarfile = ('/var/www/html/HRProprietary/HRAI/langParVar.php');
require_once ($langParVarfile);

// / A sentence is defined as a user inputed string that terminates with a period.
// / returns an array of separate sentences.
if (strpos($input, '.') !== false) {  
  $sentences = $input;
  // / Count the number of '.' within $sentences.
  $sentCount = substr_count($sentences,'.');
  if ($sentCount > 1){
    $sentencesSplit = preg_split("/.!?/", $sentences);  
    $sentences = (explode('.', $input));
    $SentArrCount = array_count_values($sentencesSplit);
    foreach ($sentences as $sentence) {
// / Count the number of words within a sentence.
      $WordOfSentArr = str_word_count($sentence, 1, 'àáãç3');  
print_r($WordOfSentArr);  
  foreach($WordOfSentArr as $word) {
    $wordFile = "/var/www/html/HRProprietary/HRAI/Databse/Words/$word.php";
    include ($wordFile);
    $sentHash = ("$sentNoun,$sentPronoun,$sentVerb,$sentAdverb,$sentAdj,$sentPreposition,$sentConjunction,$sentInterjection,$sentTense,$sentPerson,$sentPlural,$sentGreeting,$sentStatement,$sentQuestion,$sentAttitude,$sentMood,$sentHappy,$sentSad,$sentAngry,$sentSubmissive,$sentDominant,$sentConfidence,$sentPositive,$sentNegative,$sentSorry.");
    $convCachefile = ('/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.'convCache.php');
    $convCache0 = fopen("$convCachefile", "a+");
    $txt = ('$word'."$word".' = array('."\"$wordHash\"".', '."\"$sentWordHash\"".', '."\"$sentHash\"".');'."\r");
    $compConvCachefile = file_put_contents($convCachefile, $txt.PHP_EOL , FILE_APPEND); } } 
    
    $sentHash = ("$sentNoun,$sentPronoun,$sentVerb,$sentAdverb,$sentAdj,$sentPreposition,$sentConjunction,$sentInterjection,$sentTense,$sentPerson,$sentPlural,$sentGreeting,$sentStatement,$sentQuestion,$sentAttitude,$sentMood,$sentHappy,$sentSad,$sentAngry,$sentSubmissive,$sentDominant,$sentConfidence,$sentPositive,$sentNegative,$sentSorry.");
    $convCachefile = ('/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.'convCache.php');
    $convCache0 = fopen("$convCachefile", "a+");
    $txt = ('$sentHash = '."$sentHash".';'."\r");
    $compConvCachefile = file_put_contents($convCachefile, $txt.PHP_EOL , FILE_APPEND);} }  
  elseif ($sentCount = '') {
    $sentCount = 1;
    $sentence = $input;
    $WordOfSentArr = str_word_count($sentence, 1, 'àáãç3'); 
print_r($WordOfSentArr);  
  foreach($WordOfSentArr as $word) {
    $wordFile = "/var/www/html/HRProprietary/HRAI/Database/Words/$word.php";
    include ($wordFile);
    $sentHash = ("$sentNoun,$sentPronoun,$sentVerb,$sentAdverb,$sentAdj,$sentPreposition,$sentConjunction,$sentInterjection,$sentTense,$sentPerson,$sentPlural,$sentGreeting,$sentStatement,$sentQuestion,$sentAttitude,$sentMood,$sentHappy,$sentSad,$sentAngry,$sentSubmissive,$sentDominant,$sentConfidence,$sentPositive,$sentNegative,$sentSorry.");
    $convCachefile = ('/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.'convCache.php');
    $convCache0 = fopen("$convCachefile", "a+");
    $txt = ('$word'."$word".' = array('."\"$wordHash\"".', '."\"$sentWordHash\"".', '."\"$sentHash\"".');'."\r");
    $compConvCachefile = file_put_contents($convCachefile, $txt.PHP_EOL , FILE_APPEND); } 

    $sentHash = ("$sentNoun,$sentPronoun,$sentVerb,$sentAdverb,$sentAdj,$sentPreposition,$sentConjunction,$sentInterjection,$sentTense,$sentPerson,$sentPlural,$sentGreeting,$sentStatement,$sentQuestion,$sentAttitude,$sentMood,$sentHappy,$sentSad,$sentAngry,$sentSubmissive,$sentDominant,$sentConfidence,$sentPositive,$sentNegative,$sentSorry.");
    $convCachefile = ('/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.'convCache.php');
    $convCache0 = fopen("$convCachefile", "a+");
    $txt = ('$sentHash = '."$sentHash".';'."\r");
    $compConvCachefile = file_put_contents($convCachefile, $txt.PHP_EOL , FILE_APPEND); }    



elseif (!strpos($input, '.') !== false) {
  $sentence = $input; 
  $sentOfWordarr = str_word_count($sentence, 1, 'àáãç3'); 
print_r($sentOfWordarr); 
foreach ($sentOfWordarr as $word) {
    $wordFile = "/var/www/html/HRProprietary/HRAI/Database/Words/$word.php";
    include ($wordFile); 
    $sentHash = ("$sentNoun,$sentPronoun,$sentVerb,$sentAdverb,$sentAdj,$sentPreposition,$sentConjunction,$sentInterjection,$sentTense,$sentPerson,$sentPlural,$sentGreeting,$sentStatement,$sentQuestion,$sentAttitude,$sentMood,$sentHappy,$sentSad,$sentAngry,$sentSubmissive,$sentDominant,$sentConfidence,$sentPositive,$sentNegative,$sentSorry.");
    $convCachefile = ('/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.'convCache.php');
    $convCache0 = fopen("$convCachefile", "a+");
    $txt = ('$word'."$word".' = array('."\"$wordHash\"".', '."\"$sentWordHash\"".', '."\"$sentHash\"".');'."\r");
    $compConvCachefile = file_put_contents($convCachefile, $txt.PHP_EOL , FILE_APPEND); } 
    
    $sentHash = ("$sentNoun,$sentPronoun,$sentVerb,$sentAdverb,$sentAdj,$sentPreposition,$sentConjunction,$sentInterjection,$sentTense,$sentPerson,$sentPlural,$sentGreeting,$sentStatement,$sentQuestion,$sentAttitude,$sentMood,$sentHappy,$sentSad,$sentAngry,$sentSubmissive,$sentDominant,$sentConfidence,$sentPositive,$sentNegative,$sentSorry.");
    $convCachefile = ('/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.'convCache.php');
    $convCache0 = fopen("$convCachefile", "a+");
    $txt = ('$sentHash = '."$sentHash".';'."\r");
    $compConvCachefile = file_put_contents($convCachefile, $txt.PHP_EOL , FILE_APPEND); } 

echo nl2br("\r");
print ($sentHash);


// / A fragment is defined as a selection of text within a sentence that terminates with a comma.
// / Returns an array of separate arrays.
if (strpos($input, ',') !== false) {
$fragments = implode(',', array_slice(explode(',', $input), 0, $sentOfWordArr));
  foreach ($fragments as $fragment) {
  // / Count the number of words within a fragment.
  $fragWordCount = str_word_count($fragment, 1, 'àáãç3');

  } }
elseif (!strpos($input, ',') !== false) { }

// / If we need to select a part of a section we define the selection by wordcount from the beginning
// / of a user inputted string.
//$selection1 = $_POST['selection1'];
  //if(empty($selection1)) {
  	//$selection1 = 0; }
//$selection2 = $_POST['selection2'];
  //if(empty($selection2)) {
  	//$selection2 = 0; }


// / The meaning of a word is interpreted by the HRAI language parser as a hasb based on the type of wordType 
// / (question, statement, command, opinionOut, opinionIn), the wordStat (verb, noun, adjective), the wordTense
// / (past, present, future), the WordWeight (very negative, negative, neutral, positive, very positive), an array
// / of synonyms, an array of antonyms, and a satisfy flag (wordSatisfy) that tells us if the word is to be ignored
// / responded to directly, or included within a part of another response (basically the priority of the word based on 
// / other words around it).
//function getWordMeaning($words) {
  //foreach ($words as $word) {
 //$currentEmo = getCurrentEmo();
 //$impliedEmo = getImpliedEmo($word);
 //$wordHash = (' '.getFirstWord($word).' '.getWordType($word).' '.getWordStat($word).' '.getWordTense($word).' '
   //.getWordWeight($word).' '.getWordSynArr($word).' '.getWordAntArr($word).' '.$getWordSatisfy($word).' '); }
  //return($wordHash);
//}


// /Get the first word of a sentence and determine the nature of it.
//function getFirstWord($sentence) {
//$words = implode(' ', array_slice(explode(' ', $sentence));
//$firstW = implode(' ', array_slice(explode(' ', $sentence), 0, 1)); }
 //if $firstW (in_array($wordTypeQ)) {
   


  //}

//function getWordsCust($sentence) {
//$words = implode(' ', array_slice(explode(' ', $sentence));
//$first10 = implode(' ', array_slice(explode(' ', $sentence), 0, 10)); 





//All data below this line is machine generated code.


?>
<div id="end"></div>






