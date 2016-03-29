<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of alunoDao
 *
 * @author rogerio
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/uniten/intranet/util/conn.php';
//require_once 'C:/xampp/htdocs/unite/intranet/util/conn.php';
class AlunoDao {
    private $conn;
    public function AlunoDao(){
        $this->conn = new Mysql();
        $this->conn->connect();
    }

    public function  __destruct() {
        $this->conn->close();
    }

    public function listaByAgenda($agenda){

        $lista = array();
        $query = "";

    }
	
	 public function pesquisaPorNome($searchTerm,$page,$sidx, $sord='asc',$limit=30) {
       
        if (!$sidx)
            $sidx = 1;
        if ($searchTerm == "") {
            $searchTerm = "%";
        } else {
            $searchTerm = "%" . $searchTerm . "%";
        }

        $result = $this->conn->query("SELECT COUNT(*) AS count FROM aluno WHERE nome like '" . $searchTerm . "' or cpf LIKE  '" . $searchTerm . "'");

        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $count = $row['count'];

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }


        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($total_pages != 0)
            $SQL = "SELECT * FROM aluno WHERE nome like '" . $searchTerm . "' or cpf LIKE  '" . $searchTerm . "' ORDER BY $sidx $sord LIMIT $start , $limit";
        else
            $SQL = "SELECT * FROM aluno WHERE nomelike '" . $searchTerm . "' or cpf LIKE  '" . $searchTerm . "'  ORDER BY $sidx $sord";

        $result = $this->conn->query($SQL);

        $response->page = $page;
        $response->total = $total_pages;
        $response->records = $count;
        $i = 0;
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $response->rows[$i]['id'] = $row['id'];
            $response->rows[$i]['name'] =  $row['nome'];
            $response->rows[$i]['documento'] = $row['cpf'];
            //$response->rows[$i]=array($row[id],$row[invdate],$row[name],$row[amount],$row[tax],$row[total],$row[note]);
            $i++;
        }
        return $response;
    }
   
}
?>
