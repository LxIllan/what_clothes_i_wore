<?php

    session_start();

    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }

    require_once 'AdminEvents.php';
    require_once 'AdminDressItems.php';
    require_once 'navigation.php';
    require_once 'template.php';
    require_once 'Util.php';

    HTML_head('Dress Items');
    HTML_body(["Today's Events"]);
    
    $adminEvents = new AdminEvents();
    $adminDressItems = new AdminDressItems();
?>

    <!-- Accordion -->
    <div id="accordion" role="tablist">
    

        <?php
            $userID = $_SESSION['user']['id'];
            $events = $adminEvents->getTodaysEvents($userID);
            
            foreach ($events as $event) {
                $description = str_replace(' ', '', $event->getDescription());
                echo '<div class="card col-12">';
                    echo '<div class="card-header" role="tab" id="headingOne">';
                        echo '<h6 class="mb-0 text-center"><a data-toggle="collapse" aria-expanded="true" href="#' . $description . '" aria-controls="' . $description . '">' . $event->getDescription() . '<b></b></a></h6>';
                    echo '</div>';
                    echo '<div class="collapse hide" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" id="' . $description . '">';
                        echo '<div class="card-body col-12">';
                            echo '<div class="table-responsive">';
                                echo '<table class="table table-hover table-condensed">';
                                    echo '<thead>';
                                    echo '<tr class="bg-primary">';
                                    echo '<th>Photo</th>';
                                    echo '<th>Dress Item</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';
                            $dressItems = $adminDressItems->getDressItemsByEvent($event->getEventID());
                            foreach ($dressItems as $dressItem) { 
                                echo '<tr>';
                                echo '<td><img class="img-thumbnail" height="40" width="40" src="' . $dressItem->getPhotoLocation() . '" /></td>';
                                echo '<td>' . $dressItem->getName() . '</td>';
                                echo '</tr>';
                            }
                                    echo '</tbody>';
                                echo '</table>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
                echo '<br>';
            }
        ?>

        <br>        

    </div>
    <!-- Accordion -->        

<?php 
    HTML_fotter();
?>