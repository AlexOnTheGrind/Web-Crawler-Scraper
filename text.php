<?php
	include('simple_html_dom.php');
	ini_set('default_socket_timeout', 3);

	function text(){
	
	$myfile = file("links/VisiLinkiUzProduktiem.txt");
	$myfile = preg_replace('/\s+/', '', $myfile);
	
	$myfile2 = file("links/VisiLinkiUzProduktiem2.txt");
	$myfile2 = preg_replace('/\s+/', '', $myfile2);
	
	Getinfo($myfile2);
	Getinfo($myfile);

	}
?>