<?php
session_start();
if(!isset($_SESSION['authentication']))
{
header("Location: login.php");
}

?>

<!-- *********************************************************************

REPLACE THE PHP CODE SPECIFIED IN THIS CODE WITH CRONJOB FILE TO AUTOMATE THE SYSTEM, THAT 
CRONJOB FILE IS ALSO INCLUDED WITHIN PROJECT FILES

NOTE: PAGE REDIRECTS EVERY 2MIN TO SEND QUED SMS IN LINE 232, SPECIFY SERVER IP INSTEAD localhost -so to keep automated has to keep dashboard page open & will slow down web response time
      ALTERNATIVELY REMOVE REDIRECT AND USE A CRON JOB IN LINUX TO AUTOMATE THE PROCESS           -no need to keep dashboard page open and fasten web response time

SPECIFY SMSC HOST NAME OR HOST IP AND PORT FOR RECEIVING SMS IN LINE 45. //for smsc to receive sms

SPECIFY ESME ID AND PASSWORD TO BIND RECEIVER IN LINE 52.                //for receiver to receive sms

SPECIFY IP IN LINE 161                                                   //for smsc to send sms
SPECIFY PORT NUMBER IN LINE 162                                          //for smsc to send sms
SPECIFY ID TO BIND TRANSMITTER NUMBER IN LINE 163                        //for transmitter to send sms
SPECIFY PASSWORD TO BIND TRANSMITTER NUMBER IN LINE 164                  //for transmitter to send sms

                                                                        
**************************************************************************
-->

<?php require('include/header.php');    ?>

<?php require('include/navbar.php');    ?>

