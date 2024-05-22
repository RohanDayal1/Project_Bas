<?php
// auteur: RohanD
// functie: insert class Klant

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Klant;
use Bas\classes\Database;

$db = new Database();
$db->getConnection();

// Maak een nieuwe klant aan
$klant = new Klant();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    $data = [
        'klantNaam' => $_POST['klantnaam'],
        'klantEmail' => $_POST['klantemail'],
        'klantAdres' => $_POST['klantadres'],
        'klantPostcode' => $_POST['klantpostcode'],
        'klantWoonplaats' => $_POST['klantwoonplaats']
    ];
    
    if ($klant->insertKlant($data)) {
        echo "Klant succesvol toegevoegd!";
    } else {
        echo "Er is een fout opgetreden bij het toevoegen van de klant.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">=
<head>
    <meta charset="UTF-8">
    <title>CRUD Klant</title>
	<link rel="stylesheet" href="../style.css">
</head>
<body class ="formbody">
    <h1>Klant Toevoegen</h1>
    <form class = "crudform" method="post">
        <label for="nv">Klantnaam:</label>
        <input type="text" id="nv" name="klantnaam" placeholder="Klantnaam" required/>
        <br>   
        <label for="an">Klantemail:</label>
        <input type="email" id="an" name="klantemail" placeholder="Klantemail" required/>
        <br>   
        <label for="adres">Klantadres:</label>
        <input type="text" id="adres" name="klantadres" placeholder="Klantadres" required/>
        <br>
        <label for="postcode">Klantpostcode:</label>
        <input type="text" id="postcode" name="klantpostcode" placeholder="Klantpostcode" required/>
        <br>
        <label for="woonplaats">Klantwoonplaats:</label>
        <input type="text" id="woonplaats" name="klantwoonplaats" placeholder="Klantwoonplaats" required/>
        <br><br>
        <input type='submit' name='insert' value='Toevoegen'>
		<a href='read.php' class='back-link'>Terug</a>
    </form>
</body>
</html>



