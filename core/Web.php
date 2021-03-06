<?php
require_once(__DIR__ . '/../model/Route.php');

Route::get('', 'IndexController', 'redirectToHome');
Route::get('home', 'IndexController', 'index');
Route::get('out', 'IndexController', 'out');
Route::get('about', 'AboutUsController', 'index');
Route::get('contact', 'ContactController', 'index');
Route::post('contact', 'ContactController', 'post');
Route::get('product', 'ProductController', 'index');
Route::get('news', 'NewsController', 'index');
Route::post('login', 'LoginController', 'post');
Route::get('login', 'LoginController', 'index');
Route::get('dashboard', 'DashboardController', 'index');
Route::get('AdminDashboard', 'AdminDashboardController', 'index');
Route::post('contact/delete', 'AdminDashboardController', 'contactDelete');
Route::post('user/edit', 'ClientsController', 'userEdit');
Route::post('user/delete', 'ClientsController', 'userDelete');
Route::post('AdminDashboard', 'AdminDashboardController', 'post');
Route::get("Clients","ClientsController","index");
Route::get("MyOrders","MyOrdersController","index");
Route::post("MyOrders","MyOrdersController","post");
Route::post("MyOrders/delete","MyOrdersController","delete");
Route::get("MyProfile","ProfileController","index");
Route::post("MyProfile/edit","ProfileController","edit");
Route::get("News","AdminNewsController","index");
Route::post("News/delete","AdminNewsController","delete");
Route::post("News/add","AdminNewsController","add");
Route::get("Order","OrderController", "index");
Route::get("Orders","AdminOrderController", "index");
Route::post("Orders/delete","AdminOrderController", "delete");
Route::post("Order/SendMessage","OrderController","sendMessage");
Route::post("Order/listMessages","OrderController","listMessages");
Route::post("Order/ChangeStatus", "OrderController","changeStatus");
