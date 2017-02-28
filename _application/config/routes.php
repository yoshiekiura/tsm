<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "page/frontend";
//$route['default_controller'] = "auth/login";
$route['404_override'] = 'page/frontend/error';

$route[_backend_login_uri] = "auth/login";
$route[_backend_logout_uri] = "auth/logout";
$route[_backend_login_uri . '/(:any)'] = "auth/login/$1";
$route[_backend_logout_uri . '/(:any)'] = "auth/logout/$1";
$route['member'] = "voffice/login";

$route['media/assets/images/(:any)'] = "media/images/get_image/$1";
$route['cron/(:any)'] = "_cron/$1";
$route['_cron/(:any)'] = "_cron/$1";
$route['api/(:any)'] = "service_api/$1";
$route['rekap/(:any)'] = "rekap/$1";
$route['voffice/(:any)'] = "voffice/$1";
$route['backend/([a-zA-Z_-]+)/(:any)'] = "$1/backend/$2";
$route['backend/([a-zA-Z_-]+)'] = "$1/backend";
$route['backend_service/([a-zA-Z_-]+)/(:any)'] = "$1/backend_service/$2";
$route['backend_service/([a-zA-Z_-]+)'] = "$1/backend_service";
$route['auth/(:any)'] = "auth/$1";
$route['([a-zA-Z_-]+)/(:any)'] = "$1/frontend/$2";
$route['([a-zA-Z_-]+)'] = "$1/frontend";


/* End of file routes.php */
/* Location: ./application/config/routes.php */