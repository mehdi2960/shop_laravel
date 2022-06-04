<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\Market\BrandController;
use App\Http\Controllers\Admin\Market\CategoryController;
use App\Http\Controllers\Admin\Market\CommentController;
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

Route::prefix('admin')->namespace('Admin')->group(function (){
    Route::get('/',[AdminDashboardController::class,'index'])->name('admin.home');
    //Market
    Route::prefix('market')->namespace('Market')->group(function (){
        //category
        Route::prefix('category')->group(function (){
            Route::get('/',[CategoryController::class,'index'])->name('admin.content.category.index');
            Route::get('/create',[CategoryController::class,'create'])->name('admin.content.category.create');
            Route::post('/store',[CategoryController::class,'store'])->name('admin.content.category.store');
            Route::get('/edit/{postCategory}',[CategoryController::class,'edit'])->name('admin.content.category.edit');
            Route::put('/update/{postCategory}',[CategoryController::class,'update'])->name('admin.content.category.update');
            Route::delete('/delete/{postCategory}',[CategoryController::class,'destroy'])->name('admin.content.category.destroy');
            //ajax
            Route::get('/status/{postCategory}',[CategoryController::class,'status'])->name('admin.content.category.status');
        });

        //brand
        Route::prefix('brand')->group(function(){
            Route::get('/', [BrandController::class, 'index'])->name('admin.market.brand.index');
            Route::get('/create', [BrandController::class, 'create'])->name('admin.market.brand.create');
            Route::post('/store', [BrandController::class, 'store'])->name('admin.market.brand.store');
            Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('admin.market.brand.edit');
            Route::put('/update/{id}', [BrandController::class, 'update'])->name('admin.market.brand.update');
            Route::delete('/destroy/{id}', [BrandController::class, 'destroy'])->name('admin.market.brand.destroy');
        });

        //comment
        Route::prefix('comment')->group(function(){
            Route::get('/', [CommentController::class, 'index'])->name('admin.market.comment.index');
            Route::get('/show', [CommentController::class, 'show'])->name('admin.market.comment.show');
            Route::post('/store', [CommentController::class, 'store'])->name('admin.market.comment.store');
            Route::get('/edit/{id}', [CommentController::class, 'edit'])->name('admin.market.comment.edit');
            Route::put('/update/{id}', [CommentController::class, 'update'])->name('admin.market.comment.update');
            Route::delete('/destroy/{id}', [CommentController::class, 'destroy'])->name('admin.market.comment.destroy');
        });
    });

});
