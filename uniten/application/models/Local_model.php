<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LocaCursoAluno
 *
 * @author rogerio
 */
class Local_Model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function verificaInscricao($agenda, $aluno) {

        $query = $this->db->query("SELECT * FROM local_curso_aluno WHERE local_curso_id = " . $agenda . " AND aluno_id=" . $aluno);
        //return count($query->result_array());
        $dado = array();
        foreach ($query->result_array() as $row) {
            $dado[] = $row['data_cadastro'];
        }
        return $dado;
    }

    /*public function insereClassificacao($agenda, $aluno) {
        
        $sql = "SELECT count(*) as classificacao FROM local_curso_aluno WHERE local_curso_id = " . $agenda ;
        $query = $this->db->query($sql);
        $row = array();
        if ($query->num_rows() > 0) {
            $row = $query->row();
        }
               
        $query = "UPDATE local_curso_aluno SET classificacao = ".$row->classificacao." WHERE local_curso_id = " . $agenda . " AND aluno_id = " . $aluno;
        
        return $row->classificacao;
        
    }*/
    
     public function insereClassificacao($agenda, $aluno) {

        $query = "UPDATE local_curso_aluno LEFT JOIN
                                 (SELECT local_curso_id,COUNT(*) AS baseVal FROM local_curso_aluno WHERE local_curso_id=" . $agenda . " GROUP BY local_curso_id)
                          AS totalSum USING (local_curso_id)
                          SET classificacao=baseVal
                          WHERE local_curso_id = " . $agenda . " AND aluno_id = " . $aluno;

        $this->db->query($query);

        $query = $this->db->query("SELECT classificacao,(select prova from local_curso where id = local_curso_id) as prova,(select vagas from local_curso where id = local_curso_id) as vagas  FROM local_curso_aluno WHERE local_curso_id = " . $agenda . " AND aluno_id=" . $aluno);
        $row = array();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            //ser for um curso sem prova e o numero de vagas menor ou igual a classificacao adiciona como aprovado
            if($row->prova==0 && $row->classificacao <= $row->vagas){
                $this->db->query("UPDATE local_curso_aluno SET status = 1 WHERE local_curso_id = " . $agenda . " AND aluno_id = " . $aluno);
            }
        }
        return @$row->classificacao;
    }

    public function alterar($agenda, $aluno, $classificacao) {
        
    }

    public function aprovados($agenda, $vagas) {

        $query = $this->db->query("SELECT classificacao, (select upper(nome) from aluno where id = aluno_id) as nome FROM local_curso_aluno WHERE local_curso_id = ".$agenda." and status < 4 HAVING  classificacao >= 1 order by classificacao asc  limit 0," . $vagas);
        $dado = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $obj = new stdClass();
                $obj->classificacao = $row['classificacao'];
                $obj->nome = $row['nome'];
                $dado[] = $obj;
            }
        }
        return $dado;
    }

    public function suplentes($agenda, $vagas) {
        $query = $this->db->query("SELECT classificacao, (select upper(nome)from aluno where id = aluno_id) as nome FROM local_curso_aluno WHERE local_curso_id = " . $agenda . " HAVING  classificacao >= 1  order by classificacao asc limit " . $vagas . " , 500");
        $dado = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $obj = new stdClass();
                $obj->classificacao = $row['classificacao'];
                $obj->nome = $row['nome'];
                $dado[] = $obj;
            }
        }
        return $dado;
    }

    public function verificaDesistencia($aluno) {
        $query = $this->db->query("SELECT
                                         DATE_FORMAT(data_cadastro,'%d/%m%/%Y') AS data_cadastro,
                                         (SELECT id FROM desistencia WHERE local_curso_id = LCA.local_curso_id AND aluno_id = LCA.aluno_id order by id desc limit 1 ) as desistencia,
                                         (DATEDIFF(CURRENT_DATE() , data_cadastro)) as  contador,
                                          DATE_FORMAT(DATE_ADD(data_cadastro, INTERVAL 60 DAY),'%d/%m%/%Y') as liberacao
                                   FROM local_curso_aluno LCA
                                   WHERE aluno_id = " . $aluno . "
                                   AND status = 4 ORDER  BY local_curso_id DESC limit 1"
        );
        $row = array();
        if ($query->num_rows() > 0) {
            $row = $query->row();
        }

        return $row;
    }

    public function ultimoCurso($aluno) {
        
        
        
        /*$sql = "SELECT
                     (SELECT data_termino FROM local_curso WHERE id = local_curso_id) as data_final,
                     (SELECT horario_inicial FROM local_curso WHERE id = local_curso_id) as horario_inicial,
                     (SELECT horario_final FROM local_curso WHERE id = local_curso_id) as horario_final,
                     (SELECT status FROM local_curso WHERE id = local_curso_id) as status,
                     (SELECT nome FROM local_curso LC, curso C WHERE LC.id = local_curso_id AND curso_id = C.id) as nome
                FROM local_curso_aluno LCA
                WHERE aluno_id = " . $aluno . "
                ORDER  BY data_cadastro DESC limit 1";*/
        $sql = "SELECT
                     (SELECT data_termino FROM local_curso WHERE id = local_curso_id) as data_final,
                     (SELECT horario_inicial FROM local_curso WHERE id = local_curso_id) as horario_inicial,
                     (SELECT horario_final FROM local_curso WHERE id = local_curso_id) as horario_final,
                     (SELECT prova_data FROM local_curso WHERE id = local_curso_id) as prova_data,
                     (SELECT prova_horario FROM local_curso WHERE id = local_curso_id) as prova_horario,
                     (SELECT prova FROM local_curso WHERE id = local_curso_id) as prova,
                      status,
                     (SELECT nome FROM local_curso LC, curso C WHERE LC.id = local_curso_id AND curso_id = C.id) as nome,
                     (SELECT local_id FROM local_curso LC, curso C WHERE LC.id = local_curso_id AND curso_id = C.id) as local
                FROM local_curso_aluno LCA
                WHERE aluno_id = " . $aluno . "
                ORDER  BY data_cadastro DESC limit 1";
        
       
        $query = $this->db->query($sql);
        $row = $query->row();
        
        

        return $row;
    }

}


