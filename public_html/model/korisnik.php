<?php
class Korisnik implements DomenskiObjekat
{

    public $id;
    public $username;
    public $password;
    public $email;
    public $telefon;

    public $uslov;

    public function __construct()
    {

        //namestanje konstruktora da poziva ostale konstruktore u zavisnosti od broja argumenata
        //koji su mu prosledjeni
        $a = func_get_args();
        $i = func_num_args();
        $f = "__construct" . $i;
        if (method_exists($this, $f)) {
            call_user_func_array(array($this, $f), $a);

        }

    }
    public function __construct5($id, $username, $password, $email, $telefon)
    {
        $this->id       = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email    = $email;
        $this->telefon  = $telefon;
    }

    public function vrati_naziv_tabele()
    {
        return 'korisnik';
    }
    public function napuni_objekte($result_set)
    {
        $objekti = array();
        while ($row = mysqli_fetch_assoc($result_set)) {
            
            $id       = $row['id'];
            $username = $row['username'];
            $password = $row['password'];
            $email    = $row['email'];
            $telefon  = $row['telefon'];

            $obj = new Korisnik($id, $username, $password, $email, $telefon);
            array_push($objekti, $obj);
        }
        return $objekti;
    }
    public function vrati_uslov_za_nadji_slog()
    {
        return $this->uslov;
    }
    public function vrati_uslov_za_nadji_slogove()
    {
        return $this->uslov;
    }
    public function vrati_uslov_za_prebroj_sve()
    {

    }
    public function postavi_uslov_za_nadji_slog($uslov)
    {
        $this->uslov = $uslov;
        
    }
    public function postavi_uslov_za_nadji_slogove($uslov)
    {
    }
    public function postavi_uslov_za_prebroj_sve($uslov)
    {

    }

    public function vratiBrojVezanihObjekata() {
      return 0;
    }
    public function vratiBrojSlogovaVezanogObjekta($i) {
    }
    public function vratiSlogVezanogObjekta($i, $j) {

    }
    public function vrati_polja_za_insert() {
      
    }
    public function vrati_vrednosti_za_insert(){
      return "NULL" . ",'" .$this->username . "','" . $this->password . "','" . $this->email . "','" . $this->telefon ."'," . 0;
    }
}
