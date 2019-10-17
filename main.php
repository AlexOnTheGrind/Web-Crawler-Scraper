<?php
	include("links.php");
	include("text.php");
	echo "avilabe comands\n 1.Get the links from a websit type links\n 2.Extract all the text from it typle text\n 3.Translate it\n";
	$handle = fopen ("php://stdin","r");
	$line = fgets($handle);
	if(trim($line) == 'links'){
		$url = fgets($handle);
		links($url);
	}
	if(trim($line) == 'text')
		text();
	if(trim($line) == 'del')
		del();
	else 
		echo "check your spelling";
	
	fclose($handle);
	echo "\n"; 
	echo "Thank you, continuing...\n";
	
?>