<?php
  if (isset($_GET['logout'])) {
    session_start();
    unset($_SESSION['authentication']);
  }
  require('include/connection.php');
  
  
  if(isset($_POST['submit']))  {
    $username=$_POST['username'];
    $password=$_POST['password'];

  //filter these variables for security
  $username= strip_tags(mysqli_real_escape_string($connection,trim($username))); 
  $password= strip_tags(mysqli_real_escape_string($connection,trim($password)));
   
  $query= "SELECT* FROM user WHERE username='$username'";
  $result_set=mysqli_query($connection,$query);

 if($result_set) {

  //as username is matched, now verify password
  $row= mysqli_fetch_assoc($result_set);
  $password_hash= $row['password'];
  
   if(password_verify($password,$password_hash)) {
     
      header("Location: dashboard.php");
      session_start();
      $_SESSION['authentication'] = "OKAY";
    }
    else   {
      header("Location: forgot-password.php");
     
       }
  }

} //end of isset

    date_default_timezone_set('Asia/Colombo');
    $cookie_period= 60*60*24*30; // 30 days remember when checked the box
    $cookie_timeset= time()+ $cookie_period;

if(isset($_POST['remember'])) {
   
    setcookie('username','inoc', $cookie_timeset);
    setcookie('password','1234', $cookie_timeset);
      }
else  {
    $cookie_timeset= time()- $cookie_period;
   
    setcookie('username',NULL, $cookie_timeset);
    setcookie('password',NULL, $cookie_timeset);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="img/favicon.ico" />

  <title>INOC MOBITEL</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  
</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image">
                  <img style="width: 500px;height: 500px;" src="img/mobitel_login.png" alt="">
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  
                  <form class="user"  action="login.php" method="post">
                    <div class="form-group">
                      
                      <input type="text" class="form-control form-control-user" name="username"  placeholder="Enter Username" value="<?php if(isset($_COOKIE['username']))
                      echo $_COOKIE['username']; ?>" required>
                    
                    </div>
                    <div class="form-group">
                      
                      <input type="password" class="form-control form-control-user" name="password"  placeholder="Password" value="<?php if(isset($_COOKIE['password']))
                      echo $_COOKIE['password']; ?>" required>

                    </div>
                   <!--
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        
                      <input type="checkbox" name="remember" class="custom-control-input" id="customCheck" <?php if(isset($_COOKIE['username'])) { echo "checked='checked'";}?>  value="1">
                      <label class="custom-control-label" for="customCheck">Remember Me</label>

                     </div>
                    </div>
                    -->
                    <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="Login">
                                       
                  </form>
                  
                  
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.php">Forgot Password?</a>
                  </div>
                 
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

     
    </div>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Mobitel 2020 (Developed by University of Sri Jayewardenepura)</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
