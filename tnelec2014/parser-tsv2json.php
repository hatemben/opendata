<?php

/**
* Script permettant de convertir données des parrains du txt vers json/csv
* Utilisez pdftotext pour la conversion, ensuite manuellement supprimer 
* les titres et les entête et garder uniquement le contenu des tableaux
* Le reste il y'a 5 paramètres à introduire manuellement pour chaque fichier et voilà.
*
*  NB : gardez les lignes vides, au cas où un nom de famille, ou du père est inexistant.
*
* @since September 27, 2014
* @author hatem <hatem@php.net>
* @todo 
*/

//Start edit here
$file = "tsv/candidat-txt.tsv";

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
		} elseif ($i >= $firstpage and $i < $firstpage*2) {
			$name[$i-$firstpage]['sname'] = $v;
		} elseif($i >= $firstpage*2 and $i < $firstpage*3) {
			$name[$i-$firstpage*2]['familyname'] = $v;
		} elseif ($i >= $firstpage*3 and $i < $firstpage*4) {
			if (!is_numeric($v*1)){die('result is not a CIN :'.$v);}
			$name[$i-$firstpage*3]['cin'] = $v;
		}


		if ($i == $firstpage *4-1) {
			//print_r($name); 
			$page++;$j =-1;
		}

	} elseif ( $page == $numpages) { // last page
echo "Last page\n\n";


		if ($j < $lastpage){

			$name[$i]['fname'] = $v;

		} elseif ($j >= $lastpage and $j < $lastpage*2) {

			$name[$i-$otherpages]['sname'] = $v;

		} elseif($j >= $lastpage*2 and $j < $lastpage*3) {

			$name[$i-$otherpages*2]['familyname'] = $v;

		} elseif ($j >= $lastpage*3 and $j < $lastpage*4) {

			if (!is_numeric($v*1)){die('result is not a CIN :'.$v);}

			$name[$i-$otherpages*3]['cin'] = $v;

		}


		if ($i == $lastpage *4) {
			//print_r($name); 
			$page++;
		}

	} else {  // other page

echo "Page number $page\n\n";

		if ($j < $otherpages){

			$name[$i]['fname'] = $v;

		} elseif ($j >= $otherpages and $j < $otherpages*2) {

			$name[$i-$otherpages]['sname'] = $v;

		} elseif($j >= $otherpages*2 and $j < $otherpages*3) {

			$name[$i-$otherpages*2]['familyname'] = $v;

		} elseif ($j >= $otherpages*3 and $j < $otherpages*4) {


			if (!is_numeric($v*1)){die('result is not a CIN :'.$v);}

			$name[$i-$otherpages*3]['cin'] = $v;
		}


		if ($j == $otherpages *4-1) {
			$page++; $j =-1;
		}

	}
	$i++; $j++;
}


echo "size of name = ".sizeof($name)."\n page number : $page / $numpages\n";

$res = json_encode($name);

// save json
$fp = fopen($file.'.json', 'w');
fwrite($fp, $res);
fclose($fp);
	
// save csv
$fp = fopen($file.'.csv', 'w');
foreach ($name as $fields) {
    fputcsv($fp, $fields);
}
fclose($fp);


