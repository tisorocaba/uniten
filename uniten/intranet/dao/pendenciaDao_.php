<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pendenciaDao
 *
 * @author rogerio
 */
//require_once 'C:/xampp/htdocs/unite/intranet/util/conn.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/uniten/intranet/util/conn.php';

class PendenciaDao {

    private $conn;

    public function PendenciaDao() {
        $this->conn = new Mysql();
        $this->conn->connect();
    }

    public function __destruct() {
        $this->conn->close();
    }
    
    
    public function agendasSemDiariosPorEmpresa($empresa = '') {

      

            $sql = "  select 
                            (select fantasia from empresa E where empresa_curso_id = E.id ) as empresa,
                            (select id from empresa E where empresa_curso_id = E.id ) as idempresa,
                             id as cod,
                             count(id) as total 
                             from local_curso L
                             where data_inicio < DATE_SUB(CURDATE(),INTERVAL 1 DAY)
                             and data_termino > CURDATE()
                             and status = 1
                             and empresa_curso_id = ".$empresa."
                             and id not in (
                             
                                            select local_curso_id from diario_classe 
                                                                  where data_aula = DATE_SUB(CURDATE(),INTERVAL 1 DAY)
                                                                  and local_curso_id in ( 
                                                                                         select id  from local_curso LL  
                                                                                         where status = 1 
                                                                                         and empresa_curso_id = ".$empresa." )
                             
                             )
                             group by L.empresa_curso_id";
       
        $rs = $this->conn->query($sql);
        $row= null;
        if ($this->conn->countRow($rs) > 0) {
            $row = $this->conn->fetch($rs, MYSQL_ASSOC);
           
        }
        return $row;
    }

    public function agendasSemDiarios($local = '') {

        if ($local == '') {

            $sql = "  select 
                            (select fantasia from empresa E where empresa_curso_id = E.id ) as empresa,
                            (select id from empresa E where empresa_curso_id = E.id ) as idempresa,
                             id as cod,
                             count(id) as total 
                             from local_curso 
                             where data_inicio < DATE_SUB(CURDATE(),INTERVAL 1 DAY)
                             and data_termino > CURDATE()
                             and status = 1
                             and id not in (select local_curso_id from diario_classe where data_aula = DATE_SUB(CURDATE(),INTERVAL 1 DAY))
                             group by empresa_curso_id ";
        } else {
             $sql = "  select 
                            (select fantasia from empresa E where empresa_curso_id = E.id ) as empresa,
                            (select id from empresa E where empresa_curso_id = E.id ) as idempresa,
                             id as cod,
                             count(id) as total 
                             from local_curso 
                             where data_inicio < DATE_SUB(CURDATE(),INTERVAL 1 DAY)
                             and data_termino > CURDATE()
                             and status = 1
                             and local_curso_id = " . $local . "
                             and id not in (select local_curso_id from diario_classe where data_aula = DATE_SUB(CURDATE(),INTERVAL 1 DAY))
                             group by empresa_curso_id ";
            
        }
        $rs = $this->conn->query($sql);
        $lista = array();
        if ($this->conn->countRow($rs) > 0) {
            while ($row = $this->conn->fetch($rs, MYSQL_ASSOC)) {
                $lista[] = $row;
            }
        }
        return $lista;
    }

    public function diariosSempresencaByEmpresa($local = '') {
        if ($local == '') {
            $sql = " select 
                       count(DC.id) as total,
                        (select fantasia from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id) as empresa,
                        (select E.id from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id) as cod
                        from diario_classe DC, local_curso LC 
                        where DC.id not in (select diario_classe_id from diario_classe_aluno) 
                        and DC.local_curso_id = LC.id 
                        and LC.status <> 3
                    GROUP by (select fantasia from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id)
                    order by local_curso_id DESC";
        } else {
            $sql = " select 
                       count(DC.id) as total,
                        (select fantasia from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id) as empresa,
                           (select E.id from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id) as cod
                  
                    from diario_classe DC, local_curso LC where id not in (select diario_classe_id from diario_classe_aluno) 
                    and local_curso_id = LC.id 
                    and local_curso_id = " . $local . "
                    and LC.status <> 3
                    GROUP by (select fantasia from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id)
                    order by local_curso_id DESC";
        }

        $rs = $this->conn->query($sql);
        $lista = array();
        if ($this->conn->countRow($rs) > 0) {
            while ($row = $this->conn->fetch($rs, MYSQL_ASSOC)) {
                $lista[] = $row;
            }
        }
        return $lista;
    }

