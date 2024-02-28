<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\LinkController;
use App\http\Controllers\frontend\CatogeryController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\AllCollectionController;
use App\Http\Controllers\frontend\AllCatogeryController;
use App\Http\Controllers\frontend\VaraintController;
use App\Http\Controllers\frontend\EmojiController;
use App\Http\Controllers\backend\RolPerUsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\backend\admin\AdminController;
//use App\Http\Controllers\admin\backend\AdminproductController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\backend\company\UserBackendController;
//air tabel controller
use App\Http\Controllers\airtabel\EmojiairtableController;
use App\Http\Controllers\airtabel\ColourairtabelController;
use App\Http\Controllers\airtabel\CollectionairtabelController;
use App\Http\Controllers\airtabel\ProductairtabelController;











/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('password/code/check',[AuthController::class, 'emailPasswordCheck']);
    Route::post('password-reset', [AuthController::class, 'eamilResetPassword']);
    Route::post('forget-password', [AuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);


    Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    });

});
        
Route::group(['prefix' => 'sadm'], function () {
    /* Route::group(['middleware' => 'auth:sanctum'], function () { */
      /*   Route::group(['middleware' => ['role:super admin']], function () { */
             Route::post('addrole', [RolPerUsersController::class, 'addRole']);
             //
             Route::post('addpermession', [RolPerUsersController::class, 'addPermession']);
             Route::get('product/count',[AdminController::class,'getProductCount'])->name('product-count-adminDashboard');
             Route::get('product/recents',[AdminController::class,'getRecentAddedProduct'])->name('product-recent-adminDashboard');
             //
             Route::get('customer/recent', [AdminController::class, 'getRecentCustomer']);
             Route::get('customer/count', [AdminController::class, 'getCustomerCount']);
             //
             Route::get('order/count', [AdminController::class, 'getAllorder']);
             Route::get('order/sale', [AdminController::class, 'getcountTotalSale']);
             //
             Route::get('count', [AdminController::class, 'count']);
             Route::get('user/delete', [AdminController::class, 'getDeleteUser']);
             Route::get('user/details', [AdminController::class, 'getSingleUserDetails']);
             Route::put('user/edit', [AdminController::class, 'getEditSingleUserDetails']);
             Route::put('product/starproducts',[AdminController::class, 'editStarProduct']);
       /*  }); */
    
   /*  }); */


});

//Route::group(['middleware' => 'auth:sanctum'], function () {
   // Route::group(['middleware' => ['role:company']], function () {
        Route::get('cart/{id}',[UserBackendController::class,'getCart'])->name('user_cart_inforamtion');
        Route::post('cart/update',[UserBackendController::class,'createCart'])->name('update_user_cart_inforamtion');
        Route::put('cart/create/address',[UserBackendController::class,'createCartAddress'])->name('update_user_cart_address');

       
    //});
//});

//product
Route::get('saveallproduct',[ProductController::class,"saveAllproduct"])->name('get_all_product_from_air_table_and_save_in_the_database');
Route::get('productdataairtable',[ProductController::class,"api_getAllproductDataFromAirtable"])->name('get_all_product_from_air_table');
Route::get('products',[ProductController::class,"getProduct"])->name('get_all_product_ourdatabase');
Route::get('starproducts',[ProductController::class,"gettestProduct"]);
Route::get('products/{id}', [ProductController::class, 'getSingleProduct'])->name('get_single_product_ourdatabase');
Route::get('product/starproducts', [ProductController::class, 'getStarProduct'])->name('get_star_product_ourdatabase');
Route::get('product/usa',[ProductController::class, 'getUsaProduct']);
Route::get('product/can',[ProductController::class, 'getCanProduct']);
Route::get('product/recent',[ProductController::class, 'getRecentProduct'])->name('get_recent_product');
Route::get('airtabel/product',[ProductController::class, 'showAllCollectionAirTabel']);

//varaint 
Route::post('saveallvaraint',[VaraintController::class,"saveAllVaraintFromAirTabel"]);

//collection
Route::get('showallcollection',[AllCollectionController::class,"showAllCollection"])->name('show_all_collection_from_air_table');
Route::get('saveallcollection',[AllCollectionController::class,"saveAllCollectionFromAirTabel"])->name('save_all_collection_from_air_table');
Route::get('collection',[AllCollectionController::class,"getCollection"])->name('all_collection_from_air_table');
Route::get('collection/{collection_name}',[AllCollectionController::class,"getCollectionProducts"]);
Route::get('airtabel/collection', [AllCollectionController::class,"showAllCollectionAirTabel"])->name("air_tabel_collection");

//catogery
Route::get('saveallCatogery',[AllCatogeryController::class,"saveAllCatogeryModel"])->name('all_catogery_from_air_table');
Route::get('catogey',[AllCatogeryController::class,"showallCatogery"])->name('show_all_catogery_from_ourtable');
Route::get('airtabel/catgeory', [AllCatogeryController::class,"showAllCatogeryAirTabel"])->name("air_tabel_catogery");

//Emoji
/* Route::get('saveemoji',[EmojiController::class,"saveAllEmoji"])->name('save_emoji_from_air_table');
Route::get('emoji',[EmojiController::class,"showallCatogery"])->name('show_emoji_ourtable'); */

//

/*******************************************************************************************************************************************************************************************************************************************/

//testimg 
Route::get('testget',[TestingController::class,"gettestController"])->name("testing-controler-get");
Route::post('testpost',[TestingController::class,"posttestController"])->name("testing-controler-post");



//AIRTABE API

//EMOJI
Route::get('saveemoji',[EmojiairtableController::class,"saveEmoji"]);



//COLOURS
Route::get('savecolours',[ColourairtabelController::class,"saveColours"]);


//collection
Route::get('savecollection',[CollectionairtabelController::class,"saveCollection"]);

//product
Route::get('saveproduct',[ProductairtabelController::class,"saveProduct"]);






























