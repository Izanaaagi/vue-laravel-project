<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ParseController;
use App\Http\Controllers\TopicCommentController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TopicLikeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UsersListController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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


Route::post('/register', [RegisterController::class, 'create']);
Route::post('/login', [LoginController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/avatar', [AvatarController::class, 'store']);
    Route::get('/avatar/{id}', [AvatarController::class, 'show']);

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::get('/users/{id}', [UserProfileController::class, 'show']);
    Route::get('/users', [UserProfileController::class, 'index']);

    Route::get('/usersList', [UsersListController::class, 'showUsersList'])->name('list');


    Route::apiResource('forum', CategoryController::class);
    Route::apiResource('forum.topics', TopicController::class);
    Route::apiResource('forum.topics.likes', TopicLikeController::class);
    Route::apiResource('forum.topics.comments', TopicCommentController::class);

    Route::prefix('friends')->group(function () {
        Route::get('/', [FriendController::class, 'index'])->name('friends');
        Route::patch('/add/{id}', [FriendController::class, 'acceptFriend'])->name('addFriend');
        Route::post('/sendRequest/{id}', [FriendController::class, 'sendRequest'])->name('sendRequest');
        Route::delete('/delete/{id}', [FriendController::class, 'deleteFriend'])->name('deleteFriend');
    });
});
