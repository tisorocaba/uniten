<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['noticias']                 = 'noticias/index';
$route['noticias/(:num)']          = 'noticias/detalhe/$1';
$route['noticias/(:num)/(:any)']   = 'noticias/detalhe/$1';

$route['eventos']                  = 'eventos/index';
$route['eventos/(:num)']           = 'eventos/detalhe/$1';
$route['eventos/(:num)/(:any)']    = 'eventos/detalhe/$1';

$route['resultados']               = 'resultados/index';
$route['resultados/(:num)']        = 'resultados/detalhe/$1';
$route['resultados/(:num)/(:any)'] = 'resultados/detalhe/$1';

$route['faleconosco']  = 'contato/formulario';
$route['localizacao']  = 'contato/localizacao';

$route['servicos/(:num)/(:any)'] = 'servicos/detalhe/$1';

$route['cursos'] = 'cursos/index';
$route['cursos/(:num)/(:num)/(:any)'] = 'cursos/descricao/$1/$2/$3';

$route['inscricoes-em-andamento'] = 'cursos/cursos_abertos';

$route['servicos/(:num)/(:any)'] = 'servicos/detalhe/$1';
$route['manual-do-aluno'] = 'servicos/detalhe/4';

$route['anuario'] = 'servicos/detalhe/13';

/* End of file routes.php */
/* Location: ./application/config/routes.php */