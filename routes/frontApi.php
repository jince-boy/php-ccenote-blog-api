<?php

use App\Http\Controllers\Api\FrontController\ArticleController;
use App\Http\Controllers\Api\FrontController\BannerController;
use App\Http\Controllers\Api\FrontController\CategoryController;
use App\Http\Controllers\Api\FrontController\CommentController;
use App\Http\Controllers\Api\FrontController\ConfigController;
use App\Http\Controllers\Api\FrontController\CountController;
use App\Http\Controllers\Api\FrontController\MasterController;
use App\Http\Controllers\Api\FrontController\PartnerController;
use App\Http\Controllers\Api\FrontController\TagController;
use App\Http\Controllers\Api\FrontController\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('front')->group(function () {
    Route::get('/config',[ConfigController::class,'getWebConfig']);
    Route::get('/menu',[ConfigController::class,'getMenu']);
    Route::prefix('user')->group(function () {
        Route::get('/',[UserController::class,'getUserData']);
        Route::middleware('FrontRefreshToken')->group(function(){
            Route::post('/logout', [UserController::class, 'logout']);
            Route::post('/updatePassword', [UserController::class, 'updatePassword']);
            Route::prefix('my')->group(function () {
                Route::get('/', [UserController::class, 'getMyData']);
                Route::post('/update', [UserController::class, 'updateMyData']);
                Route::post('/updateAvatar', [UserController::class, 'updateAvatar']);
            });
        });
        Route::post('/register', [UserController::class, 'register'])->middleware("isRegister");
        Route::post('/login', [UserController::class, 'login'])->middleware('verifyCode');
        Route::post('/resetPassword', [UserController::class, 'resetPassword']);
        Route::get('/getMailCode', [UserController::class, 'getMailCode']);
        Route::get('/getVerifyCode', [UserController::class, 'getVerifyCode']);
    });
    Route::prefix('article')->group(function(){
        Route::get('/list',[ArticleController::class,'getArticleList']);
        Route::get('/',[ArticleController::class,'getArticle']);
        Route::prefix('comment')->middleware('FrontRefreshToken')->group(function(){
            Route::post('/add',[CommentController::class,'addComment']);
        });
        Route::prefix('comment')->group(function(){
            Route::get('/getArticleCommentList',[CommentController::class,'getArticleCommentList']);
            Route::get('/new',[CommentController::class,'newCommentList']);
        });
        Route::get('/hotArticle',[ArticleController::class,'hotArticle']);
        Route::get('/search',[ArticleController::class,'searchFrontArticle']);
    });
    Route::prefix('category')->group(function(){
       Route::get('/',[CategoryController::class,'getCategoryArticle']);
    });
    Route::get('/banner',[BannerController::class,'getList']);
    Route::get('/master',[MasterController::class,'getMaster']);
    Route::get('/count',[CountController::class,'getCount']);
    Route::prefix('/tag')->group(function(){
        Route::get('/',[TagController::class,'getTagArticle']);
        Route::get('/list',[TagController::class,'getTagList']);
    });
    Route::get('/partner',[PartnerController::class,'getPartnerList']);
});
