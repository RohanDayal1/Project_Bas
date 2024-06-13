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

	<a href='insert.php'>Toevoegen nieuw klant</a><br><br>

    <form method="post" class="searchbar">
        <label for="klantNaam">Zoek op klantnaam:</label>
        <input type="text" name="klantNaam" id="klantNaam">
        <input type="submit" name="search" value="Zoeken">
    </form>

    <?php
// Autoloader classes via composer
require '../../vendor/autoload.php';

use Bas\classes\Klant;

// Check if the form has been submitted for deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['klantId'])) {
    $klantId = intval($_POST['klantId']);
    
    // Instantiate the Klant class
    $klant = new Klant();

    // Call the delete method
    $result = $klant->deleteKlant($klantId);

    if ($result) {
        // Success message (you can modify this to redirect or display a message)
        echo "Klant successfully deleted.";
    } else {
        // Error message
        echo "Error deleting klant.";
    }
}

// Maak een object Klant
$klant = new Klant();

// Start CRUD
$klant->crudKlant();
?>
</body>

</html>