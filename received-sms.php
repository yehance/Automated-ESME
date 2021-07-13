<?php
session_start();
if(!isset($_SESSION['authentication']))
{
header("Location: login.php");
}

?>

<?php require('include/header.php');    ?>

<?php require('include/navbar.php');    ?>

<?php require('include/topbar.php');    ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h2 mb-2 text-gray-800">Received SMS</h1>
         
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h4 class="m-0 font-weight-bold text-primary">Received SMS Summary</h4>
            </div>
            <div class="card-body">
              
              <!-- show session msg-->
              <?php 
              if(isset($_SESSION['message'])): 
              ?>
              <div class="alert alert-<?=$_SESSION['msg_type'] ?>">
                 <?php
                   echo $_SESSION['message'];
                   unset($_SESSION['message']);
                ?>
              </div>
              <?php endif ?>

                                          
              <?php
              //Table select query for database
              require('include/connection.php');
              date_default_timezone_set('Asia/Colombo');

              $query="SELECT* FROM  recsms ";
              $result_set=mysqli_query($connection,$query);

              

              ?>

              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Date-Time</th>
                      <th>Message</th>
                      <th>Sender</th>
                                                           
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Date-Time</th>
                      <th>Message</th>
                      <th>Sender</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    
                   <?php
                    while($row=mysqli_fetch_assoc($result_set))  {
                   ?> 
                                                
                      <tr>
                        <td><?php echo $row["id"];  ?></td>
                        <td><?php echo $row["date_time"];  ?></td>
                        <td><?php echo $row["msg"]; ?></td>
                        <td><?php echo $row["sender_num"];   ?></td>                             
                      </tr>   
                                          
                     <?php
                      }
                     ?>
                                       
                  
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->



    <?php require('include/footer.php'); ?>  