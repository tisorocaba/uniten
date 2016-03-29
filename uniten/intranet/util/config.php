<?php 
ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
session_start();
header("Content-Type: text/html; charset=utf-8",true);

ini_set('display_errors', 'On');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);

/* titulos */
define('TITLE',   'UNITE');
define('TITLEADM',   'ADM');
define('TITLERODAPE',   'Copyright UNITE 2011');

/* Variaveis de local */
//define('BASEDIR',  'C:/xampp/htdocs/uniten2015');
//define('BASEURL',  'http://uniten2015.dev');

define('BASEDIR',  'E:/Default/uniten/intranet');
define('BASEURL',  'http://www.sorocaba.sp.gov.br/uniten');



/*
define('BASEDIR',  '/home/unitesor/public_html');
define('BASEURL',  'http://unite.sorocaba.sp.gov.br');
*/
define('BASEFILE',  BASEDIR.'/files/');
define('URLARQ',   BASEURL.'/files/');

/* Caminhos */
require_once BASEDIR . '/../application/libraries/lumine/Lumine.php';
require_once BASEDIR . '/util/funcoes.php';
require_once BASEDIR . '/../lumine-conf.php';
require_once BASEDIR . '/dao/logDao.php';
require_once BASEDIR . '/util/security.php';

$cfg = new Lumine_Configuration( $lumineConfig );

$limit = 25;


register_shutdown_function( array($cfg->getConnection(), 'close') );

function __autoload( $clname )
{
	Lumine::import( $clname );
}



