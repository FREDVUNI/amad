<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* Apis routes*/
$route['api/brand'] = 'api/Brand/index_get';
$route['api/brand/add'] = 'api/Brand/index_post';
$route['api/brand/delete'] = 'api/Brand/index_delete';
$route['api/brand/update'] = 'api/Brand/index_put';

$route['api/events'] = 'api/Event/index_get';

$route['api/category'] = 'api/Category/index_get';
$route['api/category/add'] = 'api/Category/index_post';
$route['api/category/delete'] = 'api/Category/index_delete';
$route['api/category/update'] = 'api/Category/index_put';
/* Apis routes*/

/*backend routes*/
$route['admin/login'] = 'backend/Auth/login';
$route['admin/logout']="backend/Auth/logout";
$route['admin/index'] = 'backend/Admin/index';
$route['admin/forgot-password'] = 'backend/Auth/forgotpassword';
$route['admin/404']="backend/Admin/error404";

$route['admin/register'] = 'backend/User/register';
$route['admin/users'] = 'backend/User/users';
$route['admin/changepassword'] = 'backend/User/changePassword';
$route['admin/profile'] = 'backend/User/index';

$route['admin/categories'] = 'backend/Category/index';
$route['admin/add/category'] = 'backend/Category/add';
$route['admin/category/(:any)'] = 'backend/Category/edit/$1';
$route['admin/delete/category/(:any)']="backend/Category/delete/$1";

$route['admin/services'] = 'backend/Service/index';
$route['admin/add/service'] = 'backend/Service/add';
$route['admin/service/(:any)'] = 'backend/Service/edit/$1';
$route['admin/delete/service/(:any)']="backend/Service/delete/$1";

$route['admin/slider'] = 'backend/Slider/index';
$route['admin/add/slider'] = 'backend/Slider/add';
$route['admin/slider/(:any)'] = 'backend/Slider/edit/$1';
$route['admin/delete/slider/(:any)']="backend/Slider/delete/$1";

$route['admin/icons'] = 'backend/Icon/index';
$route['admin/add/icon'] = 'backend/Icon/add';
$route['admin/icon/(:any)'] = 'backend/Icon/edit/$1';
$route['admin/delete/icon/(:any)'] = 'backend/Icon/delete/$1';

$route['admin/brands'] = 'backend/Brand/index';
$route['admin/add/brand'] = 'backend/Brand/add';
$route['admin/brand/(:any)'] = 'backend/Brand/edit/$1';
$route['admin/delete/brand/(:any)']="backend/Brand/delete/$1";

$route['admin/partners'] = 'backend/Partner/index';
$route['admin/add/partner'] = 'backend/Partner/add';
$route['admin/partner/(:any)'] = 'backend/Partner/edit/$1';
$route['admin/delete/partner/(:any)'] = 'backend/Partner/delete/$1';

$route['admin/amenities'] = 'backend/Leisure/index';
$route['admin/add/amenity'] = 'backend/Leisure/add';
$route['admin/amenity/(:any)'] = 'backend/Leisure/edit/$1';
$route['admin/amenity/delete/(:any)']="backend/Leisure/delete/$1";

$route['admin/events-and-parties'] = 'backend/Event/index';
$route['admin/add/events-and-parties'] = 'backend/Event/add';
$route['admin/event/(:any)'] = 'backend/Event/edit/$1';
$route['admin/delete/event/(:any)']="backend/Event/delete/$1";

$route['admin/sales-offers'] = 'backend/Offer/index';
$route['admin/add/sales-offer'] = 'backend/Offer/add';
$route['admin/offer/(:any)'] = 'backend/Offer/edit/$1';
$route['admin/delete/offer/(:any)']="backend/Offer/delete/$1";

$route['admin/subscriptions'] = 'backend/Subscription/index';
$route['admin/add/newsletter'] = 'backend/Subscription/newsletter';

/*backend routes*/

/*frontend routes*/
$route['default_controller'] = 'welcome';
$route['404_override'] = 'Custom404';
$route['translate_uri_dashes'] = FALSE;
/*frontend routes*/
