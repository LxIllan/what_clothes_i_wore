<?php

require_once 'Event.php';
require_once 'EventDAO.php';
require_once 'Util.php';

class AdminEvents {

    private $_eventDAO;

    function __construct() {
        $this->_eventDAO = new EventDAO();
    }   

    public function addEvent(string $description, string $fullDescription, string $date, int $userID) : bool {
        $eventID = 1;        
        return $this->_eventDAO->addEvent(new Event($eventID, $description, $fullDescription, $date, $userID));
    }

    public function editEvent(Event $event) : bool {
        return $this->_eventDAO->editEvent($event);
    }

    public function getEvent(int $eventID) : ?Event {
        return $this->_eventDAO->getEvent($eventID);
    }

    public function getTodaysEvents(int $userID) : array {
        return $this->_eventDAO->getTodaysEvents($userID);
    }

    public function getEventsByDescription(int $userID, string $description) : array {
        return $this->_eventDAO->getEventsByDescription($userID, $description);
    }

    public function getEventsBetweenDates(int $userID, ?string $since, ?string $until) : array {
        if (!isset($since)) {
			$since = date('Y-m-d', strtotime("first day of this month"));
		}
		if (!isset($until)) {
			$until = date('Y-m-d');
		}
        return $this->_eventDAO->getEventsBetweenDates($userID, $since, $until);
    }

    public function getEventsByThisDressItem(int $dressItemID) : array {
        return $this->_eventDAO->getEventsByThisDressItem($dressItemID);
    }

    public function addDressItemToEvent(int $eventID, int $dressItemID) : bool {
        return $this->_eventDAO->addDressItemToEvent($eventID, $dressItemID);
    }

    public function deleteDressItemInEvent(int $eventID, int $dressItemID) : bool {
        return $this->_eventDAO->deleteDressItemInEvent($eventID, $dressItemID);
    }
}