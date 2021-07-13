<?php
//following function extracts region code,alarm and occurance date and time from received SMS
function ext_ZTE($msgZTE)  {
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

              
                   //This function returns the substring before the first ";" of a string 
                   function GetZTE($content){             
                    $r = explode(";", $content);
                    if (isset($r[0])){
                      
                       return $r[0];
                   
                      }
                       return 'Error!';
                    }
    //CODE TO EXTRACT DATE AND TIME FROM ZTE
                               
    $start="Raised Time:";
                               
    $r = explode($start, $msgZTE);
                      
    if (isset($r[1]))  {
                       
      $output1 = substr($r[1],0,19);
        
    }  


    //CODE TO EXTRACT ALARM NAME FROM ZTE            // ******** confirm whether numbers inside the brackets is also important
   
    require('functions/fget_between.php');
    $start="; Alarm Code:";
    $end="(";
    $output2=GetBetween($msgZTE,$start,$end);


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

   if(isset($output3))  {   //isset to avoid errors when $result is not set for NOA code
    $out_ZTE= array("region_code"=>$output3,"alarm_name"=>$output2,"date_time"=>$output1);
        
     return $out_ZTE;
   }



}                    
?>                  