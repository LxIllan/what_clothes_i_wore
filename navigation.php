<?php    
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }    
    require_once 'create_event.php';
?>

<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.php"><i class="fa fa-fw fa-home"></i>Home</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        
            <!-- Dress items -->
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dress items">
                <a class="nav-link" href="dress_items.php">
                    <i class="fa fa-fw fa-archive"></i>
                    <span class="nav-link-text">Dress items</span>
                </a>
            </li>
            <!-- /Dress items -->   

            <!-- Create event -->            
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Create event">
                <a class="nav-link" data-toggle="modal" data-target="#modalCreateEvent">
                    <i class="fa fa-fw fa-plus"></i>
                    <span class="nav-link-text">Create event</span>
                </a>
            </li>
            <!-- /Create event -->

            <!-- Dress items -->
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Events">
                <a class="nav-link" href="events.php">
                    <i class="fa fa-fw fa-list-alt"></i>
                    <span class="nav-link-text">Events</span>
                </a>
            </li>
            <!-- /Dress items -->

            <?php
            if ($_SESSION['user']['root']) { ?>
                <!-- Settings -->
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Settings">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse"
                    href="#collapseSettings" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-gear"></i>
                        <span class="nav-link-text">Settings</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseSettings">                        
                        <!-- Subcategories -->
                        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Subcategories">
                            <a class="nav-link" href="subcategories.php">
                                <i class="fa fa-fw fa-list"></i>
                                <span class="nav-link-text">Subcategories</span>
                            </a>
                        </li>            
                        <!-- /Subcategories -->
                        <!-- Users -->
                        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Users">
                            <a class="nav-link" href="users.php">
                                <i class="fa fa-fw fa-users"></i>
                                <span class="nav-link-text">Users</span>
                            </a>
                        </li>            
                        <!-- /Users -->
                    </ul>
                </li>
                <!-- /Settings -->
            <?php
            }
            ?>
        </ul>

        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">            
            <!-- User -->
            <li class="dropdown nav-item">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i>
                    <?php
                        $fullname = $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'];
                        echo $fullname;
                        if ($_SESSION['user']['root']) {
                            echo ' #';
                        } else {
                            echo '  ';
                        }
                    ?>
                </a>

                <ul class="dropdown-menu">
                    <li class="dropdown-item">
                        <a class="dropdown-item" href="profile.php">
                            <i class="fa fa-user fa-fw"></i>
                            Profile
                        </a>
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item">
                        <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                            <i class="fa fa-fw fa-power-off"></i>
                            Log out
                        </a>
                    </li>
                </ul>
            </li>
            <!-- /User -->
        </ul>
    </div>
</nav>
<!-- Navigation-->


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog"
     aria-labelledby="logoutModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">
                    ¿Desea salir?
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>            
            <div class="modal-footer">
                <a class="btn btn-primary" href="logout.php">Aceptar</a>
            </div>
        </div>
    </div>
</div>
<!-- /Logout Modal-->