<?php

class DressItem {

    private $dressItemID;
    private $name;
    private $description;
    private $photoLocation;
    private $available;
    private $userID;
    private $subcategoryID;

    public function __construct(int $dressItemID, string $name, string $description, string $photoLocation, int $available, int $userID, int $subcategoryID) {
        $this->dressItemID = $dressItemID;
        $this->name = $name;
        $this->description = $description;
        $this->photoLocation = $photoLocation;
        $this->available = $available;
        $this->userID = $userID;
        $this->subcategoryID = $subcategoryID;
    }    

    public function getDressItemID() : int
    {
        return $this->dressItemID;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setPhotoLocation(string $photoLocation)
    {
        $this->photoLocation = $photoLocation;
    }

    public function getPhotoLocation() : string
    {
        return $this->photoLocation;
    }

    public function setAvailable(int $available)
    {
        $this->available = $available;
    }

    public function getAvailable() : int
    {
        return $this->available;
    }

    public function setSubcategoryID(int $subcategoryID)
    {
        $this->subcategoryID = $subcategoryID;
    }

    public function getSubcategoryID() : int
    {
        return $this->subcategoryID;
    }    

    public function getUserID() : int
    {
        return $this->userID;
    }

}