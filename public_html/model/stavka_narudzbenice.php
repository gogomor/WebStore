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

    public function __construct4($id_narudzbenice,$id_proizvod, $kol, $iznos)
    {   
        $this->id_narudzbenice = $id_narudzbenice;
        $this->proizvod   = $id_proizvod;
        $this->kolicina   = $kol;
        $this->iznos      = $iznos;
        
    }

	public function vrati_naziv_tabele(){
		return "stavka_narudzbenice";
	}
    public function napuni_objekte($result_set){
        $objekti = array();

        while($row = mysqli_fetch_assoc($result_set)){

            $id_narudzbenice = $row['id_narudzbenice'];
            $id_proizvoda = $row['id_proizvoda'];
            $kolicina = $row['kolicina'];
            $iznos = $row['iznos'];
           
            $obj = new StavkaNarudzbenice($id_narudzbenice,$id_proizvoda, $kolicina, $iznos);

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
    public function postavi_uslov_za_nadji_slog($uslov){
    }
    public function postavi_uslov_za_nadji_slogove($uslov){
        $this->uslov = " id_narudzbenice = {$uslov}";
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

 