<?php include('includes/initialize.php'); ?>

<?php include('layouts/header.php'); ?>
<?php
if($session->is_logged_in()){
    header("Location: index.php");
}

$poruka = "";
//autentifikacija
if(isset($_POST['submit'])){
    $kon = Controller::getInstance();

    //input od korisnika pretvori u bezbedne stringove za bazu
    $safe_strings = $kon->esc($_POST);

    //provera korisnika
    $user = $safe_strings['username'];
    $pass = md5($safe_strings['password']);           
    $korisnik = $kon->proveri_korisnika($user, $pass, "log");
    if(!empty($korisnik)){
        //povecaj broj logovanja
        $kon->num_log($korisnik->id);

        $session->login($korisnik);
        header("Location: index.php");
     }
    else {
        $poruka =  "<h3>Korisničko ime ili lozinka nisu ispravni. <br> Pokušajte ponovo.</h3>";
    }
}
?>
<div style="margin-top: 30px; font-family: 'Arima Madurai', cursive;">
<h3>Dobrodošli u imaginarnu web prodavnicu. <br>Da biste je isprobali možete se registrovati ili koristiti probni account:<br>
Korisnično ime: korisnik <br> Lozinka: korisnik</h3>
</div>
<div id=formLogin>

    <form action="login.php" method="post">
        <label for="username">Korisničko ime:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Lozinka:</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" name="submit" value="Uloguj se">
    </form>
</div>
<?php echo $poruka; ?>
<?php include('layouts/footer.php') ?>
