<?php
namespace Core\Entities;

class User {
    private $id;
    private $name;
    private $email;
    private $login;
    private $password;

    public function __construct($name, $email, $login, $password) {
        $this->name = $name;
        $this->email = $email;
        $this->login = $login;
        $this->setPassword($password);
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }
}