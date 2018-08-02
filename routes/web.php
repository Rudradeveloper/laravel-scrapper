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
// 
// .media-left { manga well p }
// http://readcomicsonline.ru/comic/1985-black-hole-repo-2017
// http://readcomicsonline.ru/comic-list

Route::get('/', function() {
    $crawler = Goutte::request('GET', 'http://readcomicsonline.ru/comic/1985-black-hole-repo-2017');

    // $crawler->filter('.chart-title ')->each(function ($node) {

    //   // getting title 
    //   print_r($node->text());
    //   echo "<br>";
    // });

    // $crawler->filter('a > img')->each(function ($node) {

    //   if($node->getNode(0)->tagName == 'img') {

    //   	echo "<pre>";
    //   	print_r($node->getNode(0)->getAttribute('src'));
    //   }

    // });

    $crawler->filter('p')->each(function ($node) {

      echo "<pre>";
      print_r($node->text());

    });

    die("here");

    return view('welcome');
});
