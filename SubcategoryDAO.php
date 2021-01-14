<?php
require_once 'Connection.php';
require_once 'Util.php';
require_once 'Subcategory.php';

class SubCategoryDAO {

    private $_connection;

    function __construct() {
        $this->_connection = new Connection();
    }

    public function addSubcategory(Subcategory $subcategory): bool {
        return $this->_connection->insert("INSERT INTO subcategory(subcategory, category_id, sex_id) "            
            . "VALUES ('" . $subcategory->getSubcategory() . "', "                                
            . $subcategory->getCategoryID() . ", "
            . $subcategory->getSEXID() . ")");
    }    

    public function editSubcategory(Subcategory $subcategory): bool {
        return $this->_connection->update("UPDATE subcategory SET "
            . "subcategory = '" . $subcategory->getSubcategory() . "', "
            . "category_id = " . $subcategory->getCategoryID() . ", "
            . "sex_id = " . $subcategory->getPhotoLocation() . " "            
            . "WHERE subcategory_id = " . $subcategory->getSubcategoryID());
    }

    // try this funcion, see if all records are deleted, dress items.
    public function deleteSubcategory(int $subcategoryID) : bool {        
        return $this->_connection->delete("DELETE FROM subcategory WHERE subcategory_id = $subcategoryID");
    }    

    public function getSubcategory(int $subcategoryID) : Subcategory {        
        $tuple = $this->_connection->select("SELECT subcategory_id, subcategory, category_id, sex_id "
            . "FROM subcategory WHERE subcategory_id = " . $subcategoryID)->fetch_array();        
        return (isset($tuple)) ? new Subcategory($tuple[0], $tuple[1], $tuple[2], $tuple[3]) : null;        
    }    

    public function getSubcategories(int $categoryID, int $sexID) : array {
        $subcategories = [];        
        $result = $this->_connection->select("SELECT subcategory_id FROM subcategory WHERE category_id = $categoryID AND sex_id IN ($sexID, 3)");        
        while ($row = $result->fetch_array()) {                        
            $subcategories[] = self::getSubcategory($row['subcategory_id']);
        }                
        $result->free();
        return $subcategories;
    }

    public function getAllSubcategories(int $sexID) : array {
        $subcategories = [];        
        $result = $this->_connection->select("SELECT subcategory_id FROM subcategory WHERE sex_id IN ($sexID, 3) ORDER BY subcategory");
        while ($row = $result->fetch_array()) {                        
            $subcategories[] = self::getSubcategory($row['subcategory_id']);
        }                
        $result->free();
        return $subcategories;
    }

}