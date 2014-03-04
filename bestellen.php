Die Datei bestellen.php legt Produkte in den Warenkorb 

<?php

if (!isset($_GET['id'])) {
    die("Kein Produkt ausgew&auml;hlt.");
}

// Wenn das Produkt noch nicht gekauft wurde...
if (!isset($_SESSION['warenkorb']) ||
    !in_array($_GET['id'], $_SESSION['warenkorb'])) {

    // In den Warenkorb legen:
    $_SESSION['warenkorb'][] = $_GET['id'];
}
?>

