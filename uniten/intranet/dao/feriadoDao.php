<?php
//require_once 'C:/xampp/htdocs/uniten/intranet/util/conn.php';

require_once $_SERVER['DOCUMENT_ROOT'].'/uniten/intranet/util/conn.php';


class FeriadoDao {

    private $conn;

    public function FeriadoDao() {
        $this->conn = new Mysql();
        $this->conn->connect();
    }

    public function __destruct() {
        $this->conn->close();
    }
    
 
    
    public function isFeriado($data){
        $rs = $this->conn->query("SELECT COUNT(0) as total FROM feriado WHERE data = '{$data}'");
        $row = $this->conn->fetch($rs);
        return $row['total'];
    } 
    
   
    public function escape($var) {
        return $this->conn->escape($var);
    }

}


