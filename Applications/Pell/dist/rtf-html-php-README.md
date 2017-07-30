# rtf-html-php
RTF to HTML converter in PHP

In a recent project, I desperately needed an RTF to HTML converter written in PHP. Googling around turned up some matches, but I could not get them to work properly. Also, one of them called passthru() to use a RTF2HTML executable, which is something I didn’t want. I was looking for an RTF to HTML converter written purely in PHP.

Since I couldn’t find anything ready-made, I sat down and coded one up myself. It’s short, and it works, implementing the subset of RTF tags that you’ll need in HTML and ignoring the rest. As it turns out, the RTF format isn’t that complicated when you really look at it, but it isn’t something you code a parser for in 15 minutes either.

## How to use it

Include the file rtf-html-php.php somewhere in your project. Then do this:

    $reader = new RtfReader();
    $rtf = file_get_contents("test.rtf"); // or use a string
    $result = $reader->Parse($rtf);
    
The parser will return TRUE if the RTF was parsed successfully, or FALSE is the RTF was malformed.

If you’d like to see what the parser read (for debug purposes), then call this (but only if the RTF was successfully parsed):

    $reader->root->dump();

To convert the parser’s parse tree to HTML, call this (but only if the RTF was successfully parsed):

    $formatter = new RtfHtml();
    echo $formatter->Format($reader->root);

## Install via Composer

```
composer require henck/rtf-to-html
```

#### Update 10 Mar '16:

* The RTF parser would either issue warnings or go into an infinite loop when parsing a malformed RTF. Instead, it now returns TRUE when parsing was successful, and FALSE if it was not.

#### Update 23 Feb '16:

* The RTF to HTML converter can now be installed through Composer (thanks to felixkiss).

#### Update 28 Oct '15:

* A bug causing control words to be misparsed occasionally is now fixed.

#### Update 3 Sep ’14:

* Fixed bug: underlining would start but never end. Now it does.
* Feature request: images are now filtered out of the output.
