<?php

use Illuminate\Http\Request;
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

Route::group([
    'namespace'=>'Api'
    ], function () {

    Route::group(['prefix' => 'auth'],function (){
        //Вход по email/пароль
        Route::post('login', 'AuthController@login');
        //Регистрация по email/пароль/имя
        Route::post('signup', 'AuthController@signup');


        Route::group([
            'middleware' => 'auth:api'
        ],function (){
            //Выход
            Route::get('logout', 'AuthController@logout');
        });

    });


    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        //Получение списка всех постов с пагинацией
        Route::get('posts','PostController@getAllPosts');
        //Получение списка всех постов по пользователю
        Route::get('user/{user}/posts','PostController@getAllUserPosts');
        //Получение списка всех постов по категории
        Route::get('category/{category}/posts','PostController@getAllCategoryPosts');
        //Получение списка избранных постов
        Route::get('favorites/posts','PostController@getAllMyFavoritePosts');
        //Получение конкретного поста
        Route::get('post/{post}','PostController@getPost');
        //Добавление чужого поста в избранное
        Route::post('add/favor/{post}','PostController@addPostToFavorite');
        //Удаление чужого поста из избранное
        Route::delete('delete/favor/{post}','PostController@deletePostFromFavorite');
        //Создание поста
        Route::post('create/post','PostController@createPost');
        //Удаление своего поста
        Route::delete('delete/post/{post}','PostController@deleteMyPost');


    });
});

