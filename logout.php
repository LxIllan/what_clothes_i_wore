<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }
    session_unset();
    if (session_destroy()) {
        header('Location: login.php');
    } else {
        header('Location: index.php');
    }
