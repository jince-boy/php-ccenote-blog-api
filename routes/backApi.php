<?php

use App\Http\Controllers\Api\BackController\AdminController;
use App\Http\Controllers\Api\BackController\ArticleController;
use App\Http\Controllers\Api\BackController\BannerController;
use App\Http\Controllers\Api\BackController\CategoryController;
use App\Http\Controllers\Api\BackController\ConfigController;
use App\Http\Controllers\Api\BackController\FileController;
use App\Http\Controllers\Api\BackController\HomeController;
use App\Http\Controllers\Api\BackController\PartnerController;
use App\Http\Controllers\Api\BackController\PermissionController;
use App\Http\Controllers\Api\BackController\RoleController;
use App\Http\Controllers\Api\BackController\TagController;
use App\Http\Controllers\Api\BackController\UserController;
use App\Http\Controllers\Api\BackController\CommentController;
use Illuminate\Support\Facades\Route;


Route::prefix('back')->group(function () {
    Route::get('/home', [HomeController::class, 'getWebData'])->middleware('BackRefreshToken');
    Route::prefix('admin')->group(function(){
        Route::middleware('BackRefreshToken')->group(function(){
            Route::post('/logout', [AdminController::class, 'logout']);
            Route::prefix('my')->group(function () {
                Route::get('/', [AdminController::class, 'getMyData']);
                Route::post('/update', [AdminController::class, 'updateMyData']);
                Route::post('/updateAvatar', [AdminController::class, 'updateAvatar']);
            });
            Route::post('/updatePassword', [AdminController::class, 'updatePassword']);
        });
        Route::post('/login', [AdminController::class, 'login'])->middleware('verifyCode');
        Route::get('/getVerifyCode', [AdminController::class, 'getVerifyCode']);
        Route::prefix('user')->group(function () {
            Route::get('/', [AdminController::class, 'getAdmin']);
            Route::get('/list', [AdminController::class, 'getAdminList']);
            Route::post('/add', [AdminController::class, 'addAdmin']);
            Route::prefix('update')->group(function () {
                Route::post('/data', [AdminController::class, 'updateAdminUser']);
                Route::post('/avatar', [AdminController::class, 'updateAdminUserAvatar']);
            });
            Route::post('/delete', [AdminController::class, 'deleteAdminUser']);
        });
    });
    Route::middleware(['BackRefreshToken', 'StatusTesting', 'permission'])->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/search', [UserController::class, 'searchUser']);
            Route::get('/list', [UserController::class, 'getUserList']);
            Route::get('/', [UserController::class, 'getUser']);
            Route::post('/add', [UserController::class, 'addUser']);
            Route::prefix('update')->group(function () {
                Route::post('/', [UserController::class, 'updateUser']);
                Route::post('/avatar', [UserController::class, 'updateUserAvatar']);
            });
            Route::post('/delete', [UserController::class, 'deleteUser']);
        });
        Route::prefix('permission')->group(function () {
            Route::get("/list", [PermissionController::class, "getPermissionList"]);
            Route::get("/", [PermissionController::class, "getPermissionData"]);
            Route::post("/add", [PermissionController::class, 'addPermission']);
            Route::post("/update", [PermissionController::class, 'updatePermission']);
            Route::post("/delete", [PermissionController::class, 'deletePermission']);
        });
        Route::prefix('role')->group(function () {
            Route::get('/list', [RoleController::class, 'getRoleList']);
            Route::get('/', [RoleController::class, 'getRoleData']);
            Route::post("/add", [RoleController::class, 'addRole']);
            Route::post("/update", [RoleController::class, 'updateRole']);
            Route::post("/delete", [RoleController::class, 'deleteRole']);
        });
        Route::prefix('config')->group(function () {
            Route::get('/', [ConfigController::class, 'getConfig']);
            Route::prefix('/comment')->group(function () {
                Route::get('/', [ConfigController::class, 'getKeywords']);
                Route::post('/set', [ConfigController::class, 'setKeyword']);
            });
            Route::prefix('update')->group(function () {
                Route::post('/', [ConfigController::class, 'setConfig']);
                Route::post('/logo', [ConfigController::class, 'setLogo']);
            });
        });
        Route::prefix('article')->group(function () {
            Route::get('/search', [ArticleController::class, 'searchArticle']);
            Route::get('/list', [ArticleController::class, 'getArticleList']);
            Route::get('/', [ArticleController::class, 'getArticle']);
            Route::post('/add', [ArticleController::class, 'addArticle']);
            Route::post('/update', [ArticleController::class, 'UpdateArticle']);
            Route::post('/add_image', [ArticleController::class, 'addArticleImg']);
            Route::post('/add_video', [ArticleController::class, 'addArticleVideo']);
            Route::post('/delete', [ArticleController::class, 'deleteArticle']);
            Route::prefix('comment')->group(function () {
                Route::post('/add', [CommentController::class, 'addComment']);
                Route::get('/list', [CommentController::class, 'getCommentList']);
                Route::post('/delete', [CommentController::class, 'deleteComment']);
                Route::get('/search', [CommentController::class, 'searchComment']);
            });
        });
        Route::prefix('tag')->group(function () {
            Route::get('/all', [TagController::class, 'getAll']);
            Route::get('/list', [TagController::class, 'getTagsList']);
            Route::get('/', [TagController::class, 'getTag']);
            Route::post('/add', [TagController::class, 'addTags']);
            Route::post('/update', [TagController::class, 'updateTags']);
            Route::post('/delete', [TagController::class, 'deleteTags']);
        });
        Route::prefix('category')->group(function () {
            Route::get('/list', [CategoryController::class, 'getCategorysList']);
            Route::get('/', [CategoryController::class, 'getCategory']);
            Route::post('/add', [CategoryController::class, 'addCategory']);
            Route::post('/update', [CategoryController::class, 'updateCategory']);
            Route::post('/delete', [CategoryController::class, 'deleteCategory']);
        });
        Route::prefix('file')->group(function () {
            Route::get('/', [FileController::class, 'getFileList']);
            Route::post('/upload', [FileController::class, 'uploadFile']);
            Route::post('/delete', [FileController::class, 'deleteFile']);
        });
        Route::prefix('banner')->group(function () {
            Route::get('/list', [BannerController::class, 'getBannerList']);
            Route::get('/', [BannerController::class, 'getBanner']);
            Route::post('/add', [BannerController::class, 'addBanner']);
            Route::post('/update', [BannerController::class, 'updateBanner']);
            Route::post('/delete', [BannerController::class, 'deleteBanner']);
        });
        Route::prefix('partner')->group(function () {
            Route::get('/list', [PartnerController::class, 'getPartnerList']);
            Route::get('/', [PartnerController::class, 'getPartner']);
            Route::post('/add', [PartnerController::class, 'addPartner']);
            Route::post('/update', [PartnerController::class, 'updatePartner']);
            Route::post('/delete', [PartnerController::class, 'deletePartner']);
        });
    });
});
