<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function() {
    $crawler = Goutte::request('GET', 'https://www.amarujala.com/india-news');
    $crawler->filter('.image-caption')->each(function ($node) {
      dump($node->text());
    });

    return view('welcome');
});
