<?php

//Spritpreise v1 by kill0rz

//Konfiguration

///In welchem Radius sollen die Tankstellen angezeigt werden?
$radius = 3; //maximal 25

///Standardwerte, die genommen werden sollen, wenn der User seine Position nicht bestimmt hat
///Standard-Breitengrad
$latitude_standard = "51.1";
///Standard-Längengrad
$longitude_standard = "11.1";

///Dein API Schlüssel von tankerkoenig.de --> https://creativecommons.tankerkoenig.de/#register
$apikey = "ABCDEF";

///Manchmal werden die Straßennamen statt der Tankstellennamen angezeigt.
///Hier kannst du das manuell korrigieren. Zwei Beispiele habe ich dir schon eingetragen.
$vordefiniertestraßennamen = array(
	'BAT PLÖTZETAL WEST - A14' => 'Agip',
	'Tankstelle Salzmünde' => 'Freie TS',
);

//
// Ab hier nichts mehr ändern
//
//
//

if ($filename == "index.php") {
	$get_tank_output = array();
	$get_tank_headline = 'Aktuelle Werte:';

	if (isset($_COOKIE['gettank_latitude']) && trim($_COOKIE['gettank_latitude']) != '' && isset($_COOKIE['gettank_longitude']) && trim($_COOKIE['gettank_longitude']) != '') {
		$latitude = $_COOKIE['gettank_latitude'];
		$longitude = $_COOKIE['gettank_longitude'];
	} else {
		$latitude = $latitude_standard;
		$longitude = $longitude_standard;
	}

	$setbreak = true;

	$get_tank_headline_werte = floatval($latitude) . "," . floatval($longitude);
	function checkumlaute($string) {
		$ersetzen = array(
			'ä' => '&auml;',
			'ö' => '&ouml;',
			'ü' => '&uuml;',
			'Ä' => '&Auml;',
			'Ö' => '&Ouml;',
			'Ü' => '&Uuml;',
			'ß' => '&szlig;',
			'Str..' => 'Str.',
			'Str.' => 'Straße',
			'Strasse' => 'Straße',
			'strasse' => 'straße',
		);
		$string = strtr($string, $ersetzen);
		return $string;
	}

	function checknamen($station) {
		$name = $station->brand;

		//set logos
		$tankstellennamen = array(
			'cleancar' => 'CleanCar',
			'bft' => 'BFT',
		);
		foreach ($tankstellennamen as $replacer => $name_neu) {
			if (str_replace($replacer . " ", "", strtolower($name)) != strtolower($name)) {
				$name = $name_neu;
				break;
			}
		}
		if (file_exists("./img/get_tank/logos/" . strtolower(trim($station->brand)) . ".png") && trim($station->brand) != '') {
			return "<img src='./img/get_tank/logos/" . strtolower(trim($station->brand)) . ".png' alt='{$name} logo' />";
		}

		$name = $station->name;
		//fest definierte Straßen

		$name = trim(strtr($name, $vordefiniertestraßennamen));

		//set logos
		$tankstellennamen = array(
			'agip' => 'Agip',
			'agri futura' => 'RWG',
			'aral' => 'Aral',
			'avia' => 'Avia',
			'bft' => 'bft',
			'classic' => 'classic',
			'dea' => 'DEA',
			'elan' => 'ELAN',
			'elf' => 'Elf',
			'eni' => 'ENI',
			'esso' => 'Esso',
			'fina' => 'Fina',
			'globus' => 'Globus',
			'greenline' => 'Greenline',
			'gulf' => 'Gulf',
			'hem' => 'HEM',
			'hoyer' => 'Hoyer',
			'jet' => 'JET',
			'm1' => 'M1',
			'mtb' => 'MTB',
			'oil!' => 'OIL!',
			'omv' => 'OMV',
			'orlen' => 'Orlen',
			'q1' => 'Q1',
			'q8' => 'Q8',
			'raiffeisen' => 'RWG',
			'ratio' => 'Ratio',
			'rwg' => 'RWG',
			'shell' => 'Shell',
			'sprint' => 'Sprint',
			'star' => 'Star',
			'tamoil' => 'Tamoil',
			'tankpool24' => 'tankpool24',
			'total' => 'Total',
			'totalenergies' => 'TotalEnergies',
			'total energies' => 'TotalEnergies',
			'union' => 'Union',
			'westfalen' => 'Westfalen',
		);

		foreach ($tankstellennamen as $replacer => $name_neu) {
			if (str_replace($replacer . " ", "", strtolower($name)) != strtolower($name)) {
				$name = $name_neu;
				break;
			}
		}
		if (file_exists("./img/get_tank/logos/" . strtolower($name) . ".png")) {
			return "<img src='./img/get_tank/logos/" . strtolower($name) . ".png' alt='{$name} logo' />";
		}

		if ($name != $station->brand && trim($name) != '') {
			return $name . " (" . $station->brand . ")";
		} else {
			return $name;
		}
	}

	function replace_umlaute($mode, $string = "") {
		//1 - klein --> groß
		//2 - groß  --> klein

		$array_große_umlaute = array("Ä", "Ö", "Ü");
		$array_kleine_umlaute = array("ä", "ö", "ü");

		if ($mode == 1) {
			$endtmp = str_replace($array_kleine_umlaute, $array_große_umlaute, $string);
			return $endtmp;
		} elseif ($mode == 2) {
			$endtmp = str_replace($array_große_umlaute, $array_kleine_umlaute, $string);
			return $endtmp;
		} else {
			return false;
		}
	}

	function firstupintelligent($gs) {
		$strings = explode(" ", $gs);
		$erg = '';
		$tmptmptmp = '';
		foreach ($strings as $s) {
			$tmp = trim(ucfirst($s)) . " ";
			$zeichen = array("[", "(", "-", ",", "/", "&", "|", '"');
			foreach ($zeichen as $zeichen) {
				if (str_replace($zeichen, "", $tmp) != $tmp) {
					$strsplit = explode($zeichen, $tmp);
					$tmptmp = array();
					foreach ($strsplit as $s) {
						$tmp = trim(ucfirst(strtolower($s))) . " ";
						$tmp = trim(replace_umlaute(2, $tmp)) . " ";
						$tmptmp[] = trim(replace_umlaute(1, substr($tmp, 0, 1)) . substr($tmp, 1));
					}
					$tmp = implode($tmptmp, $zeichen);
				} else {
					$tmp = trim($tmp) . " ";
				}
			}
			$tmp .= " ";
			$erg .= trim($tmp) . " ";
		}
		return trim($erg);
	}

	function getvalues($index) {
		global $get_tank_output, $longitude, $latitude, $radius, $setbreak;
		$json = file_get_contents('https://creativecommons.tankerkoenig.de/json/list.php?lat=' . $latitude . '&lng=' . $longitude . '&rad=' . $radius . '&sort=price&type=' . $index . '&apikey=' . $apikey);
		$data = json_decode($json);
		$zaehler = 0;
		if (count($data->stations) > 0) {
			foreach ($data->stations as $station) {
				if ($station->price > 0) {
					if (!isset($get_tank_output[$index])) {
						$get_tank_output[$index] = '';
					}
					$zaehler++;

					$street = '';
					$street_split = explode(" ", $station->street);
					foreach ($street_split as $split) {
						$street .= ucfirst(strtolower($split)) . " ";
					}

					$place = '';
					$place_split = explode(" ", $station->place);
					foreach ($place_split as $split) {
						$place .= ucfirst(strtolower($split)) . " ";
					}

					$place = str_replace("Ot", "OT", $place);

					$get_tank_output[$index] .= checkumlaute(checknamen($station)) . "<br />";
					$get_tank_output[$index] .= "Preis: <b>" . $station->price . "&euro;</b><br />";
					$get_tank_output[$index] .= checkumlaute(firstupintelligent($street)) . " " . $station->houseNumber . "<br />0" . $station->postCode . " " . checkumlaute(firstupintelligent($place));

					$get_tank_output[$index] .= "<hr>";
					if ($zaehler >= 3 && $setbreak) {
						break;
					}
				}
			}
		}
		$get_tank_output[$index] = substr($get_tank_output[$index], 0, strlen($get_tank_output[$index]) - 4);
		$get_tank_output[$index] = "<img src='/wbb2/img/get_tank/{$index}.gif' alt='{$index}' /><br /><br />" . checkumlaute($get_tank_output[$index]);
	}

	getvalues("e10");
	getvalues("e5");
	getvalues("diesel");

}