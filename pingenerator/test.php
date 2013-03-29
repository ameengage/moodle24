<?php
$myFile = "testFile.txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = "Bobby Bopper\n";
//fwrite($fh, $stringData);
$stringData = $stringData . "Tracy Tanner\n";
$stringData = $stringData . "Vignesh\n";
fwrite($fh, $stringData);
fclose($fh);
?>