<?php
namespace Core\Entities;

class Request {
    private $requestId;
    private $userId;
    private $email;
    private $price;

    public function __construct($userId, $email, $price) {
        $this->userId = $userId;
        $this->email = $email;
        $this->price = $price;
    }

    public function getRequestId() {
        return $this->requestId;
    }

    public function setRequestId($requestId) {
        $this->requestId = $requestId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPrice() {
        return $this->price;
    }
}