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
        <h1>CRUD VerkoopOrder</h1>
        <nav>
            <ul>
                <li><a href="../index.html">Home</a></li>
                <li><a href="../klant/read.php">CRUD Klant</a></li>
                <li><a href="../artikel/read.php">CRUD Artikel</a></li>
                <li><a href="read.php">CRUD Verkooporder</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </header>
	
<?php

// Autoloader classes via composer
require '../../vendor/autoload.php';

use Bas\classes\VerkoopOrder;

// Maak een object Klant
$verkooporder = new VerkoopOrder;

// Start CRUD
$verkooporder->crudVerkoopOrder();

?>
</body>
</html>