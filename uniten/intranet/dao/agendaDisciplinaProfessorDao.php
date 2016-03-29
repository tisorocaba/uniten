<?php
/**
 * Description of agendaCurso
 *
 * @author rogerio
 */
//require_once 'C:/xampp/htdocs/uniten/intranet/util/conn.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/uniten/intranet/util/conn.php';

class AgendaDisciplinaProfessorDao {

    private $conn;

    public function __construct() {
        $this->conn = new Mysql();
        $this->conn->connect();
    }

    public function __destruct() {
        $this->conn->close();
    }
    
    public function listaDisciplinaAgenda($agenda){
        $lista = array();
        $rs = $this->conn->query("SELECT   D.nome, D.id
                      FROM local_curso LC, curso C, curso_disciplina CD, disciplina D
                      WHERE LC.id = ' ".$agenda." ' 
                      AND LC.curso_id = C.id
                      AND CD.curso_id = C.id
                      AND CD.disciplina_id = D.id
                      ORDER BY D.nome ASC");
        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
        }
        return $lista;
    }

    public function listaProfessorAgenda($agenda) {
        $lista = array();
        $query = 'SELECT       (SELECT nome FROM professor WHERE id = professor_id ) as professor,
                               (SELECT nome FROM disciplina WHERE id = disciplina_id ) as disciplina,
                               professor_id as proid
                      FROM agenda_professor_disciplina
                      WHERE local_curso_id = ' . $agenda . ' ORDER BY professor ASC ';



        $rs = $this->conn->query($query);

        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
        }
        return $lista;
    }

    public function listaProfessorAgendaAgrupado($agenda) {
        $lista = array();
        $query = 'SELECT       (SELECT nome FROM professor WHERE id = professor_id ) as professor,
                               (SELECT nome FROM disciplina WHERE id = disciplina_id ) as disciplina,
                               professor_id as proid
                      FROM agenda_professor_disciplina
                      WHERE local_curso_id = ' . $agenda . ' group by professor_id ORDER BY professor ASC ';



        $rs = $this->conn->query($query);

        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
        }
        return $lista;
    }

    function verificaProfessorAgenda($agenda, $professor, $disciplina) {

        $sql = "SELECT disciplina_id FROM agenda_professor_disciplina  WHERE local_curso_id = " . $agenda . "  AND professor_id =" . $professor . " AND disciplina_id = " . $disciplina;



        $rs = $this->conn->query($sql);
        if ($this->conn->countRow($rs) > 0)
            return true;
        else
            return false;
    }

    function gravaProfessorAgenda($agenda, $professor, $disciplina) {

        $sql = "SELECT professor_id FROM agenda_professor_disciplina  WHERE local_curso_id = " . $agenda . "  AND disciplina_id =" . $disciplina;
        $rs = $this->conn->query($sql);
        if ($this->conn->countRow($rs) > 0) {
            $ins = "UPDATE agenda_professor_disciplina SET professor_id = " . $professor . " WHERE disciplina_id = " . $disciplina . "  AND local_curso_id =" . $agenda;
            $this->conn->query($ins);
        } else {
            $ins = "INSERT INTO agenda_professor_disciplina(professor_id,disciplina_id,local_curso_id) VALUES(" . $professor . "," . $disciplina . "," . $agenda . ")";
            $this->conn->query($ins);
        }
        // gravando da grade de aula
         $sql = "UPDATE diario_classe SET professor_id = " . $professor . " WHERE disciplina_id = " . $disciplina . "  AND local_curso_id =" . $agenda;
         $this->conn->query($sql);
         return $sql;
        
        
        
    }

    function getDisciplinaPorAgendaProfessor($agenda, $professor) {
      
             $query = 'SELECT       
                               (SELECT nome FROM disciplina WHERE id = disciplina_id ) as disciplina,
                               disciplina_id as disid
                      FROM agenda_professor_disciplina
                      WHERE local_curso_id = ' . $agenda . ' and professor_id =' . $professor;
            
       
       



        $rs = $this->conn->query($query);

        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
            return $lista;
        } else {
            return false;
        }
    }
    
    
     function getProfessorPorAgendaDiciplina($agenda, $disciplina) {
      
             $query = 'SELECT       
                               (SELECT nome FROM professor WHERE id = professor_id ) as professor
                        FROM agenda_professor_disciplina
                      WHERE local_curso_id = ' . $agenda . ' and disciplina_id =' . $disciplina;
            
      
        $rs = $this->conn->query($query);
        $obj = $this->conn->object($rs);
        return $obj->professor;
       
    }
    

    public function escape($var) {
        return $this->conn->escape($var);
    }

}


