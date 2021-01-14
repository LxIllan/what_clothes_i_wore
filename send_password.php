<?php
    require_once 'AdminUsers.php';
    require_once 'Util.php';
    
    $adminUsers = new AdminUsers();
    
    $email = $_POST['email'];    

    $user = $adminUsers->getUserByEmail($email);
    $password = Util::createPassword();
       
    $to         =  $email;
    $subject    =  'Recover password';
    $headers    =  "From: whatclothesiwore@syss.tech\r\n" .
                    'Reply-To: whatclothesiwore@syss.tech' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                    // Cabeceras para indicar que tiene datos HTML
    $headers .= 'MIME-Version: 1.0' . "\r\n" .
                    'Content-type: text/html; charset=utf-8' . "\r\n";

    $message =  '<html>'.
                '<head>' . 
                '<title></title>' .
                '</head>'.
                '<body>'.
                '<h1>Hi ' . $user->getFirstname() . ' ' . $user->getLastname() . '!</h1>' .
                '<br><br>' .
                'You requested a password change' .
                '<br>' .
                'We give you this password <b> ' . $password . ' </b> ' .
                '<br><br>' . 
                'We recommend that you change it immediately' .
                '<br><br>' .
                'Regards' .
                '<a href="http://whatclothesiwore.syss.tech">whatclothesiwore.syss.tech</a>'.
                '<br><br>' .
                '</body>' .
                '</html>';

    $password = sha1($password);
    $user->setPassword($password);
    if ($adminUsers->editUser($user)) {
        if (mail($to, $subject, $message, $headers)) {
            echo '<script>alert("We have sent you an email");</script>';
            header('Location: index.php');
        }
    }