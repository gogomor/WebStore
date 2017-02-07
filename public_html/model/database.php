<?php 
class Database {
    private $connection;

    function __construct(){
        $this->open_connection();
    }
    public function open_connection() {
        $this->connection = mysqli_connect(DB_SERVER, DB_USER,DB_PASS,DB_NAME);

        
        if(mysqli_connect_errno()){
            die("Database connection failed" . mysqli_connect_error() . " (".mysqli_connect_errno() .")");
        }
        //podesavanje latinice
        mysqli_query($this->connection, "SET NAMES 'utf8'"); 
    }
    public function close_connection() {
        if(isset($this->connection)) 
        {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }
    //input od korisnika pretvara u bezbedan string za sql
    public function esc($arr){
        foreach ($arr as $key => $value) {
            if(!is_numeric($value) && $key!='password') 
            {
                $arr[$key] = mysqli_real_escape_string($this->connection, $value);
            }
        }
        return $arr;
    }
    public function check_result_set($result_set){
        if(!$result_set) {
            echo mysqli_error($this->connection);
            die("<br> Database query failed");           
        }
    }

    public function vrati_sve(DomenskiObjekat $do){
        $sql = "SELECT * FROM ". $do->vrati_naziv_tabele();
        $result_set = mysqli_query($this->connection,$sql);
        $this->check_result_set($result_set);
        return $do->napuni_objekte($result_set);
    }

    public function vrati_objekat(DomenskiObjekat $do) {
        $sql = "SELECT * FROM " . $do->vrati_naziv_tabele() . " WHERE ". $do->vrati_uslov_za_nadji_slog();
        $result_set = mysqli_query($this->connection,$sql);
        $this->check_result_set($result_set);
        $arr = $do->napuni_objekte($result_set); 
        if($arr)
        {
            return $arr[0];
        } 
        else return false;

    }
    public function vrati_objekte(DomenskiObjekat $do) {
        $sql = "SELECT * FROM " . $do->vrati_naziv_tabele() . " WHERE ". $do->vrati_uslov_za_nadji_slogove();
        $result_set = mysqli_query($this->connection,$sql);
        $this->check_result_set($result_set);
        return $do->napuni_objekte($result_set);
        
    }
    public function prebroj_sve(DomenskiObjekat $do) {
        $sql = "SELECT * FROM " . $do->vrati_naziv_tabele();
        $result_set = mysqli_query($this->connection, $sql);
        $this->check_result_set($result_set);
        return mysqli_num_rows($result_set);
    }
    public function vrati_poslednji_id(DomenskiObjekat $do) {
        $sql = "SELECT MAX(id) FROM " . $do->vrati_naziv_tabele();
        $result_set = mysqli_query($this->connection, $sql);
        $this->check_result_set($result_set);
        $row = mysqli_fetch_array($result_set);
        return $row[0];
    }
    public function prebroj_sve_uz_uslov(DomenskiObjekat $do) {
        $sql = "SELECT * FROM " . $do->vrati_naziv_tabele() . " WHERE " . $do->vrati_uslov_za_prebroj_sve();
        $result_set = mysqli_query($this->connection, $sql);
        $this->check_result_set($result_set);
        return mysqli_num_rows($result_set);
    }
    public function vrati_za_paginaciju($offset, $limit, $kategorija) {
        $sql = "SELECT * FROM proizvod ";
        if(!empty($kategorija)) {
            $sql .= "WHERE kategorija = '{$kategorija}'";
        }
        $sql .= " LIMIT {$limit} ";
        $sql .= "OFFSET {$offset}";
        $result_set = mysqli_query($this->connection, $sql);
        $this->check_result_set($result_set);
        $proizvod = new Proizvod();
        return $proizvod->napuni_objekte($result_set);

    }
    public function prebroj_sve_u_kategoriji($kategorija) {
        $sql = "SELECT * FROM proizvod WHERE kategorija = " . "'{$kategorija}'";
        $result_set = mysqli_query($this->connection, $sql);
        $this->check_result_set($result_set);
        return mysqli_num_rows($result_set);

    }
    
    public function sacuvaj_slog(DomenskiObjekat $do)  {
        
            $sql = "INSERT INTO " . $do->vrati_naziv_tabele() . " VALUES (" . $do->vrati_vrednosti_za_insert() . ")";    
           
            if (!mysqli_query($this->connection, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($this->connection);
                return false;
            } 
            for ($i = 0; $i < $do->vratiBrojVezanihObjekata(); $i++) {
                for ($j = 0; $j < $do->vratiBrojSlogovaVezanogObjekta($i); $j++) {
                    $vezo = $do->vratiSlogVezanogObjekta($i, $j);
                    $upit = "INSERT INTO " . $vezo->vrati_naziv_tabele() ." VALUES (" . $vezo->vrati_vrednosti_za_insert(). ")";
                     if (!mysqli_query($this->connection, $upit)) {
                        echo "Error: " . $upit . "<br>" . mysqli_error($this->connection);
                        return false;
                    } 
                   
                }
            }
            return true;          
    }

    public function num_log($id){
        $sql = "UPDATE korisnik SET num_log = num_log + 1 WHERE korisnik.id = {$id}";
        $result_set = mysqli_query($this->connection, $sql);
        $this->check_result_set($result_set);
    }
    


    
    //     mysqli_fetch_array($result_set);   
    //     mysqli_num_rows($result_set);    
    //     mysqli_insert_id($this->connection);   
    //     mysqli_affected_rows($this->connection);
    


}



?>