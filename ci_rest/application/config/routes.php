<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'books';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


/**
* REST Service from Books
*/

//GET - SELECT * (todos)
$route["books"]["get"] = "books/index";

//GET - SELECT WHERE (específico)
$route["books/(:num)"]["get"] = "books/find/$1";

//POST - INSERT
$route["books"]["post"] = "books/index";

//PUT - EDIT (específico)
$route["books/(:num)"]["put"] = "books/index/$1";

//DELETE - REMOVE (específico)
$route["books/(:num)"]["delete"] = "books/index/$1";