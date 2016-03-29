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
//require_once 'C:/xampp/htdocs/uniten/intranet/util/conn.php';

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
    
    
    public function listaCandidatoAgendaDesclassificados($agenda, $aluno='') {
        $lista = array();
             $query = 'SELECT   aluno_id as id,
                               (SELECT nome FROM aluno WHERE id = aluno_id ) as aluno,
                               (SELECT email FROM aluno WHERE id = aluno_id ) as email,
                               (SELECT concat(ddd, " - ", telefone) FROM aluno WHERE id = aluno_id ) as telefone,
                               (SELECT bairro FROM aluno WHERE id = aluno_id ) as bairro,
                               classificacao,status,nota_prova, 
                               DATE_FORMAT(data_cadastro, "%d/%m/%Y") data
                      FROM local_curso_aluno
                      WHERE local_curso_id = ' . $agenda . ' and status = 0 HAVING  classificacao = 0 ORDER BY aluno ASC ';
      

        $rs = $this->conn->query($query);

        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
        }
        return $lista;
    }
    
    public function listaCandidatoAgendaClassificados($agenda, $aluno='') {
        $lista = array();
             $query = 'SELECT   aluno_id as id,
                               (SELECT nome FROM aluno WHERE id = aluno_id ) as aluno,
                               (SELECT concat(ddd, " - ", telefone) FROM aluno WHERE id = aluno_id ) as telefone,
                               (SELECT bairro FROM aluno WHERE id = aluno_id ) as bairro,
                               classificacao,status,nota_prova, 
                               DATE_FORMAT(data_cadastro, "%d/%m/%Y") data
                      FROM local_curso_aluno
                      WHERE local_curso_id = ' . $agenda . ' HAVING  classificacao >= 1 ORDER BY classificacao ASC, aluno ASC ';
      

        $rs = $this->conn->query($query);

        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
        }
        return $lista;
    }

    public function listaCandidatoAgenda($agenda, $aluno='') {
        $lista = array();
        if (empty($aluno)) {
            $query = 'SELECT   aluno_id as id,
                               (SELECT nome FROM aluno WHERE id = aluno_id ) as aluno,
                               (SELECT cpf FROM aluno WHERE id = aluno_id ) as cpf,
                               (SELECT concat(ddd, " - ", telefone) FROM aluno WHERE id = aluno_id ) as telefone,
                               (SELECT bairro FROM aluno WHERE id = aluno_id ) as bairro,
                               classificacao,status,nota_prova, 
                               DATE_FORMAT(data_cadastro, "%d/%m/%Y") data
                      FROM local_curso_aluno
                      WHERE local_curso_id = ' . $agenda . ' and status <> 4  ORDER BY classificacao ASC, aluno ASC ';
        } else {
            $query = 'SELECT   aluno_id as id,
                               (SELECT nome FROM aluno WHERE id = aluno_id ) as aluno,
                               (SELECT concat(ddd, " - ", telefone) FROM aluno WHERE id = aluno_id ) as telefone,
                               (SELECT bairro FROM aluno WHERE id = aluno_id ) as bairro,
                               classificacao,status,nota_prova,
                               DATE_FORMAT(data_cadastro, "%d/%m/%Y") data
                      FROM local_curso_aluno
                      WHERE local_curso_id = ' . $agenda . ' and aluno_id in (SELECT id from aluno WHERE nome like "' . $aluno . '%") ORDER BY classificacao ASC, aluno ASC ';
        }


        $rs = $this->conn->query($query);

        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
        }
        return $lista;
    }
    
    
    
    public function listaAlunoInciaram($agenda) {
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
                      WHERE local_curso_id = ' . $agenda . ' AND status >= 1  ORDER BY aluno ASC ';



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
                               DATE_FORMAT(data_cadastro, "%d/%m/%Y") data,
                               (((select count(*) from diario_classe_aluno DCA, diario_classe DC 
                                     where  DC.local_curso_id = LCL.local_curso_id 
                                     and DC.id = DCA.diario_classe_id 
                                     and aluno_id = LCL.aluno_id 
                                     and presenca = 1) * 100 )/ 
                                     
                                     (select count(*) from diario_classe_aluno DCA, diario_classe DC 
                                     where  DC.local_curso_id = LCL.local_curso_id 
                                     and DC.id = DCA.diario_classe_id 
                                     and aluno_id = LCL.aluno_id )

                             ) as percentual
                      FROM local_curso_aluno LCL
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
                               (SELECT COUNT(*) from poscurso_ausente WHERE local_curso_id  = LCA.local_curso_id and aluno_id = LCA.aluno_id) as ausente,
                               (SELECT count(*) from poscurso WHERE local_curso_id  = LCA.local_curso_id and aluno_id = LCA.aluno_id) as pesquisado,
                               (SELECT cpf FROM aluno WHERE id = aluno_id ) as cpf,
                               (SELECT rg FROM aluno WHERE id = aluno_id ) as rg,
                               (SELECT endereco FROM aluno WHERE id = aluno_id ) as endereco,
                               (SELECT numero FROM aluno WHERE id = aluno_id ) as numero,
                               (SELECT email FROM aluno WHERE id = aluno_id ) as email,
                               (SELECT cidade FROM aluno WHERE id = aluno_id ) as cidade,
                               classificacao,status,nota,
                               (CASE (SELECT trabalhando FROM poscurso WHERE aluno_id = LCA.aluno_id and local_curso_id = ' . $agenda . ' LIMIT 1)
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
    
    public function listaAlunoAgendaFinal($agenda) {
        $lista = array();
        $query = 'select nota,status,aluno_id,
                 (select count(*) from diario_classe_aluno DCA, diario_classe DC 
                                     where  DC.local_curso_id = LCL.local_curso_id 
                                     and DC.id = DCA.diario_classe_id 
                                     and aluno_id = LCL.aluno_id 
                                     
                    ) as apontamentos,
                   (select count(*) from diario_classe_aluno DCA, diario_classe DC 
                                     where  DC.local_curso_id = LCL.local_curso_id 
                                     and DC.id = DCA.diario_classe_id 
                                     and aluno_id = LCL.aluno_id 
                                     and presenca = 0
                    ) as faltas,
                    


                (

                 ((select count(*) from diario_classe_aluno DCA, diario_classe DC 
                                     where  DC.local_curso_id = LCL.local_curso_id 
                                     and DC.id = DCA.diario_classe_id 
                                     and aluno_id = LCL.aluno_id 
                                     and presenca = 1) * 100 )/ 
                                     
                                     (select count(*) from diario_classe_aluno DCA, diario_classe DC 
                                     where  DC.local_curso_id = LCL.local_curso_id 
                                     and DC.id = DCA.diario_classe_id 
                                     and aluno_id = LCL.aluno_id )

                ) as percentual,
                (SELECT nome FROM aluno WHERE id = aluno_id ) as aluno,

                (
                  select count(*) from diario_classe_aluno DCA, diario_classe DC 
                where  DC.local_curso_id = LCL.local_curso_id and DC.id = DCA.diario_classe_id and aluno_id = LCL.aluno_id  and vale = 1


                  )*2 as passes


                from  local_curso_aluno LCL 
                where local_curso_id = '.$agenda.' and status >=1 order by aluno asc';



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
                               (SELECT id FROM desistencia WHERE local_curso_id = LCA.local_curso_id AND aluno_id = LCA.aluno_id ) as desistencia,
                               DATE_FORMAT((SELECT data_inicio FROM local_curso L WHERE L.id = local_curso_id), "%d/%m/%Y") as inicio,
                               DATE_FORMAT((SELECT data_termino FROM local_curso L WHERE L.id = local_curso_id), "%d/%m/%Y") as termino,
                               classificacao,status,nota,nota_prova,
                               DATE_FORMAT(data_matricula, "%d/%m/%Y") matricula,
                               (SELECT nome FROM usuario WHERE id = usuario_id) as usuario,
                               (CASE status
                                     WHEN 0 THEN "Inscrito"
                                     WHEN 1 THEN "Matriculado"
                                     WHEN 2 THEN "Aprovado"
                                     WHEN 3 THEN "Reprovado"
                                     WHEN 4 THEN "Desistente"
                                END) as situacao,
                               DATE_FORMAT(data_cadastro, "%d/%m/%Y") data
                      FROM local_curso_aluno LCA
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
        $sql = "SELECT status,classificacao,nota,passe,nota_prova as notaprova FROM local_curso_aluno  WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
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
    
    function gravaAvaliacaoFinal($agenda, $aluno, $nota='') {
         $this->conn->query("call pro_grava_avaliacao_final(".$agenda.",".$aluno.",".$nota.")");
    }

   /* function gravaAvaliacaoFinal($agenda, $aluno, $nota='') {
        
        // numero de diarios
        $query = "select count(aluno_id) as total 
                                from diario_classe_aluno DCA 
                                WHERE aluno_id = ".$aluno."
                                and diario_classe_id  
                                IN (select id from diario_classe where local_curso_id = ".$agenda.")";
        $rs = $this->conn->query($query);
        $rowD = $this->conn->fetch($rs);
        
         // numero de presenças
        $query = "select count(aluno_id) as total 
                                from diario_classe_aluno DCA 
                                WHERE aluno_id = ".$aluno."
                                and presenca = 1
                                and diario_classe_id  
                                IN (select id from diario_classe where local_curso_id = ".$agenda.")";
        
        $rs = $this->conn->query($query);
        $rowP = $this->conn->fetch($rs);
        
        // calculando o percentual de faltas
        try {
              $percentual = ($rowP['total']*100)/$rowD['total'];
        } catch (Exception $exc) {
              $percentual = 0;
        }

      
        
       
        
        if((float)$percentual < 75 || (int)$nota < 7){
            $status = 3;
        }else{
            $status = 2;
        }
        
        $query = "UPDATE local_curso_aluno SET status =" . $status . ", nota ='" . $nota . "' WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
        $this->conn->query($query);
        
        unset($rowP);
        unset($rowD);
        unset($rs);
    }*/

    public function alteraStatus($agenda, $aluno, $status) {
        $query = "UPDATE local_curso_aluno SET status =" . $status . " WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
        $this->conn->query($query);
    }

    public function alteraPasse($agenda, $aluno, $passe) {
        $query = "UPDATE local_curso_aluno SET passe =" . $passe . " WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
        $this->conn->query($query);
    }

    public function gravaAlunoAgenda($agenda, $aluno, $status, $passe, $classificacao='', $nota='') {
        $rs = $this->conn->query("select aluno_id from local_curso_aluno where local_curso_id=".$agenda." and aluno_id = ".$aluno);
        if(mysql_fetch_array($rs)==0){
             $query = "INSERT local_curso_aluno(local_curso_id,aluno_id,status,classificacao,nota,passe) VALUES(" . $agenda . "," . $aluno . "," . $status . ",'" . $classificacao . "','" . $nota . "','" . $nota . "')";
             $this->conn->query($query);
        }
       
    }

    public function alteraClassificacao($agenda, $aluno, $classificacao, $nota=0) {

        $query = "UPDATE local_curso_aluno SET classificacao ='" . $classificacao . "', nota_prova = '" . $nota . "' WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
        $this->conn->query($query);
    }

    public function alteraNota($agenda, $aluno, $nota) {
        $query = "UPDATE local_curso_aluno SET nota ='" . $nota . "' WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
        $this->conn->query($query);
    }
    
     function gravaMatricula($agenda, $aluno, $usuario) {
        $query = "UPDATE local_curso_aluno SET data_matricula ='" . date('Y-m-d H:i:s'). "', usuario_id ='" . $usuario. "' WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
        $this->conn->query($query);
    }

    public function removeAlunoCurso($agenda, $aluno) {
        /** removendo as presencas dos diarios **/
        $this->conn->query("select * from diario_classe_aluno where aluno_id = ".$aluno." and diario_classe_id in (select id from diario_classe where local_curso_id = ".$agenda.")");
       
        /** apagando a ligacao do aluno com o curso **/
        $this->conn->query("DELETE FROM local_curso_aluno  WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno);
       

    }

    public function getPasse($agenda, $aluno) {


        $sql = "SELECT passe FROM local_curso_aluno  WHERE local_curso_id = " . $agenda . " AND aluno_id =" . $aluno;
       
        $rs = $this->conn->query($sql);
        $row = $this->conn->fetch($rs);
        return $row['passe'];
    }

    public function verificaDesistencia($aluno) {
        $rs = $this->conn->query("SELECT
                                         DATE_FORMAT(data_cadastro,'%d/%m%/%Y') AS data_cadastro,
                                         (SELECT id FROM desistencia WHERE local_curso_id = LCA.local_curso_id AND aluno_id = LCA.aluno_id order by id DESC LIMIT 1 ) as desistencia,
                                         (DATEDIFF(CURRENT_DATE() , data_cadastro)) as  contador,
                                          DATE_FORMAT(DATE_ADD(data_cadastro, INTERVAL 60 DAY),'%d/%m%/%Y') as liberacao
                                   FROM local_curso_aluno LCA
                                   WHERE aluno_id = " . $aluno . "
                                   AND status = 4 ORDER  BY local_curso_id DESC limit 1"
        );
        $row = array();
        if ($this->conn->countRow($rs) > 0) {
            $row = $this->conn->object($rs);
        }

        return $row;
    }
    
    public function ultimoCurso($aluno) {
        $sql = "SELECT
                     (SELECT data_inicio FROM local_curso WHERE id = local_curso_id) as data_inicio,
                     (SELECT data_termino FROM local_curso WHERE id = local_curso_id) as data_final,
                     (SELECT horario_inicial FROM local_curso WHERE id = local_curso_id) as horario_inicial,
                     (SELECT horario_final FROM local_curso WHERE id = local_curso_id) as horario_final,
                     (SELECT prova_data FROM local_curso WHERE id = local_curso_id) as prova_data,
                     (SELECT prova_horario FROM local_curso WHERE id = local_curso_id) as prova_horario,
                     (SELECT prova FROM local_curso WHERE id = local_curso_id) as prova,
                     (SELECT periodo FROM local_curso WHERE id = local_curso_id) as periodo,
                      status,
                     (SELECT nome FROM local_curso LC, curso C WHERE LC.id = local_curso_id AND curso_id = C.id) as nome,
                     (SELECT local_id FROM local_curso LC, curso C WHERE LC.id = local_curso_id AND curso_id = C.id) as local,
                     local_curso_id as agenda
                FROM local_curso_aluno LCA
                WHERE aluno_id = " . $aluno . "
                AND LCA.STATUS = 1 
                ORDER  BY data_cadastro DESC limit 1";
        $rs = $this->conn->query($sql);
        

        return $this->conn->object($rs);
    }
    
    public function agendaAnos(){
        
        $rs = $this->conn->query('select year(data_termino) as ano from local_curso GROUP by year(data_termino) order by year(data_termino) desc');
        $lista = array();
        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj->ano;
            }
        }
        return $lista;
    } 
    
    
    public function agendaDadosEvolucao($ano,$tipo){
       
        if($tipo=='C'){
            $sql = 'select count(id) as total from local_curso where year(data_termino) = "'.$ano.'" and status = 2';
        }  elseif ($tipo=='V') {
             $sql = 'select sum(vagas) as total from local_curso where year(data_termino) = "'.$ano.'" and status = 2';
        }elseif($tipo=='N'){
            $sql = 'select count(aluno_id) as total from local_curso_aluno where status = 2 and  year(data_cadastro) = "'.$ano.'"';
        }else{
             $sql = 'select count(aluno_id) as total from local_curso_aluno LCA, local_curso LC where   year(LCA.data_cadastro) = "'.$ano.'" and LCA.local_curso_id = LC.id and LC.status = 2';
    
        }
         
        $rs = $this->conn->query($sql);
     
        $row = $this->conn->fetch($rs);
        $this->conn->free($rs);
        return  $row['total'];
    } 

    public function escape($var) {
        return $this->conn->escape($var);
    }

}

?>
