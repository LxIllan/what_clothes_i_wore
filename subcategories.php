<?php
    session_start();
    if (isset($_SESSION['user'])) {    
        if (!$_SESSION['user']['root']) {
            header('Location: index.php');
        }
    } else {
        header('Location: login.php');
    }

    require_once 'template.php';
    HTML_head('Users');
    HTML_body(['Subcategories']);

    require_once 'AdminSubcategories.php';
    
    $adminSubcategories = new AdminSubcategories();
?>

  
    <div class="text-center">
        <a href="#add" data-toggle="modal">
            <button type='button' class='btn btn-primary btn-sm'><span class='fa fa-fw fa-plus' aria-hidden='true'></span></button>
        </a>
    </div>

    <br>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <?php            
            foreach (Util::CATEGORIES as $key => $value) {                        
                echo '<li class="nav-item">';
                echo '<a class="nav-link" id="' . $value . '-tab" data-toggle="tab" href="#' . $value . '" role="tab" aria-controls="' . $value . '" aria-selected="false">' . $value . '</a>';
                echo '</li>';
            }
        ?>
    </ul>

    <div class="tab-content" id="myTabContent">
        <?php            
            echo '<br>';                    
            foreach (Util::CATEGORIES as $key => $value) {                                    
                echo '<div class="tab-pane fade" id="' . $value . '" role="tabpanel" aria-labelledby="' . $value . '-tab">';
                
                    echo '<div class="table-responsive">';
                        echo '<table class="table table-hover table-condensed">';
                            echo '<thead>';
                                echo '<tr class="bg-primary">';
                                    echo '<th>Subcategory</th>';
                                    echo '<th></th>';
                                echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                
                            $subcategories = $adminSubcategories->getSubcategories($key, $_SESSION['user']['sex']);                                    

                            foreach ($subcategories as $subcategory) {
                                echo '<tr>';
                                    echo '<td>' . $subcategory->getSubcategory() . '</td>';
                    
                                    echo '<td><div class="btn-group">';
                                            echo '<button type="button" class="btn btn-primary';
                                                echo 'dropdown-toggle btn-sm"';
                                                    echo 'data-toggle="dropdown">&nbsp;&nbsp;<i ';
                                                        echo 'class="fa fa-fw fa-cogs"></i>&nbsp;&nbsp;';
                                                echo '<span class="caret"></span>';
                                            echo '</button>';
                                            echo '<div class="dropdown-menu">';
                                                echo '<a class="dropdown-item"' ;
                                                    echo 'href="#edit' . $subcategory->getSubcategoryID() . '" data-toggle="modal">';
                                                        echo '<i class="fa fa-fw fa-edit"></i>';
                                                        echo ' Edit';
                                                    echo '</a>';
                                                echo '<div class="dropdown-divider"></div>';
                                                echo '<a class="dropdown-item"';
                                                    echo 'href="#alter' . $subcategory->getSubcategoryID() . '" data-toggle="modal">';
                                                    echo '<i class="fa fa-fw fa-remove"></i>';
                                                        echo ' Delete';
                                                echo '</a>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</td>';
                                echo '</tr>';
                }
                            echo '</tbody>';
                        echo '</table>';
                    echo '</div>';

                echo '</div>';

            }
        ?>                      
    </div>
        
    <!--Add Item Modal -->
    <div id="add" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">                
                <div class="modal-header">
                    <h4 class="modal-title">Add category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" class="form-horizontal" role="form">                        
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label class="control-label">Subcategory:</label><br>
                                <input type="text" class="form-control" name="subcategory" placeholder="subcategory" required>
                            </div>                            
                            <div class="col-md-4 mb-3">
                                <label class="control-label">Category:</label><br>
                                <select name="categoryID" class="form-control custom-select">
                                    <?php
                                    foreach (Util::CATEGORIES as $key => $value) {
                                        echo "<option ";
                                        echo "value = ". $key .">" . $value . "</option>";
                                    }                                    
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="control-label">Sex:</label><br>
                                <select name="sexID" class="form-control custom-select">
                                    <?php
                                    foreach (Util::SEX as $key => $value) {
                                        echo "<option ";
                                        echo "value = ". $key .">" . $value . "</option>";
                                    }                                    
                                    ?>
                                </select>
                            </div>
                        </div>                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="addSubcategory"><span class="fa fa-fw fa-plus"></span></button>
                            <button type="button" class="btn btn-secundary" data-dismiss="modal"><span class="fa fa-fw fa-remove"></span></button>
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>
    <!--Add Item Modal -->


    <?php 
        if (isset($_POST['addSubcategory'])) {
            $subcategory = $_POST['subcategory'];
            $categoryID = $_POST['categoryID'];
            $sexID = $_POST['sexID'];
            if ($adminSubcategories->addSubcategory($subcategory, $categoryID, $sexID)) {
                echo '<script>alert("Subcategory added successfully"); window.location.href="subcategories.php";</script>';
            } else {

            }
        }
    ?>

<?php
    HTML_fotter();
?>