<?php


Route::group(['namespace'=>'AdminPanel','prefix'=>'admin'], function () {
    Route::get('/', 'HomeController@index')->middleware('admin');

    Route::group(['namespace' => 'AdminAuth'], function () {
        Route::get('/login', 'LoginController@showLoginForm')->name('admin.login');
        Route::post('/login', 'LoginController@login');
        Route::any('/logout', 'LoginController@logout')->name('admin.logout');
        // Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.request');
        // Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        // Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm');
        // Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.email');
    });

    Route::group(['middleware' => ['admin', 'auth:admin']], function () {
        Route::get('/home', 'HomeController@home');
        Route::get('/profile', 'HomeController@profile');
        Route::post('/edit_profile', 'HomeController@edit_profile');
        Route::post('/change_password', 'HomeController@change_password');

        Route::resources(['admins'=>'AdminsController']);
        Route::post('admins/{id}/disable','AdminsController@disable');
        Route::get('admins/{id}/transform','AdminsController@transform_page');
        Route::post('admins/{id}/transform','AdminsController@transform');
        
        Route::resources(['roles'=>'RolesController']);
        Route::post('roles/{id}/disable','RolesController@disable');
        Route::get('roles/{id}/transform','RolesController@transform_page');
        Route::post('roles/{id}/transform','RolesController@transform');

        // Route::resources(['permissions'=>'PermissionsController']);
        Route::resource('articles', 'Article\ArticleController');
        Route::get('articles/{article}/status', 'Article\ArticleController@changeStatus');

        Route::resource('products', 'Shop\ProductController');
        Route::get('products/{product}/status', 'Shop\ProductController@changeStatus');

        Route::resource('categories', 'CategoryController');

        Route::resource('menus', 'MenuController');
        Route::get('menus/{menu}/status', 'MenuController@changeStatus');


        Route::resource('orders', 'Shop\OrderController')->only(['index', 'show', 'delete']);
        Route::get('orders/{order}/status', 'Shop\OrderController@changeStatus');

        Route::resource('payments', 'Shop\PaymentController')->only(['index', 'show']);

        Route::get('notification/send/email', 'NotificationController@showFormEmail')->name('notification.email.showForm');
        Route::post('notification/send/email', 'NotificationController@sendEmail')->name('notification.email.send');

        Route::get('notification/send/sms', 'NotificationController@showFormSms')->name('notification.sms.showForm');
        Route::post('notification/send/sms', 'NotificationController@sendSms')->name('notification.sms.send');

        //route insert head ->
        
        Route::resources(['panel_settings' => 'Panel_settingsController']);
    });
});


Route::group(['namespace' => 'Frontend', 'prefix' => '/'], function () {
    Route::get('/', 'ProductController@index');
    Route::get('cart', 'BasketController@index')->name('basket');
    Route::get('basket/add/{product}', 'BasketController@add')->name('basket.add');
    Route::post('basket/update/{product}', 'BasketController@update')->name('basket.update');
    Route::get('checkout', 'BasketController@checkoutForm')->name('basket.checkoutForm');
    Route::post('checkout', 'BasketController@checkout')->name('basket.checkout');
    Route::get('products', 'ProductController@index')->name('products');
    Route::post('checkCoupon', 'CouponController@store')->name('checkCoupon');
    Route::get('couponRemove', 'CouponController@remove')->name('coupon.remove');
    Route::post('/payment/{gateway}/verify', 'PaymentController@verify')->name('payment.verify');
});

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes(['verify' => true]);
Route::get('sessions', function () {
    dd(session()->all());
});
Route::get('basket/clear', function () {
    session()->forget('basket');
    return back();
});
Route::get('/{path?}',function(){
    return view('app');
})->where('path','.*');



