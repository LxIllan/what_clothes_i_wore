<?php

    require_once 'AdminEvents.php';
    $adminEvents = new AdminEvents();
?>

    <!--Add event -->
    <div id="modalCreateEvent" class="modal fade" role="dialog">
        <form method="post" class="form-horizontal" role="form">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add event</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <label class="control-label">Event:</label><br>
                        <input type="text" class="form-control" name="description" required><br>
                        <label class="control-label">Description:</label><br>
                        <textarea name="fullDescription" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="createEvent"><span class="fa fa-fw fa-check"></span></button>
                        <button type="button" class="btn btn-light" data-dismiss="modal"><span class="fa fa-fw fa-remove"></span></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /Add event -->

<?php
    if (isset($_POST['createEvent'])) {
        $description = $_POST['description'];
        $fullDescription = isset($_POST['fullDescription']) ? $_POST['fullDescription'] : '';
        $date = date("Y-m-d");
        $userID = $_SESSION['user']['id'];
        if ($adminEvents->addEvent($description, $fullDescription, $date, $userID)) {
            ?>
                <script type="text/javascript">
                alert("Event added successfully.");
                </script>
            <?php
            echo '<script>window.location.href="index.php"</script>';
        } else {
            echo '<script>alert("Error");</script>';
        }
    }
?>