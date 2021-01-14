<?php

require_once 'DressItemDAO.php';
require_once 'DressItem.php';
require_once 'Util.php';

class AdminDressItems {

    private $_dressItemDAO;

    function __construct() {
        $this->_dressItemDAO = new DressItemDAO();
    }   

    public function addDressItem(string $name, string $description, string $photoLocation, int $userID, int $subcategoryID) : bool {        
        $dressItemID = 1;
        $available = 1;
        return $this->_dressItemDAO->addDressItem(new DressItem($dressItemID, $name, $description, $photoLocation, $available, $userID, $subcategoryID));
    }

    public function editDressItem(DressItem $dressItem) : bool {
        return $this->_dressItemDAO->editDressItem($dressItem);
    }

    public function deleteDressItem(int $dressItemID) : bool {
        return $this->_dressItemDAO->deleteDressItem($dressItemID);
    }

    public function getDressItem(int $dressItemID) : DressItem {
        return $this->_dressItemDAO->getDressItem($dressItemID);
    }

    public function getDressItemsByEvent(int $eventID) : array {
        return $this->_dressItemDAO->getDressItemsByEvent($eventID);
    }

    public function getDressItems(int $userID, int $subcategoryID, bool $getAvailable) : array
    {        
        return $this->_dressItemDAO->getDressItems($userID, $subcategoryID, $getAvailable);
    }

    public function getAllDressItems(int $userID, bool $getAvailable = true) : array {
        return $this->_dressItemDAO->getAllDressItems($userID, $getAvailable);
    }

    public function getNextID() : int {
        return $this->_dressItemDAO->getNextID();
    }
}