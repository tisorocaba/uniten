<?php

//require_once 'C:/xampp/htdocs/unite/intranet/util/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/uniten/intranet/util/conn.php';

class ProcessoDao {

    private $conn;

    public function __construct() {
        $this->conn = new Mysql();
        $this->conn->connect();
    }

    public function __destruct() {
        $this->conn->close();
    }

    public function escape($str) {
        return $this->conn->escape($str);
    }

    public function gravaProcesso($data, $hora, $empresa, $aluno, $status, $setor='', $id='') {
        if ($id == '') {
            $sql = "insert into unite_emprega_processo(aluno_id,unite_emprega_id,data,hora,setor,status) values(" . $aluno . "," . $empresa . ",'" . $data . "','" . $hora . "','" . $setor . "'," . $status . ")";
        } else {
            $sql = "update unite_emprega_processo set data='" . $data . "',setor='" . $setor . "',status=" . $status . " where id=" . $id;
        }

        $this->conn->query($sql);
        return $this->conn->getId();
    }

    public function recuperaProcesso($processo) {
        $sql = "select aluno_id as aluno,data from unite_emprega_processo where id=" . $processo;
        $rs = $this->conn->query($sql);
        $row = $this->conn->fetch($rs);
        $this->conn->free($rs);
        return $row;
    }

    public function removerProcesso($processo) {
        $sql = "delete from unite_emprega_processo where id=" . $processo;
        $this->conn->query($sql);
        $sql = "delete from unite_emprega_processo_alteracao where processo_id=" . $processo;
        $this->conn->query($sql);
    }

    public function emProcesso($empresa, $aluno, $status='') {
        if ($status != '') {
            $sql = "select status from unite_emprega_processo where unite_emprega_id=" . $empresa . " and aluno_id =" . $aluno . " and status = " . $status;
        } else {
            $sql = "select status from unite_emprega_processo where unite_emprega_id=" . $empresa . " and aluno_id =" . $aluno . " order by id desc limit 1";
        }
        $rs = $this->conn->query($sql);
        $row = $this->conn->fetch($rs);
        $this->conn->free($rs);
        return $row['status'];
    }

    public function listaProcessos($empresa, $aluno) {
        $sql = "select id from unite_emprega_processo where unite_emprega_id=" . $empresa . " and aluno_id =" . $aluno;
        $rs = $this->conn->query($sql);
        $lista = array();
        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
        }
        return $lista;
    }

    public function verificaStatus($aluno, $empresa, $status) {
        $sql = "select status  from unite_emprega_processo where aluno_id = " . $aluno . " and unite_emprega_id = " . $empresa . "  and STATUS > " . $status . " order by status desc limit 1";
        $rs = $this->conn->query($sql);
        $row = $this->conn->fetch($rs);
        $this->conn->free($rs);
        return $row['status'];
    }

    public function registraAlteracaoStatus($aluno, $empresa, $data, $de, $para, $processo) {
        $sql = "insert into unite_emprega_processo_alteracao(aluno_id,empresa_id,data,status_de,status_para,processo_id) values(" . $aluno . "," . $empresa . ",'" . $data . "'," . $de . "," . $para . "," . $processo . ")";
        $this->conn->query($sql);
    }

    public function listaAlteracaoProcesso($processo) {
        $sql = "select * from unite_emprega_processo_alteracao where processo_id=" . $processo;
        $rs = $this->conn->query($sql);
        $lista = array();
        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
        }
        return $lista;
    }

    public function alunosProcesso($empresa, $status, $offset='') {

        $sql = "select *,
                       (select nome from aluno where id=aluno_id) as nome, aluno_id as cod     
                from unite_emprega_processo where unite_emprega_id =" . $empresa . " and status = " . $status;
        if (!empty($offset)) {
            if ((int) $offset === 0) {
                $sql .= " LIMIT 0,25";
            } else {
                $sql .= " LIMIT " . (int) $offset . ",25";
            }
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

}

?>
