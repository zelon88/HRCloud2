<?php

$WRDhello =  'hello';
$word = 'hello';
$ltrCount = strlen($word);

$noun = 0;
$pronoun = 0;
$verb = 0;
$adverb = 0;
$adj = 0;
$preposition = 0;
$conjunction = 0;
$interjection = 0;
$tense = 0;
$person = 0;
$plural = 0;
$greeting = 1;
$statement = 0;
$question = 0;
$attitude = 1;
$mood = 0;
$happy = 1;
$sad = 0;
$angry = 0;
$submissive = 0;
$dominant = 0;
$confidence = 0;
$positive = 1;
$negative = 0;
$sorry = 0;
$synonyms = array('Hello','hi');
$antonyms = array('Goodbye', 'bye', 'Bye');
$wordSearchMeta = array('a friendly greeting', 'hi there', 'hello there');


$baseWordHash =  "$word,$ltrCount,$noun,$pronoun,$verb,$adverb,$adj,$preposition,$conjunction,$interjection,$tense,$person,$plural,$greeting,$statement,$question,$attitude,$mood,$happy,$sad,$angry,$submissive,$dominant,$confidence,$positive,$negative,$sorry.";
$baseWordHash = str_replace(' ', '', $baseWordHash);

// / Set the wordHash for this word. This is an adjusted value according to the sentence it was parsed in,
$wordHash = "$word,$ltrCount,$noun,$pronoun,$verb,$adverb,$adj,$preposition,$conjunction,$interjection,$tense,$person,$plural,$greeting,$statement,$question,$attitude,$mood,$happy,$sad,$angry,$submissive,$dominant,$confidence,$positive,$negative,$sorry.";
$wordHash = str_replace(' ', '', $wordHash);
print ($wordHash);

// / When we are compiling words into a sentence hash, we consider the words that have already been 
// / through the langPar and write/rewrite certain flags appropriately. Each change can be noticed
// / by the langPar, allowing it to realize (inherit?) things like possesion of a noun by a noun,
// / or which adjectives enhance which specific part of the sentence.  
$sentNoun = ($sentNoun + $noun);
$sentPronoun = ($sentPronoun + $pronoun);
$sentVerb = ($sentVerb + $verb);
$sentAdverb = ($sentAdverb + $adverb);
$sentAdj = ($sentAdj + $adj);
$sentPreposition = ($sentPreposition + $preposition);
$sentConjunction = ($sentConjunction + $preposition);
$sentInterjection = ($sentInterjection + $interjection);

// / If the tense (past, present, or future {-1,0,1}) are set, we rewrite them to tell langPar 
// / that this word references a different part of the sentence.
$sentTense = $tense;
$sentPerson = $person;
$sentPlural = $plural;
$sentGreeting = ($sentGreeting + $greeting);
$sentStatement = ($sentStatement + $statement);
$sentQuestion = ($sentQuestion + $question);
$sentAttitude = ($sentAttitude + $attitude);
$sentMood = ($sentMood + $mood);
$sentHappy = ($sentHappy + $happy);
$sentSad = ($sentSad + $sad);
$sentAngry = ($sentAngry + $angry);
$sentSubmissive = ($sentSubmissive + $submissive);
$sentDominant = ($sentDominant + $dominant);
$sentConfidence = ($sentConfidence + $confidence);
$sentPositive = ($sentPositive + $positive);
$sentNegative = ($sentNegative + $negative);
$sentSorry = ($sentSorry + $sorry);

$sentWordHash = ("$word,$ltrCount,$sentNoun,$sentPronoun,$sentVerb,$sentAdverb,$sentAdj,$sentPreposition,$sentConjunction,$sentInterjection,$sentTense,$sentPerson,$sentPlural,$sentGreeting,$sentStatement,$sentQuestion,$sentAttitude,$sentMood,$sentHappy,$sentSad,$sentAngry,$sentSubmissive,$sentDominant,$sentConfidence,$sentPositive,$sentNegative,$sentSorry.");
$sentWordHash = str_replace(' ', '', $sentWordHash);
print ($sentWordHash);