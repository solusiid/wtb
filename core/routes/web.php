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

Route::get('/', [
    'middleware' => 'auth', 'as' => 'dashboard', 'uses' => 'CoreController@showDashboard'
]);
Route::get('auth/login', [
    'as' => 'login', 'uses' => 'CoreController@showLogin'
]);
Route::get('notification', [
    'as' => 'notification-user', 'uses' => 'CustomerController@showNotificationUser'
]);
Route::get('csrf', 'APIController@getCsrf');
Route::group(['prefix' => 'master'], function() {
	Route::get('brand', [
	    'as' => 'brand', 'uses' => 'CoreController@showMerk'
	]);
	Route::get('model', [
	    'as' => 'model', 'uses' => 'CoreController@showModel'
	]);
	Route::get('type', [
	    'as' => 'type', 'uses' => 'CoreController@showType'
	]);
	Route::get('mcategory', [
	    'as' => 'mcategory', 'uses' => 'CoreController@showMainCat'
	]);
	Route::get('category', [
	    'as' => 'category', 'uses' => 'CoreController@showCat'
	]);
	Route::get('payment', [
	    'as' => 'payment', 'uses' => 'CoreController@showPayment'
	]);
	Route::get('tenor', [
	    'as' => 'tenor', 'uses' => 'CoreController@showTenor'
	]);
	Route::get('city', [
	    'as' => 'city', 'uses' => 'CoreController@showCity'
	]);
	Route::get('city', [
	    'as' => 'city', 'uses' => 'CoreController@showCity'
	]);
	Route::get('{param}/detail/{id}', [
	    'as' => 'detail', 'uses' => 'CoreController@showDetailParam'
	]);
	Route::get('{id}/tambah-data', [
	    'as' => 'tambah-data', 'uses' => 'CoreController@showTambahData'
	]);
});

Route::group(['prefix' => 'account'], function() {
	Route::get('user-grade', [
	    'as' => 'user-grade', 'uses' => 'AccountController@showUserGrade'
	]);
	Route::get('user-account', [
	    'as' => 'user-account', 'uses' => 'AccountController@showAdmin'
	]);
	Route::get('cutomer', [
	    'as' => 'cutomer', 'uses' => 'AccountController@showCustomer'
	]);
	Route::get('seller-adm', [
	    'as' => 'seller-adm', 'uses' => 'AccountController@showSellerAdm'
	]);
	Route::get('seller', [
	    'as' => 'seller', 'uses' => 'AccountController@showSeller'
	]);
	Route::get('{param}/detail/{id}', [
	    'as' => 'account-detail', 'uses' => 'AccountController@showAccountDetail'
	]);
	Route::get('account-seller-{id}', [
	    'as' => 'account-seller', 'uses' => 'AccountController@showAccountDetail1'
	]);
	Route::get('{type}/add', [
	    'as' => 'add-member', 'uses' => 'AccountController@showAddMember'
	]);
	Route::get('user-detail-{type}', [
	    'as' => 'user-detail', 'uses' => 'AccountController@showUserDetail'
	]);
	Route::get('tambah-user-level', [
	    'as' => 'tambah-user-level', 'uses' => 'AccountController@showAddUserLevel'
	]);
});

Route::group(['prefix' => 'request'], function() {
	Route::get('all-request', [
	    'as' => 'all-request', 'uses' => 'RequestController@showAllRequest'
	]);
	Route::get('all-offers', [
	    'as' => 'all-offers', 'uses' => 'RequestController@showAllOffers'
	]);
	Route::get('all-payment', [
	    'as' => 'all-payment', 'uses' => 'RequestController@showAllPayment'
	]);
	Route::get('send-notification', [
	    'as' => 'send-notification', 'uses' => 'RequestController@showSendNotification'
	]);
});

Route::group(['prefix' => 'notification'], function() {
	Route::get('notif', [
	    'as' => 'notif', 'uses' => 'NotificationController@showNotif'
	]);
});

Route::group(['prefix' => 'logs'], function() {
	Route::get('log', [
	    'as' => 'log', 'uses' => 'LogsController@showLogs'
	]);
	Route::get('system-log', [
	    'as' => 'system-log', 'uses' => 'LogsController@showSystemLog'
	]);
});

Route::group(['prefix' => 'customer'], function() {
	Route::get('customer-req', [
	    'as' => 'customer-req', 'uses' => 'CustomerController@showCustomerReq'
	]);
	Route::get('customer-off', [
	    'as' => 'customer-off', 'uses' => 'CustomerController@showCustomerOff'
	]);
	Route::get('confirm-dp', [
	    'as' => 'confirm-dp', 'uses' => 'CustomerController@showConfirmDP'
	]);
	Route::get('detail/{id}', [
	    'as' => 'customer-detail', 'uses' => 'CustomerController@showsellerdetail'
	]);
});

