<!--
	Auteur: RohanD
	Function: home page CRUD Klant
-->
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
<header>
        <h1>CRUD Klant</h1>
        <nav>
            <ul>
                <li><a href="../index.html">Home</a></li>
                <li><a href="read.php">CRUD Klant</a></li>
                <li><a href="../artikel/read.php">CRUD Artikel</a></li>
                <li><a href="../verkooporder/read.php">CRUD Verkooporder</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </header>

	<a href='insert.php'>Toevoegen nieuw artikel</a><br><br>
	
<?php

// Autoloader classes via composer
require '../../vendor/autoload.php';

use Bas\classes\Klant;

// Maak een object Klant
$klant = new Klant;

// Start CRUD
$klant->crudKlant();

?>
</body>

</html>