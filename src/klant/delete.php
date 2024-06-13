<?php
// auteur: RohanD
// functie: Deletere

// Include your database connection and necessary classes
require '../../vendor/autoload.php';
use Bas\classes\Klant;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verwijderen'])) {
    $klantId = intval($_GET['klantId']); // Retrieve klantId from GET parameter
    
    // Instantiate your class
    $klant = new Klant();

    // Call the delete method
    $result = $klant->deleteKlant($klantId);

    if ($result) {
        echo '<script>alert("Klant verwijderd")</script>';
        echo "<script> location.replace('read.php'); </script>";
        exit;
    } else {
        echo "Error deleting Klant.";
    }
} else {
    echo "Invalid request.";
}
?>
