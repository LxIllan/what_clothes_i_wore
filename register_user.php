<?php
    require_once 'AdminUsers.php';

    $adminUsers = new AdminUsers();

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password1 = $_POST['password1'];
    $sexID = $_POST['sexID'];

    $adminsEmails = $adminUsers->getEmailAdmins();
    $adminsEmails = implode(",", $adminsEmails);

    if (strcmp($password, $password1) == 0) {
        $password1 = sha1($password);
        if ($adminUsers->addUser($firstname, $lastname, $email, $password, $sexID)) {
            echo '<script>alert("User has been registered. We\'ll contact you by email.");</script>';
            header('Location: index.php');
        } else {
            echo '<script>alert("Error");</script>';
        }
    }