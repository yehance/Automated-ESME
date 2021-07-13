<?php
session_start();
if(!isset($_SESSION['authentication']))
{
header("Location: login.php");
}

?>

<!-- NOTE:ADD SERVER IP INSTEAD OF localhost IN LINE 145  -->
<!-- NOTE:ADD SERVER IP INSTEAD OF localhost IN LINE 145  -->

<?php require('include/header.php');    ?>

<?php require('include/navbar.php');    ?>

<?php require('include/topbar.php');    ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h2 mb-2 text-gray-800">Clear SMS</h1>

          <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary">Delete SMS in a Range</h4>
              </div>
              <div class="card-body">


              <!-- code to delete received messages -->
              <?php
              require('include/connection.php');

              if (isset($_POST['delete_rec'])):
              ?>  
              <?php  
                 $start=$_POST['start_num_rec'];
                 $end=$_POST['end_num_rec']; 
                
                 if( (is_numeric($start)) && (is_numeric($end))) {  //validation int 
                         $valid_int = true; }
                     else {$valid_int = false; }    
                

                 if($start < $end)  {  //validation + range                          
                        $valid_range = true;}
                    else {$valid_range = false; }

                if(($valid_int==false) ||($valid_range==false )) {
                  $_SESSION['message']="Please enter a valid range!";
                  $_SESSION['msg_type']="warning";
                }
                    
                
                if(($valid_int==true) && ($valid_range==true)) { 
                 $i=0;
                 $query1="SELECT* FROM  recsms ";
                 $result_set1=mysqli_query($connection,$query1);
                 
                 while($row=mysqli_fetch_assoc($result_set1))  {
                    $i++;
                    $del_id=$row["id"];                  
                    if(($start <= $del_id) && ($del_id<= $end))  {

                    $query2="DELETE FROM recsms WHERE id=$del_id LIMIT 1";
                    $result_set2=mysqli_query($connection,$query2);
                    
                    }

                 }    
                      if ($i>= $end)  {
                       $_SESSION['message']="Records has been deleted successfully!";
                       $_SESSION['msg_type']="danger";
                      }
                      else {
                        $_SESSION['message']="Please enter a valid range!";
                        $_SESSION['msg_type']="warning";
                     }
                }
                ?>    
                
              <?php endif //end isset ?>

              <!-- code to delete received messages -->
              <?php
              require('include/connection.php');

              if (isset($_POST['delete_sen'])):
              ?>  
              <?php  
                 $start=$_POST['start_num_sen'];
                 $end=$_POST['end_num_sen']; 
                
                 if( (is_numeric($start)) && (is_numeric($end))) {  //validation int 
                         $valid_int = true; }
                     else {$valid_int = false; }    
                

                 if($start < $end)  {  //validation + range                          
                        $valid_range = true;}
                    else {$valid_range = false; }

                if(($valid_int==false) ||($valid_range==false )) {
                  $_SESSION['message']="Please enter a valid range!";
                  $_SESSION['msg_type']="warning";
                }
                       
                                   
                if(($valid_int==true) && ($valid_range==true)) { 
                 $i=0;
                 $query1="SELECT* FROM  sentsms ";
                 $result_set1=mysqli_query($connection,$query1);
                 
                 while($row=mysqli_fetch_assoc($result_set1))  {
                    $i++;
                    $del_id=$row["id"];                  
                    if(($start <= $del_id) && ($del_id<= $end))  {

                    $query2="DELETE FROM sentsms WHERE id=$del_id LIMIT 1";
                    $result_set2=mysqli_query($connection,$query2);
                    
                    }

                 }
                      if ($i>= $end)  {
                       $_SESSION['message']="Records has been deleted successfully!";
                       $_SESSION['msg_type']="danger";
                      }
                      else {
                        $_SESSION['message']="Please enter a valid range!";
                        $_SESSION['msg_type']="warning";
                     }
                }
                ?>    
                
              <?php endif //end isset ?>


            <!-- Message Displaying changes -->
            <?php 
                 
            if(isset($_SESSION['message'])): 
            ?>
              <div class="alert alert-<?=$_SESSION['msg_type'] ?>">
                 <?php
                   echo $_SESSION['message'];
                   unset($_SESSION['message']);
                ?>
              </div>

              <!-- following tag redirects to filter-sms after 1s showing the alert -->
              <meta http-equiv="refresh" content="1;url=http://localhost/ASMS/clear-sms.php">
             
            <?php   endif ?>


                <!-- Form Content begins Here -->
                <div class="form-row">
               
                   <!-- Delete Received SMS -->
                  <div class="col-lg-6">
                    <div class="p-5">
                      <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Delete Received SMS</h1>
                      </div>
                      <form class="user" action="clear-sms.php" method="POST">
                        <div class="form-group">
                          <input type="text" class="form-control form-control-user" name="start_num_rec" id="start_num_rec"  placeholder="Enter start ID number to delete SMS">
                        </div>
                        <div class="form-group">
                          <input type="text" class="form-control form-control-user" name="end_num_rec" id="end_num_rec" placeholder="Enter end ID number to delete SMS">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-user btn-block" name="delete_rec" id="delete_rec">
                                Delete Messages
                            </button>
                           </div>
                                               
                      </form>
                                           
                    </div>
                  </div> 
                  
                  <!-- Delete Sent SMS -->
                  <div class="col-lg-6">
                      <div class="p-5">
                        <div class="text-center">
                          <h1 class="h4 text-gray-900 mb-4">Delete Sent SMS</h1>
                        </div>
                        <form class="user" action="clear-sms.php" method="POST">
                          <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="start_num_sen" id="start_num_sen"  placeholder="Enter start ID number to delete SMS">
                          </div>
                          <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="end_num_sen" id="end_num_sen" placeholder="Enter end ID number to delete SMS">
                          </div>
                         
                          <div class="form-group">
                            <button type="sumbit" class="btn btn-primary btn-user btn-block" name="delete_sen" id="delete_sen">
                               Delete Messages
                            </button>
                          </div>                         
                        </form>
                        <!-- Form Content Ends Here -->                       
                      </div>
                    </div> 

                </div>
               
                            

               <!-- Page Content Ends Here -->
              </div>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->



     <?php require('include/footer.php'); ?>  