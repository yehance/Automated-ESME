<?php
session_start();
if(!isset($_SESSION['authentication']))
{
header("Location: login.php");
}

?>



<!-- NOTE:ADD SERVER IP INSTEAD OF localhost IN LINE 94  -->
<!-- NOTE:ADD SERVER IP INSTEAD OF localhost IN LINE 94  -->

<?php require('include/header.php');    ?>

<?php require('include/navbar.php');    ?>

<?php require('include/topbar.php');    ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h2 mb-2 text-gray-800">Filter SMS</h1>
         
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h4 class="m-0 font-weight-bold text-primary">Filtered SMS Summary</h4>
            </div>
            <div class="card-body">
            
            
            <?php
              //Table select query for database
              require('include/connection.php');
             
              $query1="SELECT* FROM  filtersms ";
              $result_set=mysqli_query($connection,$query1);
                                                 
            //following code updates the filtersms table corresponding to checkbox entry
            //& display session messages accordingly. 
            $submit_id=0;
            if(isset($_POST['submit']))    {
            
            $submit_id =$_POST['submit'];
           

             if(isset($_POST['filter_check']))
             {
             $value = isset($_POST['filter_check']) ? $_POST['filter_check'] : 0;
             }
             
                if(isset($value))  {
                  $query= "UPDATE filtersms SET filter_op='1' WHERE id=$submit_id";
                  
                  if(mysqli_query($connection,$query))   {
                    $_SESSION['message'] ="Filter selected successfully!";          
                    $_SESSION['msg_type']="success";
                    
                  }  
                     else  {
                      $_SESSION['message'] ="Record Update Failed !";          
                      $_SESSION['msg_type']="danger";
                     }
                }

                
                else {
                  $query= "UPDATE filtersms SET filter_op='0' WHERE id=$submit_id";  
                  
                  if(mysqli_query($connection,$query))   {
                    $_SESSION['message'] ="Filter de-selected successfully!";          
                    $_SESSION['msg_type']="warning";           
                  }  
                    else  {
                      $_SESSION['message'] ="Record Update Failed !";          
                      $_SESSION['msg_type']="danger";
                    }
                                               
                }
                
             }   
            
            ?>
          
            <!-- Message Displaying changes to the filter information -->
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
              <meta http-equiv="refresh" content="1;url=http://localhost/ASMS/filter-sms.php">
             
             <?php   endif ?>
             
              <!-- Begin table content -->
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Vendor</th>
                      <th>Alarm</th>
                      <th>Filter Option</th>
                                            
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Vendor</th>
                      <th>Alarm</th>
                      <th>Filter Option</th>
                    </tr>
                  </tfoot>
                  <tbody>
                 
                  <?php
                    while($row=mysqli_fetch_assoc($result_set))  {
                   ?> 
                                                
                      <tr>
                        <td><?php echo $row["vendor"];  ?></td>
                        <td><div class="alert alert-primary">
                           <?php echo $row["alarm_name"];  ?>
                           </div>
                        </td>
                        <td>
                        <form action="filter-sms.php" method="POST">
                        <div class="form-check">
                        <input type="checkbox" class="form-check-input" value="1" name="filter_check" <?php if( $row["filter_op"]== "1" ) { echo "checked='checked'";}?> id="filter_check"/>
                        <button type="submit" class="btn btn-primary" name="submit" value="<?php echo $row["id"]; ?>">Submit</button>
                        </div>
                        </form>
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