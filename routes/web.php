<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\PaidServiceController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ConsultationController as AdminConsultationController;
use App\Http\Controllers\Admin\BadgeController;

// 認証不要のルート
Route::get('/', [HomeController::class, 'index'])->name('home');

// 認証関連
Auth::routes();

// Google認証
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

// 認証が必要なルート
Route::middleware(['auth'])->group(function () {
    // ダッシュボード
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // プロフィール
    Route::resource('profile', ProfileController::class)->only(['show', 'edit', 'update']);

    // 鑑定関連（相談者向け）
    Route::middleware(['user.type:client'])->group(function () {
        Route::get('/practitioners', [ConsultationController::class, 'practitioners'])->name('practitioners.index');
        Route::get('/practitioners/{user}', [ConsultationController::class, 'practitionerProfile'])->name('practitioners.show');
        Route::get('/consultations/create/{practitioner}', [ConsultationController::class, 'create'])->name('consultations.create');
        Route::post('/consultations', [ConsultationController::class, 'store'])->name('consultations.store');
    });

    // 鑑定関連（鑑定師向け）
    Route::middleware(['user.type:practitioner'])->group(function () {
        Route::post('/consultations/{consultation}/accept', [ConsultationController::class, 'accept'])->name('consultations.accept');
        Route::post('/consultations/{consultation}/complete', [ConsultationController::class, 'complete'])->name('consultations.complete');
    });

    // 鑑定関連（共通）
    Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');
    Route::get('/consultations/{consultation}', [ConsultationController::class, 'show'])->name('consultations.show');
    Route::post('/consultations/{consultation}/cancel', [ConsultationController::class, 'cancel'])->name('consultations.cancel');

    // メッセージ
    Route::get('/consultations/{consultation}/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/consultations/{consultation}/messages', [MessageController::class, 'store'])->name('messages.store');

    // レビュー
    Route::post('/consultations/{consultation}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/practitioners/{user}/reviews', [ReviewController::class, 'index'])->name('reviews.index');

    // ポイント
    Route::get('/points', [PointController::class, 'index'])->name('points.index');
    Route::get('/points/purchase', [PointController::class, 'showPurchaseForm'])->name('points.purchase.form');
    Route::post('/points/purchase', [PointController::class, 'purchase'])->name('points.purchase');
    Route::post('/consultations/{consultation}/tip', [PointController::class, 'sendTip'])->name('points.tip');

    // 有料サービス（優良鑑定師向け）
    Route::middleware(['user.type:expert'])->group(function () {
        Route::resource('paid-services', PaidServiceController::class);
    });

    // 管理者向け
    Route::middleware(['user.type:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('consultations', AdminConsultationController::class);
        Route::resource('badges', BadgeController::class);
    });
});
