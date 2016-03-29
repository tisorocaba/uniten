<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of diarioClasseDao
 *
 * @author rogerio
 */
//require_once 'C:/xampp/htdocs/uniten/intranet/util/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/uniten/intranet/util/conn.php';


class DiarioClasseDao {

    private $conn;

    function DiarioClasseDao() {
        $this->conn = new Mysql();
        $this->conn->connect();
    }

    function __destruct() {
        $this->conn->close();
    }

    function remover($diario) {

        $this->conn->query("DELETE  FROM diario_classe_aluno WHERE diario_classe_id = " . $diario);
        
    }

    function alteraPresenca($diario, $aluno, $presenca) {

        $sql = "SELECT * FROM diario_classe_aluno WHERE diario_classe_id = " . $diario . " AND aluno_id =" . $aluno;
        $rs = $this->conn->query($sql);
        if ($this->conn->countRow($rs) > 0) {
            $query = "UPDATE diario_classe_aluno SET presenca =" . $presenca . " WHERE diario_classe_id = " . $diario . " AND aluno_id =" . $aluno;
        } else {
            $query = "INSERT INTO diario_classe_aluno(diario_classe_id,aluno_id,presenca) VALUES(" . $diario . "," . $aluno . "," . $presenca . ")";
        }
        $this->conn->free($rs);

        $this->conn->query($query);
    }

    function alteraVale($diario, $aluno, $vale) {
        
        $sql = "SELECT * FROM diario_classe_aluno WHERE diario_classe_id = " . $diario . " AND aluno_id =" . $aluno;
        $rs = $this->conn->query($sql);
        if ($this->conn->countRow($rs) > 0) {
            $query = "UPDATE diario_classe_aluno SET vale =" . $vale . " WHERE diario_classe_id = " . $diario . " AND aluno_id =" . $aluno;
        } else {
            $query = "INSERT INTO diario_classe_aluno(diario_classe_id,aluno_id,vale) VALUES(" . $diario . "," . $aluno . "," . $vale . ")";
        }
       
        $this->conn->free($rs);

        $this->conn->query($query);
    }

    // essa funcão eh utilizada para retornar o status da presenca do aluno e deixar os check selecionado
    function isCheckedPresenca($diario, $aluno, $status) {
        $sql = "SELECT * FROM diario_classe_aluno WHERE diario_classe_id = " . $diario . " AND aluno_id =" . $aluno . " AND presenca = " . $status;
        $rs = $this->conn->query($sql);
        if ($this->conn->countRow($rs) > 0) {
            $this->conn->free($rs);
            return "checked";
        } else {
            $this->conn->free($rs);
            return "";
        }
    }

    // essa funcão eh utilizada para retornar o status do vale do aluno e deixar os check selecionado
    function isCheckedVale($diario, $aluno, $vale) {
        $sql = "SELECT * FROM diario_classe_aluno WHERE diario_classe_id = " . $diario . " AND aluno_id =" . $aluno . " AND vale = " . $vale;
        $rs = $this->conn->query($sql);
        if ($this->conn->countRow($rs) > 0) {
            $this->conn->free($rs);
            return "checked";
        } else {
            $this->conn->free($rs);
            return "";
        }
    }
    
    function listaAlunosUtilizamPasse($diario){
        $sql = "SELECT nome FROM diario_classe_aluno D, aluno A WHERE diario_classe_id = " . $diario." AND A.id = D.aluno_id and vale = 1";
        $rs = $this->conn->query($sql);
        $lista = array();
        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
            
        }
        $this->conn->free($rs);
        return $lista;
        
    }
    
     function listaDatasDiario($agenda){
        $sql = "select id, data_aula as data from diario_classe where local_curso_id = ".$agenda." order by data_aula asc";
        
                
        $rs = $this->conn->query($sql);
        
        $lista = array();
        $cont = 0;
        if ($this->conn->countRow($rs) > 0) {
            while ($row = $this->conn->fetch($rs)) {
                $lista[$cont] = $row;
                $cont++;
            }
            
        }
        //$this->conn->free($rs);
      
        return $lista;
        
    }
    
    // essa funcão eh utilizada para retornar o status da presenca do aluno e deixar os check selecionado
    function isPresenca($diario='', $aluno) {
        
        $sql = "SELECT * FROM diario_classe_aluno WHERE diario_classe_id = '" . $diario . "' AND aluno_id =" . $aluno;
        $rs = $this->conn->query($sql);
        if ($this->conn->countRow($rs) > 0) {
            
            $row = $this->conn->fetch($rs);
            if($row['presenca']==1){
                return "P";
            }else{
                return "F";
            }
            
           
        }
             return "";
        
    }  
    
    
     function listaAlunos($diario){
        $sql = "SELECT A.nome,D.presenca,D.vale FROM diario_classe_aluno D, aluno A WHERE diario_classe_id = " . $diario." AND A.id = D.aluno_id";
        $rs = $this->conn->query($sql);
        $lista = array();
        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
            
        }
        $this->conn->free($rs);
        return $lista;
        
    }
    
    
    
    function totalVales($diario){
         $sql = "SELECT vale FROM diario_classe_aluno  WHERE diario_classe_id = " . $diario." AND  vale = 1";
         $rs = $this->conn->query($sql);
         return $this->conn->countRow($rs);
    }

    function escape($valor) {
        return $this->conn->escape($valor);
    }
    
    function totalFaltas($agenda,$aluno){
         $sql = "select * from diario_classe_aluno where  aluno_id = ".$aluno." and presenca = 0 and diario_classe_id in (select id from diario_classe where local_curso_id = ".$agenda.")";
         $rs = $this->conn->query($sql);
         return $this->conn->countRow($rs);
        
    }

}

?>