    public function diariosSemPresenca($local = '') {

        if ($local == '') {
            $sql = "select 
                        (select id from local_curso where id = local_curso_id ) as cod,
                        (select nome from curso C, local_curso LC where LC.curso_id = C.id and LC.id = local_curso_id) as curso,
                        (select local from local L, local_curso LC where LC.local_id = L.id and LC.id = local_curso_id) as local,
                        (SELECT nome from professor where id = professor_id) as monitor,
                        (select fantasia from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id) as empresa,
                        (select DATE_FORMAT(data_inicio,'%d/%m/%Y') from local_curso where id = local_curso_id ) as inicio,
                        (select DATE_FORMAT(data_termino,'%d/%m/%Y') from local_curso where id = local_curso_id ) as termino,
                            DATE_FORMAT(data_aula,'%d/%m/%Y') as data_do_diario

                    from diario_classe DC , local_curso LC 
                    where DC.id not in (select diario_classe_id from diario_classe_aluno)
                    and local_curso_id = LC.id 
                    and LC.status <> 3
                    order by local_curso_id DESC";
        } else {
            $sql = "select 
                        (select id from local_curso where id = local_curso_id ) as cod,
                        (select nome from curso C, local_curso LC where LC.curso_id = C.id and LC.id = local_curso_id) as curso,
                        (select local from local L, local_curso LC where LC.local_id = L.id and LC.id = local_curso_id) as local,
                        (SELECT nome from professor where id = professor_id) as monitor,
                        (select fantasia from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id) as empresa,
                        (select DATE_FORMAT(data_inicio,'%d/%m/%Y') from local_curso where id = local_curso_id ) as inicio,
                        (select DATE_FORMAT(data_termino,'%d/%m/%Y') from local_curso where id = local_curso_id ) as termino,
                        DATE_FORMAT(DC.data_aula,'%d/%m/%Y') as data_do_diario

                    from diario_classe DC, local_curso LC where DC.id not in (select diario_classe_id from diario_classe_aluno) 
                    and local_curso_id = LC.id and local_curso_id = " . $local . "
                    and LC.status <> 3
                    order by local_curso_id DESC";
        }
        $rs = $this->conn->query($sql);
        $lista = array();
        if ($this->conn->countRow($rs) > 0) {
            while ($row = $this->conn->fetch($rs, MYSQL_ASSOC)) {
                $lista[] = $row;
            }
        }
        return $lista;
    }

    public function agendasSemProfessor($local = '') {
        if ($local == '') {
            $sql = "select 

                        id as codigo,
                        (select nome from curso C where curso_id = C.id) as curso,
                        (select local from local L where local_id = L.id) as local,

                        DATE_FORMAT(data_inicio,'%d/%m/%Y')  as inicio,
                        DATE_FORMAT(data_termino,'%d/%m/%Y')  as termino

                        from local_curso  
                        where status <= 2
                        and DATEDIFF(now(),data_inicio)<=5
                        and id not in (select local_curso_id from agenda_professor_disciplina)";
        } else {
            $sql = "select 

                        id as codigo,
                        (select nome from curso C where curso_id = C.id) as curso,
                        (select local from local L where local_id = L.id) as local,

                        DATE_FORMAT(data_inicio,'%d/%m/%Y')  as inicio,
                        DATE_FORMAT(data_termino,'%d/%m/%Y')  as termino

                        from local_curso  
                        where status <= 2
                        and local_id = " . $local . "
                        and DATEDIFF(now(),data_inicio)<=5
                        and id not in (select local_curso_id from agenda_professor_disciplina)";
        }
        $rs = $this->conn->query($sql);
        $lista = array();
        if ($this->conn->countRow($rs) > 0) {
            while ($row = $this->conn->fetch($rs, MYSQL_ASSOC)) {
                $lista[] = $row;
            }
        }
        return $lista;
    }

    public function agendasComPoucosAulons($local = '') {


        if ($local == '') {
            $sql = "select 
                    id as codigo,
                    (select nome from curso C where curso_id = C.id) as curso,
                    (select local from local L where local_id = L.id) as local,
                    (select count(*) from local_curso_aluno where local_curso_id = LC.id) as inscritos,
                    
                    DATE_FORMAT(data_inicio,'%d/%m/%Y')  as inicio,
                    DATE_FORMAT(data_termino,'%d/%m/%Y')  as termino

                    from local_curso LC
                    where status = 1
                    and DATEDIFF(now(),data_inicio)<=10
                    and vagas > (select count(id) from local_curso_aluno where id = local_curso_id )";
        } else {
            $sql = "select 

                    id as codigo,
                    (select nome from curso C where curso_id = C.id) as curso,
                    (select local from local L where local_id = L.id) as local,
                    vagas,
                    (select count(*) from local_curso_aluno where local_curso_id = LC.id) as quantidade,
                    
                    (select count(id) from local_curso_aluno where id = local_curso_id ) as inscritos,
                    DATE_FORMAT(data_inicio,'%d/%m/%Y')  as inicio,
                    DATE_FORMAT(data_termino,'%d/%m/%Y')  as termino

                    from local_curso 
                    where status = 1
                    and local_id = " . $local . "
                    and DATEDIFF(now(),data_inicio)<=10
                    and vagas > (select count(id) from local_curso_aluno where id = local_curso_id )";
        }

        $rs = $this->conn->query($sql);
        $lista = array();
        if ($this->conn->countRow($rs) > 0) {
            while ($row = $this->conn->fetch($rs, MYSQL_ASSOC)) {
                $lista[] = $row;
            }
        }
        return $lista;
    }

