             <?php

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

                        $msg_status = "Sent";
                        
                    } //end isset region_code
                           
                 } //end if filter alarm

                else {   $msg_status = "Not Sent";    }

                //entering data to the sentsms table
                $query= "INSERT INTO sentsms (id,date_time,region_name,alarm_name,ack) VALUES ($rec_id,'$date_time','$region','$alarm','$msg_status')";
                $result_set= mysqli_query($connection,$query);

              } //end isset alarm_name

             } //end of function process_message
                        
            
             ?>