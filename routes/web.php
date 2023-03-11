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

use \Illuminate\Support\Facades\Route;


Route::get('/logout', array('uses' => 'UserController@logout'));

Route::get('/', array('uses' => 'Auth\LoginController@index', 'as' => 'welcome'));

Auth::routes();

Route::get('admin', function () {
    return view('admin_template');
});

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/denied', 'UserController@accessDenied')->middleware('auth');
Route::get('/users', 'UserController@users');


Route::group(['middleware' => ['auth'], 'prefix' => 'user', 'as' => 'user'], function () {
    Route::get('/create', ['as' => 'create', 'uses' => 'UserController@index', 'middleware' => 'roles', 'roles' => ['Admin', 'manager']]);
    Route::post('/save', ['as' => 'save', 'uses' => 'UserController@saveUser', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::get('/list', ['as' => 'list', 'uses' => 'UserController@userList']);
    Route::any('/search', ['as' => 'search', 'uses' => 'UserController@search']);
    Route::post('/update', ['as' => 'update', 'uses' => 'UserController@updateUser', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::get('/role/create', ['as' => 'role/create', 'uses' => 'UserController@createRole', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::post('/role/save', ['as' => 'role/save', 'uses' => 'UserController@saveRole', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::get('/role/list', ['as' => 'role/list', 'uses' => 'UserController@roleList', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::get('/permission', ['as' => 'permission', 'uses' => 'UserController@permission', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::post('/role/assign', ['as' => 'role/assign', 'uses' => 'UserController@assignRoles', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::any('/role/search', ['as' => 'role/search', 'uses' => 'UserController@searchUserForRole', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::get('/profile', ['as' => 'profile', 'uses' => 'UserController@userProfile']);
    Route::get('/locationlist', ['as' => 'locationlist', 'uses' => 'UserController@getLocations']);

});

Route::group(['middleware' => ['auth'], 'prefix' => 'location', 'as' => 'location'], function () {
    Route::get('/index', ['as' => 'index', 'uses' => 'LocationController@locationList']);
    Route::get('/create', ['as' => 'create', 'uses' => 'LocationController@index', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::post('/save', ['as' => 'save', 'uses' => 'LocationController@saveLocation', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::any('/search', ['as' => 'search', 'uses' => 'LocationController@search']);
    Route::post('/update', ['as' => 'update', 'uses' => 'LocationController@updateLocation', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::get('/alllocations', ['as' => 'alllocations', 'uses' => 'LocationController@getLocations']);
});

Route::group(['prefix' => 'supplier', 'as' => 'supplier'], function () {
    Route::get('/index', ['as' => 'index', 'uses' => 'SupplierController@supplierList', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::get('/create', ['as' => 'create', 'uses' => 'SupplierController@index', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::post('/save', ['as' => 'save', 'uses' => 'SupplierController@saveSupplier', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::any('/search', ['as' => 'search', 'uses' => 'SupplierController@search', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::get('/list', ['as' => 'list', 'uses' => 'SupplierController@getSupplierList', 'middleware' => 'roles', 'roles' => ['Admin']]);
    Route::post('/update', ['as' => 'update', 'uses' => 'SupplierController@updateSupplier', 'middleware' => 'roles', 'roles' => ['Admin']]);
});

Route::group(['middleware' => ['auth'], 'prefix' => 'product', 'as' => 'product'], function () {
    Route::get('/create', ['as' => 'index', 'uses' => 'ProductController@index', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::post('/category/save', ['as' => 'category', 'uses' => 'ProductController@categorySave', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::post('/brand/save', ['as' => 'brand', 'uses' => 'ProductController@brandSave', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::post('/save', ['as' => 'save', 'uses' => 'ProductController@saveProduct', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/category/list', ['as' => 'category/list', 'uses' => 'ProductController@getCategoryList', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/brand/list', ['as' => 'brand/list', 'uses' => 'ProductController@getBrandList', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/taxProfile', ['as' => 'taxProfile', 'uses' => 'ProductController@getTaxProfiles', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/list', ['as' => 'list', 'uses' => 'ProductController@productList', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::any('/search', ['as' => 'search', 'uses' => 'ProductController@search', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::post('/update', ['as' => 'update', 'uses' => 'ProductController@updateProduct', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);

});


Route::group(['middleware' => ['auth'], 'prefix' => 'po', 'as' => 'po'], function () {
    Route::get('/index', ['as' => 'index', 'uses' => 'PoController@index', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::post('/productlist', ['as' => 'productlist', 'uses' => 'PoController@getProductList', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::post('/save', ['as' => 'productlist', 'uses' => 'PoController@savePo', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/list', ['as' => 'list', 'uses' => 'PoController@poList', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/approve/{id}', ['as' => 'approve', 'uses' => 'PoController@approvePo', 'middleware' => 'roles', 'roles' => ['admin', 'manager']]);
    Route::get('/reject/{id}', ['as' => 'reject', 'uses' => 'PoController@rejectPo', 'middleware' => 'roles', 'roles' => ['admin', 'manager']]);
    Route::get('/view/{id}', ['as' => 'view', 'uses' => 'PoController@poView', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/search', ['as' => 'search', 'uses' => 'PoController@searchPo', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
});


Route::group(['middleware' => ['auth'], 'prefix' => 'stock', 'as' => 'stock'], function () {
    Route::get('/add', ['as' => 'index', 'uses' => 'GrnController@index', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::post('/productlist', ['as' => 'productlist', 'uses' => 'GrnController@getProductList', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::post('/save', ['as' => 'save', 'uses' => 'GrnController@saveGrn', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/user', ['as' => 'user', 'uses' => 'UserController@getUser', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/list', ['as' => 'user', 'uses' => 'GrnController@grnList', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/view/{id}', ['as' => 'view', 'uses' => 'GrnController@grnView', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/approve/{id}', ['as' => 'approve', 'uses' => 'GrnController@approveGrn', 'middleware' => 'roles', 'roles' => ['admin', 'manager']]);
    Route::get('/reject/{id}', ['as' => 'reject', 'uses' => 'GrnController@rejectGrn', 'middleware' => 'roles', 'roles' => ['admin', 'manager']]);
    Route::get('/search', ['as' => 'search', 'uses' => 'GrnController@searchGrn', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/gtns', ['as' => 'gtns', 'uses' => 'GrnController@loadGtns']);
    Route::post('/accept', ['as' => 'accept', 'uses' => 'GrnController@acceptGtn', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);

});


Route::group(['middleware' => ['auth'], 'prefix' => 'issues', 'as' => 'issues'], function () {
    Route::get('/create', ['as' => 'index', 'uses' => 'GtnController@index', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::post('/productlist', ['as' => 'productlist', 'uses' => 'GtnController@getProductList', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::post('/save', ['as' => 'save', 'uses' => 'GtnController@saveGtn', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/list', ['as' => 'save', 'uses' => 'GtnController@gtnList', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/search', ['as' => 'search', 'uses' => 'GtnController@searchGtn', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/view/{id}', ['as' => 'view', 'uses' => 'GtnController@gtnView', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/approve/{id}', ['as' => 'approve', 'uses' => 'GtnController@approveGtn', 'middleware' => 'roles', 'roles' => ['admin', 'manager']]);
    Route::get('/reject/{id}', ['as' => 'reject', 'uses' => 'GtnController@rejectGtn', 'middleware' => 'roles', 'roles' => ['admin', 'manager']]);
    Route::get('/locationlist', ['as' => 'locationlist', 'uses' => 'GtnController@getLocations']);
});

Route::group(['middleware' => ['auth'], 'prefix' => 'invoice', 'as' => 'invoice'], function () {
    Route::get('/create', ['as' => 'index', 'uses' => 'InvoiceController@index', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::post('/save', ['as' => 'index', 'uses' => 'InvoiceController@saveInvoice', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::post('/productlist', ['as' => 'productlist', 'uses' => 'InvoiceController@getProductList']);
    Route::get('/list', ['as' => 'list', 'uses' => 'InvoiceController@invoiceList', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/view/{id}', ['as' => 'view', 'uses' => 'InvoiceController@viewInvoice', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/void/{id}', ['as' => 'void', 'uses' => 'InvoiceController@voidInvoice', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);

});

Route::group(['middleware' => ['auth'], 'prefix' => 'reports', 'as' => 'reports'], function () {
    Route::get('/index', ['as' => 'index', 'uses' => 'ReportController@index', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/stock', ['as' => 'stock', 'uses' => 'ReportController@stockReport', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/valuation', ['as' => 'stock', 'uses' => 'ReportController@valuationReport', 'middleware' => 'roles', 'roles' => ['admin', 'manager']]);
    Route::get('/stock/search', ['as' => 'stock', 'uses' => 'ReportController@search']);
    Route::get('/poReport', ['as' => 'poReport', 'uses' => 'ReportController@poReport', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/grnReport', ['as' => 'grnReport', 'uses' => 'ReportController@grnReport', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/gtnReport', ['as' => 'gtnReport', 'uses' => 'ReportController@gtnReport', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/salesReport', ['as' => 'salesReport', 'uses' => 'ReportController@salesReport', 'middleware' => 'roles', 'roles' => ['admin', 'manager']]);
    Route::get('/binCard', ['as' => 'binCard', 'uses' => 'ReportController@binCard', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('downloadExcel/{type}', 'ReportController@downloadExcel');
    Route::get('/stockSupplier', ['as' => '/stockSupplier', 'uses' => 'ReportController@stockBySuppllier']);
    Route::get('/supplier/search', ['as' => '/supplier/search', 'uses' => 'ReportController@searchStockBySuppllier', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/stockLocation', ['as' => '/stockLocation', 'uses' => 'ReportController@stockByLocation', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/saleProduct', ['as' => '/saleProduct', 'uses' => 'ReportController@salesByProduct', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
    Route::get('/saleSupplier', ['as' => '/saleSupplier', 'uses' => 'ReportController@salesBySupplier', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);

});


//Route::group(['middleware' => ['auth'], 'prefix' => 'return', 'as' => 'return'], function () {
//    Route::get('/index', ['as' => 'index', 'uses' => 'ReturnController@index', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
//    Route::post('/save', ['as' => 'save', 'uses' => 'ReturnController@saveReturn', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
//    Route::get('/list', ['as' => 'list', 'uses' => 'ReturnController@returnList', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
//    Route::get('/search', ['as' => 'search', 'uses' => 'ReturnController@searchReturn', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
//    Route::get('/view/{id}', ['as' => 'search', 'uses' => 'ReturnController@returnView', 'middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']]);
//    Route::get('/approve/{id}', ['as' => 'approve', 'uses' => 'ReturnController@approveReturn', 'middleware' => 'roles', 'roles' => ['admin', 'manager']]);
//    Route::get('/reject/{id}', ['as' => 'approve', 'uses' => 'ReturnController@rejectReturn', 'middleware' => 'roles', 'roles' => ['admin', 'manager']]);
//});

Route::group(['prefix' => 'return'], function () {
    Route::get('/new-return', 'ReturnController@newReturn')->name('new.return');
    Route::post('/product-list','ReturnController@getProductList')->name('srn.productList');
    Route::post('/save-return','ReturnController@saveReturn')->name('srn.save');
    Route::get('/index','ReturnController@srns')->name('srn.list');
    Route::post('/srn-search','ReturnController@searchSrn')->name('srn.search');
    Route::get('/srn-approve/{id}','ReturnController@approveSrn')->name('srn.approve');
    Route::get('/srn-reject/{id}','returnController@rejectSrn')->name('srn.reject');
    Route::get('/return-view/{srn}','returnController@viewReturn')->name('srn.view');
});


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
