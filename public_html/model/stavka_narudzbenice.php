<?php 
class StavkaNarudzbenice implements DomenskiObjekat
{

	public $id_narudzbenice;
	public $proizvod;
	public $kolicina;
	public $iznos;

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

    public function __construct3($proizvod, $kol, $iznos)
    {
        $this->proizvod   = $proizvod;
        $this->kolicina   = $kol;
        $this->iznos      = $iznos;
        
    }

	public function vrati_naziv_tabele(){
		return "stavka_narudzbenice";
	}
    public function napuni_objekte($result_set){

    }
    
    public function vrati_uslov_za_nadji_slog(){
    }
    public function vrati_uslov_za_nadji_slogove(){
    }
    public function vrati_uslov_za_prebroj_sve(){
      
    }
    public function postavi_uslov_za_nadji_slog($uslov){
    }
    public function postavi_uslov_za_nadji_slogove($uslov){
    }
    public function postavi_uslov_za_prebroj_sve($uslov){
      
    }
    public function vratiBrojVezanihObjekata() {
    	return 0;
    }
    public function vratiBrojSlogovaVezanogObjekta($i) {
    	return 0;
    }
    public function vratiSlogVezanogObjekta($i, $j) {
      
    }
    public function vrati_polja_za_insert() {
      
    }
     public function vrati_vrednosti_za_insert(){
      return $this->id_narudzbenice . " ," . $this->proizvod->id . " ," . $this->kolicina . " ," . 
      $this->iznos;
    }

}



 ?>

 