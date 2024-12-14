<?php
namespace Data\Repositories;

require_once("Core/DataInterfaces/IUserRepository.php");
use Core\DataInterfaces\IUserRepository;

require_once("Core/Entities/User.php");
use Core\Entities\User;

class UserRepository implements IUserRepository {
    private $connection;

    public function __construct($dbConnection) {
        $this->connection = $dbConnection; // Предполагается, что $dbConnection - это PDO объект
    }

    // Метод для добавления пользователя
    public function addUser(User $user): bool {
        $stmt = $this->connection->prepare("INSERT INTO account (name, email, login, password) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $user->getName(),
            $user->getEmail(),
            $user->getLogin(),
            $user->getPassword()
        ]);
    }

    public function findUserByUserName($userName):User {
        $query = "select * from account where login = '$userName'";
        $queryResult = \mysqli_query($this->connection, $query);
        $userInfo = \mysqli_fetch_assoc($queryResult);
        
        $newUser = new User(
            $userInfo["name"], 
            $userInfo["email"], 
            $userInfo["login"], 
            $userInfo["password"]
        );

        $newUser->setId($userInfo["id"]);

        return $newUser;
    }

    public function findUserById(int $userId): User {
        $query = "SELECT * FROM account WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $queryResult = $stmt->get_result();
        $userInfo = $queryResult->fetch_assoc();
    
        // Проверьте, что пользователь найден
        if (!$userInfo) {
            throw new \Exception("Пользователь не найден");
        }
    
        $foundUser = new User(
            $userInfo["name"], 
            $userInfo["email"], 
            $userInfo["login"], 
            $userInfo["password"]
        );
        $foundUser->setId($userInfo["id"]);
    
        return $foundUser;
    }

   // Метод для проверки пользователя
   public function checkUser(string $login, string $password): ?User {
    // Подготовка SQL-запроса
    $stmt = $this->connection->prepare("SELECT * FROM account WHERE login = ?");
    $stmt->bind_param("s", $login); // Привязываем параметр
    $stmt->execute(); // Выполняем запрос

    // Получаем результат
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Извлекаем ассоциативный массив

        // Проверяем пароль
        if (password_verify($password, $row['password'])) {
            // Если пароль верен, создаем объект User и возвращаем его
            $user = new User($row['name'], $row['email'], $row['login'], $row['password']);
            $user->setId($row['id']); // Устанавливаем id пользователя
            return $user;
        }
    }

    return null; // Если пользователь не найден или пароль неверный
}
}