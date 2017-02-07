<?php

class Proizvod implements DomenskiObjekat
{

    public $id;
    public $naziv;
    public $zalihe;
    public $kategorija;
    public $cena;
    public $slika;

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

    public function __construct6($id, $naz, $zalihe, $kat, $cena, $slika)
    {
        $this->id         = $id;
        $this->naziv      = $naz;
        $this->zalihe     = $zalihe;
        $this->kategorija = $kat;
        $this->cena       = $cena;
        $this->slika      = $slika;
    }
    public function vrati_naziv_tabele()
    {
        return 'proizvod';
    }

    public function napuni_objekte($result_set)
    {
        $objekti = array();

        while ($row = mysqli_fetch_assoc($result_set)) {
            $id         = $row['id'];
            $naziv      = $row['naziv'];
            $zalihe     = $row['zalihe'];
            $kategorija = $row['kategorija'];
            $cena       = $row['cena'];
            $slika      = $row['slika'];

            $obj = new Proizvod($id, $naziv, $zalihe, $kategorija, $cena, $slika);

            array_push($objekti, $obj);
        }
        return $objekti;
    }
    public function vrati_putanju_slike()
    {
        //return IMG_PATH.DS.'proizvodi'.DS.$this->slika;
        return "images/proizvodi/" . $this->slika;
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
        $this->uslov = $uslov;
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
      
    }

}
