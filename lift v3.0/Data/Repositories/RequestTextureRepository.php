<?php
namespace Data\Repositories;

require_once("Core/DataInterfaces/IRequestTexturRepository.php");

use Core\Entities\RequestTexture;
use Core\DataInterfaces\IRequestTextureRepository;

class RequestTextureRepository implements IRequestTextureRepository {
    private $db;

    public function __construct(\mysqli $dbConnection) {
        $this->db = $dbConnection;
    }

    public function save(RequestTexture $requestTexture): bool {
        $requestId = $requestTexture->getRequestId();
        $elementId = $requestTexture->getElementId();
        $textureId = $requestTexture->getTextureId();

        // Prepare and execute the SQL statement
        $stmt = $this->db->prepare("INSERT INTO request_textures (request_id, element_id, texture_id) VALUES (?, ?, ?)");
        if (!$stmt) {
            return false; // Handle error
        }

        $stmt->bind_param("iii", $requestId, $elementId, $textureId);
        $result = $stmt->execute();
        $stmt->close();

        return $result; // Return true if successful
    }

    public function findByRequestId(int $requestId): array {
        $query = "select element_id, texture_id from request_textures where request_id = $requestId";

        $queryResult = \mysqli_query($this->db, $query) or die(\mysqli_error($this->db));
        $requestElementTexture =[];

        if ($queryResult) {
            while ($row = mysqli_fetch_assoc($queryResult)) {
                $requestElementTexture[] = $row;
            }
        } else {
            throw new \Exception("Не найдена информация об этой заявке");
        }

        return $requestElementTexture;
    }
}