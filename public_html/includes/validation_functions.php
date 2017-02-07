<?php 

   function validate_email($email) 
   {
  		return filter_var($email, FILTER_VALIDATE_EMAIL) ?  true : false ;
   }
   function validate_password($pass){
   		return strlen($pass) < 6 ? false : true;  		
   }
   function validate_username($user){
   		if(strpos($user, " ") === false) {
   			return true;
   		}
   		return false;
   }
   function validate_telefon($telefon){
   		return is_numeric($telefon);
   }


   function validate_errors($errors) {
   		$output = "";
   		if(!empty($errors)) {
   			$output .= "<div class=\"error\">";
   			$output .= "<h3>Molimo Vas ispravite sledeće greške:</h3>";		
   			$output .= "<br><ul>";
   			foreach ($errors as $key => $val) {
   				$output .= "<li>{$val}</li>";
   			}
   			$output .= "</ul>";
   			$output .= "</div>";
   		}
   		return $output;
   }








?>