<?php

    session_start();

    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }        
    
    require_once 'template.php';    

    require_once 'AdminEvents.php';
    
    $adminEvents = new AdminEvents();
    $userID = $_SESSION['user']['id'];
    HTML_head('Events');
    HTML_body(['Events']);
?>

    <!-- row -->
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <form action="" class="" method="post">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            <input type="date" class="form-control" name="since" id="fechaInicio"
                                value="<?php
                                if (isset($_POST['search'])) {
                                    echo $_POST['since'];
                                } else {
                                    echo date('Y-m-d');
                                } ?>"
                                min="2020-11-00" max="<?php echo date("Y-m-d");?>"> 
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            <input type="date" class="form-control" name="until" id="fechaFin"
                                value="<?php
                                if (isset($_POST['search'])) {
                                    echo $_POST['until'];
                                } else {
                                    echo date('Y-m-d');
                                } ?>"
                                min="2020-11-00" max="<?php echo date("Y-m-d");?>">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                        <div class="form-group input-group">
                            <input type="text" class="form-control" id="descriptionSearch" placeholder="Description..." name="description" value="<?php if(isset($_POST['search'])) echo $_POST['description']; ?>">
                            <span class="input-group-btn"><button class="btn btn-primary" type="submit" name="search"><i class="fa fa-search"></i></button></span>
                        </div>
                        </div>
                    </div>
                </div>
            </form>
            <br>
        </div>
    </div>
    <!-- /row -->


    <!-- row -->                        
    <div class="table-responsive">
        <table class="table table-hover table-condensed">
            <thead>
            <tr class="bg-primary">
            <th>Event</th>                            
            <th>Date</th>
            </tr>
            </thead>
            <tbody id="events">
            <?php
                $events = (isset($_POST['search'])) ? $adminEvents->getEventsByDescription($userID, $_POST['description']) : $adminEvents->getEventsBetweenDates($userID, null, null);
                foreach ($events as $event) {
                    echo '<tr>';
                    echo '<td><a href="event.php?id=' . $event->getEventID() . '">' . $event->getDescription() . '</a></td>';                                    
                    echo '<td>' . Util::changeDateFormat($event->getDate()) . '</td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>            
    <!-- /row -->

    <script>
        var lista = document.getElementById('events');
        var filtro = document.getElementById('descriptionSearch');
        filtro.addEventListener('keyup', filtrarEvents);

        function filtrarEvents(e) {
            var texto = e.target.value.toLowerCase();
            var events = lista.getElementsByTagName('tr');
            Array.from(events).forEach(function(event) {                
                var eventDescription = event.firstElementChild.textContent;
                if (eventDescription.toLocaleLowerCase().indexOf(texto) != -1) {
                    event.style.display = 'table-row';
                } else {
                    event.style.display = "none";
                }
            });
        }
    </script>

<?php 
    HTML_fotter();
?>