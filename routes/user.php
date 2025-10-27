<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->namespace('User\Auth')->group(function () {

    // Registration
    Route::controller('RegisteredUserController')->group(function () {
        Route::get('register', 'create')->name('register');
        Route::post('register', 'store');
    });

    // Login
    Route::controller('AuthenticatedSessionController')->group(function () {
        Route::get('login', 'create')->name('login');
        Route::post('login', 'store');
    });

    // Password Reset
    Route::controller('PasswordResetLinkController')->group(function () {
        Route::get('forgot-password', 'create')->name('password.request');
        Route::post('forgot-password', 'store')->name('password.email');
    });

    Route::controller('NewPasswordController')->group(function () {
        Route::get('reset-password/{token}', 'create')->name('password.reset');
        Route::post('reset-password', 'store')->name('password.store');
    });
});

Route::middleware('auth')->namespace('User\Auth')->group(function () {
    // Email Verification
    Route::get('verify-email', 'EmailVerificationPromptController')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', 'VerifyEmailController')
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::controller('EmailVerificationNotificationController')->group(function () {
        Route::post('email/verification-notification', 'store')
            ->middleware('throttle:6,1')
            ->name('verification.send');
    });

    // Password Confirmation
    Route::controller('ConfirmablePasswordController')->group(function () {
        Route::get('confirm-password', 'show')->name('password.confirm');
        Route::post('confirm-password', 'store');
    });

    // Update Password
    Route::controller('PasswordController')->group(function () {
        Route::put('password', 'update')->name('password.update');
    });

    // Logout
    Route::controller('AuthenticatedSessionController')->group(function () {
        Route::get('logout', 'destroy')->name('logout');
    });
});

Route::middleware('auth')->namespace('User')->group(function () {
    // Profile Management
    Route::controller('ProfileController')->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // course management
    Route::middleware('verified')->group(function () {

        Route::controller('UserController')->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
        });

        Route::controller('CourseController')->group(function () {
            Route::get('course/create', 'create')->name('course.create');
            Route::post('course/store', 'store')->name('course.store');
            Route::get('/courses/{course}/edit', 'edit')->name('course.edit');
            Route::post('/courses/{course}','update')->name('course.update');
            Route::get('/my-courses','myCourses')->name('my.courses');
        });
    });
});
