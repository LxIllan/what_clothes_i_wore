<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }

    require_once 'AdminDressItems.php';
    require_once 'AdminEvents.php';
    require_once 'AdminSubcategories.php';

    $adminDressItems = new AdminDressItems();
    $adminEvents = new AdminEvents();

    if (isset($_GET['id'])) {
        $dressItemID = $_GET['id'];
        $dressItem = $adminDressItems->getDressItem($dressItemID);
        if (!isset($dressItem)) {
            echo "<script>alert('Error, dress itemn doesn\'t exists.');</script>";
            header('Location: dress_items.php');
        }
    } else {
        header('Location: dress_items.php');
    }

    require_once 'template.php';

    HTML_head($dressItem->getName());
    HTML_body(['dress_items.php' => 'Dress Items', $dressItem->getName()]);

    $userID = $_SESSION['user']['id'];
    $sexID = $_SESSION['user']['sex'];
    $adminSubcategories = new AdminSubcategories();            
    $allSubcategories = $adminSubcategories->getAllSubcategories($sexID);  
?>


    <!-- row -->
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <form class="" action="" method="post" enctype="multipart/form-data">
                <div class="text-center">
                    <img class="img-thumbnail" height="200" width="200" src="<?php echo $dressItem->getPhotoLocation(); ?>"/>
                    <br>
                    <output id="list"></output>
                    <br>                    
                    <input type="file" accept=".jpg" class="btn-light" id="photo" name="photo">                    
                </div>
                <br>
                <div class="form-row">
                    <div class="col-md-6 mb-2">
                        <label class="control-label">Dress Item:</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="<?php echo $dressItem->getName(); ?>" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="control-label">Details:</label>
                        <input type="text" class="form-control" name="description"
                            value="<?php echo $dressItem->getDescription(); ?>" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*">
                    </div>                        
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-2">
                        <label class="control-label">Subcategory:</label>
                        <select name="subcategoryID" class="form-control custom-select">
                            <?php
                            foreach ($allSubcategories as $subcategory) {                                    
                                echo "<option "; if ($subcategory->getSubcategoryID() == $dressItem->getSubcategoryID()) echo "selected ";
                                echo "value = ". $subcategory->getSubcategoryID() .">" . $subcategory->getSubcategory() . "</option>";                                    
                            }                                    
                            ?>
                        </select>                            
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="control-label">Available:</label>
                        <select name="sexID" class="form-control custom-select">
                            <?php
                            foreach (Util::AVAILABLE as $key => $value) {
                                echo "<option "; if ($key == $dressItem->getAvailable()) echo "selected ";
                                echo "value = ". $key .">" . $value . "</option>";
                            }                                    
                            ?>
                        </select>
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

    <?php
        $events = $adminEvents->getEventsByThisDressItem($dressItemID);
        if (!empty($events)) { ?>
            <div class="card col-12">
                <div class="card-header" role="tab" id="headingOne">
                    <h6 class="mb-0 text-center"><a data-toggle="collapse" aria-expanded="true" href="#usedIn" aria-controls="usedIn">Used in<b></b></a></h6>
                </div>
                <div class="collapse hide" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" id="usedIn">
                    <div class="card-body col-12">
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed">
                                <thead>
                                <tr class="bg-primary">
                                <th>Event</th>                            
                                <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
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
                    </div>
                </div>
            </div>
        <?php
        }
    ?>

    <br>

    <?php
    if (isset($_POST['saveChanges'])) {
        $dressItem->setName($_POST['name']);
        $dressItem->setDescription($_POST['description']);
        $dressItem->setSubcategoryID($_POST['subcategoryID']);
        if (strlen($_FILES['photo']['name']) > 0) {
            $dressItem->setPhotoLocation(Util::uploadPhoto($_FILES['photo'], $userID, Util::DRESS_ITEM_PHOTO));
        }
        if ($adminDressItems->editDressItem($dressItem)) { ?>
            <script type="text/javascript">
                alert("Data has been updated successfully.");
                window.location = "index.php";
            </script>
            <?php
        } else {
            echo "error";
        }
    }
    ?>

    <script>
        function archivo(evt) {
            var files = evt.target.files; // FileList object
            // Obtenemos la imagen del campo "file".
            for (var i = 0, f; f = files[i]; i++) {
                //Solo admitimos imágenes.
                if (!f.type.match('image.*')) {
                    continue;
                }
                var reader = new FileReader();
                reader.onload = (function() {
                    return function(e) {
                        // Insertamos la imagen
                        document.getElementById("list").innerHTML = ['<div class="text-center"><div class="alert alert-ligth">The below photo it\'ll the new photo.</div><img class="img-thumbnail" height="200" width="200" src="', e.target.result , '"/></div><br>'].join('');
                    };
                })(f);
                reader.readAsDataURL(f);
            }
        }
        document.getElementById('photo').addEventListener('change', archivo, false);
    </script>
    
<?php 
    HTML_fotter();
?>