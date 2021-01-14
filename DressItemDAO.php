<?php
require_once 'Connection.php';
require_once 'Util.php';
require_once 'DressItem.php';

class DressItemDAO {

    private $_connection;

    function __construct() {
        $this->_connection = new Connection();
    }

    public function addDressItem(DressItem $dressItem): bool {
        return $this->_connection->insert("INSERT INTO dress_item(name, description, "
            . "photo_location, available, user_id, subcategory_id) "
            . "VALUES ('" . $dressItem->getName() . "', '"
            . $dressItem->getDescription() . "', '"            
            . $dressItem->getPhotoLocation() . "', "
            . $dressItem->getAvailable() . ", "
            . $dressItem->getUserID() . ", "
            . $dressItem->getSubcategoryID() . ")");
    }


    public function getNextID(): int {
        $tuple = $this->_connection->select("SELECT AUTO_INCREMENT FROM "
            . "INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'dress_item'")->fetch_array();
        return $tuple[0];
    }

    public function editDressItem(DressItem $dressItem): bool {
        return $this->_connection->update("UPDATE dress_item SET "
            . "name = '" . $dressItem->getName() . "', "
            . "description = '" . $dressItem->getDescription() . "', "            
            . "photo_location = '" . $dressItem->getPhotoLocation() . "', "            
            . "available = " . $dressItem->getAvailable() . ", "
            . "subcategory_id = " . $dressItem->getSubcategoryID() . " "
            . "WHERE dress_item_id = " . $dressItem->getDressItemID());
    }

    // try this funcion, see if all records are deleted, dress items.
    public function deleteDressItem(int $dressItemID) : bool {
        $photoLocation = "img/dress_items/IMG_" . $dressItemID . ".jpg";
        if (file_exists($photoLocation)) {
            unlink($photoLocation);
        }
        return $this->_connection->delete("DELETE FROM dress_item WHERE dress_item_id = $dressItemID");
    }    

    public function getDressItem(int $dressItemID) : ?DressItem {        
        $tuple = $this->_connection->select("SELECT dress_item_id, name, description, photo_location, available, "
            . "user_id, subcategory_id FROM dress_item WHERE dress_item_id = " . $dressItemID)->fetch_array();
        if (isset($tuple)) {
            return new DressItem($tuple[0], $tuple[1], $tuple[2], $tuple[3], $tuple[4], $tuple[5], $tuple[6]);
        } else {
            return null;
        }
    }    

    public function getDressItems(int $userID, int $subcategoryID, bool $getAvailable = true) : array {
        $dressItems = [];        
        $result = $this->_connection->select("SELECT dress_item_id FROM dress_item "
            . "WHERE user_id = $userID AND subcategory_id = $subcategoryID AND available = $getAvailable "
            . "ORDER BY subcategory_id DESC");                
        while ($row = $result->fetch_array()) {
            $dressItems[] = self::getDressItem($row['dress_item_id']);
        }
        $result->free();
        return $dressItems;
    }

    public function getDressItemsByEvent(int $eventID) : array {
        $dressItems = [];        
        $result = $this->_connection->select("SELECT dress_item_id FROM used_clothing "
            . "WHERE event_id = $eventID");   
        while ($row = $result->fetch_array()) {
            $dressItems[] = self::getDressItem($row['dress_item_id']);
        }
        $result->free();
        return $dressItems;
    }

    public function getAllDressItems(int $userID) : array {
        $dressItems = [];        
        $result = $this->_connection->select("SELECT dress_item_id FROM dress_item "
            . "WHERE user_id = $userID ORDER BY subcategory_id DESC");        
            while ($row = $result->fetch_array()) {
                $dressItems[] = self::getDressItem($row['dress_item_id']);
            }
        $result->free();
        return $dressItems;
    }
}