<?php
 
require 'vendor/autoload.php';
 
if ( !file_exists("./user.json") ) {
	$User = array();
	$daten = array();
	$daten["ID"] = "0";
	$daten["name"] = "test";
	$daten["password"] = "test";
	$daten["mail"] = "test@tgm.ac.at";
	$User[$daten["ID"]] = $daten;
 
	file_put_contents("./user.json", json_encode($User));
}

class AccountHandler{

	function put(){
	$User=json_decode( file_get_contents("./user.json"));
		if(isset($_GET["name"]) && isset($_GET["password"]) && isset($_GET["mail"])){
			$User[] = $_POST;
		}
		file_put_contents("./user.json",json_encode($User));
	}

ToroHook::add("404", function() {
	echo "Not found";
});

Toro::serve(array(
	"/users.php" => "AccountHandler", //PUT - Registrieren
	"/users/log/show.php" => "AccountHandler", //GET - Anzeigen
));
?>
