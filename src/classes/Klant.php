<?php
// auteur: RohanD
// functie: definitie class Klant
namespace Bas\classes;

use Bas\classes\Database;
use PDO;

include_once "functions.php";

class Klant extends Database {
    public $klantId;
    public $klantemail = null;
    public $klantnaam;
    public $klantadres;
    public $klantpostcode;
    public $klantwoonplaats;
    private $table_name = "Klant";

    // Methods

    /**
     * Summary of crudKlant
     * @return void
     */
    public function crudKlant(): void {
        try {
            if (isset($_POST['search']) && !empty($_POST['klantNaam'])) {
                $klanten = $this->searchKlanten($_POST['klantNaam']);
            } else {
                $klanten = $this->getKlanten();
            }
            $this->showTable($klanten);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Summary of getKlanten
     * @return array
     */
    public function getKlanten() : array {
        $sql = "SELECT klantId, klantNaam, klantEmail, klantAdres, klantPostcode, klantWoonplaats FROM " . $this->table_name;
        $stmt = self::$conn->query($sql);
        $lijst = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $lijst;
    }

    /**
     * Summary of getKlant
     * @param int $klantId
     * @return array
     */
    public function getKlant(int $klantId) : array {
        $sql = "SELECT klantId, klantNaam, klantEmail klantAdres, klantPostcode, klantWoonplaats FROM " . $this->table_name . " WHERE klantId = :klantId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':klantId', $klantId, \PDO::PARAM_INT);
        $stmt->execute();
        $klant = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $klant ? $klant : [];
    }

    public function dropDownKlant($row_selected = -1) {
        // Haal alle klanten op uit de database mbv de method getKlanten()
        $lijst = $this->getKlanten();
        
        echo "<label for='Klant'>Choose a klant:</label>";
        echo "<select name='klantId'>";
        foreach ($lijst as $row) {
            if ($row_selected == $row["klantId"]) {
                echo "<option value='{$row["klantId"]}' selected='selected'> {$row["klantNaam"]} {$row["klantEmail"]}</option>\n";
            } else {
                echo "<option value='{$row["klantId"]}'> {$row["klantNaam"]} {$row["klantEmail"]}</option>\n";
            }
        }
        echo "</select>";
    }

    /**
     * Summary of showTable
     * @param array $lijst
     * @return void
     */
    private function showTable(array $klanten): void {
        echo "<table>";
        if (!empty($klanten)) {
            echo $this->getTableHeader($klanten[0]);
            foreach ($klanten as $row) {
                echo "<tr>";
                echo "<td>{$row['klantNaam']}</td>";
                echo "<td>{$row['klantEmail']}</td>";
                echo "<td>{$row['klantWoonplaats']}</td>";
                echo "<td>{$row['klantAdres']}</td>";
                echo "<td>{$row['klantPostcode']}</td>";
                echo "<td><form method='post' action='update.php?klantId={$row['klantId']}'><button name='update'>Wzg</button></form></td>";
                echo "<td><form method='POST' action='delete.php?klantId={$row['klantId']}'><button name='verwijderen'>Verwijderen</button></form></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Geen klanten gevonden</td></tr>"; // Aangepast van 7 naar 6
        }
        echo "</table>";
    }

    private function getTableHeader(array $row): string {
        $header = "<tr>";
        foreach (array_keys($row) as $key) {
            if ($key !== "klantId") { // klantId-kolom weghalen
                $header .= "<th>" . htmlspecialchars($key) . "</th>";
            }
        }
        $header .= "<th>Acties</th>";
        $header .= "</tr>";
        return $header;
    }

    /**
     * Summary of searchCustomer
     * Search for customers by name (klantNaam)
     *
     * @param string $searchTerm The search term to look for in customer names
     * @return array Returns an array of customers matching the search term
     */

   public function searchKlanten(string $klantNaam): array {
    try {$sql = "SELECT * FROM $this->table_name WHERE klantNaam LIKE :klantNaam";
        $stmt = self::$conn->prepare($sql);
        $naam = '%' . $klantNaam . '%';
        $stmt->bindParam(':klantNaam', $naam, PDO::PARAM_STR);$stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];} catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}
    
    // Delete klant
    /**
     * Summary of deleteKlant
     * @param int $klantId
     * @return bool
     */
    public function deleteKlant(int $klantId) : bool {
        try {
            $sql = "DELETE FROM " . $this->table_name . " WHERE klantId = :klantId";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':klantId', $klantId, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Log the error message
            error_log('Delete Klant Error: ' . $e->getMessage());
            return false;
        }
    }
    
    
    public function updateKlant($row) : bool {
        $sql = "UPDATE " . $this->table_name . " SET klantEmail = :klantEmail, klantNaam = :klantNaam, klantAdres = :klantAdres, klantPostcode = :klantPostcode, klantWoonplaats = :klantWoonplaats WHERE klantId = :klantId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':klantId', $row['klantId'], \PDO::PARAM_INT);
        $stmt->bindParam(':klantEmail', $row['klantEmail'], \PDO::PARAM_STR);
        $stmt->bindParam(':klantNaam', $row['klantNaam'], \PDO::PARAM_STR);
        $stmt->bindParam(':klantAdres', $row['klantAdres'], \PDO::PARAM_STR);
        $stmt->bindParam(':klantPostcode', $row['klantPostcode'], \PDO::PARAM_STR);
        $stmt->bindParam(':klantWoonplaats', $row['klantWoonplaats'], \PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Summary of BepMaxKlantId
     * @return int
     */
    private function BepMaxKlantId() : int {
        // Bepaal uniek nummer
        $sql = "SELECT MAX(klantId)+1 FROM " . $this->table_name;
        return (int) self::$conn->query($sql)->fetchColumn();
    }

    /**
     * Summary of insertKlant
     * @param array $row
     * @return bool
     */
    public function insertKlant(array $row) : bool {
        // Bepaal een unieke klantId
        $klantId = $this->BepMaxKlantId();
        
        // query
        $sql = "INSERT INTO " . $this->table_name . " (klantId, klantEmail, klantNaam, klantAdres, klantPostcode, klantWoonplaats) VALUES (:klantId, :klantEmail, :klantNaam, :klantAdres, :klantPostcode, :klantWoonplaats)";
        
        // Prepare
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':klantId', $klantId, \PDO::PARAM_INT);
        $stmt->bindParam(':klantEmail', $row['klantEmail'], \PDO::PARAM_STR);
        $stmt->bindParam(':klantNaam', $row['klantNaam'], \PDO::PARAM_STR);
        $stmt->bindParam(':klantAdres', $row['klantAdres'], \PDO::PARAM_STR);
        $stmt->bindParam(':klantPostcode', $row['klantPostcode'], \PDO::PARAM_STR);
        $stmt->bindParam(':klantWoonplaats', $row['klantWoonplaats'], \PDO::PARAM_STR);
        
        // Execute
        return $stmt->execute();
    }
}
?>
