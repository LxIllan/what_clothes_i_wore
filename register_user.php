<?php
    require_once 'AdminUsers.php';

    $adminUsers = new AdminUsers();

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password1 = $_POST['password1'];
    $sexID = $_POST['sexID'];

    if ($adminUsers->existEmail($_POST['email'])) {
        echo '<script>alert("Error, there\'s an user with that email.");</script>';
        header('Location: register.php');
    } else {
        if (strcmp($password, $password1) == 0) {
            $password = sha1($password);
            if ($adminUsers->addUser($firstname, $lastname, $email, $password, $sexID)) {
                echo '<script>alert("User has been registered.");</script>';
                header('Location: login.php');
            } else {
                echo '<script>alert("Error");</script>';
            }
        }
    }        
    