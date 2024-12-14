<?php
 namespace Core\DataInterfaces;

require_once("Core/Entities/User.php");
use Core\Entities\User;

 interface IUserRepository {
    public function addUser(User $user): bool; // Метод для добавления пользователя
    public function checkUser(string $login, string $password): ?User; // Метод для проверки пользователя
    public function findUserByUserName(int $userName):User;
    function findUserById(int $userId):User;
}