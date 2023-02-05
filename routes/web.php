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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/login/phone', 'Auth\LoginController@phone')->name('login.phone');
Route::post('/login/phone', 'Auth\LoginController@verify');

Route::get('/verify/{token}', 'Auth\RegisterController@verify')->name('register.verify');

//Route::get('/cabinet', 'Cabinet\HomeController@index')->name('cabinet');
Route::group(
    [
        'prefix'    => 'cabinet',
        'as'        => 'cabinet.', // подставляется в "->name"
        'namespace' => 'Cabinet',
        'middleware'=> ['auth'],
    ],
    function () {
        Route::get('/', 'HomeController@index')->name('home');

        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('/', 'ProfileController@index')->name('home');
            Route::get('/edit', 'ProfileController@edit')->name('edit');
            Route::put('/update', 'ProfileController@update')->name('update');

            Route::post('/phone', 'PhoneController@request');
            Route::get('/phone', 'PhoneController@form')->name('phone');
            Route::put('/phone', 'PhoneController@verify')->name('phone.verify');

            Route::post('/phone/auth', 'PhoneController@auth')->name('phone.auth');
        });
    }
);

/*
Route::prefix('admin')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::namespace('Admin')->group(function () {
            Route::get('/', 'HomeController@index')->name('admin.home');
            Route::resource('users', 'UsersController');
        });
    });
});
*/

// laralearn то что выше можно написать иначе:
Route::group(
    [
        'prefix'    => 'admin',
        'as'        => 'admin.', // подставляется в "->name"
        'namespace' => 'Admin',
        'middleware'=> ['auth', 'can:admin-panel'], // can берется из app/Providers/AuthServiceProvider.php
    ],
    function () {
        Route::get('/', 'HomeController@index')->name('home');

        // laralearn генерируем сразу пачку методов (index, create, update и тд)
        Route::resource('users', 'UsersController');
        Route::post('/users/{user}/verify', 'UsersController@verify')->name('users.verify');

        Route::resource('regions', 'RegionController');

        Route::group(['prefix' => 'adverts', 'as' => 'adverts.', 'namespace' => 'Adverts'], function () {

            Route::resource('categories', 'CategoryController');

            Route::group(['prefix' => 'categories/{category}', 'as' => 'categories.'], function () {
                Route::post('/first', 'CategoryController@first')->name('first');
                Route::post('/up', 'CategoryController@up')->name('up');
                Route::post('/down', 'CategoryController@down')->name('down');
                Route::post('/last', 'CategoryController@last')->name('last');
                Route::resource('attributes', 'AttributeController')->except('index');
            });

        });
    }
);
