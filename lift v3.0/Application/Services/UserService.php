<?php
namespace Application\Services;
session_start();

require_once("Core/Entities/User.php");
require_once("Core/DataInterfaces/IUserRepository.php");

use Core\Entities\User;
use Core\DataInterfaces\IUserRepository;

class UserService {
    private $userRepository;

    public function __construct(IUserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    // Метод для регистрации нового пользователя
    public function registerUser($name, $email, $login, $password): bool {
        // Создаем нового пользователя
        $user = new User($name, $email, $login, $password);

        if($this->userRepository->addUser($user)) {
              $foundUser = $this->userRepository->findUserByUserName($login);
              $_SESSION["userId"] = $foundUser->getId();

            return true;
        }
        else {
            return false;
        }
    }

    // Метод для проверки пользователя
    public function authenticateUser($login, $password): ?User {
        $user = $this->userRepository->checkUser($login, $password);

        $_SESSION["userId"] = $user->getId();

        return $user;
    }

    public function findUserById(int $userId): User {
        return $this->userRepository->findUserById($userId);
    }
}