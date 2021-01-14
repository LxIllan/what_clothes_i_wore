<?php

require_once 'Connection.php';
require_once 'Event.php';
require_once 'Util.php';

class EventDAO {

    private $_connection;

    function __construct() {
        $this->_connection = new Connection();
    }

    public function addEvent(Event $event) : bool {
        return $this->_connection->insert("INSERT INTO event(description, full_description, date, user_id) "
            . "VALUES ('" . addcslashes($event->getDescription()) . "', '"
            . addcslashes($event->getFullDescription()) . "', '"            
            . $event->getDate() . "', "            
            . $event->getUserID() . ")");
    }

    public function getNextID() : int {
        $tuple = $this->_connection->select("SELECT AUTO_INCREMENT FROM "
            . "INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'event'")->fetch_array();
        return $tuple[0];
    }

    public function editEvent(Event $event) : bool {
        return $this->_connection->update("UPDATE event SET "
            . "description = '" . $event->getDescription() . "', "
            . "full_description = '" . $event->getFullDescription() . "', "
            . "date = '" . $event->getDate() . "' "
            . "WHERE event_id = " . $event->getEventID());
    }

    public function deleteEvent(int $eventID) : bool {
        return $this->_connection->delete("DELETE FROM event WHERE event_id = $eventID");
    }

    public function getEvent(int $eventID) : ?Event {
        $tuple = $this->_connection->select("SELECT event_id, description, full_description, date, user_id "
            . "FROM event WHERE event_id = " . $eventID)->fetch_array();
        if (isset($tuple)) {
            return new Event($tuple[0], $tuple[1], $tuple[2], $tuple[3], $tuple[4]);
        } else {
            return null;
        }
    }

    public function getEvents(int $userID) : array {
        $events = [];        
        $result = $this->_connection->select("SELECT event_id FROM event WHERE user_id = $userID");
        while ($row = $result->fetch_array()) {
            $events[] = self::getEvent($row['event_id']);
        }
        $result->free();
        return $events;
    }

    public function getTodaysEvents(int $userID) : array {
        $events = [];
        $result = $this->_connection->select("SELECT event_id FROM event WHERE user_id = $userID AND date = curdate()");
        while ($row = $result->fetch_array()) {
            $events[] = self::getEvent($row['event_id']);
        }
        $result->free();
        return $events;
    }

    public function getEventsBetweenDates(int $userID, string $since, string $until) : array {
        $events = [];
        $result = $this->_connection->select("SELECT event_id FROM event WHERE user_id = $userID AND date >= '$since' AND date <= '$until'");
        while ($row = $result->fetch_array()) {
            $events[] = self::getEvent($row['event_id']);
        }
        $result->free();
        return $events;
    }

    public function getEventsByDescription(int $userID, string $description) : array {
        $events = [];
        $result = $this->_connection->select("SELECT event_id FROM event WHERE user_id = $userID AND description LIKE '%$description%' ORDER BY description");
        while ($row = $result->fetch_array()) {
            $events[] = self::getEvent($row['event_id']);
        }
        $result->free();
        return $events;
    }

    public function getEventsByThisDressItem(int $dressItemID) : array {
        $events = [];        
        $result = $this->_connection->select("SELECT event_id FROM used_clothing WHERE dress_item_id = $dressItemID");
        while ($row = $result->fetch_array()) {
            $events[] = self::getEvent($row['event_id']);
        }
        $result->free();
        return $events;
    }

    public function addDressItemToEvent(int $eventID, int $dressItemID) : bool {
        return $this->_connection->insert("INSERT INTO used_clothing(event_id, dress_item_id) "
            . "VALUES ($eventID, $dressItemID)");
    }

    public function deleteDressItemInEvent(int $eventID, int $dressItemID) : bool {
        return $this->_connection->delete("DELETE FROM used_clothing WHERE event_id = $eventID AND dress_item_id = $dressItemID");
    }
}
