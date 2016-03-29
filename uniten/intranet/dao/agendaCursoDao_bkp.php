<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of agendaCurso
 *
 * @author rogerio
 */
//require_once 'C:/xampp/htdocs/unite/intranet/util/conn.php';

require_once $_SERVER['DOCUMENT_ROOT'].'/uniten/intranet/util/conn.php';


class AgendaCursoDao {

    private $conn;

    public function AgendaCursoDao() {
        $this->conn = new Mysql();
        $this->conn->connect();
    }

    public function __destruct() {
        $this->conn->close();
    }

    public function listaCandidatoAgenda($agenda, $aluno='') {
        $lista = array();
        if (empty($aluno)) {
            $query = 'SELECT   aluno_id as id,
                               (SELECT nome FROM aluno WHERE id = aluno_id ) as aluno,
                               (SELECT concat(ddd, " - ", telefone) FROM aluno WHERE id = aluno_id ) as telefone,
                               (SELECT bairro FROM aluno WHERE id = aluno_id ) as bairro,
                               classificacao,status,nota_prova, 
                               DATE_FORMAT(data_cadastro, "%d/%m/%Y") data
                      FROM local_curso_aluno
                      WHERE local_curso_id = ' . $agenda . ' ORDER BY classificacao ASC, aluno ASC ';
        } else {
            $query = 'SELECT   aluno_id as id,
                               (SELECT nome FROM aluno WHERE id = aluno_id ) as aluno,
                               (SELECT concat(ddd, " - ", telefone) FROM aluno WHERE id = aluno_id ) as telefone,
                               (SELECT bairro FROM aluno WHERE id = aluno_id ) as bairro,
                               classificacao,status,nota_prova,
                               DATE_FORMAT(data_cadastro, "%d/%m/%Y") data
                      FROM local_curso_aluno
                      WHERE local_curso_id = ' . $agenda . ' and aluno_id in (SELECT id from aluno WHERE nome like "%' . $aluno . '%") ORDER BY classificacao ASC, aluno ASC ';
        }


        $rs = $this->conn->query($query);

        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
        }
        return $lista;
    }

    public function listaAlunoAgenda($agenda) {
        $lista = array();
        $query = 'SELECT   aluno_id as id,
                               (SELECT nome FROM aluno WHERE id = aluno_id ) as aluno,
                               (SELECT concat(ddd, " - ", telefone) FROM aluno WHERE id = aluno_id ) as telefone,
                               (SELECT bairro FROM aluno WHERE id = aluno_id ) as bairro,
                               (SELECT cpf FROM aluno WHERE id = aluno_id ) as cpf,
                               (SELECT rg FROM aluno WHERE id = aluno_id ) as rg,
                               (SELECT endereco FROM aluno WHERE id = aluno_id ) as endereco,
                               (SELECT numero FROM aluno WHERE id = aluno_id ) as numero,
                               (SELECT email FROM aluno WHERE id = aluno_id ) as email,
                               (SELECT cidade FROM aluno WHERE id = aluno_id ) as cidade,
                               classificacao,status,nota,passe,
                               DATE_FORMAT(data_cadastro, "%d/%m/%Y") data
                      FROM local_curso_aluno
                      WHERE local_curso_id = ' . $agenda . ' AND status >= 1 AND status < 4 ORDER BY aluno ASC ';



        $rs = $this->conn->query($query);

        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
        }
        return $lista;
    }

    public function listaAlunoAprovadosAgenda($agenda) {
        $lista = array();
        $query = 'SELECT   aluno_id as id,
                               (SELECT nome FROM aluno WHERE id = aluno_id ) as aluno,
                               (SELECT concat(ddd, " - ", telefone) FROM aluno WHERE id = aluno_id ) as telefone,
                               (SELECT bairro FROM aluno WHERE id = aluno_id ) as bairro,
                               (SELECT cpf FROM aluno WHERE id = aluno_id ) as cpf,
                               (SELECT rg FROM aluno WHERE id = aluno_id ) as rg,
                               (SELECT endereco FROM aluno WHERE id = aluno_id ) as endereco,
                               (SELECT numero FROM aluno WHERE id = aluno_id ) as numero,
                               (SELECT email FROM aluno WHERE id = aluno_id ) as email,
                               (SELECT cidade FROM aluno WHERE id = aluno_id ) as cidade,
                               classificacao,status,nota,
                               (CASE (SELECT trabalhando FROM poscurso WHERE aluno_id = LCA.aluno_id and local_curso_id = ' . $agenda . ')
                                     WHEN 1 THEN "Sim"
                                     WHEN 0 THEN "Não"
                                END) as situacao,
                               DATE_FORMAT(data_cadastro, "%d/%m/%Y") data
                      FROM local_curso_aluno LCA
                      WHERE local_curso_id = ' . $agenda . ' AND status = 2 ORDER BY aluno ASC ';



        $rs = $this->conn->query($query);

        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
        }
        return $lista;
    }

    public function listaAgendaAluno($aluno) {
        $lista = array();
        $query = 'SELECT       aluno_id as aluno,local_curso_id as agenda,
                               (SELECT nome FROM curso C, local_curso L WHERE L.id = local_curso_id AND L.curso_id = C.id ) as curso,

                               DATE_FORMAT((SELECT data_inicio FROM local_curso L WHERE L.id = local_curso_id), "%d/%m/%Y") as inicio,
                               DATE_FORMAT((SELECT data_termino FROM local_curso L WHERE L.id = local_curso_id), "%d/%m/%Y") as termino,
                               classificacao,status,nota,
                               (CASE status
                                     WHEN 0 THEN "Matriculado"
                                     WHEN 1 THEN "Cursando"
                                     WHEN 2 THEN "Aprovado"
                                     WHEN 3 THEN "Reprovado"
                                     WHEN 4 THEN "Desistiu"
                                END) as situacao,
                               DATE_FORMAT(data_cadastro, "%d/%m/%Y") data
                      FROM local_curso_aluno
                      WHERE aluno_id = ' . $aluno . '  ORDER BY data DESC ';



        $rs = $this->conn->query($query);

        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
        }
        return $lista;
    }

    function getAgendaAluno($agenda, $aluno) {
        $sql = "SELECT status,classificacao,nota,passe FROM local_curso_aluno  WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
        $rs = $this->conn->query($sql);
        $obj = false;
        if ($this->conn->countRow($rs) > 0) {
            $obj = $this->conn->object($rs);
        }
        return $obj;
    }

    // Metodo utilizado para verificar se existe um anulo classificado
    // utilizado na secao de exame
    function verificaAlunoClassificacao($agenda, $classificacao) {
        $sql = "SELECT aluno_id FROM local_curso_aluno  WHERE local_curso_id = " . $agenda . "  AND classificacao =" . $classificacao;



        $rs = $this->conn->query($sql);

        if ($this->conn->countRow($rs) > 0) {

            $row = $this->conn->fetch($rs);
            return $row['aluno_id'];
        }
        return 0;
    }

    function gravaAvaliacaoFinal($agenda, $aluno, $status, $nota='') {
        $query = "UPDATE local_curso_aluno SET status =" . $status . ", nota ='" . $nota . "' WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
        $this->conn->query($query);
    }

    public function alteraStatus($agenda, $aluno, $status) {
        $query = "UPDATE local_curso_aluno SET status =" . $status . " WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
        $this->conn->query($query);
    }

    public function alteraPasse($agenda, $aluno, $passe) {
        $query = "UPDATE local_curso_aluno SET passe =" . $passe . " WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
        $this->conn->query($query);
    }

    public function gravaAlunoAgenda($agenda, $aluno, $status, $passe, $classificacao='', $nota='') {

        $query = "INSERT local_curso_aluno(local_curso_id,aluno_id,status,classificacao,nota,passe) VALUES(" . $agenda . "," . $aluno . "," . $status . ",'" . $classificacao . "','" . $nota . "','" . $nota . "')";
        $this->conn->query($query);
    }

    public function alteraClassificacao($agenda, $aluno, $classificacao,$nota) {

        $query = "UPDATE local_curso_aluno SET classificacao ='" . $classificacao . "', nota_prova = '".$nota."' WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
        $this->conn->query($query);
    }

    public function alteraNota($agenda, $aluno, $nota) {
        $query = "UPDATE local_curso_aluno SET nota ='" . $nota . "' WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
        $this->conn->query($query);
    }

    public function removeAlunoCurso($agenda, $aluno) {
        $query = "DELETE FROM local_curso_aluno  WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
        $this->conn->query($query);
    }
    
    public function getPasse($agenda, $aluno){
       
        
        $sql = "SELECT passe FROM local_curso_aluno  WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
        
        $rs = $this->conn->query($sql);
        $row = $this->conn->fetch($rs);
        return $row['passe'];
        
    }

    public function escape($var) {
        return $this->conn->escape($var);
    }

}

?>
