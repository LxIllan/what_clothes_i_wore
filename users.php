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
    require_once 'AdminUsers.php';

    HTML_head('Users');
    HTML_body(['Users']);

    $adminUsers = new AdminUsers();
    $users = $adminUsers->getUsers(false);
?>
        <!-- row -->
        <div class="">
            <div class="">                     
                <div class="">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                            <tr class="bg-primary">
                                <th>Photo</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="table-striped">
                            <?php
                            foreach ($users as $user) { ?>
                                <tr>
                                    <td><img class="rounded-circle" height="120" width="120" src="<?php echo $user->getPhotoLocation(); ?>"/></td>
                                    <td><?php echo $user->getFirstName();?></td>
                                    <td><?php echo $user->getLastName();?></td>
                                    <td>
                                        <a class="btn btn-secondary btn-sm" href="">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }                            
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->

<?php
    HTML_fotter();
?>