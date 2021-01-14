<?php

class Event {

    private $eventID;
    private $description;
    private $fullDescription;
    private $date;
    private $userID;

    public function __construct(int $eventID, string $description, string $fullDescription, string $date, int $userID) {
        $this->eventID = $eventID;
        $this->description = $description;
        $this->fullDescription = $fullDescription;
        $this->date = $date;
        $this->userID = $userID;
    }

    public function setEventID(int $eventID)
    {
        $this->eventID = $eventID;
    }

    public function getEventID() : int
    {
        return $this->eventID;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setFullDescription(string $fullDescription)
    {
        $this->fullDescription = $fullDescription;
    }

    public function getFullDescription() : string
    {
        return $this->fullDescription;
    }

    public function setDate(string $date)
    {
        $this->date = $date;
    }

    public function getDate() : string
    {
        return $this->date;
    }

    public function setUserID(int $userID)
    {
        $this->userID = $userID;
    }

    public function getUserID() : int
    {
        return $this->userID;
    }

}