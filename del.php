<?php
 function del(){
	 
	$folder = 'C:\ALEX\tulkošanas programma';
	$files = glob($folder . '/*.txt');
	
	foreach($files as $file){
		if(is_file($file)){
			unlink($file);
		}
	}
}
?>