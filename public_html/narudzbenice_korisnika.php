<?php include('includes/initialize.php'); ?>

<?php include('layouts/header.php'); ?>

<?php 

if(!$session->is_logged_in()){
	header("Location: login.php");

}

$kon = Controller::getInstance();
$narudzbenice = $kon->vrati_narudzbenice_korisnika($session->user_id);

?>
<div class="divTblNarudzbenice">
	<table class="tblNarudzbenice">
		<th>Datum isporuke</th>
		<th>Ukupan iznos</th>
		<th>Napomena</th>
		<th>Detaljnije</th>
		<?php foreach ($narudzbenice as $nar) { ?>
				
		<tr>
			<td><?php echo $nar->datum_isporuke ?></td>
			<td><?php echo $nar->ukupan_iznos ?> .din</td>
			<td><?php echo $nar->napomena ?></td>
			<td><a href="puna_narudzbenica_korisnika?id=<?php echo $nar->id_korisnika; ?>">
					<img src="images/korpa2.png">
				</a></td>

		</tr>
		<?php } ?>
	</table>
</div>







<?php include('layouts/footer.php') ?>
