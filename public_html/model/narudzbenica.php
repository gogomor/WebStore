<?php 
class Narudzbenica implements DomenskiObjekat {

	public $id;
	public $id_korisnik;
	public $stavke = array();
	public $adresa;
	public $datum_isporuke;
	public $ukupan_iznos;
	public $napomena;

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
    public function __construct6($id_kor, $stavke, $adresa, $datum, $iznos, $napomena){
    	$this->id_korisnik = $id_kor;
    	$this->stavke = $stavke;
    	$this->adresa = $adresa;
    	$this->datum_isporuke = $datum;
    	$this->ukupan_iznos = $iznos;
    	$this->napomena = $napomena;
    }

	public $uslov;

	public function vrati_naziv_tabele(){
		return 'narudzbenica';
	}
    public function napuni_objekte($result_set){

    }
    public function vrati_uslov_za_nadji_slog(){
    }
    public function vrati_uslov_za_nadji_slogove(){
    }
    public function vrati_uslov_za_prebroj_sve(){
      
    }
    public function postavi_uslov_za_nadji_slog($uslov)
    {
    }
    public function postavi_uslov_za_nadji_slogove($uslov)
    {
    }
    public function postavi_uslov_za_prebroj_sve($uslov)
    {

    }
    public function vratiBrojVezanihObjekata() {
    	return 1;
    }
    public function vratiBrojSlogovaVezanogObjekta($i) {
    	return count($this->stavke);
    }
    public function vratiSlogVezanogObjekta($i, $j) {
      	return $this->stavke[$j];
    }
    public function vrati_polja_za_insert() {
      return "(id, id_korisnika, adresa, datum_isporuke, ukupan_iznos, napomena)";
    }
     public function vrati_vrednosti_za_insert(){
      return "NULL" . " ," . $this->id_korisnik . " ,'" . $this->adresa . "' ,'" . $this->datum_isporuke . "' ," . 
      $this->ukupan_iznos . ", '" . $this->napomena . "'";
    }
    public function napuni_stavke_sa_id_narudzbenice() {
    	foreach ($this->stavke as $stavka) {
    		$stavka->id_narudzbenice = $this->id_narudzbenice;
    	}
    }
    public function napuni_stavke_sa_rb(){
    	for($i = 0; $i < count($this->stavke); $i++){
    		$this->stavke[$i]->rb_stavke = $i+1;
    	}
    	
    	

    }
}


 ?>