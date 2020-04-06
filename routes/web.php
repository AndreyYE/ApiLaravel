<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['namespace'=>'Admin',
    'prefix'=>'admin','as'=>'admin.'],function()
{
    //Регистрация админа
    Route::get('/formRegistration','AuthController@formRegister')->name('register');
    Route::post('/registration','AuthController@registration')->name('register.submit');
    //Вход по email/пароль
    Route::get('/formLogin','AuthController@formLogin')->name('login');
    Route::post('/login','AuthController@login')->name('login.submit');

    Route::group(['middleware' => 'auth:admin'],function(){
        //Выход
        Route::get('/logout','AuthController@logout')->name('logout');
        // Админ панель
        Route::get('/adminPanel','HomeController@cabinet')->name('cabinet');
        // CRUD для категорий постов
        Route::resource('/categories', 'CategoryController');
        //Список пользователей
        Route::get('/listUsers','UserController@list')->name('users');
        //Пользователь подробно со статистикой постов
        Route::get('/user/{user}','UserController@user')->name('user');
        // Список постов
        Route::get('/listPosts','PostController@list')->name('posts');
        // Пост подробно с информацией об авторе и количестве добавлений в избранное
        Route::get('/post/{post}','PostController@post')->name('post');

    });
});

