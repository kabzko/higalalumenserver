<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/print_receipt', 'APIController@print_receipt');
$router->get('/open_cash_drawer', 'APIController@open_cash_drawer');
$router->post('/super_admin_login', 'APIController@super_admin_login');
$router->post('/load_profiles', 'APIController@load_profiles');
$router->post('/profile_login', 'APIController@profile_login');
$router->post('/end_session', 'APIController@end_session');
$router->post('/load_inventory_by_store', 'APIController@load_inventory_by_store');
$router->post('/checkout_purchase', 'APIController@checkout_purchase');
$router->post('/load_attendance_by_store', 'APIController@load_attendance_by_store');
$router->post('/load_inventory_cart', 'APIController@load_inventory_cart');
$router->post('/load_selected_receipt', 'APIController@load_selected_receipt');
$router->post('/add_new_product', 'APIController@add_new_product');
$router->post('/new_profile', 'APIController@new_profile');
$router->post('/change_profile_name', 'APIController@change_profile_name');
$router->post('/update_pin', 'APIController@update_pin');
$router->post('/delete_profile', 'APIController@delete_profile');
$router->post('/update_product_details', 'APIController@update_product_details');
$router->post('/update_product_discount', 'APIController@update_product_discount');
$router->post('/load_store_admin', 'APIController@load_store_admin');
$router->post('/load_tax', 'APIController@load_tax');
$router->post('/update_vat_value', 'APIController@update_vat_value');
$router->post('/load_sales_analysis', 'APIController@load_sales_analysis');
$router->post('/load_stock_delivery_logs', 'APIController@load_stock_delivery_logs');
$router->post('/change_super_admin', 'APIController@change_super_admin');
$router->post('/record_product_stock', 'APIController@record_product_stock');
$router->post('/customers_name', 'APIController@customers_name');
$router->post('/load_category', 'APIController@load_category');
$router->post('/load_supplier', 'APIController@load_supplier');
$router->post('/products_leaderboard', 'APIController@products_leaderboard');
$router->post('/load_total_sales', 'APIController@load_total_sales');
$router->post('/load_bad_orders', 'APIController@load_bad_orders');
$router->post('/deduct_bad_stocks', 'APIController@deduct_bad_stocks');
$router->post('/load_store_credit', 'APIController@load_store_credit');
$router->post('/load_system_printers', 'APIController@load_system_printers');
$router->post('/daily_sales_info', 'APIController@daily_sales_info');
$router->post('/load_store_expenses', 'APIController@load_store_expenses');
$router->post('/record_expenses', 'APIController@record_expenses');
$router->post('/delete_record_expense', 'APIController@delete_record_expense');
$router->post('/load_logs', 'APIController@load_logs');
$router->post('/delete_record_stock_delivery', 'APIController@delete_record_stock_delivery');
$router->post('/delete_record_bad_order', 'APIController@delete_record_bad_order');
$router->post('/search_name_unpaid', 'APIController@search_name_unpaid');
$router->post('/search_name_paid', 'APIController@search_name_paid');
