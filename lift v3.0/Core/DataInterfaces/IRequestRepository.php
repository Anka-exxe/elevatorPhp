<?php
namespace Core\DataInterfaces;

require_once("Core/Entities/Request.php");
use Core\Entities\Request;

interface IRequestRepository {
    public function add(Request $request): ?Request;
    public function findById(int $requestId): ?Request;
    public function findByUserId(int $userId): array;
    public function getAllRequests(): array;
    public function setNewPrice(int $requestId, float $price):bool;
}