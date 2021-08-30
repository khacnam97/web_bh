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
    return view('page');
});

Route::get('/login', [App\Http\Controllers\LoginController::class, 'getLogin'])->name('getLogin');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::get('/register', [App\Http\Controllers\LoginController::class, 'getRegister'])->name('getRegister');
Route::post('/register', [App\Http\Controllers\LoginController::class, 'postRegister'])->name('postRegister');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
    Route::get('/change-password',[App\Http\Controllers\LoginController::class, 'getChangePassword'])->name('getChangePassword');
    Route::post('/change-password',[App\Http\Controllers\LoginController::class, 'postChangePassword'])->name('postChangePassword');
    Route::get('/user/profile', [App\Http\Controllers\UserController::class, 'getProfile'])->name('user.getProfile');
    Route::post('/user/profile/{id}', [App\Http\Controllers\UserController::class, 'postProfile'])->name('user.postProfile');
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/user-index', [App\Http\Controllers\UserController::class, 'userIndex'])->name('user.index');
        Route::get('/user-list', [App\Http\Controllers\UserController::class, 'userList'])->name('user.list');
        Route::get('/user/create', [App\Http\Controllers\UserController::class, 'getCreate'])->name('user.getCreate');
        Route::post('/user/create', [App\Http\Controllers\UserController::class, 'postCreate'])->name('user.postCreate');
        Route::post('/user/trash/{id}', [App\Http\Controllers\UserController::class, 'trash'])->name('user.trash');
        Route::post('/user/restore/{id}', [App\Http\Controllers\UserController::class, 'restore'])->name('user.restore');
        Route::delete('/user/delete/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');
        Route::get('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'getEdit'])->name('user.getEdit');
        Route::post('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'postEdit'])->name('user.postEdit');
        Route::get('/example', [App\Http\Controllers\UserController::class, 'example'])->name('user.example');

        // script routes
        Route::get('/script',[App\Http\Controllers\ScriptController::class, 'index'])->name('script.index');
        Route::get('/script-list',[App\Http\Controllers\ScriptController::class, 'list'])->name('script.list');
        Route::delete('/script/delete/{id}', [App\Http\Controllers\ScriptController::class, 'delete'])->name('script.delete');
        Route::get('/script/create', [App\Http\Controllers\ScriptController::class, 'getCreate'])->name('script.getCreate');
        Route::post('/script/create', [App\Http\Controllers\ScriptController::class, 'postCreate'])->name('script.postCreate');
        Route::get('/script/edit/{id}', [App\Http\Controllers\ScriptController::class, 'getEdit'])->name('script.getEdit');
        Route::post('/script/edit/{id}', [App\Http\Controllers\ScriptController::class, 'postEdit'])->name('script.postEdit');
        Route::post('/script/active/{id}', [App\Http\Controllers\ScriptController::class, 'active'])->name('script.active');
        Route::post('/script/sort', [App\Http\Controllers\ScriptController::class, 'sort'])->name('script.sort');
    });

    // analyze file routes
    Route::get('/upload', [App\Http\Controllers\FileController::class, 'upload'])->name('get-upload');
    Route::get('/analyze', [App\Http\Controllers\FileController::class, 'index'])->name('get-analyze');
    Route::post('/analyze', [App\Http\Controllers\FileController::class, 'create'])->name('post-analyze');
    Route::get('/files', [App\Http\Controllers\FileController::class, 'getFiles'])->name('get-files');
    Route::get('/download-original-file', [App\Http\Controllers\FileController::class, 'downloadOriginal'])->name('download-original-file');
    Route::get('/download-analyzed-file', [App\Http\Controllers\FileController::class, 'downloadAnalyzed'])->name('download-analyzed-file');
    Route::delete('/files/{id}', [App\Http\Controllers\FileController::class, 'delete'])->name('file.delete');
});
