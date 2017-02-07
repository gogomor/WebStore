<?php
interface DomenskiObjekat {
    
    public function vrati_naziv_tabele();
    public function napuni_objekte($result_set);
    public function vrati_uslov_za_nadji_slog();
	public function vrati_uslov_za_nadji_slogove();
	public function vrati_uslov_za_prebroj_sve();
	public function postavi_uslov_za_nadji_slog($uslov);
    public function postavi_uslov_za_nadji_slogove($uslov);   
    public function postavi_uslov_za_prebroj_sve($uslov); 
    public function vrati_polja_za_insert();
    public function vrati_vrednosti_za_insert(); 
    public function vratiBrojVezanihObjekata();
    public function vratiBrojSlogovaVezanogObjekta($i);
    public function vratiSlogVezanogObjekta($i, $j); 
}


?>