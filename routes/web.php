<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::get('/about', function () {
    return view('about');
});

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/blog-details', function () {
    return view('blog-details');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/checkout', function () {
    return view('checkout');
});


Route::get('/contact', function () {
    return view('contact');
});


Route::get('/faq', function () {
    return view('faq');
});

Route::get('/wishlist', function () {
    return view('wishlist');
});

Route::get('/shops', function () {
    return view('shops');
});

Route::get('/shop-details', function () {
    return view('shop-details');
});


Route::get('/shops-grid', function () {
    return view('shops-grid');
});
Route::get('/shop-right-sidebar', function () {
    return view('shop-right-sidebar');
});



