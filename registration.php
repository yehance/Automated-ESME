<?php 
session_start();
if(!isset($_SESSION['authentication']))
{
header("Location: login.php");
}

?>

<!-- NOTE:ADD SERVER IP INSTEAD OF localhost IN LINE 132  -->
<!-- NOTE:ADD SERVER IP INSTEAD OF localhost IN LINE 132  -->

<?php
          
          //connecting database
          require('include/connection.php');

        //Register code  
        if (isset($_POST['submit1'])) {
          
          
          $name = $_POST['name'];
          $password1 = $_POST['password1'];
          $password2 = $_POST['password2'];
          

          //filter variables for security
          $name      = strip_tags(mysqli_real_escape_string($connection,trim($name)));
          $password1   = strip_tags(mysqli_real_escape_string($connection,trim($password1)));
          $password2   = strip_tags(mysqli_real_escape_string($connection,trim($password2)));
          
          if ($password1 != $password2) {
           
            $_SESSION['message']="Two passwords do not match !";
            $_SESSION['msg_type']="danger";
          } else {
            $options = array("cost"=>4);
            $hashPassword = password_hash($password1,PASSWORD_BCRYPT,$options);
            
                $sql = "INSERT INTO user (username,`password`) VALUES ('$name','$hashPassword')";

                     
            if (!mysqli_query($connection, $sql)) {
              die('Error: ' . mysqli_error($connection));
            }
            else {
              $_SESSION['message']="Record has been saved successfully!";
              $_SESSION['msg_type']="success";
            }
          }
        } 


        //Reset code
        if (isset($_POST['Reset'])) {
            
          $username = $_POST['username'];
          $pwd1     = $_POST['pwd1'];
          $pwd2     = $_POST['pwd2'];
        

          //filter variables for security
          $username = strip_tags(mysqli_real_escape_string($connection,trim($username)));
          $pwd1     = strip_tags(mysqli_real_escape_string($connection,trim($pwd1)));
          $pwd2     = strip_tags(mysqli_real_escape_string($connection,trim($pwd2)));


          if ($pwd1 != $pwd2) {
            $_SESSION['message']="Two passwords do not match !";
            $_SESSION['msg_type']="danger";
          } 
          else {

          $options = array("cost"=>4);
          $hashPassword = password_hash($pwd1,PASSWORD_BCRYPT,$options);
          
           

            //$query="SELECT* FROM user_p WHERE username='$username' LIMIT 1";
            //$result_set= mysqli_query($connection,$query);
            //if(mysqli_num_rows($result_set) > 0){
            
            $qry = "UPDATE `user` SET `password`='$hashPassword' WHERE `username` = '$username'";
            if (mysqli_query($connection, $qry)) {
              $_SESSION['message']="Password reset Successful !";
              $_SESSION['msg_type']="success";
            }
            else {
              $_SESSION['message']="Password reset Unsuccessful !";
              $_SESSION['msg_type']="danger";
              
            }

          //} else{
            //$_SESSION['message']="Enter a valid username !";
            //$_SESSION['msg_type']="warning";
          //}

           
                                 
          }
        }
        ?>

  
<?php require('include/header.php');    ?>

<?php require('include/navbar.php');    ?>

<?php require('include/topbar.php');    ?>


        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h2 mb-2 text-gray-800">User Registration</h1>

          <!-- Message Displaying when invalid date range is given -->
          <?php 
                
                 if(isset($_SESSION['message'])): 
              ?>
              <div class="alert alert-<?=$_SESSION['msg_type'] ?>">
                 <?php
                   echo $_SESSION['message'];
                   unset($_SESSION['message']);
                ?>
              </div>

               <!-- following tag redirects to update-region after 1s showing the alert -->
               <meta http-equiv="refresh" content="1;url=http://localhost/ASMS/registration.php">
             
             <?php endif ?>
          
             
                   
    <!-- Reg  -->
    <div class="col-xl-12 col-md-6 mb-4">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Registration Form</h6>
        </div>
        <div class="card-body">
          <form method="post" action=" ">

              <div class="form-row">
              <div class="col-md-4 mb-3">
                <label>Username :</label>
                <input type="text" name="name" class="form-control" placeholder="Enter username" maxlength="10" required>
              </div>
            </div>

            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label>Password :</label>
                <input type="password" name="password1" class="form-control" placeholder="Enter password" maxlength="30" required>
              </div>
              <div style="padding-right: 34px;">
              </div>

              <div class="col-md-4 mb-3">
                <label>Confirm Password :</label>
                <input type="password" name="password2" class="form-control" placeholder="Enter password again" maxlength="30" required>
              </div>
            </div>

            

            <br>
            <input class="btn btn-success" type=submit value="Add" name="submit1">

          </form>
          
        </div>
      </div>
    </div>


    <!-- res -->
    <div class="col-xl-12 col-md-6 mb-4">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Password Reset Form</h6>
        </div>
        <div class="card-body">
          <form method="post" action="registration.php">

              <div class="form-row">
              <div class="col-md-4 mb-3">
                <label>Username :</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" maxlength="10" required>
              </div>
            </div>

            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label>New Password :</label>
                <input type="password" name="pwd1" id="pwd1" class="form-control" placeholder="Enter new password" maxlength="30" required>
              </div>
              <div style="padding-right: 34px;">
              </div>
              <div class="col-md-4 mb-3">
                <label>Confirm New Password :</label>
                <input type="password" name="pwd2" id="pwd2" class="form-control" placeholder="Enter new password again" maxlength="30" required>
              </div>
            </div>

            <br>
            <input class="btn btn-success" type=submit value="Reset" name="Reset">

          </form>
         

        </div>
      </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->




<?php require('include/footer.php'); ?>     