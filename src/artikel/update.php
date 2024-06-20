<?php
// auteur: RohanD
// functie: update artikelgegevens

// Autoloader classes via Composer
require '../../vendor/autoload.php';
use Bas\classes\Artikel;

$artikel = new Artikel;

// Verwerken van formulierinzending
if (isset($_POST["update"]) && $_POST["update"] == "Wijzigen") {
    // Data voorbereiden voor update
    $row = [
        'artId' => $_POST['artId'],
        'artOmschrijving' => $_POST['artOmschrijving'],
        'artInkoop' => $_POST['artInkoop'],
        'artVerkoop' => $_POST['artVerkoop'],
        'artMinVoorraad' => $_POST['artMinVoorraad'],
        'artMaxVoorraad' => $_POST['artMaxVoorraad'],
        'artLocatie' => $_POST['artLocatie']
    ];

    // Artikel bijwerken
    $success = $artikel->updateArtikel($row);

    // Bericht weergeven afhankelijk van succes van de update
    if ($success) {
        echo "Artikelgegevens succesvol bijgewerkt.<br>";
    } else {
        echo "Fout bij het bijwerken van de artikelgegevens.<br>";
    }
}

// Als artId is opgegeven, haal artikelgegevens op en toon formulier
if (isset($_GET['artId'])) {
    $row = $artikel->getArtikel((int)$_GET['artId']);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikelgegevens Wijzigen</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="formbody">
    <h1>Artikelgegevens Wijzigen</h1>
    <form method="post" class="crudform">
        <input type="hidden" name="artId" value="<?= isset($row['artId']) ? htmlspecialchars($row['artId']) : '' ?>">
        <label for="artOmschrijving">Omschrijving:</label>
        <input type="text" name="artOmschrijving" value="<?= isset($row['artOmschrijving']) ? htmlspecialchars($row['artOmschrijving']) : '' ?>"> </br>
        <label for="artInkoop">Inkoop:</label>
        <input type="text" name="artInkoop" value="<?= isset($row['artInkoop']) ? htmlspecialchars($row['artInkoop']) : '' ?>"> </br>
        <label for="artVerkoop">Verkoop:</label>
        <input type="text" name="artVerkoop" value="<?= isset($row['artVerkoop']) ? htmlspecialchars($row['artVerkoop']) : '' ?>"> </br>
        <label for="artMinVoorraad">Minimale Voorraad:</label>
        <input type="text" name="artMinVoorraad" value="<?= isset($row['artMinVoorraad']) ? htmlspecialchars($row['artMinVoorraad']) : '' ?>"> </br>
        <label for="artMaxVoorraad">Maximale Voorraad:</label>
        <input type="text" name="artMaxVoorraad" value="<?= isset($row['artMaxVoorraad']) ? htmlspecialchars($row['artMaxVoorraad']) : '' ?>"> </br>
        <label for="artLocatie">Locatie:</label>
        <input type="text" name="artLocatie" value="<?= isset($row['artLocatie']) ? htmlspecialchars($row['artLocatie']) : '' ?>"> </br></br>
        <input type="submit" name="update" value="Wijzigen">
    </form></br>
    <a href="read.php">Terug</a>
</body>
</html>
<?php
} else {
    echo "Geen artId opgegeven<br>";
}
?>
