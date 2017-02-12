<?php require_once('includes/initialize.php'); ?>
<?php  
if(!$session->is_logged_in()){
    header("Location: login.php");
}
?>
<!--STAVKE POKAZUJU NA ONO STO POKAZUJU STAVKE IZ SESIJE-->
<?php $stavke = &$_SESSION['stavke'];?>

<!--AKO JE DAT NALOG ZA BRISANJE PROIZVODA IZ KORPE-->
<?php

if (isset($_GET['id'])) {
    foreach ($stavke as $key => $val) {
        if ($val->proizvod->id == $_GET['id']) {
            $_SESSION['korpa'] -= $val->iznos;
            array_splice($stavke, $key,1);
            break;
        }
    }
}
?>

<?php include 'layouts/header.php';?>

<!--AKO JE KORPA PRAZNA-->
<?php if (empty($stavke)) {
    echo "<br><br><h2>Korpa je prazna.</h2>";
    echo "<br><br><form action=\"index.php\">
        <input type=\"submit\" value=\"Nazad\" class=\"dugme\">
    </form>";}?>

<!--TABELA PROIZVODA U KORPI -->
<div class="divKorpaTabela">
<table class="tblKorpa" <?php if (empty($stavke)) {echo "style=\"visibility: hidden\"";}?>>
    <tr>
        <th>Ime proizvoda</th>
        <th>Slika</th>
        <th>Cena</th>
        <th>Količina</th>
        <th>Iznos</th>
        <th>Ukloni</th>
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
                <td>
                    <a href=\"korpa.php?id=" . $st->proizvod->id . 
                    "\"><i class=\"fa fa-window-close fa-2x malo_i\" aria-hidden=\"true\"></i></a>
                </td>
              </tr>";
    }
}
?>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td>Ukupno:</td>
    <td><?php echo $_SESSION['korpa'] . " .din"; ?></td>
    <td></td>

</tr>
</table>

    <form action="narudzbenica.php">
        <input type="submit" value="Naruči" class="dugme" <?php if (empty($stavke)) {
                echo " style=\"visibility: hidden\"";
                } ?> >
    </form>


</div>
<?php include 'layouts/footer.php';?>
