<?php

require 'vendor/autoload.php';
 
if ( !file_exists("./produkte.json") ) {
	$Produkte = array();
	$daten = array();
	$daten["ID"] = "0";
	$daten["name"] = "test";
	$daten["beschreibung"] = "test";
	$daten["bewertung"] = "5/5";
	$Produkte[$daten["ID"]] = $daten;
 
	file_put_contents("./produkte.txt", json_encode($Produkte));
}
 
class ProduktHandler
{
	//Registriert den Benutzer wenn er noch nicht angemeldet ist.
	function put()
	{
		//David Boeheims arbeit :)
	}

	//Liefert ein Produkt anhand seiner ID zurueck
	function get()
	{
		$entries = json_decode( file_get_contents( "./produkte.txt" ) );
		
		if (isset($_GET["ID"]))
		{
			echo ($entries[$_GET["ID"]]);
		}
	}
}

class ProduktHand{
	function get(){
		//file oeffnen
		$entries = json_decode( file_get_contents("./produkte.txt"));
		
		//pruefen der Eingabe
		if(isset($_GET["name"]) &&  isset($_GET["beschreibung"]) && isset($_GET["bewertung"]) && isset($_GET["ID"])){
			//holt sich das Element mit der ID
			$entries->getElementById($_GET["ID"]);
			//schreibt die Daten hinein
			$daten["name"] = $_GET["name"];
			$daten["beschreibung"] = $_GET["beschreibung"];
			$daten["bewertung"] = $_GET["bewertung"];
		}
		//schließt und speichert das File
		file_put_contents("./produkte.txt",json_encode($Produkte));
	}
}

ToroHook::add("404", function() {
	echo "Not found. ATOMLOL";
});

Toro::serve(array(
	"/products.php" => "ProduktHandler", //PUT - Registrieren
	"/products/log/show.php" => "ProduktHand", //GET - Anzeigen
));
?>
