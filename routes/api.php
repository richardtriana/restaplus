<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DetailOrderController;
use App\Http\Controllers\KitProductController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ImportProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\DetailBillingController;
use App\Http\Controllers\PrintOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ZoneController;
use App\Models\Configuration;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function () {

	Route::put('/users/changePassword',  [UserController::class, 'changePassword']);
	Route::get('/users/user-list', [UserController::class, 'listUsers'])->middleware('can:user.index');
	Route::resource('/users', UserController::class);
	Route::post('/users/{user}/activate',  [UserController::class, 'activate']);
	Route::post('/register', [UserController::class, 'register']);

	Route::post('/categories/{category}/activate',  [CategoryController::class, 'activate']);
	Route::get('/categories/category-list', [CategoryController::class, 'categoryList']);
	Route::resource('/categories', CategoryController::class);

	Route::resource('/taxes', TaxController::class);
	Route::post('/taxes/{tax}/activate',  [TaxController::class, 'activate']);

	Route::post('/brands/{brand}/activate',  [BrandController::class, 'activate']);
	Route::get('/brands/brand-list', [BrandController::class, 'brandList']);
	Route::resource('/brands', BrandController::class);

	Route::get('/print-order/{id}', [PrintOrderController::class, 'printTicket'])->middleware('can:order.index');
	Route::get('/print-payment-ticket/{order}', [PrintOrderController::class, 'printPaymentTicket'])->middleware('can:order.index');
	Route::get('/orders/generatePdf/{order}', [OrderController::class, 'generatePdf']);
	Route::get('/orders/generatePaymentPdf/{order}', [OrderController::class, 'generatePaymentPdf']);
	Route::resource('/orders',  OrderController::class);
	Route::resource('/order-details', DetailOrderController::class);

	Route::get('/billings/generatePdf/{billing}', [BillingController::class, 'generatePdf']);
	Route::resource('/billings',  BillingController::class);
	Route::resource('/billing-details', DetailBillingController::class);


	Route::get('/orders/byClient/{client_id}', [OrderController::class, 'creditByClient']);
	Route::post('/orders/payCreditByClient', [OrderController::class, 'payCreditByClient']);

	Route::resource('/products',  ProductController::class);
	Route::post('/products/{product}/activate',  [ProductController::class, 'activate']);
	Route::post('/products/search-product',  [ProductController::class, 'searchProduct']);
	Route::post('/products/filter-product-list',  [ProductController::class, 'filterProductList']);
	Route::post('/products/stock-update/{id}', [ProductController::class, 'updateStockById']);

	Route::resource('kit-products', KitProductController::class)->middleware('can:product.store');

	Route::resource('/suppliers',  SupplierController::class);
	Route::post('/suppliers/{supplier}/activate',  [SupplierController::class, 'activate']);
	Route::post('/suppliers/search-supplier',  [SupplierController::class, 'searchSupplier']);
	Route::post('/suppliers/filter-supplier-list',  [SupplierController::class, 'filterSupplierList']);

	Route::resource('/clients',  ClientController::class);
	Route::post('/clients/{client}/activate',  [ClientController::class, 'activate']);
	Route::post('/clients/search-client',  [ClientController::class, 'searchClient']);
	Route::post('/clients/filter-client-list',  [ClientController::class, 'filterClientList']);


	Route::get('/roles/getAllRoles', [RoleController::class, 'getAllRoles']);
	Route::resource('/roles', RoleController::class);
	Route::get('/permissions', [RoleController::class, 'getPermissions']);

	Route::get('/departments', [DepartmentController::class, 'index']);
	Route::get('/departments/{id}/getMunicipalities', [DepartmentController::class, 'getMunicipalitiesByDepartment']);

	Route::resource('/configurations', ConfigurationController::class)->except(['create', 'edit', 'destroy', 'show'])->middleware('can:configuration');;
	Route::get('/company-logo', function () {
		$configuration = new Configuration();
		$image = $configuration->select('logo')->first();
		return $image;
	});
	Route::post('/import/upload-file-import', [ImportProductController::class, 'uploadFile'])->middleware('can:product.store');

	Route::get('/reports/sales-report', [ReportController::class, 'reportSales']);
	Route::get('/reports/general-sales-report', [ReportController::class, 'reportGeneralSales']);
	Route::get('/reports/product-sales-report', [ReportController::class, 'reportProductSales']);
	Route::get('/reports/total-products-report', [ReportController::class, 'reportTotalProducts']);

	Route::get('/boxes/box-list', [BoxController::class, 'boxList']);
	Route::get('/boxes/byUser', [BoxController::class, 'getBoxesByUser']);
	Route::resource('/boxes', BoxController::class);
	Route::post('/boxes/{box}/activate', [BoxController::class, 'activate']);
	Route::post('/boxes/base/{box}', [BoxController::class, 'updateBase']);

	Route::get('/boxes/{box}/consecutiveAll', [BoxController::class, 'consecutiveAllByBox'])->middleware('can:box.index');
	Route::get('/boxes/{box}/getAssignUserByBox', [BoxController::class, 'getAssignUserByBox'])->middleware('can:box.index');
	Route::post('/boxes/{box}/toAssignUserByBox', [BoxController::class, 'toAssignUserByBox'])->middleware('can:box.store');

	Route::resource('/zones', ZoneController::class);
});
