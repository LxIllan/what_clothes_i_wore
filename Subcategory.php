<?php

class Subcategory {

    private $subcategoryID;
    private $subcategory;
    private $categoryID;
    private $sexID;

    public function __construct(int $subcategoryID, string $subcategory, int $categoryID, int $sexID) {
        $this->subcategoryID = $subcategoryID;
        $this->subcategory = $subcategory;
        $this->categoryID = $categoryID;
        $this->sexID = $sexID;
    }

    public function setSubcategoryID(int $subcategoryID)
    {
        $this->subcategoryID = $subcategoryID;
    }

    public function getSubcategoryID() : int
    {
        return $this->subcategoryID;
    }

    public function setSubcategory(string $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    public function getSubcategory() : string
    {
        return $this->subcategory;
    }

    public function setCategoryID(int $categoryID)
    {
        $this->categoryID = $categoryID;
    }

    public function getCategoryID() : int
    {
        return $this->categoryID;
    }

    public function setSexID(int $sexID)
    {
        $this->sexID = $sexID;
    }

    public function getSexID() : int
    {
        return $this->sexID;
    }

}