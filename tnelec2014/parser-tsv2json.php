<?php

/**
* Script permettant de convertir données des parrains du txt vers json
* @since September 27, 2014
* @author hatem <hatem@php.net>
* @todo 
*/

//Start edit here
$file = "tsv/hechmi-elhamdi-txt.tsv";

// items per pages;
$firstpage = 35;
$otherpages = 43;
$lastpage = 7;

// number of pages
$numpages = 525;


// don't edit here
$data = file($file);

$i  = 0;
$page = 1;
$name = array();

foreach($data as $k=>$v){

	$v = trim($v);

	if ($page == 1) { // first page
echo "First page ($i)\n\n";
		if ($i < $firstpage){
			$name[$i]['fname'] = $v;
		} elseif ($i > $firstpage and $i < $firstpage*2) {
			$name[($i-$firstpage)]['sname'] = $v;
		} elseif($i > $firstpage*2 and $i < $firstpage*3) {
			$name[($i-$firstpage*2)]['familyname'] = $v;
		} elseif ($i > $firstpage*3 and $i < $firstpage*4) {
			if (!is_numeric($v*1)){die('result is not a CIN :'.$v);}
			$name[($i-$firstpage*3)]['cin'] = $v;
				print_r($name); 

		}


		if ($i == $firstpage *4-1) {
			$page++;
		}

	} elseif ( $page == $numpages) { // last page
echo "Last page\n\n";


		if ($j < $lastpage){
			$name[$i]['fname'] = $v;
		} elseif ($j > $lastpage and $j < $lastpage*2) {
			$name[$i-$lastpage]['sname'] = $v;
		} elseif($j > $lastpage*2 and $j < $lastpage*3) {
			$name[$i-$lastpage*2]['familyname'] = $v;
		} elseif ($j > $lastpage*3 and $j < $lastpage*4) {
			if (!is_numeric($v)){die('result is not a CIN :'.$v);}
			$name[$i-$lastpage*3]['cin'] = $v;
				print_r($name[$i]); 

		}


		if ($i == $lastpage *4) {
			$page++;
		}

	} else {  // other page

echo "Page number $page ($i)\n\n";


		if ($j < $otherpages){
			$name[$i]['fname'] = $v;
		} elseif ($j > $otherpages and $j < $otherpages*2) {
			$name[$i-$otherpages]['sname'] = $v;
		} elseif($j > $otherpages*2 and $j < $otherpages*3) {
			$name[$i-$otherpages*2]['familyname'] = $v;
		} elseif ($j > $otherpages*3 and $j < $otherpages*4) {
			if (!is_numeric($v)){die('result is not a CIN :'.$v);}
			$name[$i-$otherpages*3]['cin'] = $v;
				print_r($name); 
		}


		if ($i == $otherpages *4) {
			$page++; $j =0;
		}

	}
	$i++; $j++;
}