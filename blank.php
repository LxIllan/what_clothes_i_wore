<?php

    session_start();

    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }        
    
    require_once 'template.php';    

    HTML_head('Blank');
    HTML_body(['Blank']);        
?>

    

<?php 
    HTML_fotter();
?>