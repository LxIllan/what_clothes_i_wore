<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }
    require_once 'template.php';
    require_once 'AdminUsers.php';

    HTML_head('User');
    HTML_body(['Profile']);

    $userId = $_SESSION['user']['id'];
    $adminUsers = new AdminUsers();
    $user = $adminUsers->getUser($userId); 
?>


    <!-- row -->
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <form class="" action="" method="post" enctype="multipart/form-data">
                <div class="text-center">
                    <img class="rounded-circle" height="200" width="200" src="<?php echo $user->getPhotoLocation(); ?>"/>
                    <br>
                    <output id="list"></output>
                    <br>                    
                    <input type="file" accept=".jpg" class="btn-light" id="photo" name="photo">                    
                </div>
                <br>
                <div class="form-row">
                    <div class="col-md-6 mb-2">
                        <label class="control-label">Firstname:</label>
                        <input type="text" class="form-control" name="firstname"
                            value="<?php echo $user->getFirstname(); ?>" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="control-label">Lastname:</label>
                        <input type="text" class="form-control" name="lastname"
                            value="<?php echo $user->getLastname(); ?>" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*" required>
                    </div>                        
                </div>
                <div class="form-row">                        
                    <div class="col-md-6 mb-2">
                        <label class="control-label" for="txtCorreo">E-mail:</label>
                        <input type="text" class="form-control" name="email" value="<?php echo $user->getEmail(); ?>" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        
                    </div>
                </div>
                <?php
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == 1) {
                            $error = 'Las contraseñas no coinciden.';
                        } elseif ($_GET['error'] == 2) {
                            // Claves menores de 8 chars
                            $error = 'Tiene que ingresar una contraseña de al menos 4 caracteres';
                        }?>
                        <div class="alert alert-danger alert-dismissible text-center">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span> </button>
                            <strong>¡Error!</strong> <?php echo $error; ?>
                        </div>
                        <?php
                    }
                ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="control-label">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Confirm password:</label>
                        <input type="password" name="password1" id="password1" class="form-control" placeholder="Password" onfocusout="isSamePassword()">
                    </div>
                </div>
                <div class="text-center">
                    <input type="submit" name="saveChanges" value="Save changes" class="btn btn-primary">                    
                </div>
            </form>
        </div>
    </div>
    <!-- /.row -->    

    <?php
    if (isset($_POST['saveChanges'])) {
        $user->setFirstname($_POST['firstname']);
        $user->setLastname($_POST['lastname']);
        if (strcmp($_POST['email'], $user->getEmail()) != 0) {
            if (!$adminUsers->existEmail($_POST['email'])) {
                $user->setEmail($_POST['email']);
            } else {
                ?>
                <script type="text/javascript">
                    alert('Error, there\'s an user with that email.');
                    window.location = "profile.php";
                </script>
                <?php
            }
        }
        
        if (strlen($_FILES['photo']['name']) > 0) {
            $user->setPhotoLocation(Util::uploadPhoto($_FILES['photo'], $userId, Util::USER_PHOTO));
        }
        
        $password = $_POST['password'];
        if (strlen($password) > 0) {
            $password = sha1($password);
            $user->setPassword($password);
        }

        if ($adminUsers->editUser($user)) {
            echo '<script type="text/javascript">alert("Data has been update successfully");window.location = "index.php";</script>';
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
                        document.getElementById("list").innerHTML = ['<div class="text-center"><div class="alert alert-ligth">The below photo it\'ll the new photo.</div><img class="rounded-circle" height="200" width="200" src="', e.target.result , '"/></div><br>'].join('');
                    };
                })(f);
                reader.readAsDataURL(f);
            }
        }
        document.getElementById('photo').addEventListener('change', archivo, false);
    </script>

<script>
    function isSamePassword() {
        var password = $('#password').val();
        var password1 = $('#password1').val();
        if (password.localeCompare(password1) != 0) {
            alert('The passwords do not match');
            $('#password').val('');
            $('#password1').val('');
        }
    }
  </script>

<?php 
    HTML_fotter();
?>
