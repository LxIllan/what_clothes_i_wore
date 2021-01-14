<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }    

    require_once 'template.php';
    require_once 'AdminDressItems.php';
    require_once 'AdminSubcategories.php';
    require_once 'AdminEvents.php';

    HTML_head('Dress Items');
    HTML_body(['Dress Items']);
        
    $sexID = $_SESSION['user']['sex'];
    $userID = $_SESSION['user']['id'];

    $adminSubcategories = new AdminSubcategories();
    $allSubcategories = $adminSubcategories->getAllSubcategories($sexID);
    
    $adminDressItems = new AdminDressItems();    
    $dressItems = [];
    
    $adminEvents = new AdminEvents();
    $events = $adminEvents->getTodaysEvents($userID);    
    if ((isset($_GET['eventID'])) && (isset($_GET['dressItemID']))) {
        $eventID = $_GET['eventID'];
        $dressItemID = $_GET['dressItemID'];
        if ($adminEvents->addDressItemToEvent($eventID, $dressItemID)) {
            echo '<script>alert("Item added successfully");</script>';
        }
    }
?>

    <!-- row -->
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">                        
                <div class="form-row">
                    <div class="col-md-4 mb-3">                    
                        <div class="text-center">                            
                            <div class="form-group input-group">
                            <input type="text" class="form-control" id="searchDressItem" placeholder="Search item...">
                                <span class="input-group-btn"><button class="btn btn-primary"><i class="fa fa-search"></i></button></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            <button type='button' class='btn btn-primary btn-sm' data-target="#add" data-toggle="modal"><span class='fa fa-fw fa-plus' aria-hidden='true'></span></button>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            -
                        </div>
                    </div>
                </div>                        
            <br>
        </div>
    </div>
    <!-- /row -->    

    <br>
    <div class="table-responsive">
        <table class="table table-hover table-condensed">
            <thead>
                <tr class="bg-primary">
                    <th>Photo</th>
                    <th>Dress Item</th>
                    <th>Details</th>
                    <th>Subcategory</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id='items'>
                <?php                                                                            
                
                $dressItems = $adminDressItems->getAllDressItems($userID, true);

                foreach ($dressItems as $dressItem) { 
                    $dressItemID = $dressItem->getDressItemID();
                    $name = $dressItem->getName();
                    ?>
                    <tr>
                        <td><img class="img-thumbnail" height="75" width="75" src="<?php echo $dressItem->getPhotoLocation();?>" /></td>
                        <td><a href="dress_item.php?id=<?php echo $dressItemID; ?>"><?php echo $name; ?></a></td>                  
                        <td><?php echo $dressItem->getDescription(); ?></td>
                        <td><?php echo $adminSubcategories->getSubcategory($dressItem->getSubcategoryID())->getSubcategory();?></td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle btn-sm"
                                        data-toggle="dropdown">&nbsp;&nbsp;<i class="fa fa-fw fa-cogs"></i>&nbsp;&nbsp;
                                        <span class="caret"></span>
                                </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                            href="#removeDressItem<?php echo $dressItemID; ?>" data-toggle="modal">
                                            <i class="fa fa-fw fa-remove"></i>
                                                Delete
                                        </a>
                                        <?php
                                        foreach ($events as $event) {
                                            echo '<div class="dropdown-divider"></div>';
                                            echo '<a class="dropdown-item"';
                                            echo 'href="?eventID=' . $event->getEventID() . '&dressItemID=' . $dressItemID . '">';
                                            echo '<i class="fa fa-fw fa-plus"></i>';
                                            echo 'Add to ' . $event->getDescription();
                                            echo '</a>';
                                        }
                                        ?>
                                    </div>
                            </div>
                        </td>
                    </tr>
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
                    if ($adminDressItems->deleteDressItem($dressItemRemovedID)) {
                        echo '<script>alert("Dress item has been removed")</script>';
                        echo '<script>window.location.href="dress_items.php"</script>';
                    }
                }                                               
                ?>
            </tbody>
        </table>
    </div>
               

    <!--Add Item Modal -->
    <div id="add" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">                
                <div class="modal-header">
                    <h4 class="modal-title">Add dress item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" class="form-horizontal" role="form">
                        <div class="text-center">
                            <img class="img-thumbnail" height="200" width="200"
                                src="img/dress_items/default.jpg"/>
                            <br>
                            <br>
                            <output id="list"></output>
                            <input type="file" accept=".jpg" class="btn-light" id="photo" name="photo">
                            <br>
                        </div>
                        <br>           
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label class="control-label">Dress item:</label><br>
                                <input type="text" class="form-control" name="dressItem" placeholder="Polo" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*" required>
                            </div>                                                            
                            <div class="col-md-4 mb-3">
                                <label class="control-label">Details:</label><br>
                                <input type="text" class="form-control" name="description" placeholder="Polo Tommy Hilfiger" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="control-label">Subcategory:</label><br>
                                <select name="subcategoryID" class="form-control custom-select">
                                    <?php
                                    foreach ($allSubcategories as $subcategory) {
                                        echo "<option ";
                                        echo "value = ". $subcategory->getSubcategoryID() .">" . $subcategory->getSubcategory() . "</option>";
                                    }                                    
                                    ?>
                                </select>
                            </div>
                        </div>                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="addDressItem"><span class="fa fa-fw fa-plus"></span></button>
                            <button type="button" class="btn btn-secundary" data-dismiss="modal"><span class="fa fa-fw fa-remove"></span></button>
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>
    <!--Add Item Modal -->
        
    <?php 
        if (isset($_POST['addDressItem'])) {
            $dressItem = $_POST['dressItem'];
            $description = $_POST['description'];
            $subcategoryID = $_POST['subcategoryID'];
            $dressItemID = $adminDressItems->getNextID();
            $photoLocation = Util::uploadPhoto($_FILES['photo'], $dressItemID, Util::DRESS_ITEM_PHOTO);
            if ($adminDressItems->addDressItem($dressItem, $description, $photoLocation, $userID, $subcategoryID)) {
                echo '<script>alert("Dress item added successfully"); window.location.href="dress_items.php";</script>';
            } else {
                echo '<script>alert("Error");</script>';
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
                        document.getElementById("list").innerHTML = ['<div class="text-center"><div class="alert alert-ligth">The below photo it\'ll the new photo.</div><img class="img-thumbnail" height="200" width="200" src="', e.target.result,'"/></div><br>'].join('');
                    };
                })(f);
                reader.readAsDataURL(f);
            }
        }
        document.getElementById('photo').addEventListener('change', archivo, false);
    </script>

    <script>
        var lista = document.getElementById('items');
        var filtro = document.getElementById('searchDressItem');
        filtro.addEventListener('keyup', filtrarItems);

        function filtrarItems(e) {
            var texto = e.target.value.toLowerCase();
            var items = lista.getElementsByTagName('tr');
            Array.from(items).forEach(function(item) {
                var itemNombre = item.firstElementChild.nextElementSibling.textContent;
                var itemDescription = item.firstElementChild.nextElementSibling.nextElementSibling.textContent;
                if ((itemNombre.toLocaleLowerCase().indexOf(texto) != -1) || (itemDescription.toLocaleLowerCase().indexOf(texto) != -1)) {
                    item.style.display = 'table-row';
                } else {
                    item.style.display = "none";
                }
            });
        }
    </script>

<?php 
    HTML_fotter();
?>