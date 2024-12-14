<?php

namespace Data\Repositories;

require_once 'Data/Repositories/Dependencies.php';
require_once 'Core/DataInterfaces/IElementTextureRepository.php';

use Core\Entities\ElementTexture;
use Core\Entities\Element;
use Core\Entities\Texture;
use Core\DataInterfaces\IElementTextureRepository;

class ElementTextureRepository implements IElementTextureRepository {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    // Получение всех связок элементов и текстур
    public function getAllElementTextures() {
        $sql = "SELECT * FROM element_textures";
        $result = $this->connection->query($sql);

        $elementTextures = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $elementTextures[] = new ElementTexture($row['element_id'], $row['texture_id']);
            }
        }
        return $elementTextures;
    }

    // Получение связки по ID элемента и текстуры
    public function getElementTexture($elementId, $textureId) {
        $stmt = $this->connection->prepare("SELECT * FROM element_textures WHERE element_id = ? AND texture_id = ?");
        $stmt->bind_param("ii", $elementId, $textureId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new ElementTexture($row['element_id'], $row['texture_id']);
        }

        return null; // Если связка не найдена
    }

    // Добавление новой связки элементов и текстур
    public function addElementTexture($elementId, $textureId) {
        $stmt = $this->connection->prepare("INSERT INTO element_textures (element_id, texture_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $elementId, $textureId);

        if ($stmt->execute()) {
            return new ElementTexture($elementId, $textureId); // Возвращает объект связки
        } else {
            return false; // Ошибка при добавлении
        }
    }

     // Получение всех текстур по ID элемента
     public function getTexturesByElementId($elementId) {
        $stmt = $this->connection->prepare("SELECT t.id, t.texture_path 
                                             FROM element_textures et 
                                             JOIN textures t ON et.texture_id = t.id 
                                             WHERE et.element_id = ?");
        $stmt->bind_param("i", $elementId);
        $stmt->execute();
        $result = $stmt->get_result();

        $textures = [];
        while ($row = $result->fetch_assoc()) {
            $textures[] = new Texture($row['id'], $row['texture_path']);
        }

        return $textures; // Возвращает массив объектов Texture
    }

    // Закрытие соединения
    public function close() {
        $this->connection->close();
    }
}