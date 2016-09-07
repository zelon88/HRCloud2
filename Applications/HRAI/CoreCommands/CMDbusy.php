<?php
if (getServBusy() == 1 ) {
echo nl2br('This server reports it is busy.'."\r"); }
if (getServBusy() == 0 ) {
echo nl2br('This server reports it is idle.'."\r--------------------------------"); }