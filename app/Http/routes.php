<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$router->model('user', 'KW\Transactions\Models\User', function() {
    abort(404);
});
$router->model('region', 'KW\Transactions\Models\Region', function() {
    abort(404);
});
$router->model('transaction', 'KW\Transactions\Models\Transaction', function() {
    abort(404);
});
Route::bind('contact_type', function($value) {
    return KW\Transactions\Models\ContactType::where('name', $value)->first();
});
Route::bind('transaction_status', function($value) {
    return KW\Transactions\Models\TransactionStatus::where('name', $value)->first();
});
Route::bind('payment_status', function($value) {
    return KW\Transactions\Models\PaymentStatus::where('name', $value)->first();
});
Route::bind('listing_status', function($value) {
    return KW\Transactions\Models\ListingStatus::where('name', $value)->first();
});

Route::group(['middleware' => ['locale']], function () {
    // Authentication Routes...
    $this->get('login', 'Auth\AuthController@getLogin')->name('login');
    Route::group(['middleware' => ['current.office']], function() {
        $this->post('login', 'Auth\AuthController@postLogin')->name('login_post');
    });
    $this->get('logout', 'Auth\AuthController@getLogout')->name('logout');

    // Password Reset Routes...
    $this->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm')->name('reset_password');
    $this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail')->name('reset_password_email');
    $this->post('password/reset', 'Auth\PasswordController@reset')->name('reset_password_post');
});

Route::group(['middleware' => ['auth','locale']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::resource('contact', 'ContactController', [
        'except' => [
            'show'
    ]]);
    Route::resource('listing', 'ListingController', [
        'except' => [
            'show'
        ]
    ]);
    Route::get('contact/type/{contact_type}', 'ContactController@index')->name('contact.index.filter');
    Route::get('contact/create/{contact_type}', 'ContactController@create')->name('contact.create.filter');

    Route::get('listing/status/{listing_status}', 'ListingController@index')->name('listing.index.filter');

    Route::group(['prefix' => 'api'], function () {
        Route::post('/getCities', 'ApiController@getCities')->name('api.cities_by_state_id');
        Route::post('/getMentions', 'ApiController@getMentions')->name('api.mentions');
    });


    Route::any('/change-office', 'ChangeOfficeController@change')->name('office.change');

    Route::resource('transaction', 'TransactionController');
    Route::get('transaction/status/{transaction_status}', 'TransactionController@index')->name('transaction.index.filter');
    Route::put('transaction/{transaction}/withdraw', 'TransactionController@withdraw')->name('transaction.withdraw');
    Route::put('transaction/{transaction}/add-note', 'TransactionController@addNote')->name('transaction.addNote');
    Route::get('transaction/{transaction}/payments', 'TransactionController@payments')->name('transaction.payments');

    Route::resource('payment', 'PaymentController', [
        'except' => [
            'show'
        ]]);

    Route::get('payment/status/{payment_status}', 'PaymentController@index')->name('payment.index.filter');
    Route::put('payment/{payment}/update-status', 'PaymentController@updateStatus')->name('payment.updateStatus');

    Route::get('/period/freeze', 'PeriodController@freeze')->name('period.freeze');
    Route::put('/period/close', 'PeriodController@close')->name('period.close');




    Route::group(['prefix' => 'admin'], function () {
        Route::resource('user', 'UserController', [
            'except' => [
                'destroy',
                'show'
            ],
            'names' => [
                'create' => 'user.create',
                'store' => 'user.store',
                'update' => 'user.update',
                'index' => 'user.index',
                'edit' => 'user.edit',
            ]
        ]);

        Route::match(['get', 'post'], '/profile', function () {
            return redirect(route('user.edit', ['id' => Auth::id()]));
        })->name('profile_edit');

        Route::match(['put'], '/user/{user}/roles', 'UserController@roles')->name('user.roles');

        Route::resource('region', 'RegionController', [
            'except' => [
                'destroy',
                'show'
            ],
            'names' => [
                'create' => 'region.create',
                'store' => 'region.store',
                'update' => 'region.update',
                'index' => 'region.index',
                'edit' => 'region.edit',
            ]
        ]);

        Route::resource('office', 'OfficeController', [
            'except' => [
                'destroy',
                'show'
            ],
            'names' => [
                'create' => 'office.create',
                'store' => 'office.store',
                'update' => 'office.update',
                'index' => 'office.index',
                'edit' => 'office.edit',
            ]
        ]);

        Route::put('custom-financial-attribute/upsert', 'CustomFinancialAttributeController@upsert')->name('customFinancialAttribute.upsert');
        Route::post('custom-financial-attribute/agent', 'CustomFinancialAttributeController@getAgentFinancialAttributes')->name('customFinancialAttribute.agent');
    });
});
