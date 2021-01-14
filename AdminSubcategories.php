<?php

require_once 'SubcategoryDAO.php';
require_once 'Subcategory.php';
require_once 'Util.php';

class AdminSubcategories {

    private $_subcategoryDAO;

    function __construct() {
        $this->_subcategoryDAO = new SubcategoryDAO();
    }   

    public function addSubcategory(string $subcategory, int $categoryID, int $sexID) : bool {        
        $subcategoryID = 1;        
        return $this->_subcategoryDAO->addSubcategory(new Subcategory($subcategoryID, $subcategory, $categoryID, $sexID));
    }

    public function editSubcategory(Subcategory $user) : bool {
        return $this->_subcategoryDAO->editSubcategory($user);
    }

    public function deleteSubcategory(int $dressItemID) : bool {
        return $this->_subcategoryDAO->deleteSubcategory($dressItemID);
    }

    public function getSubcategory(int $dressItemID) : Subcategory {
        return $this->_subcategoryDAO->getSubcategory($dressItemID);
    }

    public function getSubcategories(int $categoyID, int $sexID) : array {
        return $this->_subcategoryDAO->getSubcategories($categoyID, $sexID);
    }    

    public function getAllSubcategories(int $sexID) : array {
        return $this->_subcategoryDAO->getAllSubcategories($sexID);
    }
}