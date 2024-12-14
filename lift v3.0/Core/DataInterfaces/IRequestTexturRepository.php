<?php
namespace Core\DataInterfaces;

require_once("Core/Entities/RequestTexture.php");
use Core\Entities\RequestTexture;

interface IRequestTextureRepository {
    public function save(RequestTexture $requestTexture): bool; // Метод для сохранения связи заявки и текстуры
    public function findByRequestId(int $requestId): array; // Метод для поиска всех текстур по request_id
}