<?php
namespace Data\Repositories;
require_once("Core/DataInterfaces/IRequestRepository.php");

use Core\Entities\Request;
use Core\DataInterfaces\IRequestRepository;

class RequestRepository implements IRequestRepository {
    private $db;

    public function __construct(\mysqli $dbConnection) {
        $this->db = $dbConnection;
    }

    public function add(Request $request): ?Request {
        // Подготовка SQL-запроса для вставки новой заявки
        $stmt = $this->db->prepare("INSERT INTO requests (user_id, email, price) VALUES (?, ?, ?)");
        if (!$stmt) {
            return null; // Обработка ошибки
        }
    
        // Сохранение значений в переменные
        $userId = $request->getUserId();
        $email = $request->getEmail();
        $price = $request->getPrice();
    
        // Привязка параметров
        $stmt->bind_param("isd", $userId, $email, $price);
    
        // Выполнение запроса
        if ($stmt->execute()) {
            $requestId = $stmt->insert_id; // Получение ID новой записи
            $request->setRequestId($requestId); // Установка ID в объект
            return $request; // Возвращение нового объекта Request
        }
    
        return null; // Возвращение null в случае ошибки
    }

    public function findById(int $requestId): ?Request {
        $stmt = $this->db->prepare("SELECT * FROM requests WHERE request_id = ?");
        if (!$stmt) {
            return null; // Обработка ошибки
        }

        // Привязка параметров
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        
        // Получение результата
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $request = new Request($row['user_id'], $row['email'], $row['price']);
            $request->setRequestId($row['request_id']);
            return $request;
        }
        return null; // Если заявка не найдена
    }

    public function findByUserId(int $userId): array {
        // Подготовка SQL-запроса для поиска всех заявок пользователя
        $stmt = $this->db->prepare("SELECT * FROM requests WHERE user_id = ?");
        if (!$stmt) {
            return []; // Обработка ошибки
        }

        // Привязка параметров
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        
        // Получение результата
        $result = $stmt->get_result();
        $requests = [];
        
        // Обработка всех найденных заявок
        while ($row = $result->fetch_assoc()) {
            $request = new Request($row['user_id'], $row['email'], $row['price']);
            $request->setRequestId($row['request_id']);
            $requests[] = $request;
        }
        return $requests; // Возвращение массива заявок
    }

    public function getAllRequests(): array {
        $query = "select * from requests";

        $queryResult = \mysqli_query($this->db, $query) or die(\mysqli_error($this->db));

        $requests = [];

        if ($queryResult) {
            while ($row = mysqli_fetch_assoc($queryResult)) {
                $requests[] = $row;
            }
        } else {
            throw new \Exception("Что-то не так с заявками");
        }

        return $requests;
    }

    public function setNewPrice(int $requestId, float $price):bool {
        $query = "update requests set price = $price where request_id = $requestId";

        return \mysqli_query($this->db, $query) or die(\mysqli_error($this->db));
    }
}