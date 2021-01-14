<?php 
  require_once 'Util.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <link rel="shortcut icon" href="img/logo.png">
  <meta name="author" content="Fernando Illan">
  <title>Register</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
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
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Register an Account</div>
      <div class="card-body">
        <form method="post" action="register_user.php">          
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label>First name</label>
                <input class="form-control" id="firstname" name="firstname" type="text" aria-describedby="nameHelp" placeholder="Enter first name" required>
              </div>              
              <div class="col-md-6">
                <label>Last name</label>
                <input class="form-control" id="lastname" name="lastname" type="text" aria-describedby="nameHelp" placeholder="Enter last name" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">                  
              <div class="col-md-6">
                <label>Email</label>
                <input class="form-control" id="email" name="email" type="email" aria-describedby="emailHelp" placeholder="Enter email" required>              
              </div>
              <div class="col-md-6">              
                <label>Sex:</label><br>
                <select name="sexID" class="form-control custom-select">
                    <?php
                    $i = 0;
                    foreach (Util::SEX as $key => $value) {
                        if ($i < (count(Util::SEX) - 1))
                        echo "<option ";
                        echo "value = ". $key .">" . $value . "</option>";
                        $i++;
                    }                                    
                    ?>
                </select>                  
              </div>
            </div>
          </div>            
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label>Password</label>
                <input class="form-control" id="password" name="password" type="password" placeholder="Password" required>
              </div>
              <div class="col-md-6">
                <label>Confirm password</label>
                <input class="form-control" id="password1" type="password" name="password1" onfocusout="isSamePassword()" placeholder="Confirm password" required>
              </div>
            </div>
          </div>
          <input type="submit" name="register" value="Register" class="btn btn-primary btn-block">
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="login.php">Login Page</a>
          <a class="d-block small" href="forgot-password.php">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>    

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
