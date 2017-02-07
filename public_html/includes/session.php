<?php
class Session
{

    private $logged_in = false;
    public $user_id;
    public $username;
    public $message;
    public $korpa = 0;
    public $stavke;

    public function __construct()
    {
        //startovanje sesije
        session_start();
        $this->check_message();
        $this->check_login();
    }

    public function uKorpu($kol, $cena)
    {
        $this->korpa += ((int) $kol * $cena);
    }
    public function is_logged_in()
    {
        return $this->logged_in;
    }
    public function login($korisnik)
    {
        if ($korisnik) {
            $this->user_id   = $_SESSION['user_id']   = $korisnik->id;
            $this->username  = $_SESSION['username']  = $korisnik->username;
            $this->logged_in = true;
        }
    }
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($this->user_id);
        unset($_SESSION['username']);
        unset($this->username);
        unset($_SESSION['korpa']);
        unset($this->korpa);
        unset($_SESSION['stavke']);
        unset($this->stavke);
        $this->logged_in = false;
    }
    private function check_login()
    {
        if (isset($_SESSION['user_id'])) {
            $this->user_id   = $_SESSION['user_id'];
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }
    public function message($msg = "")
    {
        //ako je pozvana metoda sa argumentom onda treba postaviti poruku u sesiju
        //postavljanje poruke u atribut se vrsi naknadno u check_message()
        if (!empty($msg)) {
            $_SESSION['message'] = $msg;
        }
        //ako je pozvana bez argumenta onda treba vratiti postojecu poruku
        else {
            return $this->message;
        }
    }
    private function check_message()
    {
        //ima li poruke u superpromenljivoj sesija
        if (isset($_SESSION['message'])) {
            //postavi atribut objekta sesija na vrednost poruke
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }
    //proverava da li je narucen proizvod i vraca narucenu kolicinu ako jeste, false ako nije
    public function proveri_proizvod($id){
        if(isset($_SESSION['stavke'])) {
            $this->stavke = $_SESSION['stavke'];
            foreach ($this->stavke as $st) {
                if($st->proizvod->id == $id){
                    return $st->kolicina;    
                }
            }
            return false;
        }  
        return false; 
              
      
    }
    //azurira postojecu stavku
    public function azuriraj_stavku($id, $kol){
                $this->stavke = $_SESSION['stavke'];
                foreach ($this->stavke as $st) {
                    if($st->proizvod->id == $id){
                        $_SESSION['korpa'] -= $st->iznos;
                        $st->kolicina = $kol;
                        $st->iznos = $st->proizvod->cena * $kol;
                        $_SESSION['korpa'] += $st->iznos;
                        return true;
                    }
                }
                return false;
            }
            
    
}

$session = new Session();
$message = $session->message();
