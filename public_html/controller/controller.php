<?php 
class Controller {
	
	
	private $db;

    private static $instance;

	protected function __construct() {
		$this->db = new Database();
	}
    
    //singlton
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        
        return static::$instance;
    }
    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public function proveri_korisnika($user, $value, $reg_or_log) {
        $korisnik = new Korisnik();
        if($reg_or_log=="log") 
            $korisnik->postavi_uslov_za_nadji_slog("username = '". $user . "' AND password = '". $value ."'");
        else $korisnik->postavi_uslov_za_nadji_slog("username = '". $user . "' OR email = '". $value ."'");   

        $rezultat = $this->db->vrati_objekat($korisnik);
        if($rezultat){
            return $rezultat;
        }
        else return false;

    }
    public function prebroj_sve(DomenskiObjekat $do) {
        return $this->db->prebroj_sve($do);
        
    }
    public function vrati_sve(DomenskiObjekat $do) {
        return $this->db->vrati_sve($do);      
    }
    public function vrati_narudzbenice_korisnika($id){
        $n = new Narudzbenica();
        $n->postavi_uslov_za_nadji_slogove($id);
        return $this->db->vrati_objekte($n);
    }
    public function vrati_stavke_narudzbenice($id){
        $stavka = new StavkaNarudzbenice();
        $stavka->postavi_uslov_za_nadji_slogove($id);
        $stavke = $this->db->vrati_objekte($stavka);

        foreach ($stavke as $st) {
        $proizvod = new Proizvod();
        $proizvod->id = $st->proizvod;
        $obj_proizvod = $this->vrati_objekat_preko_id($proizvod);
        $st->proizvod = $obj_proizvod;      
     } 
     return $stavke;
    }


    public function prebroj_sve_u_kategoriji($kategorija){
        return $this->db->prebroj_sve_u_kategoriji($kategorija);
    } 
    public function vrati_za_paginaciju($offset, $limit, $kategorija){
        return $this->db->vrati_za_paginaciju($offset,$limit, $kategorija);
    }
    public function vrati_objekat_preko_id(DomenskiObjekat $do) {
        $do->postavi_uslov_za_nadji_slog('id = '. $do->id);
        return $this->db->vrati_objekat($do);
    }
    public function vrati_poslednji_id(DomenskiObjekat $do){
        return $this->db->vrati_poslednji_id($do);
    }
    public function sacuvaj_slog(DomenskiObjekat $do){
        return $this->db->sacuvaj_slog($do);
    }
    public function pretrazi_proizvode($str){
        $proizvod = new Proizvod();
        $proizvod->postavi_uslov_za_nadji_slogove("proizvod.naziv LIKE '{$str}%'");
        return $this->db->vrati_objekte($proizvod);
    }
    //input od korisnika pretvara u bezbedan string za sql
    public function esc($arr){
        return $this->db->esc($arr);
    }
    //povecaj broj logovanja korisnika
    public function num_log($id){
        return $this->db->num_log($id);
    }
}


?>