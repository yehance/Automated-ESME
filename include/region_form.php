
<?php


//1.Follwing code relates to entering form information to the database
require('connection.php');

//default value of update  
  $update= false;

  $up_id =0 ;
   
//initializing the variables to prevent the error when edit is not pressed
  $region_name  ='';
  $region_cod  =''; 
  $officer_name ='';
  $mobile       ='';


if(isset($_POST['add_officer'])) {

  
   $name=$_POST['officer'];
   $region=$_POST['region'];
   $region_code=$_POST['region_code'];
   $number=$_POST['number'];

 
   $query= "INSERT INTO regions (region_name,region_code,officer_name,mobile_num) VALUES ('$region','$region_code','$name','$number')";
   
    if(mysqli_query($connection,$query))   {
      
    
      $_SESSION['message']="Record has been saved successfully!";
      $_SESSION['msg_type']="success";
          
    }  
    else  {
       echo "Record Entry Failed !";
    }
    
 }

 //2.Following code relates to deleting data from the database

  if(isset($_GET['delete']))  {
   
  $del_id= $_GET['delete'];

  $query="DELETE FROM regions WHERE id=$del_id LIMIT 1";
  $result_set=mysqli_query($connection,$query);
  
    if($result_set)    {
              
     $_SESSION['message']="Record has been deleted successfully!";
     $_SESSION['msg_type']="danger";
                              
                                   
    }  
   else  {
     echo "Record Delete Failed !";
      }

 }

//3.Following code relates to editing data from the database

//for displaying the selected one on the fields

  if(isset($_GET['edit']))   {
       
        $up_id =$_GET['edit'];
              
        $update= true;

        $query="SELECT* FROM regions WHERE id=$up_id";
        $result_set= mysqli_query($connection,$query);

     
        $row = mysqli_fetch_assoc($result_set);

        $region_name  = $row['region_name']; 
        $region_cod  = $row['region_code']; 
        $officer_name = $row['officer_name']; 
        $mobile       = $row['mobile_num'];
    
      }
 //for updating database based on the updated details on the fields 

  if(isset($_POST['update_officer'])) {

      
   $up_id=$_POST['id'];
    
    $name=$_POST['officer'];
    $region=$_POST['region'];
    $region_code=$_POST['region_code'];
    $number=$_POST['number'];
 
  
    $query= "UPDATE regions SET region_name='$region', region_code='$region_code', officer_name='$name', mobile_num='$number' WHERE id=$up_id";
    
     if(mysqli_query($connection,$query))   {
       
    $_SESSION['message']="Record has been updated successfully!";
    $_SESSION['msg_type']="warning";
                  
     }  
     else  {
        echo "Record Update Failed !";
     }
     
  }  

 
   mysqli_close($connection);   

?>

