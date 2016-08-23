<?php

// / When we are compiling words into a sentence hash, we consider the words that have already been 
// / through the langPar and write/rewrite certain flags appropriately. Each change can be noticed
// / by the langPar, allowing it to realize (inherit?) things like possesion of a noun by a noun,
// / or which adjectives enhance which specific part of the sentence.  
$sentNoun = 0;
$sentPronoun = 0;
$sentVerb = 0;
$sentAdverb = 0;
$sentAdj = 0;
$sentPreposition = 0;
$sentConjunction = 0;
$sentInterjection = 0;

// / If the tense (past, present, or future {-1,0,1}) are set, we rewrite them to tell langPar 
// / that this word references a different part of the sentence.
$sentTense = 0;
$sentPerson = 0;
$sentPlural = 0;
$sentGreeting = 0;
$sentStatement = 0;
$sentQuestion = 0;
$sentAttitude = 0;$sentMood = 0;$sentHappy = 0;$sentSad = 0;$sentAngry = 0;$sentSubmissive = 0;$sentDominant = 0;$sentConfidence = 0;
$sentPositive = 0;
$sentNegative = 0;$sentSorry = 0;

$baseSentHash =  ("$sentNoun$sentPronoun$sentVerb$sentAdverb$sentAdj$sentPreposition$sentConjunction$sentInterjection$sentTense$sentPerson$sentPlural$sentGreeting$sentStatement$sentQuestion$sentAttitude$sentMood$sentHappy$sentSad$sentAngry$sentSubmissive$sentDominant$sentConfidence$sentPositive$sentNegative$sentSorry");
