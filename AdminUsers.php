<?php

require_once 'UserDAO.php';
require_once 'User.php';
require_once 'Util.php';

class AdminUsers {

    private $_userDAO;

    function __construct() {
        $this->_userDAO = new UserDAO();
    }   

    public function addUser(string $firstname, string $lastname, string $email, string $password, int $sexID) : bool {
        $userID = 1;
        $photoLocation = 'img/users/default.jpg';
        $root = 0;
        $verified = 1;
        return $this->_userDAO->addUser(new User($userID, $firstname, $lastname, $email, $password, $photoLocation, $root, $sexID, $verified));
    }

    public function editUser(User $user) : bool {
        return $this->_userDAO->editUser($user);
    }

    public function deleteUser(int $userID) : bool {
        return $this->_userDAO->deleteUser($userID);
    }

    public function getUser(int $userID) : ?User {
        return $this->_userDAO->getUser($userID);
    }

    public function getUserByEmail(string $email) : ?User {
        return $this->_userDAO->getUserByEmail($email);
    }

    public function getUsers(bool $verified = true) : array {
        return $this->_userDAO->getUsers($verified);
    }

    public function validateSession(string $email, string $password) : ?array {
        return $this->_userDAO->validateSession($email, $password);
    }    

    public function existEmail(string $email) : bool {
        return $this->_userDAO->existsEmail($email);
    }    

    public function getNextID() : int {
        return $this->_userDAO->getNextID();
    }

    public function verifyUser(int $userID) : bool {
        return $this->_userDAO->verifyUser($userID);
    }

    public function getEmailAdmins() : array {
        return $this->_userDAO->getEmailAdmins();
    }
}