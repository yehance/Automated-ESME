<?php require('include/header.php');    ?>

<?php require('include/navbar.php');    ?>

<?php require('include/topbar.php');    ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h2 mb-2 text-gray-800">Test Page</h1>

          <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary">Test Page</h4>
              </div>
              <div class="card-body">
                
                <!-- View Content begins Here -->
                <?php
                
               $msg1='alarm1(alarm raise): NE:Site 8 (JFDEL1_DELFT__8_Jf); Alarm Code:AC Power Off(70145); Raised Time:2020-02-12 07:58:10 ...etc( total 2 record(s) )';
              //  $msg1='alarm raise: NE:Site 57 (KNPNW1_Punnaveli_89_Jf); Alarm Code:AC Power Off(70145); Raised Time:2020-02-11 14:28:22';

               
             // $msg2='+ NE Name=KGDER2_0U0_Ilukthenna2_Dh Alarm Name=Mains Input Out of Range Occurrence Time=2020/2/12 05:50:27 GMT+05:30 Location Information=Cabinet No.=0, Subrack No.=7, Slot No.=0, Board Type=PMU, Specific Problem=AC Failure Clearance Time=2020/2/12 07:47:34 GMT+05:30 -';
                $msg2='+  NE Name=KGGAL2_0U0_Niyadurupola_IP_Dh  Alarm Name=Cell Unavailable  Occurrence Time=2020/2/11 13:14:32 GMT+05:30  Location Information=eNodeB Function Name=KGGAL2_00L_Niyadurupola_IP_Dh, Local Cell ID=82, Cell FDD TDD indication=FDD, NB-IoT Cell Flag=FALSE, Cell Name=KGGAL2-M-L85-C1, eNodeB ID=1885, Cell ID=83, Specific Problem=RF module abnormal  Clearance Time=2020/2/11 14:57:50 GMT+05:30  -';
                
               
              echo $msg1;  
              echo "<br><br><br>" ;
                              
              echo $msg2 ;   
              echo "<br><br><br>" ;
                   
                
                //FUNCTION TO SEPERATE VENDORS OF RECEIVED SMS AND OUTPUT THE EXTRACTED PARTS ACCORDINGLY
                
                function ext_sms($rec_sms)  {

                $array=explode(" ",$rec_sms);  
                if($array[0]=="+") 
                 {
                 require('functions/fget_huawei.php');  
                 return ext_huawei($rec_sms);
                }
  
                else {
                require('functions/fget_ZTE.php');
                return ext_ZTE($rec_sms);
                }
                                
                }


                   $message=$msg2;
                                  
                   $array= ext_sms($message);

                   echo"<pre>";
                   print_r($array);
                   echo"</pre>";

                   echo "<br><br><br>" ;

                   $region="Jaffna";
                   echo $region;
                   echo "<br>" ;

                   $alarm="AC Power Off";
                   echo $alarm;
                   echo "<br>" ;

                   $date_time="2020/2/11 13:14:32";
                   echo $date_time;
                   echo "<br>" ;


                   $send_message="Region : ".$region." ; "."Alarm : ".$alarm." ; "."Occurrence : ".$date_time;

                   echo $send_message;
                   echo "<br><br>" ;


                    require('include/connection.php');
                    $region='colombo';
                   //selecting mobile numbers for the respective region
                   $query = " SELECT * FROM regions WHERE  region_name = '$region' ";
                   $result_set= mysqli_query($connection,$query);
                  // if($result_set){echo "result";}
                //   $row = mysqli_fetch_assoc($result);
                //    echo $row['name'];

                  // $num_rows = mysqli_num_rows($result_set);
                 //  $i = 0;
                   $numbersarray = array();

                   //entering region mobile numbers to an array
                   while ($row = mysqli_fetch_assoc($result_set)) {
               
                       array_push($numbersarray, $row['mobile_num']);
                 //      $i++;
                   }
                   
               //    $count = 0;

                //   foreach ($numbersarray as $value) {
                //   $count++;
                //   }
               //    echo $count;
               //    echo"<br><br>";
                  echo count($numbersarray);
                  echo"<br><br>";

                  echo"<pre>";
                   print_r($numbersarray);
                   echo"</pre>";

                   $numberten = "";
                   for ($ii = 0; $ii < count($numbersarray); $ii++) {
                           
                       
                           $numberten .= $numbersarray[$ii] . ",";
                      
                       }


                  echo $numberten;
                  echo"<br><br>";

                  $numberten = rtrim($numberten, ",");

                  echo $numberten;
                  echo"<br><br>";                 


                 // 2-2: rd(s) )
                //  2-2: tc( total 2 record(s) )
                //  2-2: cord(s) )
                //  2-2: ecord(s) )
                //  2-2: l 2 record(s) )
                //  2-2: 2 record(s) )
                //  2-2: ord(s) )

                function GetZTE($content){             
                  $r = explode(";", $content);
                  if (isset($r[0])){
                    
                     return $r[0];
                 
                    }
                     return 'Error!';
                  }


                  $msgZTE='       2-2: rd(s) )      ';

                  
                 //CODE TO EXTRACT REGION CODE FROM ZTE
     
    $strafterZTE=after_last("_",$msgZTE);     //extract substring after last _
    
    $reg_codeZTE1=GetZTE($strafterZTE);     //extract substring before first ;

    
    $reg_codeZTE2 = preg_replace("/[^a-zA-Z]/", "", $reg_codeZTE1); //extract only letters from the substring


  if(substr($reg_codeZTE2,-3) != 'NOA' )  {   //to remove NOA
    if(substr($reg_codeZTE2,-3) != 'noa' )  {   //to remove noa if occurs
      
      if(strlen($reg_codeZTE2) >2)  {          //extract last two characters if length >2
         $output3=substr($reg_codeZTE2,-2);
         } 
    
      else if(strlen($reg_codeZTE2) ==2)     {
        $output3=$reg_codeZTE2;       //for reg codes without special notation
        } 
    }

  }
          
  if(isset($output3))  {
         echo $output3;
  }
     //  else{echo"elama";}

















                ?>
                <!-- View Content Ends Here -->                       
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