<?php require('include/topbar.php');    ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h2 mb-2 text-gray-800">Dashboard</h1>
         
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h4 class="m-0 font-weight-bold text-primary">Sent Alarms Summary</h4>
            </div>
            <div class="card-body">
             
             <?php   //THIS PHP FILE HAS TO BE COMMENTED OUT UPON DELPOYEMENT OF THE CRONJOB
                     //THIS WILL RUN ONLY ONE TIME,SO HAS TO REFRESH TO UDPATE THE SYSTEM

              //Table select query for database
              require('include/connection.php');
              $query="SELECT* FROM  sentsms ";
              $result_set=mysqli_query($connection,$query);
 
             //FOLLOWING CODE WITHIN THE PHP TAG HAS TO RUN IRRESPECTIVE OF THE WHICH PAGE IS OPEN
             
             //setting default timezone as colombo
             date_default_timezone_set('Asia/Colombo');


            
             //CODE TO RECEIVE SMS
           
             //for reading pending SMS you must frequently call this script. Use crontab job for example.
             //ob_start();
             //print "<pre>";

             require_once ('smpp.php');//SMPP protocol to receive sms
             
             //connect to the smpp server
             $tx=new SMPP('172.19.49.160',5016);       //******SPECIFY SMSC IP AND PORT NUMBER TO RECEIVE SMS HERE*******
             //$tx->debug=true;
             //9413579

             //bind the receiver
             $tx->system_type="WWW";
             $tx->addr_npi=1;
             //print "open status: ".$tx->state."\n";
             $tx->bindReceiver("genSite","ne#029");   //***SPECIFY ESME ID AND PASSWORD TO BIND RECEIVER HERE***
            
             do{

               //read incoming sms
               $sms=$tx->readSMS();
               //print "readSMS"

               //check sms data
               if($sms && !empty($sms['source_addr']) && !empty($sms['destination_addr']) && !empty($sms['short_message'])){
                 //send sms for processing in smsadv
                 $sender=$sms['source_addr'];
                 $receiver=$sms['destination_addr'];
                 $message=$sms['short_message'];

                   //run some processing function for incomming sms
                   process_message($sender,$message);
                 

               }
             //until we have sms in queue
             }while($sms); 

             //close the smpp connection
             $tx->close();
             unset($tx);
             //clean any output
             //ob_end_clean();
             //print "</pre>";
             

             //FOLLOWING FUNCTION DOES PROCESSING ONCE A MESSAGE IS RECEIVED AT ONE INSTANCE IN DO WHILE LOOP()
              /*  ****************************
              include; - entering data to recsms table
                       - extracting SMS elements
                       - filtering SMS
                       - forwarding SMS
                       - entering data to sentsms table
                ****************************** */    
             function process_message($sender,$message){
              $date_time = date("Y/m/d H:i:s"); 

             //insert details to message into recsms table
             $query = "INSERT INTO recsms (date_time,msg,sender_num) VALUES ('$date_time','$message','$sender') ";
             $result_set= mysqli_query($connection,$query);
             if($result_set)  {
      
              //echo "Record has been saved successfully!";
                         
             }  
             else  {
             // echo "Record Entry Failed !";
            }

             //getting the id of the entered sms(or last entered row)
             $query= "SELECT * FROM recsms ORDER BY id DESC LIMIT 1";
             $result_set= mysqli_query($connection,$query);
             $row=mysqli_fetch_assoc($result_set);
             $rec_id=$row["id"];    //this is the same id for corresponding send message allowing user to crosscheck based on id

             //function to seperate based on vendors and output the extracted parts accordingly
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
              
              $array= ext_sms($message);

              //entering region code,alarm name and date-time from  received sms into variables
              $region_code=$array['region_code'];
              $alarm=$array['alarm_name'];
              $date_time=$array['date_time'];

              //checking weather filtering is enabled for the particular alarm
              $query="SELECT* FROM filtersms WHERE alarm_name='$alarm' LIMIT 1";
              $result_set= mysqli_query($connection,$query);

              if (isset($result_set)) {    //isset in case alarm name becomes unavailable
              $row = mysqli_fetch_assoc($result_set);
              $filter_alarm  = $row['filter_op']; 
              
              //code to store sending sms to a single string variable
              $send_message="Region : ".$region." ; "."Alarm : ".$alarm." ; "."Occurrence : ".$date_time;

              if ($filter_alarm == "1")  { 

                //taking corresponding region name from regions table
                $query="SELECT* FROM regions WHERE region_code='$region_code' LIMIT 1";
                $result_set= mysqli_query($connection,$query);
             
                if (isset($result_set)) {    //isset in case a region_code becomes unavailable
                  $row = mysqli_fetch_assoc($result_set);
                  $region  = $row['region_name'];
                                 
                //CODE TO SEND SMS
                  
                //calling smppclass to send sms
                include ('smppclass.php');
                               
                //setting SMPP parameters for sending sms
                $smpphost = "172.22.88.150";            //******SPECIFY SMSC IP TO SEND SMS HERE*******
                $smppport = 5020;                       //******SPECIFY SMSC PORT NUMBER TO SEND SMS HERE*******
                $systemid = "NOCAlert";                 //******SPECIFY ID TO BIND TRANSMITTER NUMBER HERE*******
                $password = "noc123";                   //******SPECIFY PASSWORD TO BIND TRANSMITTER NUMBER HERE*******
                $system_type = "INOC";
                $from = "INOC";
                $smpp = new SMPPClass();
                
                
                $messagefinalstat = "Ok";
                $message_sts = "";
                
                
                
                    //selecting mobile numbers for the respective region
                    $query = " SELECT * FROM regions WHERE region_code = '$region_code'";
                    $result_set= mysqli_query($connection,$query);
                   
                    $numbersarray = array();

                    //entering region mobile numbers to an array
                    while ($row = mysqli_fetch_assoc($result_set)) {
                
                        array_push($numbersarray, $row['mobile_num']);
                        
                    }
                    
                    $numberten = "";
                    for ($ii = 0; $ii < count($numbersarray); $ii++) {
                                                
                    $numbersarray .= $numbersarray[$ii] . ",";
                    }

                        $numbersarray = rtrim($numbersarray, ",");
                                       
                        $smpp->SetSender($from);
                        $smpp->Start($smpphost, $smppport, $systemid, $password, $system_type);
                        $smpp->TestLink();
                                                
                        $smpp->SendMulti($numbersarray, $send_message);
                        $smpp->End();

                   //     $msg_status = "Sent";
                        //Following part addded according to smpp protocol to see success
                        
                        $message_sts = "Send Failed";
                        if ($smpp->get_last_message_status() != 0) {
                            $message_sts = "Send Failed";
                         //   echo 'Error';
                        } else {
                            $message_sts = "Send Success";
                        }


                    } //end isset region_code
                           
                 } //end if filter alarm

                else {   $msg_status = "Not Sent";    } //not sent when not filtered

                //entering data to the sentsms table
                $query= "INSERT INTO sentsms (id,date_time,region_name,alarm_name,ack) VALUES ($rec_id,'$date_time','$region','$alarm','$msg_status')";
                $result_set= mysqli_query($connection,$query);

              } //end isset alarm_name

             } //end of function process_message
                        
                   
             ?>  

              <!-- following tag redirects to index every 2 min to check and sent messages in 2min intervals -->
              <meta http-equiv="refresh" content="120;url=http://localhost/ASMS/index.php">

              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Date-Time</th>
                      <th>Region</th>
                      <th>Alarm</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                      <th>ID</th>
                      <th>Date-Time</th>
                      <th>Region</th>
                      <th>Alarm</th>
                      <th>Status</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    
                  <?php
                    while($row=mysqli_fetch_assoc($result_set))  {
                   ?> 
                                                
                      <tr>
                        <td><?php echo $row["id"];  ?></td>
                        <td><?php echo $row["date_time"];  ?></td>
                        <td><?php echo $row["region_name"]; ?></td>
                        <td><?php echo $row["alarm_name"];   ?></td>
                        <td><div class="alert alert-success">
                            <?php echo $row["ack"]; ?>
                           </div>
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