
<?php require_once('includes/initialize.php'); ?>

<?php

if(!$session->is_logged_in()){
	header("Location: login.php");
}

$kon = Controller::getInstance();


$current_page;
$per_page;
$total_count;
$paginacija;

// PROCESIRANJE PRETRAGE
if(isset($_POST['submit']) && !empty($_POST['submit']))
{
	$proizvodi = $kon->pretrazi_proizvode($_POST['pretraga']);
	$current_page = 1;
	$per_page = 12;
	$total_count = count($proizvodi);
	$paginacija = new Pagination($current_page,$per_page,$total_count);
	
}

// NIJE BILO PRETRAGE
else{

	$proizvod = new Proizvod();
	$br_proizvoda = $kon->prebroj_sve($proizvod);
	//$proizvodi = $kon->vrati_sve($proizvod);

	//paginacija:

	//trenutna stranica
	$current_page = empty($_GET['current_page']) ? 1 : $_GET['current_page'];

	//broj rekorda po stranici
	$per_page = 12;

	//ukupan broj proizvoda u zavisnosti da li je odabrana kategorija
	$total_count = empty($_GET['kategorija']) ? $br_proizvoda : $kon->prebroj_sve_u_kategoriji($_GET['kategorija']);


	$paginacija = new Pagination($current_page,$per_page,$total_count);
	$kategorija = isset($_GET['kategorija']) ? $_GET['kategorija'] : null;
	$proizvodi = $kon->vrati_za_paginaciju($paginacija->offset(), $per_page, $kategorija);
}
?>

<?php include('layouts/header.php'); ?>

<div id="subheader">
	<img class="logo" src="images/logo.png">
	<form action="index.php" method="post">
		<input id="pretraga" name="pretraga" type="text" placeholder="pretraga"/>
		<input id="btnpretraga" type="submit" name="submit" value="Traži"/>
	</form>
</div>

<!-- KATEGORIJE PROIZVODA -->
<div id="kategorije">
    <ul>
        <li class="voce">
            <a href="index.php?kategorija=voce_povrce"><div id="voce"><img src="images/voce.jpg">
                    <p <?php if(isset($_GET['kategorija']) && $_GET['kategorija'] =="voce_povrce") { echo "class=\"izabrani\""; } ?> >Voće i povrće</p>
                </div></a>
        </li>
        <li class="pekara">
            <a href="index.php?kategorija=pekara"><div id="pekara"><img src="images/pekara.jpg">
                    <p <?php if(isset($_GET['kategorija']) && $_GET['kategorija'] =="pekara") { echo "class=\"izabrani\""; } ?>>Pekara</p>
                </div></a>
        </li>
        <li class="mesara">
            <a href="index.php?kategorija=mesara"><div id="mesara"><img src="images/meso.jpg">
                    <p <?php if(isset($_GET['kategorija']) && $_GET['kategorija'] =="mesara") { echo "class=\"izabrani\""; } ?>>Mesara</p>
                </div></a>
        </li>
        <li class="zamrznuto">
            <a href="index.php?kategorija=zamrznuto"><div id="zamrznuto"><img src="images/zamrznuto.jpg">
                    <p <?php if(isset($_GET['kategorija']) && $_GET['kategorija'] =="zamrznuto") { echo "class=\"izabrani\""; } ?>>Zamrznuto</p>
                </div></a>
        </li>
        <li class="slatko">
            <a href="index.php?kategorija=slatko_slano"><div id="slatko"><img src="images/slatko.jpg">
                    <p <?php if(isset($_GET['kategorija']) && $_GET['kategorija'] =="slatko_slano") { echo "class=\"izabrani\""; } ?>>Slatko i slano</p>
                </div></a>
        </li>
        <li class="pica">
            <a href="index.php?kategorija=pice"><div id="pica"><img src="images/pica.jpg">
                    <p <?php if(isset($_GET['kategorija']) && $_GET['kategorija'] =="pice") { echo "class=\"izabrani\""; } ?>>Pića i napici</p>
                </div></a>
        </li>
    </ul>
</div>

<form action="index.php">
        <input id="prikaziSve" type="submit" value="Prikaži sve">
    </form>




<!-- PROIZVODI NA TRENUTNOJ STRANICI -->
<div id="divListaProizvoda">
<?php $i = 0;?>
<?php foreach ($proizvodi as $object): ?>	
<?php $i++; ?> 
<a href="prikaz_proizvoda.php?id=<?php echo $object->id; ?>">
	<div id="divProizvod">
		<p><?php echo $object->naziv; ?> </p>
		<img src="<?php echo $object->vrati_putanju_slike(); ?>" width="150">
		<p><?php echo $object->cena; ?> din. <?php 
		$arr = array('voce_povrce','mesara');
		if (in_array($object->kategorija,$arr)) {
			echo " &nbsp;kg";
			} 
			else{
				echo " kom";
			}
			?>
		</p>
	</div>
</a>
<!-- ako je obradjeno 4 proizvoda, dodaj horizontalnu liniju ispod njih -->
<?php if($i%4==0 && $i<10){
	echo "<hr style=\"clear:both; border-top:1px solid orange;\">";
	} ?>

<?php endforeach; ?>

</div>

<!-- PAGINACIJA STRANICE-->

<div id="divPaginacija" style="clear: both;">
<?php 
	//ako uopste ima stranica
	if($paginacija->total_pages() > 1) {
		//ako ima prethodne stranice
		if($paginacija->has_previouse_page()){
			echo "<a href=\"index.php?current_page=";
			echo $paginacija->previous_page();
			echo "\">&laquo; Prethodna &nbsp;</a>";
		}
		//medjustranice
		for ($i=1; $i <= $paginacija->total_pages(); $i++) { 
			if($i == $current_page) {
				echo "<span>{$i}<span>";
			}
			else{
				echo "<a href=\"index.php?current_page={$i}\">";
				echo $i;
				echo "&nbsp;</a>";
			}
		}
		//sledeca stranica
		 if($paginacija->has_next_page()) {
                echo " <a href=\"index.php?current_page=";
                echo $paginacija->next_page();
                echo "\">&nbsp; Sledeća &raquo;</a> ";
            }
	}
	else {
		echo "<span>1<span>";
	}

	 ?>
	

</div>


<?php include('layouts/footer.php'); ?>









