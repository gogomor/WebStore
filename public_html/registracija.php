<?php 
require_once('includes/initialize.php'); 
include 'layouts/header.php';
$kon = Controller::getInstance(); 

$errors = array();

if ($session->is_logged_in()) {
    header('Location: index.php');
}
//validacija forme
if (isset($_POST['submit'])) 
{   
    if(!validate_email($_POST['email'])){
        $errors['email'] = "Email adresa nije validna.";
    }
    if(!validate_password($_POST['password'])){
        $errors['password'] = "Dužina lozinke mora biti najmanje 6 karaktera.";
    }
    if(!validate_username($_POST['username'])){
        $errors['username'] = "Korisničko ime ne može da sadrži razmake.";
    }
    if(!validate_telefon($_POST['telefon'])){
        $errors['telefon'] = "Polje telefon može sadržati samo brojeve.";
    }
    //proveri da li postoji username ili email
    if($kon->proveri_korisnika($_POST['username'],$_POST['email'], "reg")){
        $errors['reg'] = "Korisničko ime ili email već postoje.";
    }

//procesiranje forme
   if(empty($errors))
   {    
        //bezbedni input stringovi za sql
        $safe_strings = $kon->esc($_POST);

        //punjenje objekta
        $korisnik           = new Korisnik();
        $korisnik->username = $safe_strings['username'];
        $korisnik->password = md5($safe_strings['username']);
        $korisnik->email    = $safe_strings['email'];
        $korisnik->telefon  = $safe_strings['telefon'];



        //cuvanje objekta u bazu
        if ($kon->sacuvaj_slog($korisnik)) 
        {
            $poruka = "Uspešno ste se registrovali";
            
        } else {
            echo "Nije moguce kreirati korisnika";
        }
    }
}
?>



<form id="formRegistracija" action="registracija.php" method="post">
    <label for="username">Korisničko ime:</label>  
    <input type="text" name="username" id="username" required 
    <?php if(!empty($errors)) {
        echo  " value=\"{$_POST['username']}\"";
        if(!empty($errors['username'])) echo " class=\"red_input\"";
    }      
    ?>>

    <label for="password">Lozinka:</label>        
    <input type="password" name="password" id="password" required 
     <?php if(!empty($errors)) {
        echo  " value=\"{$_POST['password']}\"";
        if(!empty($errors['password'])) echo " class=\"red_input\"";
    }      
    ?>>

    <label for="email">Email:</label>         
    <input type="text" name="email" id="email" required 
     <?php if(!empty($errors)) {
        echo  " value=\"{$_POST['email']}\"";
        if(!empty($errors['email'])) echo " class=\"red_input\"";
    }      
    ?>>

    <label for="telefon">Telefon:</label>         
    <input type="text" name="telefon" id="telefon" required 
     <?php if(!empty($errors)) {
        echo  " value=\"{$_POST['telefon']}\"";
        if(!empty($errors['telefon'])) echo " class=\"red_input\"";
    }      
    ?>>
           

    <input type="submit" name="submit" value="Registruj se">
</form>
<div style="text-align: center;">
    <h2>
        <?php 
        if(isset($poruka)){
            if($poruka) {
                echo "Uspešno ste se registrovali. <br>";
            }else {
                echo "Došlo je do greške. Registracija nije uspela.";
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
                    timer.innerHTML = "Preusmeravanje na login stranicu za "+count+" sekundi.";
                    setTimeout("countDown()", 1000);
                }else{
                    window.location.href = "login.php";
                }
            }
    </script>
    <span id="timer">
      <script><?php if($poruka){ echo "countDown();"; }?></script>
    </span>

</div>

<?php echo validate_errors($errors); ?>


<?php include 'layouts/footer.php'?>
