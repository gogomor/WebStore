<?php 
class Narudzbenica implements DomenskiObjekat {

	public $id;
	public $id_korisnika;
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
    	$this->id_korisnika = $id_kor;
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
        $objekti = array();
        while ($row = mysqli_fetch_assoc($result_set)) {
            
            $id             = $row['id'];
            $id_korisnika   = $row['id_korisnika'];
            $adresa         = $row['adresa'];
            $datum_isporuke = date("d.m.y", (strtotime($row['datum_isporuke'])));
            $ukupan_iznos   = $row['ukupan_iznos'];
            $napomena       = $row['napomena'];

            $obj = new Narudzbenica($id, $id_korisnika, $adresa, $datum_isporuke, $ukupan_iznos, $napomena);
            array_push($objekti, $obj);
        }
        return $objekti;
    }
    public function vrati_uslov_za_nadji_slog(){
    }
    public function vrati_uslov_za_nadji_slogove(){
        return $this->uslov;
    }
    public function vrati_uslov_za_prebroj_sve(){
      
    }
    public function postavi_uslov_za_nadji_slog($uslov)
    {
    }
    public function postavi_uslov_za_nadji_slogove($uslov)
    {
        $this->uslov = "id_korisnika = {$uslov}";
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
      return "NULL" . " ," . $this->id_korisnika . " ,'" . $this->adresa . "' ,'" . $this->datum_isporuke . "' ," . 
      $this->ukupan_iznos . ", '" . $this->napomena . "'";
    }
    public function napuni_stavke_sa_id_narudzbenice() {
    	foreach ($this->stavke as $stavka) {
    		$stavka->id_narudzbenice = $this->id_narudzbenice;
    	}
    }
    
}


 ?>