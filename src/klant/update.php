<?php
// auteur: RohanD
// functie: update klantgegevens

// Autoloader classes via Composer
require '../../vendor/autoload.php';
use Bas\classes\Klant;

$klant = new Klant;

// Verwerken van formulierinzending
if (isset($_POST["update"]) && $_POST["update"] == "Wijzigen") {
    // Data voorbereiden voor update
    $row = [
        'klantId' => $_POST['klantId'],
        'klantNaam' => $_POST['klantNaam'],
        'klantEmail' => $_POST['klantEmail'],
        'klantAdres' => $_POST['klantAdres'],
        'klantPostcode' => $_POST['klantPostcode'],
        'klantWoonplaats' => $_POST['klantWoonplaats']
    ];

    // Klant bijwerken
    $success = $klant->updateKlant($row);

    // Bericht weergeven afhankelijk van succes van de update
    if ($success) {
        echo "Klantgegevens succesvol bijgewerkt.<br>";
    } else {
        echo "Fout bij het bijwerken van de klantgegevens.<br>";
    }
}

// Als klantId is opgegeven, haal klantgegevens op en toon formulier
if (isset($_GET['klantId'])) {
    $row = $klant->getKlant($_GET['klantId']);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klantgegevens Wijzigen</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="formbody">
    <h1>Klantgegevens Wijzigen</h1>
    <form method="post" class="crudform">
        <input type="hidden" name="klantId" value="<?= isset($row['klantId']) ? htmlspecialchars($row['klantId']) : '' ?>">
        <label for="klantNaam">Naam:</label>
        <input type="text" name="klantNaam" value="<?= isset($row['klantNaam']) ? htmlspecialchars($row['klantNaam']) : '' ?>"> </br>
        <label for="klantEmail">Email:</label>
        <input type="email" name="klantEmail" value="<?= isset($row['klantEmail']) ? htmlspecialchars($row['klantEmail']) : '' ?>"> </br>
        <label for="klantAdres">Adres:</label>
        <input type="text" name="klantAdres" value="<?= isset($row['klantAdres']) ? htmlspecialchars($row['klantAdres']) : '' ?>"> </br>
        <label for="klantPostcode">Postcode:</label>
        <input type="text" name="klantPostcode" value="<?= isset($row['klantPostcode']) ? htmlspecialchars($row['klantPostcode']) : '' ?>"> </br>
        <label for="klantWoonplaats">Woonplaats:</label>
        <input type="text" name="klantWoonplaats" value="<?= isset($row['klantWoonplaats']) ? htmlspecialchars($row['klantWoonplaats']) : '' ?>"> </br></br>
        <input type="submit" name="update" value="Wijzigen">
    </form></br>
    <a href="read.php">Terug</a>
</body>
</html>
<?php
} else {
    echo "Geen klantId opgegeven<br>";
}
?>
