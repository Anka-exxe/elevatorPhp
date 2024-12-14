<?php
namespace Data\Repositories;

require_once 'Data/Repositories/Dependencies.php';
require_once 'Core/DataInterfaces/ITextureRepository.php';

use Core\Entities\ElementTexture;
use Core\Entities\Texture;
use Core\Entities\Element;
use Core\DataInterfaces\ITextureRepository;

class TextureRepository implements ITextureRepository {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    // Получение всех текстур
    public function getAllTextures() {
        $sql = "SELECT * FROM textures";
        $result = $this->connection->query($sql);
        
        $textures = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $textures[] = new Texture($row['id'], $row['texture_path']);
            }
        }
        return $textures;
    }

    // Получение текстуры по ID
    public function getTextureById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM textures WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return new Texture($row['id'], $row['texture_path']);
        }
        
        return null; // Если текстура не найдена
    }

    public function getPathById($textureId) {
        $query = "select texture_path from textures where id = $textureId";
        $queryResult = mysqli_query($this->connection, $query);
        $path =  mysqli_fetch_assoc($queryResult);
        return $path["texture_path"];
    }

    function getIdByPath($path) {
        if ($path === null) {
            return null; // Or throw an exception
        }
    
        // Prepare SQL query to prevent SQL injection
        $query = "SELECT id FROM textures WHERE texture_path = ?";
        $stmt = mysqli_prepare($this->connection, $query);
        
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "s", $path);
        
        // Execute the query
        mysqli_stmt_execute($stmt);
        
        // Get the result
        $queryResult = mysqli_stmt_get_result($stmt);
        
        // Check if the texture was found
        if ($textureId = mysqli_fetch_assoc($queryResult)) {
            return $textureId["id"];
        } else {
            return null; // Return null if nothing was found
        }
    }

    // Добавление новой текстуры
    public function addTexture($texturePath) {
        $stmt = $this->connection->prepare("INSERT INTO textures (texture_path) VALUES (?)");
        $stmt->bind_param("s", $texturePath);

        if ($stmt->execute()) {
            return new Texture($this->connection->insert_id, $texturePath); // Возвращает объект текстуры
        } else {
            return false; // Ошибка при добавлении
        }
    }

    // Закрытие соединения
    public function close() {
        $this->connection->close();
    }
}
