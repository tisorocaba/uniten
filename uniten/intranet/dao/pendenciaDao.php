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
//require_once 'C:/xampp/htdocs/uniten/intranet/util/conn.php';

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

      
           $sql = "SELECT 
                    LC.id as cod,
                                   (select nome from curso C, local_curso LC where LC.curso_id = C.id and LC.id = local_curso_id) as curso,
                                   (select local from local L, local_curso LC where LC.local_id = L.id and LC.id = local_curso_id) as local,
                                   (SELECT nome from professor where id = professor_id) as monitor,
                                   (select fantasia from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id) as empresa,
                                   (select DATE_FORMAT(data_inicio,'%d/%m/%Y') from local_curso where id = local_curso_id ) as inicio,
                                   (select DATE_FORMAT(data_termino,'%d/%m/%Y') from local_curso where id = local_curso_id ) as termino,
                                       DATE_FORMAT(data_aula,'%d/%m/%Y') as data_do_diario


            FROM local_curso LC, diario_classe DC 
                    WHERE DC.local_curso_id = LC.id 
                    AND LC.data_inicio < CURRENT_DATE
                    AND DC.data_aula < fun_subtrai_data(CURRENT_DATE)
                    AND LC.status <= 2
                    AND DC.id NOT IN(SELECT diario_classe_id  FROM diario_classe_aluno)
                    AND  empresa_curso_id  = ".$empresa."
                    ORDER 
                       BY local_curso_id DESC";
        

       
        $rs = $this->conn->query($sql);
        $aAgendas= null;
        if ($this->conn->countRow($rs) > 0) {
            while($row = $this->conn->fetch($rs, MYSQL_ASSOC)){
                $aAgendas[] = $row;
            }
           
        }
        return $aAgendas;
    }
    
    
    public function agendasSemDiarios($local = '') {

        if ($local == '') {

             $sql = " SELECT 
                        LC.id as cod,
                        local,
                        nome,
                        (select fantasia from empresa E where empresa_curso_id = E.id ) as empresa,
                        DATE_FORMAT(data_inicio,'%d/%m/%Y') as inicio,
                        DATE_FORMAT(data_inicio,'%d/%m/%Y')  as termino
                    FROM local_curso LC, local L, curso C
                            WHERE  local_id = L.id
                            AND curso_id = C.id
                            AND LC.status <> 3
                            AND LC.id NOT IN(SELECT local_curso_id  FROM diario_classe)
                            ORDER BY data_inicio desc";
        } else {
             $sql = "  SELECT 
                        LC.id as cod,
                        local,
                        nome,
                        (select fantasia from empresa E where empresa_curso_id = E.id ) as empresa,
                        DATE_FORMAT(data_inicio,'%d/%m/%Y') as inicio,
                        DATE_FORMAT(data_inicio,'%d/%m/%Y')  as termino
                     FROM local_curso LC, local L, curso C
                            WHERE  local_id = L.id
                            AND curso_id = C.id
                            AND LC.status <> 3
                            AND LC.id NOT IN(SELECT local_curso_id  FROM diario_classe)
                            AND local_id = " . $local . "
                            ORDER BY data_inicio desc
                        ";

            
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
    
    

    /*public function agendasSemDiarios($local = '') {

        if ($local == '') {

             $sql = " select 
                count(local_curso_id) as total ,
                (select fantasia from empresa E where empresa_curso_id = E.id ) as empresa,
                (select nome from curso where id = LC.curso_id) as curso,
                local_curso_id as cod, DATE_FORMAT(MAX(data_aula),'%d/%m/%Y') as ultimo_diario,DATEDIFF(CURDATE(),MAX(data_aula)) as dias_atraso  
                from diario_classe DC, local_curso LC  
                where  local_curso_id = LC.id 
                and status = 1

                group by local_curso_id
                HAVING  dias_atraso > 1

                order by MAX(data_aula) desc";
        } else {
             $sql = "  
                 
                    select 
                        count(local_curso_id) as total ,
                        (select fantasia from empresa E where empresa_curso_id = E.id ) as empresa,
                        (select nome from curso where id = LC.curso_id) as curso,
                        local_curso_id as cod, DATE_FORMAT(MAX(data_aula),'%d/%m/%Y') as ultimo_diario,DATEDIFF(CURDATE(),MAX(data_aula)) as dias_atraso  
                        from diario_classe DC, local_curso LC  
                        where  local_curso_id = LC.id 
                        and status = 1
                        and local_curso_id = " . $local . "
                        group by local_curso_id
                        HAVING  dias_atraso > 1

                        order by MAX(data_aula) desc";

            
        }
        $rs = $this->conn->query($sql);
        $lista = array();
        if ($this->conn->countRow($rs) > 0) {
            while ($row = $this->conn->fetch($rs, MYSQL_ASSOC)) {
                $lista[] = $row;
            }
        }
        return $lista;
    }*/
    
    public function diariosSempresencaByEmpresa($local = '') {
        if ($local == '') {
            $sql = "SELECT 
                    count(DC.id) as total,
                    (select fantasia from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id) as empresa,
                    (select E.id from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id) as cod


             FROM local_curso LC, diario_classe DC 
                     WHERE DC.local_curso_id = LC.id 
                     AND LC.data_inicio < CURRENT_DATE
                     AND DC.data_aula < fun_subtrai_data(CURRENT_DATE)
                     AND LC.status <= 2
                     AND DC.id NOT IN(SELECT diario_classe_id  FROM diario_classe_aluno)
                      GROUP by (select fantasia from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id)
                    order by local_curso_id DESC";
        } else {
            $sql = " SELECT 
                    count(DC.id) as total,
                    (select fantasia from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id) as empresa,
                    (select E.id from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id) as cod


             FROM local_curso LC, diario_classe DC 
                     WHERE DC.local_curso_id = LC.id 
                     AND LC.data_inicio < CURRENT_DATE
                     AND DC.data_aula < fun_subtrai_data(CURRENT_DATE)
                     AND LC.status <= 2
                     AND local_curso_id = " . $local . "
                     AND DC.id NOT IN(SELECT diario_classe_id  FROM diario_classe_aluno)
                     GROUP by (select fantasia from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id)
                     order by local_curso_id DESC
                   ";
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

    /*public function diariosSempresencaByEmpresa($local = '') {
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
    }*/
    
    public function diariosSemPresenca($local = '') {

        if ($local == '') {
            $sql = "SELECT 
                            (select id from local_curso where id = local_curso_id ) as cod,
                            (select nome from curso C, local_curso LC where LC.curso_id = C.id and LC.id = local_curso_id) as curso,
                            (select local from local L, local_curso LC where LC.local_id = L.id and LC.id = local_curso_id) as local,
                            (SELECT nome from professor where id = professor_id) as monitor,
                            (select fantasia from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id) as empresa,
                            (select DATE_FORMAT(data_inicio,'%d/%m/%Y') from local_curso where id = local_curso_id ) as inicio,
                            (select DATE_FORMAT(data_termino,'%d/%m/%Y') from local_curso where id = local_curso_id ) as termino,
                            DATE_FORMAT(data_aula,'%d/%m/%Y') as data_do_diario
                         FROM local_curso LC, diario_classe DC 
                         WHERE DC.local_curso_id = LC.id 
                         AND LC.data_inicio < CURRENT_DATE
                         AND DC.data_aula < fun_subtrai_data(CURRENT_DATE)
                         AND LC.status <= 2
                         AND DC.id NOT IN(SELECT diario_classe_id  FROM diario_classe_aluno)";
        } else {
            $sql = "SELECT 
                           (select id from local_curso where id = local_curso_id ) as cod,
                            (select nome from curso C, local_curso LC where LC.curso_id = C.id and LC.id = local_curso_id) as curso,
                            (select local from local L, local_curso LC where LC.local_id = L.id and LC.id = local_curso_id) as local,
                            (SELECT nome from professor where id = professor_id) as monitor,
                            (select fantasia from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id) as empresa,
                            (select DATE_FORMAT(data_inicio,'%d/%m/%Y') from local_curso where id = local_curso_id ) as inicio,
                            (select DATE_FORMAT(data_termino,'%d/%m/%Y') from local_curso where id = local_curso_id ) as termino,
                            DATE_FORMAT(data_aula,'%d/%m/%Y') as data_do_diario
                         FROM local_curso LC, diario_classe DC 
                         WHERE DC.local_curso_id = LC.id 
                         AND LC.data_inicio < CURRENT_DATE
                         AND DC.data_aula < fun_subtrai_data(CURRENT_DATE)
                         AND LC.status <= 2
                         AND DC.id NOT IN(SELECT diario_classe_id  FROM diario_classe_aluno) 
                         AND local_curso_id = LC.id and local_curso_id = " . $local . "
                        ";
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

    /*public function diariosSemPresenca($local = '') {

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
    }*/

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
                    (select nome from curso C where curso_id = C.id LIMIT 1) as curso,
                    (select local from local L where local_id = L.id LIMIT 1) as local,
                    vagas,
                    (select count(*) from local_curso_aluno where local_curso_id = LC.id LIMIT 1) as quantidade,
                    
                    (select count(id) from local_curso_aluno where id = local_curso_id LIMIT 1) as inscritos,
                    DATE_FORMAT(data_inicio,'%d/%m/%Y')  as inicio,
                    DATE_FORMAT(data_termino,'%d/%m/%Y')  as termino

                    from local_curso LC
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
