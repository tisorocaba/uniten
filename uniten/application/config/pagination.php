<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Pagination Config
 *
 * Just applying codeigniter's standard pagination config with twitter
 * bootstrap stylings
 *
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://codeigniter.com/user_guide/libraries/pagination.html
 * @email		mike@mikefunk.com
 *
 * @file		pagination.php
 * @version		1.3.1
 * @date		03/12/2012
 *
 * Copyright (c) 2011
 */

// --------------------------------------------------------------------------

// $config['base_url'] = '';
$config['per_page'] = LIMIT;
$config['uri_segment'] = 4;
$config['num_links'] = 6;
//$config['page_query_string'] = TRUE;
$config['use_page_numbers'] = TRUE;
//$config['query_string_segment'] = 'page';

$config['full_tag_open'] = '<div><ul class="pagination">';
$config['full_tag_close'] = '</ul></div>';

$config['first_link'] = '&laquo; Primeiro';
$config['first_tag_open'] = '<li class="first">';
$config['first_tag_close'] = '</li>';

$config['last_link'] = 'Último &raquo;';
$config['last_tag_open'] = '<li class="prev">';
$config['last_tag_close'] = '</li>';

$config['next_link'] = 'Próximo &rarr;';
$config['next_tag_open'] = '<li class="next">';
$config['next_tag_close'] = '</li>';

$config['prev_link'] = '&larr; Anterior';
$config['prev_tag_open'] = '<li class="last">';
$config['prev_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li class="current"><a href="javascript:;">[';
$config['cur_tag_close'] = ']</a></li>';

$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';

// $config['display_pages'] = FALSE;
// 
//$config['anchor_class'] = 'follow_link';

// --------------------------------------------------------------------------

/* End of file pagination.php */
/* Location: ./bookymark/application/config/pagination.php */
