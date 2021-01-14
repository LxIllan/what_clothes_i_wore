<?php
require_once 'Connection.php';
require_once 'Util.php';
require_once 'User.php';

class UserDAO {

    private $_connection;

    function __construct() {
        $this->_connection = new Connection();
    }

    public function addUser(User $user) : bool {
        echo '<script>alert("firstname: ' . $user->getFirstname() .  '");</script>';
        echo '<script>alert("firstname: ' . $user->getFirstname() .  '");</script>';
        echo '<script>alert("firstname: ' . $user->getFirstname() .  '");</script>';        
        return $this->_connection->insert("INSERT INTO user(firstname, lastname, email, password, "
            . "photo_location, root, sex_id, verified) "
            . "VALUES ('" . $user->getFirstname() . "', '"
            . $user->getLastname() . "', '"            
            . $user->getEmail() . "', '"            
            . $user->getPassword() . "', '"
            . $user->getPhotoLocation() . "', "
            . $user->getRoot() . ", "
            . $user->getSexID() . ", "
            . $user->getVerified() . ")");
    }

    public function verifyUser(int $userID) : bool {
        return $this->_connection->update("UPDATE user SET verified = 1 WHERE user_id = $userID");
    }

    public function getNextID() : int {
        $tuple = $this->_connection->select("SELECT AUTO_INCREMENT FROM "
            . "INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'user'")->fetch_array();
        return $tuple[0];
    }

    public function editUser(User $user) : bool {
        return $this->_connection->update("UPDATE user SET "
            . "firstname = '" . $user->getFirstname() . "', "
            . "lastname = '" . $user->getLastname() . "', "            
            . "email = '" . $user->getEmail() . "', "
            . "password = '" . $user->getPassword() . "', "            
            . "photo_location = '" . $user->getPhotoLocation() . "' "
            . "WHERE user_id = " . $user->getUserID());
    }

    // try this funcion, see if all records are deleted, dress items.
    public function deleteUser(int $userID) : bool {
        $photoLocation = "img/users/IMG_" . $userID . ".jpg";
        if (file_exists($photoLocation)) {
            unlink($photoLocation);
        }
        return $this->_connection->delete("DELETE FROM user WHERE user_id = $userID");
    }    

    public function getUser(int $userID) : ?User {
        $tuple = $this->_connection->select("SELECT user_id, firstname, lastname, "
            . "email, password, photo_location, root, sex_id, verified "
            . "FROM user WHERE user_id = " . $userID)->fetch_array();
        if (isset($tuple)) {
            return new User($tuple[0], $tuple[1], $tuple[2], $tuple[3], $tuple[4], $tuple[5], $tuple[6], $tuple[7], $tuple[8]);
        } else {
            return null;
        }
    }

    public function getUserByEmail(string $email) : ?User {
        $tuple = $this->_connection->select("SELECT user_id FROM user WHERE email LIKE '$email'")->fetch_array();
        if (isset($tuple)) {
            return self::getUser($tuple['user_id']);
        } else {
            return null;
        }
    }

    public function getUsers(bool $verified = true) : array {
        $users = [];
        $verified = intval($verified);
        $result = $this->_connection->select("SELECT user_id FROM user WHERE verified = $verified");
        while ($row = $result->fetch_array()) {
            $users[] = self::getUser($row['user_id']);
        }
        $result->free();
        return $users;
    }

    public function getEmailAdmins() : array {
        $emails = [];        
        $result = $this->_connection->select("SELECT user_id FROM user WHERE root = 1");
        while ($row = $result->fetch_array()) {
            $emails[] = self::getUser($row['user_id'])->getEmail();
        }
        $result->free();
        return $emails;
    }

    public function validateSession(string $email, string $password) : ?array {
        $result = $this->_connection->select("SELECT user_id, firstname, lastname, sex_id, root FROM user "
            . "WHERE verified = 1 AND email LIKE '$email' AND email = '$email' "
            . "AND password = '$password'");
        if ($result->num_rows == 1) {
            $row = $result->fetch_array();
            $data = [
                'id' => $row['user_id'],
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname'],
                'sex' => $row['sex_id'],
                'root' => $row['root']
            ];
        }
        return isset($data) ? $data : null;
    }

    public function existsEmail(string $email) : bool {
        $tuple = $this->_connection->select("SELECT email "
            . "FROM user WHERE email LIKE '" . $email . "'")->fetch_array();
        return (isset($tuple) && Util::validateEmail($tuple[0]));
    }
}