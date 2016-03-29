<?php

class Mysql {

    private $link;

    function __construct() {
        $this->connect();
    }

    function __destruct() {
        $this->close();
    }

    function connect() {
        $this->host = "localhost";       // <<<< ALTERE AQUI
        $this->user = "usuário_aqui";  // <<<< ALTERE AQUI
        $this->pass = "senha_aqui";  // <<<< ALTERE AQUI
        $this->db   = "portal_uniten";
         
        $this->link = mysql_connect($this->host, $this->user, $this->pass);
        mysql_select_db($this->db);
        mysql_set_charset('utf8', $this->link);
    }

    function query($query) {
        $result = mysql_query($query, $this->link) or die('ERRO SQL');
        return $result;
    }

    function close() {
        // mysql_close ( @$this->link );
    }

    function getId() {
        return mysql_insert_id();
    }

    function countRow($rs) {
        return mysql_num_rows($rs);
    }

    function fetch($rs,$type='') {

        if($type==''){
            return mysql_fetch_array($rs);
        }else{
            return mysql_fetch_array($rs,$type);
        }
        
    }

    function free($rs) {
        return mysql_free_result($rs);
    }

    function fetchAssoc($rs) {
        return mysql_fetch_assoc($rs);
    }

    function object($rs) {
        return mysql_fetch_object($rs);
    }

    function escape($str) {
        return mysql_real_escape_string($str);
    }

    function testConn() {
        try {
            $this->connect();
        } catch (Exception $e) {
            throw new Exception("Error na conn");
        }
    }

}
