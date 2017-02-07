<?php include "includes/initialize.php" ?>
<?php
if($session->is_logged_in()){
    $session->logout();

}
header("Location: login.php");







?>

