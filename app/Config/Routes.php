<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Định tuyến mặc định
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('index');

// Trang chủ & tìm kiếm
$routes->get('/', 'HomeController::index');
$routes->get('home/search', 'HomeController::search');
$routes->get('category/(:num)', 'HomeController::categoryProducts/$1');

// Route cho sản phẩm ()
$routes->get('home/item_details/(:num)', 'ItemController::show/$1');

// Route cho giới thiệu
$routes->get('/introduce', 'Home::introduce');


// Authentication Routes (Đăng ký & Đăng nhập)
$routes->get('register', 'AuthController::register');
$routes->post('register-save', 'AuthController::registerSave');
$routes->get('login', 'AuthController::login');
$routes->post('check-login', 'AuthController::checkLogin');
$routes->get('logout', 'AuthController::logout');


// Khu vực quản trị (Admin) - sử dụng group để quản lý gọn gàng
$routes->group('admin', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');

    // Quản lý danh mục
    $routes->get('manage_categories', 'CategoryController::index');
    $routes->post('add_category', 'CategoryController::addCategory');
    $routes->post('edit_category', 'CategoryController::editCategory');
    $routes->get('delete_category/(:num)', 'CategoryController::deleteCategory/$1');

    // Quản lý sản phẩm
    $routes->get('manage_products', 'AdminProductController::index');
    $routes->post('store', 'AdminProductController::store');
    $routes->post('update', 'AdminProductController::update');
    $routes->get('delete/(:num)', 'AdminProductController::delete/$1');
    $routes->get('product_details/(:num)', 'AdminProductController::productDetails/$1');
    $routes->post('update_product_details', 'AdminProductController::updateProductDetails');
    $routes->post('upload_product_images', 'AdminProductController::uploadProductImages');


    // 📰 Quản lý tin tức
    $routes->get('manage_News', 'NewsController::index');  // Hiển thị form quản lý tin tức
    $routes->get('admin/manage_News', 'NewsController::index');
    $routes->post('news/store', 'NewsController::store');
    $routes->post('news/update', 'NewsController::update');
    $routes->get('news/delete/(:num)', 'NewsController::delete/$1');

});

$routes->get('cart', 'CartController::index'); // Route cho giỏ hàng
$routes->get('cart/getCartCount', 'CartController::getCartCount'); // Route lấy số lượng sản phẩm trong giỏ hàng
 
$routes->post('cart/addToCart/(:num)', 'CartController::addToCart/$1'); // Add product to cart with the product ID
$routes->post('cart/updateQuantity', 'CartController::updateQuantity'); // Update quantity in cart

$routes->post('cart/removeProduct', 'CartController::removeProduct');// Route xóa sản phẩm khỏi giỏ
$routes->post('cart/buyNow', 'CartController::buyNow');

// Danh mục
$routes->get('get-categories', 'CategoryController::getCategories');
$routes->get('category/(:num)', 'CategoryController::viewCategory/$1');
$routes->get('home/index', 'HomeController::index', ['filter' => 'authGuard']);

// Route cho việc tạo thanh toán VNPAY
$routes->post('vnpay_php/vnpay_create_payment', 'VnpayController::createPayment'); 


$routes->post('order/buyNow', 'OrderController::buyNow');

$routes->post('order/buyNow', 'OrderController::buyNow');
$routes->get('item/(:num)', 'ProductController::item/$1'); // Nếu bạn có ProductController để hiển thị chi tiết sản phẩm

$routes->get('admin/manage_orders', 'OrderManagementController::manageOrders');
$routes->get('admin/getOrderDetails/(:num)', 'OrderManagementController::getOrderDetails/$1');
$routes->post('admin/updateOrderStatus', 'OrderManagementController::updateOrderStatus');
$routes->post('admin/deleteOrder', 'OrderManagementController::deleteOrder');

$routes->get('order/history', 'OrderController::orderHistory');
$routes->get('order/getOrderDetails/(:num)', 'OrderController::getOrderDetails/$1');
$routes->post('order/cancelOrder', 'OrderController::cancelOrder');

$routes->get('home/introduce', 'Home::introduce'); // Giới thiệu
$routes->get('home/news', 'Home::news');           // Tin tức


$routes->get('home/item_details/(:num)', 'ItemController::show/$1');
$routes->post('product/addReview/(:num)', 'ItemController::addReview/$1');
$routes->post('product/replyReview/(:num)', 'ItemController::replyReview/$1');