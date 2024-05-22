<?php
// auteur: RohanD
// functie: definitie class Klant
namespace Bas\classes;

use Bas\classes\Database;

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
    public function crudKlant() : void {
        // Haal alle klanten op uit de database mbv de method getKlanten()
        $lijst = $this->getKlanten();

        // Print een HTML tabel van de lijst    
        $this->showTable($lijst);
    }

    /**
     * Summary of getKlanten
     * @return array
     */
    public function getKlanten() : array {
        $sql = "SELECT klantId, klantEmail, klantNaam, klantAdres, klantPostcode, klantWoonplaats FROM " . $this->table_name;
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
        $sql = "SELECT klantId, klantEmail, klantNaam, klantAdres, klantPostcode, klantWoonplaats FROM " . $this->table_name . " WHERE klantId = :klantId";
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
    public function showTable(array $lijst) : void {
        $txt = "<table>";

        // Voeg de kolomnamen boven de tabel
        $txt .= getTableHeader($lijst[0]);

        foreach ($lijst as $row) {
            $txt .= "<tr>";
            $txt .=  "<td>" . $row["klantId"] . "</td>";
            $txt .=  "<td>" . $row["klantNaam"] . "</td>";
            $txt .=  "<td>" . $row["klantEmail"] . "</td>";
            $txt .=  "<td>" . $row["klantAdres"] . "</td>";
            $txt .=  "<td>" . $row["klantPostcode"] . "</td>";
            $txt .=  "<td>" . $row["klantWoonplaats"] . "</td>";
            
            // Update
            // Wijzig knopje
            $txt .=  "<td>
            <form method='post' action='update.php?klantId={$row["klantId"]}' >       
                <button name='update'>Wzg</button>    
            </form> </td>";

            // Delete
            $txt .=  "<td>
            <form method='post' action='delete.php?klantId={$row["klantId"]}' >       
                <button name='verwijderen'>Verwijderen</button>     
            </form> </td>";    
            $txt .= "</tr>";
        }
        $txt .= "</table>";
        echo $txt;
    }

    // Delete klant
    /**
     * Summary of deleteKlant
     * @param int $klantId
     * @return bool
     */
    public function deleteKlant(int $klantId) : bool {
        $sql = "DELETE FROM " . $this->table_name . " WHERE klantId = :klantId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':klantId', $klantId, \PDO::PARAM_INT);
        return $stmt->execute();
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
