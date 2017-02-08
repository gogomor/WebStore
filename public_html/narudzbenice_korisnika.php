<?php include('includes/initialize.php'); ?>

<?php include('layouts/header.php'); ?>

<?php 

if(!$session->is_logged_in()){
	header("Location: login.php");
}

$kon = Controller::getInstance();


?>


















<?php include('layouts/footer.php') ?>
