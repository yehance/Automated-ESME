<?php
//following function extracts region code,alarm and occurance date and time from received SMS
function ext_huawei($msghuawei)  {
    //below function is utilized in 'after_last' function
    function strrevpos($instr, $needle)                                   
              {
                  $rev_pos = strpos (strrev($instr), strrev($needle));
                  if ($rev_pos===false) return false;
                  else return strlen($instr) - $rev_pos - strlen($needle);
              };

                //This function outputs substring after the last one of recurring objects
                function after_last ($object, $inthat)                
                {
                   if (!is_bool(strrevpos($inthat, $object)))
                   return substr($inthat, strrevpos($inthat, $object)+strlen($object));
                };

              
                  //This function returns the substring before the first space of a string 
                  function GetCode($content) {             
                  $r = explode(" ", $content);
                  if (isset($r[0])) {
                    
                     return $r[0];
                 
                    }
                     return 'Error!';
                  }

               

                require('functions/fget_between.php');  
                
                //CODE TO EXTRACT DATE AND TIME FROM HUAWEI
                
                $start="Occurrence Time=";
                $end=" GMT";
                $output1=GetBetween($msghuawei,$start,$end);
                
               // echo $output1;

                //CODE TO EXTRACT ALARM NAME FROM +NE (HUAWEI)
                
                $start="Alarm Name=";
                $end=" Occurrence Time=";
                $output2=GetBetween($msghuawei,$start,$end);
                
               // echo $output2;

                //CODE TO EXTRACT REGION CODE FROM +NE (HUAWEI)
                              

                $strafter=after_last("_",$msghuawei);     //extract substring after last _
                
                $reg_code1= GetCode($strafter);           //extract substring before first space
                                
                //code to extract only the last two letters in case of special notation for sp.sites & mistakes
                //substr($input_string, $start_limit, $end_limit); end limit is optional

                if(strlen($reg_code1) >2)  {             //extract last two characters if length >2
                  
                 $reg_letters = preg_replace("/[^a-zA-Z]/", "", $reg_code1); //extract only letters from the substring
                 $reg_code2=substr($reg_letters,-2);

                //function to identify the case of the first letter :    preg_match("/^[A-Z]/", $str ); 
                
                 if(isset($reg_code2)) {                       
                    $case= preg_match("/^[A-Z]/", $reg_code2 );  //prevent error from not set of reg_code2 for 3number NOA codes & unique name codes
                                                                 //state true when first letter is capital                    
   
                    if($case) {                 //return true if first letter capital
                     $result=$reg_code2;
                    }
                  
                   if(isset($result))   {      //isset to avoid errors when $result is not set for NOA and unique name codes
                    $output3= $reg_code2;
                   }
                                               
                 }
                 
                } 
                  
                else if(strlen($reg_code1) ==2)   {
  
                    $case= preg_match("/^[A-Z]/", $reg_code1 ); 
                  
   
                    if($case) {                 //return true if first letter capital
                     $result=$reg_code1;
                    }
                  
                   if(isset($result))   {      //isset to avoid errors when $result is not set for NOA 
                    $output3= $reg_code1;
                   }    

                }           

    if(isset($output3)) {  //output 3 will not set for NOA and unique name sites

    $out_huawei= array("region_code"=>$output3,"alarm_name"=>$output2,"date_time"=>$output1);
        
     return $out_huawei;
    }


}
?>                  