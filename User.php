<?php

class User {

    private $userID;
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $photoLocation;
    private $root;
    private $sexID;
    private $verified;

    public function __construct(int $userID, string $firstname, string $lastname, string $email, string $password, string $photoLocation, int $root, int $sexID, int $verified) {
        $this->userID = $userID;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->photoLocation = $photoLocation;
        $this->root = $root;
        $this->sexID = $sexID;
        $this->verified = $verified;
    }    

    public function getUserID() : int
    {
        return $this->userID;
    }

    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
    }

    public function getFirstname() : string
    {
        return $this->firstname;
    }

    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
    }

    public function getLastname() : string
    {
        return $this->lastname;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function setPhotoLocation(string $photoLocation)
    {
        $this->photoLocation = $photoLocation;
    }

    public function getPhotoLocation() : string
    {
        return $this->photoLocation;
    }

    public function setRoot(int $root)
    {
        $this->root = $root;
    }

    public function getRoot() : int
    {
        return $this->root;
    }

    public function setSexID(int $sexID)
    {
        $this->sexID = $sexID;
    }

    public function getSexID() : int
    {
        return $this->sexID;
    }

    public function setVerified(int $verified)
    {
        $this->verified = $verified;
    }

    public function getVerified() : int
    {
        return $this->verified;
    }
}