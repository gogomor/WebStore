<?php include 'includes/initialize.php'?>



<!-- IZVADI PROIZVOD IZ BAZE-->
<?php if (isset($_GET['id']) && $session->is_logged_in()) {
    $kon          = Controller::getInstance();
    $proizvod     = new Proizvod();
    $proizvod->id = $_GET['id'];
    $proizvod     = $kon->vrati_objekat_preko_id($proizvod);

    //ako se proizvod vec nalazi u stavkama narudzbenice
    $kolicina = $session->proveri_proizvod($_GET['id']);
        if(!$kolicina){
            $kolicina = 0;
        }

} else {
        header("Location: index.php");
    }
//AKO JE NARUCEN PROIZVOD -> NAPRAVI STAVKU I UBACI U SESSION
if (isset($_POST['submit_u_korpu'])) {
    //ako je kolicina 0, ne radi nista
    if($_POST['uKorpu'] == 0) {
        header("Location: prikaz_proizvoda.php?id=" . $_GET['id']);
        return;
    }
    //ako se proizvod vec nalazi u stavkama narudzbenice
    
    $kolicina = $session->proveri_proizvod($_GET['id']);
    if($kolicina){
        $session->azuriraj_stavku($_GET['id'],$_POST['uKorpu']);
    }
    else{
        $stavka  = new StavkaNarudzbenice();
        $stavka->proizvod = $proizvod;
        $stavka->kolicina = $_POST['uKorpu'];
        $stavka->iznos    = $proizvod->cena * $stavka->kolicina;

        if (isset($_SESSION['stavke'])) {
            $_SESSION['korpa'] += $stavka->iznos;
        } else {
            $_SESSION['korpa']  = $stavka->iznos;
            $_SESSION['stavke'] = array();
        }
        array_push($_SESSION['stavke'], $stavka);
        

    // echo "<pre>";
    // print_r($_SESSION['stavke']);
    // echo "</pre>";
    
    }
    $kolicina = $_POST['uKorpu'];
    $poruka = "Uspešno ste stavili proizvod u korpu";

}
?>
<?php include 'layouts/header.php';?>


<div id="prikazProizvoda">
    <img src="images/proizvodi/<?php echo $proizvod->slika; ?>">
    <p><?php echo $proizvod->naziv; ?></p>
    <p>Cena: <?php echo $proizvod->cena; ?> din.</p>
    <div id="kupovinaProizvoda">
        <form action="prikaz_proizvoda.php?id=<?php echo $_GET['id']; ?>" method="post">
            <a href="#" onclick="oduzmi();">
                <i class="fa fa-minus-square fa-4x malo_i"  aria-hidden="true"></i>
            </a>
            <input id="uKorpu" type="number" name="uKorpu" value="<?php echo $kolicina; ?>" />
            <a href="#" onclick="dodaj();">
                <i class="fa fa-plus-square fa-4x malo_i" aria-hidden="true"></i>
            </a><br><br>
            <button type="submit" class="dugme" name="submit_u_korpu" 
            <?php if (isset($poruka)) echo " style=\"visibility: hidden\""; ?>>U korpu</button>
        </form>
    </div>
 
    <h2><?php if (isset($poruka)) {echo $poruka;}?></h2>

    <script type="text/javascript">
        var count = 6;   
        function countDown(){
            var timer = document.getElementById("timer");
            if(count > 0){
                count--;
                timer.innerHTML = "Preusmeravanje na početnu stranicu za "+count+" sekundi.";
                setTimeout("countDown()", 1000);
            }else{
                window.location.href = "index.php";
            }
        }
    </script>
    <span id="timer">
      <script type="text/javascript"><?php if(isset($poruka)) echo "countDown()" ?></script>
    </span>
    
    

    <form action="index.php">
        <input type="submit" class="dugme" value="Nazad">
    </form>

</div>
  
    

<?php include 'layouts/footer.php'?>