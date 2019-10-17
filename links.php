<?php	
	include("funkcijas.php");
	ini_set('default_socket_timeout', 1);
// function get al the links from a list of links
	function links($url){
	
	$r = 0;
	$index = 148;
	$zx = 0;
	//sākuma links
	$url = "https://bio113.com";
	$lines_string = file_get_contents($url);
	echo $url;
	preg_match_all('/href=.*? /', $lines_string, $match);
	//iztīram linkus
	foreach($match[0] as $key=>$value){
		$match[0][$key]=str_replace('href="',"https://bio113.com",$value);
	}
	foreach($match[0] as $key=>$value){
		$match[0][$key]=str_replace("href='","https://bio113.com",$value);
	}
	foreach($match[0] as $key=>$value){
		$match[0][$key]=str_replace('"',"",$value);
	}
	foreach($match[0] as $key=>$value){
		$match[0][$key]=str_replace("'","",$value);
	}
	//izņem no lista visus elementus kam nac > un tos kam ir > vis kas ir aiz > tiek nogriezts
	$tik = count($match[0]);
	echo $tik;
	while ($tik != 0){
		$match_1[0][$zx] = strstr($match[0][$zx], '>', true);
		$zx++;
		$tik--;
	}
	//noņem visus tukšos elementus atliekošiem elementi saglabā savu indexu
	$match_1[0] = array_filter($match_1[0]);
	$match[0] = (array_replace($match[0],$match_1[0]));
	$match[0] = array_unique($match[0]);
	$match[0] = preg_replace('/\s+/', '', $match[0]);
	//linku atrašana linkos
	$result = WebCrawl($match[0]);
	$reuslt1 = WebCrawl($result);
	$result2 = WebCrawl($reuslt1);
	$result3 = WebCrawl($result2);

	//īspašie linki, kas aizved uz visiem produktiem
	while ($index != 158){ 
		$result[$index] = str_replace('https://bio113.com',"https://www.bio113.com/lv/katalogs", $result[$index]);
		$all_the_products[$r] = $result[$index];
		$r++;
		$index++;
	}
	//atlasam visus produktus
	$allthelinks = WebCrawl($all_the_products);
	sort($allthelinks);
	//ievietojam visus produkta linkus failā
	
	$mrged4x = array_merge_recursive_ex($allthelinks, $result2);
	sort($mrged4x);
	$p = count($mrged4x);
	$textfiles = "VisiLinkiUzProduktiem.txt";
	$raw = fopen("VisiLinkiUzProduktiem.txt", "w");
	while ($p != 0) {
		$p--;
		fwrite($raw, $mrged4x[$p] . "\n");
	}
	$result2 = WebCrawl($reuslt1);
	$result3 = WebCrawl($result2);
	}
?>