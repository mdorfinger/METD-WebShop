<?php

session_start();
?>
<html>
<head><title></title></head>
<body>
<h2> Warenkorb </h2>
<hr>
<?php

if(isset($_SESSION['warenkorb']) && !empty($_SESSION['warenkorb'])){
	print "<p> Folgende Waren liegen im Warenkorb vor:</p>";
	print "<table border=0>"

?>

<tr>
<td width="80">
<b><p class="ueber"> Art. -Nr. </p></b>
</td>

<td width="420">
<b><p class="ueber"> Bezeichnung </p></b>
</td>

<td width="80">
<b><p class="ueber"> Preis </p></b>
</td>

<td width="40">
<center><b><p class="ueber"> &nbsp </p></b></center>
</td>
</tr>

<?php
$preis=0;

foreach($_SESSION['warenkorb'] as $id){
	printf('
			<tr>
			<td width="80">
			<b><p>  </p></b>
			</td>
			
			<td width="420">
			<b><p> </p></b>
			</td>
			
			<td width="80">
			<b><p> Euro %01.2f </p></b>
			</td>
			
			<td width="40">
			<center><b><p> Link </p></b></center>
			</td>
			</tr>

	',
	htmlentities($waren[$id]['nr']),
	htmlentities($waren[$id]['name']),
	htmlentities($waren[$id]['preis']),
	$id,
	SID
	);
	
	$preis+=$waren[$id]['preis'];
}
?>
<tr>
<td width="70">
<b><p> &nbsp </p></b>
</td>

<td width="420">
<b><p> &nbsp </p></b>
</td>

<td width="70">
<b><p> &nbsp </p></b>
</td>

<td width="40">
<center><b><p> &nbsp </p></b></center>
</td>
</tr>

<tr>
<td width="70">
<b><p> &nbsp </p></b>
</td>

<td width="420">
<b><p> Gesamtpreis: </p></b>
</td>

<td width="100">
<b><p> Euro <?php printf("%.2f", $preis);?> </p></b>
</td>

<td width="40">
<center><b><p> &nbsp </p></b></center>
</td>
</tr>

<?php

}
if(empty($_SESSION['warenkorb'])){
	echo " <p> Sie haben keine Produkte im Warenkorb. </p>";
	}
?>

</body>
</html>
