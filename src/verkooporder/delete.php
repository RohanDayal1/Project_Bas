<?php
// auteur: RohanD
// functie: Verwijderen van verkooporder

require '../../vendor/autoload.php';
use Bas\classes\VerkoopOrder;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verkOrdId'])) {
    $verkOrdId = intval($_POST['verkOrdId']);
    
    // Instantiate VerkoopOrder class
    $verkoopOrder = new VerkoopOrder();

    // Call the delete method
    $result = $verkoopOrder->deleteVerkoopOrder($verkOrdId);

    if ($result) {
        echo '<script>alert("Verkooporder verwijderd")</script>';
        echo "<script> location.replace('read.php'); </script>";
        exit;
    } else {
        echo "Error deleting verkooporder.";
    }
} else {
    echo "Invalid request.";
}
?>
