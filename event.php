<?php

    session_start();

    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }        
    
    require_once 'AdminEvents.php';
    require_once 'AdminDressItems.php';

    $adminEvents = new AdminEvents();
    $adminDressItems = new AdminDressItems();

    if (isset($_GET['id'])) {
        $eventID = $_GET['id'];
        $event = $adminEvents->getEvent($eventID);
        if (!isset($event)) {
            echo "<script>alert('Error, event doesn\'t exists.');</script>";
            header('Location: index.php');
        }
    } else {
        header('Location: index.php');
    }

    require_once 'template.php';

    HTML_head($event->getDescription());
    HTML_body(['events.php' => 'Events', $event->getDescription()]);
?>


    <!-- row -->
    <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form class="" action="" method="post" enctype="multipart/form-data">                    
                    <div class="form-row">
                        <div class="col-md-6 mb-2">
                            <label class="control-label">Event:</label>
                            <input type="text" class="form-control" name="description" id="name"
                                value="<?php echo $event->getDescription(); ?>" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="control-label">Description:</label>
                            <textarea name="fullDescription" class="form-control"><?php echo $event->getFullDescription(); ?></textarea>                            
                        </div>                        
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-2">
                            <label class="control-label">Date:</label>
                            <input type="date" class="form-control" name="date" value="<?php echo $event->getDate(); ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="saveChanges" value="Save changes" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->        

        <br>

        <div class="table-responsive">
        <table class="table table-hover table-condensed">
            <thead>
                <tr class="bg-primary">
                    <th>Photo</th>
                    <th>Dress Item</th>
                    <th>Details</th>                    
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $dressItems = $adminDressItems->getDressItemsByEvent($event->getEventID());
                foreach ($dressItems as $dressItem) { 
                    $dressItemID = $dressItem->getDressItemID();
                    $name = $dressItem->getName();
                    echo '<tr>';
                    echo '<td><img class="img-thumbnail" height="75" width="75" src="' . $dressItem->getPhotoLocation() . '" /></td>';
                    echo '<td><a href="dress_item.php?id=' . $dressItemID . '">' . $name . '</a></td>';                    
                    echo '<td>' . $dressItem->getDescription() . '</td>';
                    echo '<td><a href="#removeDressItem' . $dressItemID . '" data-toggle="modal">';
                               echo '<button type="button" class="btn btn-secondary btn-sm"><span class="fa fa-fw fa-remove" aria-hidden="true"></span></button>';
                            echo '</a>';
                    echo '</td>';
                    echo '</tr>';
                    ?>
                    <!--Remove dress item -->
                    <div id="removeDressItem<?php echo $dressItemID; ?>" class="modal fade" role="dialog">
                        <form method="post" class="form-horizontal" role="form">
                            <div class="modal-dialog modal-md">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Remove dress item</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="dressItemRemovedID" value="<?php echo $dressItemID; ?>">
                                        <label class="control-label">Dress item:</label><br>
                                        <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" readonly>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="removeDressItem"><span class="fa fa-fw fa-check"></span></button>
                                        <button type="button" class="btn btn-light" data-dismiss="modal"><span class="fa fa-fw fa-remove"></span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /Remove dress item -->
                    <?php
                }
                if (isset($_POST['removeDressItem'])) {
                    $dressItemRemovedID = $_POST['dressItemRemovedID'];
                    if ($adminEvents->deleteDressItemInEvent($eventID, $dressItemRemovedID)) {
                        echo '<script>window.location.href="event.php?id=' . $eventID . '"</script>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
        
    <br>

    <?php
        if (isset($_POST['saveChanges'])) {
            $event->setDescription($_POST['description']);
            $event->setFullDescription($_POST['fullDescription']);
            $event->setDate($_POST['date']);

            if ($adminEvents->editEvent($event)) {
                echo $event->getDescription();
                echo $event->getFullDescription();
                echo $event->getDate();
                echo '<script>window.location.href="event.php?id=' . $eventID . '"</script>';
            }
        }
    ?>

<?php 
    HTML_fotter();
?>