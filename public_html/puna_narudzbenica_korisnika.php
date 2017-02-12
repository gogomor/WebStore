<?php require_once('includes/initialize.php'); ?>

<?php include('layouts/header.php'); ?>


<?php 
if(!$session->is_logged_in()){
	header("Location: login.php");
}

$kon = Controller::getInstance();
$stavke = array();
if(isset($_GET['id'])){
	//izvlacenje narudzbenice sa svim stavkama i proizvodima
	$narudzbenica = new Narudzbenica();
	$narudzbenica->id = $_GET['id'];
	$puna_narudzbenica = $kon->vrati_objekat_preko_id($narudzbenica);	
	$puna_narudzbenica->stavke = $kon->vrati_stavke_narudzbenice($_GET['id']);	
	$stavke = $puna_narudzbenica->stavke;

}else {
	header('Location: narudzbenice_korisnika.php');
}

$errors = array();

?>
<div class="puna_narudzbenica">
	<div class="infoNar">
	<table>
		<tr>
			<td><span>Adresa:</span></td>
			<td><h3><?php echo $puna_narudzbenica->adresa; ?></h3></td>
		</tr>
		<tr>
			<td><span>Datum:</span></td>
			<td><h3><?php echo $puna_narudzbenica->datum_isporuke; ?></h3></td>
		</tr>
		<tr>
			<td><span>Napomena:</span></td>
			<td><h3><?php echo $puna_narudzbenica->napomena; ?></h3></td>
		</tr>
	</table>
	</div>
	<div class="divKorpaTabela punaKorpa">
		<table class="tblKorpa" <?php if (empty($stavke)) {echo "style=\"visibility: hidden\"";}?>>
		    <tr>
		        <th>Ime proizvoda</th>
		        <th>Slika</th>
		        <th>Cena</th>
		        <th>Količina</th>
		        <th>Iznos</th>
		        
    		</tr>
     <?php
    
if ($stavke) {
    foreach ($stavke as $st) {
        //jedinica mere
        $mera = "";
        $arr = array('voce_povrce','mesara');
        if (in_array($st->proizvod->kategorija,$arr)) {
            $mera = " kg";
            } 
            else{
                $mera =  " kom";
            }
        echo "<tr>
                <td>" . $st->proizvod->naziv . "</td>
                <td>
                    <a href=\"prikaz_proizvoda.php?id=" . $st->proizvod->id ."\">
                    <img src=\"" . $st->proizvod->vrati_putanju_slike() ."\"></a>
                </td>
                <td>" . $st->proizvod->cena . " din.</td>
                <td>" . $st->kolicina . $mera ."</td>
                <td>" . $st->iznos . " din.</td>
              </tr>";
    }
}
?>


<tr>
	<td></td>
	<td></td>
	<td></td>
	<td>Ukupno:</td>
    <td><?php echo $puna_narudzbenica->ukupan_iznos . " .din"; ?></td>

</tr>
</table>
	</div>
</div>


<?php include('layouts/footer.php'); ?>