    public function agendasFinalizadasSemAvaliacao($local = '') {


        if ($local == '') {
            $sql = "select 
                    id as codigo,
                    (select nome from curso C where curso_id = C.id) as curso,
                    (select local from local L where local_id = L.id) as local,

                    DATE_FORMAT(data_inicio,'%d/%m/%Y')  as inicio,
                    DATE_FORMAT(data_termino,'%d/%m/%Y')  as termino

                    from local_curso 
                    where status = 1
                    and data_termino < now()
                    and (select count(id) from local_curso_aluno where id = local_curso_id  and status <= 2) =0";
        } else {
            $sql = "select 
                    id as codigo,
                    (select nome from curso C where curso_id = C.id) as curso,
                    (select local from local L where local_id = L.id) as local,

                    DATE_FORMAT(data_inicio,'%d/%m/%Y')  as inicio,
                    DATE_FORMAT(data_termino,'%d/%m/%Y')  as termino

                    from local_curso 
                    where status = 1
                    and local_id = " . $local . "
                    and data_termino < now()
                    and (select count(id) from local_curso_aluno where id = local_curso_id  and status <= 2) =0";
        }

        $rs = $this->conn->query($sql);
        $lista = array();
        if ($this->conn->countRow($rs) > 0) {
            while ($row = $this->conn->fetch($rs, MYSQL_ASSOC)) {
                $lista[] = $row;
            }
        }
        return $lista;
    }

    public function agendaComValorVale($local = '') {
        if ($local == '') {
            $sql = "select 

                    id as codigo,
                    (select nome from curso C where curso_id = C.id) as curso,
                    (select local from local L where local_id = L.id) as local,
                    ROUND( valor_vale, 2 ) valor_vale,
                    DATE_FORMAT(data_inicio,'%d/%m/%Y')  as inicio,
                    DATE_FORMAT(data_termino,'%d/%m/%Y')  as termino

                    from local_curso 
                    where local_id = 1 or local_id = 31
                    and status <= 2 
                    HAVING valor_vale = 0";
        } else {
            $sql = "select 

                    id as codigo,
                    (select nome from curso C where curso_id = C.id) as curso,
                    (select local from local L where local_id = L.id) as local,
                    ROUND( valor_vale, 2 ) valor_vale,
                    DATE_FORMAT(data_inicio,'%d/%m/%Y')  as inicio,
                    DATE_FORMAT(data_termino,'%d/%m/%Y')  as termino

                    from local_curso 
                    where local_id = " . $local . "
                    and status <= 2
                        
                    HAVING valor_vale = 0";
        }

        $rs = $this->conn->query($sql);
        $lista = array();
        if ($this->conn->countRow($rs) > 0) {
            while ($row = $this->conn->fetch($rs, MYSQL_ASSOC)) {
                $lista[] = $row;
            }
        }
        return $lista;
    }

    public function agendasSemValorCurso($local = '') {
        if ($local == '') {
            $sql = "select 
                    id as codigo,
                    (select nome from curso C where curso_id = C.id) as curso,
                    (select local from local L where local_id = L.id) as local,

                    DATE_FORMAT(data_inicio,'%d/%m/%Y')  as inicio,
                    DATE_FORMAT(data_termino,'%d/%m/%Y')  as termino

                    from local_curso 
                    where  valor = 2 or valor = 0
                    and status <= 2";
        } else {
            $sql = "select 
                    id as codigo,
                    (select nome from curso C where curso_id = C.id) as curso,
                    (select local from local L where local_id = L.id) as local,

                    DATE_FORMAT(data_inicio,'%d/%m/%Y')  as inicio,
                    DATE_FORMAT(data_termino,'%d/%m/%Y')  as termino

                    from local_curso 
                    where  valor = 2 or valor = 0
                    and local_id = " . $local . "
                    and status <= 2";
        }

        $rs = $this->conn->query($sql);
        $lista = array();
        if ($this->conn->countRow($rs) > 0) {
            while ($row = $this->conn->fetch($rs, MYSQL_ASSOC)) {
                $lista[] = $row;
            }
        }
        return $lista;
    }

    public function removeLog() {
        $sql = 'delete from loguser where data <=  DATE_SUB(curdate(), INTERVAL 3 MONTH); ';
        $this->conn->query($sql);
    }

}

?>
