<?php
defined('BASEPATH') or exit('No direct script access allowed');

// default
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// auth
$route['login'] = 'auth';
$route['logout'] = 'auth/logout';

// akses user
$route['user/akses'] = 'akses';
$route['user/tambah_akses'] = 'akses/tambah';
$route['user/hapus_akses/(:any)'] = 'akses/hapus/$1';
$route['user/ubah_akses/(:any)'] = 'akses/ubah/$1';
$route['user/ubah_akses_role/(:any)/(:any)'] = 'akses/ubah_akses/$1/$2';
