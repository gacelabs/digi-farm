<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Marketplace';

$route['dashboard'] = 'Dashboard';
$route['inventory'] = 'Dashboard/inventory';
$route['save-product'] = 'Dashboard/save_product';
$route['save-product/(:num)'] = 'Dashboard/save_product/$1';
$route['profile'] = 'Dashboard/profile';
$route['profile/(:num)'] = 'Dashboard/profile/$1';
$route['farm'] = 'Dashboard/my_farm';
$route['settings'] = 'Dashboard/settings';

$route['dashboard/admin'] = 'Admin/index';
$route['dashboard/admin/login'] = 'Admin/login';
$route['dashboard/admin/sign_out'] = 'Admin/sign_out';

$route['login'] = 'Account/index';
$route['sign_in'] = 'Account/sign_in';
$route['sign_up'] = 'Account/sign_up';
$route['sign_out'] = 'Account/sign_out';

$route['cart'] = 'FarmCart/index';
$route['cart/add'] = 'FarmCart/add';
$route['cart/remove/(:any)'] = 'FarmCart/remove/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/