Route::group(['prefix' => 'admin-seller'], function() {
	Route::get('all-req-off', [
	    'as' => 'all-req-off', 'uses' => 'AdminSellerController@showAllReqOff'
	]);
	Route::get('setting-admin-seller', [
	    'as' => 'setting-admin-seller', 'uses' => 'AdminSellerController@showSetting'
	]);
	Route::get('account-detail-admin-{id}', [
	    'as' => 'account-detail-admin', 'uses' => 'AdminSellerController@showAccountDetail'
	]);
});

Route::group(['prefix' => 'seller'], function() {
	Route::get('seller-req', [
	    'as' => 'seller-req', 'uses' => 'SellerController@showRequestSeller'
	]);
	Route::get('seller-off', [
	    'as' => 'seller-off', 'uses' => 'SellerController@showOfferSeller'
	]);
	Route::get('{param}/add', [
	    'as' => 'req-off', 'uses' => 'SellerController@showreqoff'
	]);
	Route::get('{param}/detail/{id}', [
	    'as' => 'seller-detail', 'uses' => 'SellerController@showsellerdetail'
	]);
});

Route::group(['prefix' => 'api'], function() {
	Route::post('login/do', [
	    'as' => 'do-login', 'uses' => 'APIController@doLogin'
	]);
	Route::get('logout/do', [
	    'as' => 'do-logout', 'uses' => 'APIController@doLogout'
	]);
	Route::post('total-notif', [
	    'as' => 'total-notif', 'uses' => 'APIController@doListNotifUser'
	]);

	// Master
	Route::post('update-param', [
	    'as' => 'update-param', 'uses' => 'APIController@doUpdateParam'
	]);
	Route::post('updatepayment', [
	    'as' => 'updatepayment', 'uses' => 'APIController@doupdatepayment'
	]);
	Route::post('updatekota', [
	    'as' => 'updatekota', 'uses' => 'APIController@doUpdateKota'
	]);
	Route::post('updatetenor', [
	    'as' => 'updatetenor', 'uses' => 'APIController@doupdatetenor'
	]);
	Route::post('tambahdataadd', [
	    'as' => 'tambahdataadd', 'uses' => 'APIController@dotambahdataadd'
	]);
	Route::post('update-data', [
	    'as' => 'update-data', 'uses' => 'APIController@doUpdateData1'
	]);
	Route::get('api-list-merk', [
	    'as' => 'api-list-merk', 'uses' => 'APIController@doListMerk'
	]);
	Route::post('upload-list-merk', [
	    'as' => 'upload-list-merk', 'uses' => 'APIController@doUploadListMerk'
	]);
	Route::get('api-list-model', [
	    'as' => 'api-list-model', 'uses' => 'APIController@doListModel'
	]);
	Route::post('upload-list-model', [
	    'as' => 'upload-list-model', 'uses' => 'APIController@doUploadListModel'
	]);
	Route::get('api-list-type', [
	    'as' => 'api-list-type', 'uses' => 'APIController@doListType'
	]);
	Route::post('upload-list-type', [
	    'as' => 'upload-list-type', 'uses' => 'APIController@doUploadListType'
	]);
	Route::get('api-list-maincat', [
	    'as' => 'api-list-maincat', 'uses' => 'APIController@doListMainCat'
	]);
	Route::get('api-list-cat', [
	    'as' => 'api-list-cat', 'uses' => 'APIController@doListCat'
	]);
	Route::post('upload-list-cat', [
	    'as' => 'upload-list-cat', 'uses' => 'APIController@doUploadListCat'
	]);
	Route::get('api-list-payment', [
	    'as' => 'api-list-payment', 'uses' => 'APIController@doListPayment'
	]);
	Route::get('api-list-tenor', [
	    'as' => 'api-list-tenor', 'uses' => 'APIController@doListTenor'
	]);
	Route::post('add-list-payment', [
	    'as' => 'add-list-payment', 'uses' => 'APIController@doAddPayment'
	]);
	Route::post('add-list-tenor', [
	    'as' => 'add-list-tenor', 'uses' => 'APIController@doAddTenor'
	]);
	Route::get('api-list-city', [
	    'as' => 'api-list-city', 'uses' => 'APIController@doListCity'
	]);
	Route::post('upload-list-city', [
	    'as' => 'upload-list-city', 'uses' => 'APIController@doUploadListCity'
	]);

	// Account
	Route::get('api-list-grade', [
	    'as' => 'api-list-grade', 'uses' => 'APIController@doListGrade'
	]);
	Route::post('add-list-grade', [
	    'as' => 'add-list-grade', 'uses' => 'APIController@doAddGrade'
	]);
	Route::get('api-list-admin', [
	    'as' => 'api-list-admin', 'uses' => 'APIController@doListAdmin'
	]);
	Route::get('api-list-customer', [
	    'as' => 'api-list-customer', 'uses' => 'APIController@doListCustomer'
	]);
	Route::get('api-list-seller-adm', [
	    'as' => 'api-list-seller-adm', 'uses' => 'APIController@doListSellerAdm'
	]);
	Route::get('api-list-seller', [
	    'as' => 'api-list-seller', 'uses' => 'APIController@doListSeller'
	]);
	Route::get('api-list-seller-by', [
	    'as' => 'api-list-seller-by', 'uses' => 'APIController@doListSeller'
	]);
	Route::get('api-list-payment-user', [
	    'as' => 'api-list-payment-user', 'uses' => 'APIController@doListPaymentUser'
	]);
	Route::post('api-update-data', [
	    'as' => 'api-update-data', 'uses' => 'APIController@doUpdateData'
	]);
	Route::post('api-update-data-grade', [
	    'as' => 'api-update-data-grade', 'uses' => 'APIController@doUpdateDataGrade'
	]);
	Route::post('add-account', [
	    'as' => 'add-account', 'uses' => 'APIController@doaddaccount'
	]);
	Route::post('update-account', [
	    'as' => 'update-account', 'uses' => 'APIController@doupdateaccount'
	]);

	// Logs
	Route::get('api-logs', [
	    'as' => 'api-logs', 'uses' => 'APIController@doListLogs'
	]);
	Route::get('api-otp-log', [
	    'as' => 'api-otp-log', 'uses' => 'APIController@doListOTPLogs'
	]);
	Route::get('api-email-notif', [
	    'as' => 'api-email-notif', 'uses' => 'APIController@doListEmailNotif'
	]);

	// Request
	Route::get('api-request', [
	    'as' => 'api-request', 'uses' => 'APIController@doListRequest'
	]);
	Route::get('api-offers', [
	    'as' => 'api-offers', 'uses' => 'APIController@doListOffers'
	]);

	// Customer
	Route::get('api-request-peruser', [
	    'as' => 'api-request-peruser', 'uses' => 'APIController@doListRequestPerUser'
	]);
	Route::get('api-offers-peruser', [
	    'as' => 'api-offers-peruser', 'uses' => 'APIController@doListOffersPerUser'
	]);
	Route::post('api-confirm-dp', [
	    'as' => 'api-confirm-dp', 'uses' => 'APIController@doConfirmDP'
	]);
	Route::get('api-all-notification', [
	    'as' => 'api-all-notification', 'uses' => 'APIController@doListNotification'
	]);

	// Admin Seller
	Route::post('api-brand-choose', [
	    'as' => 'api-brand-choose', 'uses' => 'APIController@doBrandChoose'
	]);
	Route::post('api-add-seller', [
		'as' => 'api-add-seller', 'uses' => 'APIController@doAddSeller'
	]);
	Route::post('api-adm-setting', [
		'as' => 'api-adm-setting', 'uses' => 'APIController@doAdmSetting'
	]);

	// Seller
	Route::get('api-request-seller', [
	    'as' => 'api-request-seller', 'uses' => 'APIController@doListRequestSeller'
	]);
	Route::get('api-offers-seller', [
	    'as' => 'api-offers-seller', 'uses' => 'APIController@doListOffersSeller'
	]);


	Route::post('api-delete-grade', [
		'as' => 'api-delete-grade', 'uses' => 'APIController@doDeleteGrade'
	]);
	Route::post('api-delete-user', [
		'as' => 'api-delete-user', 'uses' => 'APIController@doDeleteUser'
	]);
	Route::post('api-add-member-baru', [
		'as' => 'api-add-member-baru', 'uses' => 'APIController@doAddUser'
	]);
	Route::post('api-list-menu', [
		'as' => 'api-list-menu', 'uses' => 'APIController@doListMenu'
	]);
	Route::post('add-offers', [
		'as' => 'add-offers', 'uses' => 'APIController@doaddoffers'
	]);
	Route::post('del-offers', [
		'as' => 'del-offers', 'uses' => 'APIController@dodeloffers'
	]);
	Route::post('edit-offers', [
		'as' => 'edit-offers', 'uses' => 'APIController@doeditoffers'
	]);
	Route::get('api-list-notif', [
		'as' => 'api-list-notif', 'uses' => 'APIController@dolistnotif'
	]);
	Route::post('api-accept', [
		'as' => 'api-accept', 'uses' => 'APIController@doacceptoffer'
	]);
	Route::post('send-notif-now', [
		'as' => 'send-notif-now', 'uses' => 'APIController@dosendnow'
	]);
});