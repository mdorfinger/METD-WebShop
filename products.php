<?php
 
require("toro.php");
 
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

ToroHook::add("404", function() {
	echo "Not found. ATOMLOL";
});

Toro::serve(array(
	"/products.php" => "AccountHandler", //PUT - Registrieren
	"/products/log/show.php" => "AccountHandler", //GET - Anzeigen
));
?>
