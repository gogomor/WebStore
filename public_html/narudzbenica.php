<?php include 'includes/initialize.php'?>


<?php
$poruka;
$errors = array();

$ukupan_iznos = 0;
?>

<!--PROCESIRANJE FORME -->
<?php if (isset($_POST['submit'])) {

    //validacija
    $time = strtotime($_POST['datum']);
    if(!$time) 
    {
        $errors['datum'] = "Datum nije u validnom formatu.";
    }else{
        if($time<(time()-60*60*24)){
            $errors['datum_istekao'] = "Datum koji ste ukucali je istekao.";
        }
    } 

    if(empty($_SESSION['stavke'])) $errors['stavke'] = "Korpa je prazna";

    //procesiranje
    if (empty($errors)) {
        $kon = Controller::getInstance();

        //bezbedni input stringovi za sql
        $safe_strings = $kon->esc($_POST);
        
        
        $datum = date('y.m.d', $time);        
        $adresa   = $safe_strings['adresa'];
        $napomena = $safe_strings['napomena'];

        //izracunavanje ukupnog iznosa stavki
        foreach ($_SESSION['stavke'] as $obj) {
            $ukupan_iznos += $obj->iznos;
        }
        $user_id = $session->user_id;

        $narudzbenica = new Narudzbenica($user_id, $_SESSION['stavke'],$adresa, $datum, $ukupan_iznos,$napomena);
             
        $max_id = $kon->vrati_poslednji_id($narudzbenica);
        $narudzbenica->id_narudzbenice = $max_id + 1;
        $narudzbenica->napuni_stavke_sa_id_narudzbenice();    

        $poruka = $kon->sacuvaj_slog($narudzbenica);
        if($poruka){ 
            unset($_SESSION['stavke']);
            $_SESSION['korpa'] = 0;
        }
    }    
}
?>

<?php include 'layouts/header.php';?>

<div class="divNarudzbenica">

    <form id="formNarudzbenica" action="narudzbenica.php" method="post">
    <h3>NARUDŽBENICA</h3><br>
    <hr><br>
        <label for="adresa">Adresa za dostavu:</label>
        <input type="text" name="adresa" id="adresa" required 
        <?php if(!empty($errors)) echo " value=\"{$_POST['adresa']}\""; ?>>
    
        <label for="datum">Datum isporuke (format: dan.mesec.godina):</label>
        <input type="date" name="datum" id="datum" required
        <?php if(!empty($errors)) echo " value=\"{$_POST['datum']}\" class=\"red_input\""; ?>>
    
        <label for="napomena">Napomena:</label>
        <textarea rows="4" cols="50" name="napomena" id="napomena"><?php if(!empty($errors)) echo "{$_POST['napomena']}"; ?></textarea>
                
        <input class="submitNar" type="submit" name="submit" value="Potvrdi">
    </form>

   
    <?php  echo validate_errors($errors); ?>

    <div style="text-align: center;">
    <h2>
    <?php  

    if(isset($poruka)){
        if($poruka) {
            echo "<br>Hvala Vam. Narudžbenica je kreirana. <br>";
        }else {
            echo "Došlo je do greške. Narudžbenica nije kreirana.";
        }
    }
    ?>
    </h2>
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
      <script><?php if($poruka){ echo "countDown();"; }?></script>
    </span>
    </div>

</div>



<?php include 'layouts/footer.php';?>
