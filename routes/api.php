<?php


use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\SalesMasterController;
use App\Http\Controllers\SalesDetailsController;

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



Route::post('/login', [LoginController::class, 'loginstore'])->name('login');

Route::middleware('auth.api')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

     // Category

     Route::get('/category', [CategoryController::class, 'category'])->name('category');
     Route::get('/getcategory', [CategoryController::class, 'getCategory'])->name('getcategory');
     Route::get('/category/create', [CategoryController::class, 'createCategory'])->name('category.create');
     Route::post('/category/store', [CategoryController::class, 'storeCategory'])->name('category.store');
     Route::post('/category/update', [CategoryController::class, 'categoryUpdate'])->name('update.category');
     Route::get('/category/destroy',[CategoryController::class,'categoryDestroy'])->name('destroy.category');


    // Sub Category

    Route::get('/subcategory', [SubCategoryController::class, 'subcategory'])->name('subcategory');
    Route::get('/getsubcategory', [SubCategoryController::class, 'getSubCategory'])->name('getsubcategory');
    Route::get('/subcategory/create', [SubCategoryController::class, 'createsubCategory'])->name('subcategory.create');
    Route::post('/subcategory/store', [SubCategoryController::class, 'storesubCategory'])->name('subcategory.store');
    Route::post('/subcategory/update', [SubCategoryController::class, 'Updatesubcategory'])->name('update.subcategory');
    Route::get('/subcategory/destroy',[SubCategoryController::class,'Destroysubcategory'])->name('destroy.subcategory');


     // User

     Route::get('/user', [UserController::class, 'users'])->name('user');
     Route::get('/getuser', [UserController::class, 'getUser'])->name('getuser');
     Route::get('/user/create',[UserController::class,'userCreate'])->name('create.user');
     Route::post('/user/insert',[UserController::class,'userInsert'])->name('insert.user');
     Route::post('/user/update', [UserController::class, 'userUpdate'])->name('update.user');
     Route::get('/user/destroy',[UserController::class,'userDestroy'])->name('destroy.user');


      // Products

    Route::get('/products', [ProductController::class, 'products'])->name('products');
    Route::get('/getproduct', [ProductController::class, 'getProduct'])->name('getproduct');
    Route::get('/product/create',[ProductController::class,'productCreate'])->name('create.product');
    Route::post('/product/insert',[ProductController::class,'productInsert'])->name('insert.product');
    Route::post('/product/update', [ProductController::class, 'productUpdate'])->name('update.product');
    Route::get('/product/destroy',[ProductController::class,'productDestroy'])->name('destroy.product');


    // Product Image

    Route::get('/productsImage', [ProductImageController::class, 'productsImage'])->name('productsImage');
    Route::get('/getproductsImage', [ProductImageController::class, 'getProductImage'])->name('getproductImage');
    Route::get('/productImage/create',[ProductImageController::class,'productCreateImage'])->name('create.productImage');
    Route::post('/productImage/store',[ProductImageController::class,'productInsertImage'])->name('insert.productImage');
    Route::post('/productImage/update', [ProductImageController::class, 'productsImageUpdate'])->name('update.productImage');
    Route::get('/productImage/destroy',[ProductImageController::class,'productsImageDestroy'])->name('destroy.productImage');


    // Rating

    Route::get('/ratings', [RatingController::class, 'ratings'])->name('ratings');
    Route::get('/getrating', [RatingController::class, 'getRating'])->name('getrating');
    Route::get('/rating/create',[RatingController::class,'ratingCreate'])->name('create.rating');
    Route::post('/rating/insert',[RatingController::class,'ratingtInsert'])->name('insert.rating');
    Route::post('/rating/update/{id}', [RatingController::class, 'ratingUpdate'])->name('update.rating');
    Route::get('/rating/destroy/{id}',[RatingController::class,'ratingDestroy'])->name('destroy.rating');

    // Cart

    Route::get('/carts', [CartController::class, 'carts'])->name('carts');
    Route::get('/getcart', [CartController::class, 'getCart'])->name('getcart');
    Route::get('/cart/create',[CartController::class,'cartCreate'])->name('create.cart');
    Route::post('/cart/insert',[CartController::class,'cartInsert'])->name('insert.cart');
    Route::post('/cart/update', [CartController::class, 'cartUpdate'])->name('update.cart');
    Route::get('/cart/destroy',[CartController::class,'cartDestroy'])->name('destroy.cart');



    // WishList

    Route::get('/wishlists', [WishlistController::class, 'wishlists'])->name('wishlists');
    Route::get('/getwishlists', [WishlistController::class, 'getWishlists'])->name('getwishlists');
    Route::get('/wishlist/create',[WishlistController::class,'wishlistCreate'])->name('create.wishlist');
    Route::post('/wishlist/insert',[WishlistController::class,'wishlistInsert'])->name('insert.wishlist');
    Route::post('/wishlist/update', [WishlistController::class, 'wishlistUpdate'])->name('update.wishlist');
    Route::get('/wishlist/destroy',[WishlistController::class,'wishlistDestroy'])->name('destroy.wishlist');


    // User Address

    Route::get('/user-address', [UserAddressController::class, 'userAddress'])->name('useraddress');
    Route::get('/getuser-address', [UserAddressController::class, 'getUserAddress'])->name('getuser-address');
    Route::get('/user-address/create',[UserAddressController::class,'userAddressCreate'])->name('create.useraddress');
    Route::post('/user-address/insert',[UserAddressController::class,'userAddressInsert'])->name('insert.useraddress');
    Route::post('/user-address/update', [UserAddressController::class, 'userAddressUpdate'])->name('update.useraddress');
    Route::get('/user-address/destroy',[UserAddressController::class,'userAddressDestroy'])->name('destroy.useraddress');

    // Coupon

    Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
    Route::get('/getcoupon', [CouponController::class, 'getCoupon'])->name('getcoupon');
    Route::get('/coupon/create',[CouponController::class,'couponCreate'])->name('create.coupon');
    Route::post('/coupon/insert',[CouponController::class,'couponInsert'])->name('insert.coupon');
    Route::post('/coupon/update', [CouponController::class, 'couponUpdate'])->name('update.coupon');
    Route::get('/coupon/destroy',[CouponController::class,'couponDestroy'])->name('destroy.coupon');

    // SalesMaster

    Route::get('/salesmaster', [SalesMasterController::class, 'salesmaster'])->name('salesmaster');
    Route::get('/getsalesmaster', [SalesMasterController::class, 'getSalesMaster'])->name('getsalesmaster');
    Route::get('/salesmaster/create',[SalesMasterController::class,'salesmasterCreate'])->name('create.salesmaster');
    Route::post('/salesmaster/insert',[SalesMasterController::class,'salesmasterInsert'])->name('insert.salesmaster');
    Route::post('/salesmaster/update', [SalesMasterController::class, 'salesmasterUpdate'])->name('update.salesmaster');
    Route::get('/salesmaster/destroy',[SalesMasterController::class,'salesmasterDestroy'])->name('destroy.salesmaster');

    // SalesDetails

    Route::get('/salesdetail', [SalesDetailsController::class, 'salesdetail'])->name('salesdetail');
    Route::get('/getsalesdetail', [SalesDetailsController::class, 'getSalesDetail'])->name('getsalesdetail');
    Route::get('/salesdetail/create',[SalesDetailsController::class,'salesdetailCreate'])->name('create.salesdetail');
    Route::post('/salesdetail/insert',[SalesDetailsController::class,'salesdetailInsert'])->name('insert.salesdetail');
    Route::post('/salesdetail/update', [SalesDetailsController::class, 'salesdetailUpdate'])->name('update.salesdetail');
    Route::get('/salesdetail/destroy',[SalesDetailsController::class,'salesdetailDestroy'])->name('destroy.salesdetail');


});
