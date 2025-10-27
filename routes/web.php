<?php


use Illuminate\Support\Facades\Route;

Route::controller('SiteController')->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('courses', 'courses')->name('course.index');
    Route::get('course-details/{slug}/{id}', 'courseDetails')->name('course.details');
});
