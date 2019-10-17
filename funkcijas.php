<?php
//2dim array to 1 dim array
function array_flatten($array = null) {
		$result = array();
		if (!is_array($array)) {
			$array = func_get_args();
		}
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$result = array_merge($result, array_flatten($value));
			} else {
				$result = array_merge($result, array($key => $value));
			}
		}
		return ($result);
	}
//combines array 1 and array 2
function array_merge_recursive_ex(array $match, array $match1){
    $merged = $match;

    foreach ($match1 as $key => & $value) {
        if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
            $merged[$key] = array_merge_recursive_ex($merged[$key], $value);
        } else if (is_numeric($key)) {
             if (!in_array($value, $merged)) {
                $merged[] = $value;
             }
        } else {
            $merged[$key] = $value;
        }
    }
    return ($merged);
}

function del(){
	 
	$folder = 'C:\ALEX\tulkošanas programma';
	$files = glob($folder . '/*1.txt');
	
	foreach($files as $file){
		if(is_file($file)){
			unlink($file);
		}
	}
}
function Getinfo($arraypass){
	$x = count($arraypass);
	$r =0;
	$varible = "description";
	$varible2 = "usage";
	$varible3 = "ASDF";
	$Title = '#<title>(.*?)</title>#';
	$Span ='#<span>(.*?)</span>#';

		while ($x != 0){
			$html = @file_get_html($arraypass[$x]);
			$htmlContents = @file_get_contents($arraypass[$x]);
			$htmlContents1 =  str_replace('<div class="pros">', '<div class="pros" id="ASDF">',$htmlContents);
			$htmlString = @str_get_html($htmlContents1);

			if ($html === FAlSE && $htmlContents === FALSE){
				$x--;
				$r++;
				echo $r . "\n";
			}
			else {	
				preg_match_all($Title, $htmlContents, $match);
				if (empty($match[1][0]) != FALSE){
					$x--;
					continue;
				}
				$match[1][0] = str_replace('/', '', $match[1][0]);
				$match[1][0] = str_replace(':', '', $match[1][0]);
				$match[1][0] = str_replace('*', '', $match[1][0]);
				$match[1][0] = str_replace('?', '', $match[1][0]);
				$match[1][0] = str_replace('"', '', $match[1][0]);
				$match[1][0] = str_replace('<', '', $match[1][0]);
				$match[1][0] = str_replace('>', '', $match[1][0]);
				$match[1][0] = str_replace('|', '', $match[1][0]);
				$textfiles = ($match[1][0] .'1.txt');
				$raw = fopen($match[1][0] .'1.txt', "w");
				$textfiles1 = ($match[1][0] .'.txt');
				$raw1 = fopen($match[1][0] .'.txt', "w");
				if($html){
					$Text = $html->find("div[id=$varible]", 0);
					$Text2 = $html->find("div[id=$varible2]", 0);
					if($htmlString)
						$Text3 = $htmlString->find("div[id=$varible3]", 0);
				}
				preg_match_all($Span, $htmlContents, $match2);
				$result_Span = array_flatten($match2);
				$nr = count($result_Span);			
				while($nr != 0){
					$nr--;
					$textCleanSpan = strip_tags($result_Span[$nr]);
					$textCleanSpan = strip_tags($textCleanSpan);
					@fwrite($raw, $textCleanSpan . "\n");
				}

				$textClean3 = strip_tags($Text3);
				$textClean = strip_tags($Text);
				$textClean2 = strip_tags($Text2);
				$textClean3 = html_entity_decode($textClean3);
				$textClean2 = html_entity_decode($textClean2);
				$textClean = html_entity_decode($textClean);
				@fwrite($raw, $textClean3 . "\n");
				@fwrite($raw, $textClean . "\n");
				@fwrite($raw, $textClean2 . "\n");
				$FinalFile = file($textfiles);
				$nrFin = count($FinalFile);
				unset($FinalFile[$nrFin]);
				$nrFin = $nrFin - 4;
				unset($FinalFile[$nrFin]);
				$nrFin--;
				unset($FinalFile[$nrFin]);
				$nrFin--;
				while($nrFin != 0){
					$nrFin--;
					unset($FinalFile[$nrFin]);
				}
				sort($FinalFile);
				$finfin = count($FinalFile);
				while ($finfin != 0){
					$finfin--;
					fwrite($raw1, $FinalFile[$finfin] . "\n");
				}
				$x--;
			}
			echo $x . "\e[36m Still to go\n\e[0m";
		}
	}
	function WebCrawl($array_pass) {
		$x = 0;
		$y = 0;
		$z = 0;
		$nr = 0;
		$zx = 0;
		$tik = 0;
		$nr = count($array_pass);
		echo"\e[95mThe link count is equal to \e[0m" . $nr . "\n";
		//ja var iegūt info no linka, tad no tā izņem visus pārējos linkus, ja nē, tad to linku izņem no saraksta
		while ($nr != 0) {
			echo $x . " ";
			$test = @file_get_contents($array_pass[$x]);
			if ($test === FALSE){
				echo "\e[31mthis link \e[0m" . $array_pass[$x] . "\e[31m link dosnt work\n\e[0m";
				$not_working_liks[$z] = $array_pass[$x];
				unset ($array_pass[$x]);
			}
			else {
				echo "\e[32mthis link \e[0m" . $array_pass[$x] . " \e[32mworks\n\e[0m";
				preg_match_all('/href=.*? /', $test, $match1);
				$merged[$y] = array_merge_recursive_ex($array_pass, $match1[0]);
				$y++;
			}
			$nr--;
			$x++;
			$z++;
			if ($nr == 0)
				echo "\e[101m These are the not working links! \e[0m" . print_r($not_working_liks);
		}
		//radam 1dimensionālu failu
		$result = array_flatten($merged);
		//iztīram linkus
		foreach($result as $key=>$value){
			$result[$key]=str_replace('href="',"https://bio113.com",$value);
		}
		foreach($result as $key=>$value){
			$result[$key]=str_replace("href='","https://bio113.com",$value);
		}
		foreach($result as $key=>$value){
			$result[$key]=str_replace('"',"",$value);
		}
		foreach($result as $key=>$value){
			$result[$key]=str_replace("'","",$value);
		}
		$tik = count($result);
		while ($tik != 0){
			$result_1[$zx] = strstr($result[$zx], '>', true);
			$zx++;
			$tik--;
		}
		$result_1 = array_filter($result_1);
		$result = (array_replace($result,$result_1));
		$result = array_unique($result);
		$result = preg_replace('/\s+/', '', $result);
		$result = preg_replace('/\s+/', '', $result);
		foreach ($result as $key => $ll) {
			if (strpos($ll,'.png') !== false) {
				unset($result[$key]);
			}
		}
		foreach ($result as $key => $ll) {
			if (strpos($ll,'.jpg') !== false) {
				unset($result[$key]);
			}
		}
		$result = array_unique($result);
		$result = (array_values($result));
		print_r ($result);
		return $result;
	}
?>