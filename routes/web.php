<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();



//Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
	//Route::get('/home', 'HomeController@index')->name('home');
	//Route::get('/admin', 'Admin\AdminController@index')->name('home');
	Route::get('/request/product',['uses'=>'Product\\ProductsController@productinfo']);
	

	Route::prefix('admin')->group(function () {
		Route::get('/', 'Admin\AdminController@index');
		Route::get('/tickets', 'Admin\AdminController@tickets');

		Route::get('/pendientes_entregas', 'Admin\AdminController@pendientes_entregas');
		Route::get('/ventas', 'Admin\AdminController@ventas');
		Route::get('/ventas_publico', 'Admin\AdminController@ventas_publico');
		Route::get('/inventario', 'Admin\AdminController@inventario');

		Route::get('/abono/{id}', 'Admin\AdminController@abono');
		Route::patch('/abono_set/{id}', 'Admin\AdminController@abono_set');

		Route::resource('/roles', 'Admin\RolesController');
		Route::resource('/permissions', 'Admin\PermissionsController');
		Route::resource('/users', 'Admin\UsersController');
		Route::resource('/pages', 'Admin\PagesController');
		Route::resource('/activitylogs', 'Admin\ActivityLogsController')->only([
			'index', 'show', 'destroy'
		]);

		Route::resource('/settings', 'Admin\SettingsController');
		Route::get('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
		Route::post('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);

	});

	Route::resource('product/products', 'Product\\ProductsController');
	Route::resource('stat/stats', 'Stat\\StatsController');
	Route::resource('type_client/type-clients', 'TypeClient\\TypeClientsController');
	Route::resource('client/clients', 'Client\\ClientsController');
	Route::resource('warehouse/warehouses', 'warehouse\\WarehousesController');
	Route::resource('inventory/inventories', 'Inventory\\InventoriesController');
	Route::resource('order_client/order-clients', 'OrderClient\\OrderClientsController');
	Route::get('order_client/order_clients/delete',['uses'=>'OrderClient\\OrderClientsController@delete_product_edit']);
	

	Route::resource('order/orders', 'Order\\OrdersController');

	Route::get('order/venta_publico',['uses'=>'Order\\OrdersController@venta_publico']);

	//Route::resource('public_sale/public-sales', 'PublicSale\\PublicSalesController');
	Route::resource('public_sales/public-sales', 'PublicSale\\PublicSalesController');
});



