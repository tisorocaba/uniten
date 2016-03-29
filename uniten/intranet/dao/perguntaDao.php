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


class PerguntaDao {

    private $conn;

    public function PerguntaDao() {
        $this->conn = new Mysql();
        $this->conn->connect();
    }

    public function __destruct() {
        $this->conn->close();
    }
    
    
    public function listaPerguntas($questionario) {
        $lista = array();
        $rs = $this->conn->query("SELECT id,titulo,tipo FROM pergunta_curso  WHERE questionario ='".$questionario."' ORDER BY id ASC");

        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
        }
        return $lista;
    }
    
    
    public function getProtocolo($agenda,$aluno) {
       $rs = $this->conn->query("SELECT id FROM resposta_protocolo where local_curso_id = ".$agenda." and aluno_id = ".$aluno);
        return $this->conn->countRow($rs);
    }
    
    public function getProtocoloById($id) {
       $rs = $this->conn->query("SELECT local_curso_id as agenda, aluno_id as aluno FROM resposta_protocolo where id = ".$id);
        return $this->conn->fetch($rs);
    }
    
    public function getComentario($protocolo) {
       $rs = $this->conn->query("SELECT comentario FROM resposta_comentario where resposta_protocolo_id = ".$protocolo);
       $row = $this->conn->fetch($rs);
       $this->conn->free($rs);
       return $row['comentario'];
    }
    
    public function getResposta($protocolo,$pergunta) {
       $rs = $this->conn->query("SELECT resposta FROM resposta_curso where resposta_protocolo_id = ".$protocolo." and pergunta_curso_id=".$pergunta);
        return $this->conn->fetch($rs);
    }
    
     public function gravaProtocolo($agenda,$aluno) {
        $sql = "insert into resposta_protocolo(local_curso_id,aluno_id) values(".$agenda.",".$aluno.")";
        $this->conn->query($sql);
        return $this->conn->getId();
    }
    
     public function gravaComentario($protocolo,$comentario) {
        $sql = "insert into resposta_comentario(resposta_protocolo_id,comentario) values(".$protocolo.",'".$comentario."')";
        $this->conn->query($sql);
        
    }
    
     public function gravaResposta($protocolo,$pergunta,$resposta) {
        $sql = "insert into resposta_curso(resposta_protocolo_id,pergunta_curso_id,resposta) values(".$protocolo.",'".$pergunta."','".$resposta."')";
        $this->conn->query($sql);
       
    }
    
    public function gravaRespostaProfessor($agenda,$pergunta,$resposta) {
        $sql = "insert into resposta_professor(local_curso_id,pergunta_curso_id,resposta) values(".$agenda.",'".$pergunta."','".$resposta."')";
        $this->conn->query($sql);
       
    }
    
    
    public function verificaRespostaProfessor($agenda,$pergunta,$resposta) {
        $sql = "select id from resposta_professor where local_curso_id ='".$agenda."' and pergunta_curso_id='".$pergunta."' and resposta='".$resposta."'";
        $rs = $this->conn->query($sql);
        
        
        if($this->conn->countRow($rs)>0){
          return 'checked="checked"';    
        }else{
           return '';
        }
       
    }
    
   public function removerRespostaProfessor($agenda){
        $sql = "delete from resposta_professor where local_curso_id =".$agenda;
        $this->conn->query($sql);
   }
    
         
    // nao finalizado
    public function listaRespostas($agenda) {
        $lista = array();
        $rs = $this->conn->query("SELECT id,aluno_id FROM resposta_protocolo WHERE local_curso_id = ".$agenda." ORDER BY id ASC");

        if ($this->conn->countRow($rs) > 0) {
            while ($obj = $this->conn->object($rs)) {
                $lista[] = $obj;
            }
        }
        return $lista;
    }
    
   

    public function escape($var) {
        return $this->conn->escape($var);
    }

}

?>
