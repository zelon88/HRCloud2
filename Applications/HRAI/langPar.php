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
$sesLogfile = ('/HRAI/sesLogs/'.$user_ID.'/'.$sesID.'/'.$sesID.'.txt');

require_once('/var/www/html/HRProprietary/HRAI/coreVar.php');
require_once($onlineFile);
require_once($coreFuncfile);

// / Load WordPress.
$detectWordPress = detectWordPress();
// / Detect the user and generate their UserID.
$verifyUser = verifyUser();
// / If the user is an administrator, load their credentials from AdminInfo.
$loadAdminInfo = loadAdminInfo();
// / Create a session directory if none exists.
$ForceCreateSesDir = forceCreateSesDir();
// / We call this function now because it gathers fresh info about the network and stores it in the nodeCache.
$n0stat = getNetStat();
// / Now that the nodeCache is up-to-date we can include it.
$serverID = getServIdent();

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






