<?php
require_once 'Database.php';

class DesafioTres
{

    public static function findLotes(?string $loteID = null): void
    {

        Database::setDB();

        $result = self::getLotes($loteID);
        header('Content-Type: application/json');

        if (sizeof($result)) {
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Lote no encontrado']);
        }
    }

    private static function getLotes(?string $loteID)
    {
        $lotes = [];
        $cnx = Database::getConnection();
        $query = $loteID ? "SELECT * FROM debts WHERE lote = '$loteID' " : "SELECT * FROM debts ";
        $stmt = $cnx->query($query);

        while ($rows = $stmt->fetchArray(SQLITE3_ASSOC)) {
            $lotes[] = (object) $rows;
        }
        return $lotes;
    }
}


isset($_GET['lote']) ? DesafioTres::findLotes($_GET['lote']) : DesafioTres::findLotes();
