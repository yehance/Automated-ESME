<?php
session_start();
if(!isset($_SESSION['authentication']))
{
header("Location: login.php");
}

?>

<!-- NOTE:ADD SERVER IP INSTEAD OF localhost IN LINE 39  -->
<!-- NOTE:ADD SERVER IP INSTEAD OF localhost IN LINE 39  -->


<?php require('include/header.php');    ?>

<?php require('include/navbar.php');    ?>

<?php require('include/topbar.php');    ?>


        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h2 mb-2 text-gray-800">Update Region</h1>

                   
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h4 class="m-0 font-weight-bold text-primary">Site Officer Summary</h4>
            </div>
            <div class="card-body">

              <!-- Message Displaying changes to the region information -->
              <?php 
                 require('include/region_form.php');  //this require is used for the form as well
                 if(isset($_SESSION['message'])): 
              ?>
              <div class="alert alert-<?=$_SESSION['msg_type'] ?>">
                 <?php
                   echo $_SESSION['message'];
                   unset($_SESSION['message']);
                ?>
              </div>

               <!-- following tag redirects to update-region after 1s showing the alert -->
               <meta http-equiv="refresh" content="1;url=http://localhost/ASMS/update-region.php">
             
             <?php endif ?>
            
             
              <!-- Form Content begins Here--> 
              <h1 class="h4 text-gray-900 mb-4 text-center">Enter Officer Details</h1>
                
              <!-- Add New/Update Officer -->

                                
                <form method="post" action="update-region.php"  >  
              <!-- A hidden variable is used to get the id of the row to that is being currently altered -->
                <input type="hidden" name="id" value="<?php echo $up_id; ?>">
                
                  <div class="form-row justify-content-center">
                   <div class="col-md-4 mb-3">
                   <label>Officer Name :</label> 
                   <input type="text" name="officer" class="form-control" 
                   value="<?php echo $officer_name;  ?>" placeholder="Enter officer name" maxlength="50" required>
                   </div>
        
                   <div class="col-md-4 mb-3">
                   <label>Region Name :</label>
                   <input type="text" name="region" id="region" class="form-control" 
                   value="<?php echo $region_name;  ?>"  placeholder="Enter region name" maxlength="30" required>
                   </div>
                  </div>                         
                
                  <div class="form-row justify-content-center">
                   <div class="col-md-4 mb-3">
                   <label>Mobile Number :</label>
                   <input type="text" name="number" id="number" class="form-control" 
                   value="<?php echo $mobile;  ?>" placeholder="Enter mobile number" maxlength="50" required>
                   </div>
        
                   <div class="col-md-4 mb-3">
                   <label>Region Code :</label>
                   <input type="text" name="region_code" class="form-control" 
                   value="<?php echo $region_cod;  ?>" placeholder="Enter region code" maxlength="20" required>
                   </div>
                  </div>

                  <!-- Button changes depending on the add user or update user -->
                  <div class="form-row justify-content-center">     
                  <div class="col-md-4 mb-3">
                     
                 <?php if($update == true):  ?>
                      <input type="submit" class="btn btn-success btn-user btn-block" name="update_officer" value="Update Officer">
                 <?php else: ?>
                      <input type="submit" class="btn btn-primary btn-user btn-block" name="add_officer" value="Add Officer">
                 <?php endif; ?> 

                  </div>
                  </div>
                                               
                </form>
                
                
              <!-- Table select query for database -->                             
              <?php
              require('include/connection.php');
              $query="SELECT* FROM  regions ";
              $result_set=mysqli_query($connection,$query);
              ?>

              <!-- Table Content begins Here -->
              <div class="table-responsive">
                                     
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                
              
                  <thead>
                    <tr>
                      <th>Region</th>
                      <th>Region Code</th>
                      <th>Officer Name</th>
                      <th>Mobile Number</th>
                      <th>Update</th>   
                                      
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Region</th>
                      <th>Region Code</th>
                      <th>Officer Name</th>
                      <th>Mobile Number</th>
                      <th>Update</th>
                                      
                    </tr>
                  </tfoot> 
                    
                  <tbody>
                  <?php
                     
                   while($row=mysqli_fetch_assoc($result_set))  {
                  
                   ?> 

                                
                                    
                    <tr>
                      <td><?php echo $row["region_name"];  ?></td>
                      <td><?php echo $row["region_code"];  ?></td>
                      <td><?php echo $row["officer_name"]; ?></td>
                      <td><?php echo $row["mobile_num"];   ?></td>
                      <td>
                         <a href="update-region.php?edit=<?php echo $row['id']; ?>" 
                           class="btn btn-info">Edit</a>   <!-- here link is passed to same page as the same form is used to 
                                                            edit entries as well -->
                         <a href="update-region.php?delete=<?php echo $row['id']; ?>" 
                           class="btn btn-danger">Delete</a> <!-- Delete part is handled in region-form file -->                                    
                      </td>
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