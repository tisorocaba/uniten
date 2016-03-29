<?php

//require_once 'C:/xampp/htdocs/unite/intranet/util/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/uniten/intranet/util/conn.php';


class cursosDao {

    private $conn;

    public function __construct() {
        $this->conn = new Mysql();
        $this->conn->connect();
    }

    public function __destruct() {
        $this->conn->close();
    }

    public function listaAlunosCuros($curso, $sexo, $periodo, $offset='') {
        $lista = array();

        
        
        $sql = "SELECT a.id, a.nome, a.email, a.telefone, a.data_nascimento, a.sexo, l.periodo,
                (YEAR(CURDATE())-YEAR(a.data_nascimento)) - (RIGHT(CURDATE(),5)<RIGHT(a.data_nascimento,5)) as idade,
                (select status from local_curso_aluno where local_curso_id = l.id and aluno_id = a.id) as status
                FROM aluno a
                INNER JOIN local_curso_aluno ON local_curso_aluno.aluno_id = a.id and (local_curso_aluno.status = 1 or local_curso_aluno.status = 2)
                INNER JOIN local_curso l ON local_curso_aluno.local_curso_id = l.id AND curso_id = ".$curso." and local_id not in(26,27,28) and data_inicio >=  DATE_SUB(curdate(), INTERVAL 6 MONTH) and (l.status=1 or l.status=2)";

        if ($sexo != 'A') {
            $sql .= " and a.sexo='" . $sexo . "'";
        }

        if ($periodo!= 'Q') {
            $sql .= " and l.periodo='" . $periodo . "'";
        }
       
        if((int)$offset===0){
           $sql .= " LIMIT 0,25"; 
        }else{
            $sql .= " LIMIT ".(int)$offset.",25"; 
        }


        $rs = $this->conn->query($sql);

        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
        }
        $this->conn->free($rs);
        return $lista;
    }
    
    public function totalAlunosCuros($curso, $sexo, $periodo) {
         
          $sql = "SELECT a.id, a.nome, a.email, a.telefone, a.data_nascimento, a.sexo, l.periodo,
                (YEAR(CURDATE())-YEAR(a.data_nascimento)) - (RIGHT(CURDATE(),5)<RIGHT(a.data_nascimento,5)) as idade,
                (select status from local_curso_aluno where local_curso_id = l.id and aluno_id = a.id) as status
                FROM aluno a
                INNER JOIN local_curso_aluno ON local_curso_aluno.aluno_id = a.id and (local_curso_aluno.status = 1 or local_curso_aluno.status = 2)
                INNER JOIN local_curso l ON local_curso_aluno.local_curso_id = l.id AND curso_id = ".$curso." and local_id not in(26,27,28) and data_inicio >=  DATE_SUB(curdate(), INTERVAL 6 MONTH) and (l.status=1 or l.status=2)";

        if ($sexo != 'A') {
            $sql .= " and a.sexo='" . $sexo . "'";
        }

        if ($periodo != 'Q') {
            $sql .= " and l.periodo='" . $periodo . "'";
        }
        
        
        
        
        $rs = $this->conn->query($sql);
        
        return $this->conn->countRow($rs);
         
     }
    
    public function listaAlunos($empresa,$status,$offset){
    
        $sql = "select *,
                       (select nome from aluno where id=aluno_id) as nome, aluno_id as cod     
                from unite_emprega_processo where unite_emprega_id =".$empresa." and status = ".$status;
        
        if((int)$offset===0){
           $sql .= " LIMIT 0,25"; 
        }else{
            $sql .= " LIMIT ".(int)$offset.",25"; 
        }
        
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
    
    public function totalAlunos($empresa,$status){
    
        $sql = "select id   
                from unite_emprega_processo where unite_emprega_id =".$empresa." and status = ".$status;
        
        
        
        $rs = $this->conn->query($sql);
       
        return $this->conn->countRow($rs);
        
    }




     public function escape($str){
         return $this->conn->escape($str);
     }

}

?>
