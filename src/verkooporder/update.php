<?php
// auteur: RohanD
// functie: update verkooporder status

// Autoloader classes via Composer
require '../../vendor/autoload.php';
use Bas\classes\VerkoopOrder;
use Bas\classes\Klant;
use Bas\classes\Artikel;

$verkooporder = new VerkoopOrder;
$klant = new Klant;
$artikel = new Artikel;

// Verwerken van formulierinzending
if (isset($_POST["update"]) && $_POST["update"] == "Wijzigen") {
    // Data voorbereiden voor update
    $row = [
        'verkOrdId' => $_POST['verkOrdId'],
        'klantId' => $_POST['klantId'],
        'artId' => $_POST['artId'],
        'verkOrdDatum' => $_POST['verkOrdDatum'],
        'verkOrdBestAantal' => $_POST['verkOrdBestAantal'],
        'verkOrdStatus' => $_POST['verkOrdStatus']
    ];

    // Verkooporder bijwerken
    $success = $verkooporder->updateVerkoopOrder($row);

    // Bericht weergeven afhankelijk van succes van de update
    if ($success) {
        echo "Verkooporder succesvol bijgewerkt.<br>";
    } else {
        echo "Fout bij het bijwerken van de verkooporder.<br>";
    }
}

// Als verkOrdId is opgegeven, haal verkoopordergegevens op en toon formulier
if (isset($_GET['verkOrdId'])) {
    $row = $verkooporder->getVerkoopOrder($_GET['verkOrdId']);
    $klanten = $klant->getKlanten(); // Assuming this method exists to fetch all customers
    $artikelen = $artikel->getArtikelen(); // Assuming this method exists to fetch all articles
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verkooporder Wijzigen</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="formbody">
    <h1>Verkooporder Wijzigen</h1>
    <form method="post" class="crudform">
        <input type="hidden" name="verkOrdId" value="<?= isset($row['verkOrdId']) ? htmlspecialchars($row['verkOrdId']) : '' ?>">
        
        <label for="klantId">Klant:</label>
        <select name="klantId">
            <?php foreach ($klanten as $klant) { ?>
                <option value="<?= $klant['klantId'] ?>" <?= isset($row['klantId']) && $row['klantId'] == $klant['klantId'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($klant['klantNaam']) ?>
                </option>
            <?php } ?>
        </select> *</br>

        <label for="artId">Artikel:</label>
        <select name="artId">
            <?php foreach ($artikelen as $artikel) { ?>
                <option value="<?= $artikel['artId'] ?>" <?= isset($row['artId']) && $row['artId'] == $artikel['artId'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($artikel['artOmschrijving']) ?>
                </option>
            <?php } ?>
        </select> *</br>
        
        <label for="verkOrdDatum">Datum:</label>
        <input type="date" name="verkOrdDatum"  value="<?= isset($row['verkOrdDatum']) ? htmlspecialchars($row['verkOrdDatum']) : '' ?>"> *</br>
        <label for="verkOrdBestAantal">Bestel Aantal:</label>
        <input type="number" name="verkOrdBestAantal"  value="<?= isset($row['verkOrdBestAantal']) ? htmlspecialchars($row['verkOrdBestAantal']) : '' ?>"> *</br>
        <label for="verkOrdStatus">Status:</label>
        <select name="verkOrdStatus">
            <option value="Verzonden" <?= isset($row['verkOrdStatus']) && $row['verkOrdStatus'] == 'Verzonden' ? 'selected' : '' ?>>Verzonden</option>
            <option value="Niet Verzonden" <?= isset($row['verkOrdStatus']) && $row['verkOrdStatus'] == 'Niet Verzonden' ? 'selected' : '' ?>>Niet Verzonden</option>
            <option value="Onderweg" <?= isset($row['verkOrdStatus']) && $row['verkOrdStatus'] == 'Onderweg' ? 'selected' : '' ?>>Onderweg</option>
        </select> *</br></br>
        <input type="submit" name="update" value="Wijzigen">
    </form></br>

    <a href="read.php">Terug</a>
</body>
</html>

<?php
} else {
    echo "Geen verkOrdId opgegeven<br>";
}
?>
