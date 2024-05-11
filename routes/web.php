<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TableController;

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

Route::get('/', function () {
    $title = 'Login';
    return view('login', compact('title'));
})->name('login');

Route::get('/register', function () {
    $title = 'Register';
    return view('register', compact('title'));
});

Route::get('/forgot_password', function () {
    $title = 'Forgot Password';
    return view('forgot_password', compact('title'));
});

Route::post("/login", [UserController::class, 'login']);
Route::post("/registration", [RegistrationController::class, 'registration']);
Route::post("/user_availability", [RegistrationController::class, 'userAvailability']);
Route::post("/forgot_password_accessability", [RegistrationController::class, 'forgotPasswordAccessability']);
Route::post("/send_reset_password_link", [RegistrationController::class, 'sendResetPasswordLink']);
Route::get("/reset_my_password/{email}/{code}", [RegistrationController::class, 'resetMyPassword']);
Route::post("/resetting_password/{email}/{code}", [RegistrationController::class, 'resettingPassword']);
Route::get('/verify/{token}/{user_id}', [UserController::class, 'verifyAccount'])->name('user.verify');
Route::get('email/verify', [UserController::class, 'verify'])->name('verification.notice')->middleware(['auth']);
Route::get('send_verification_email', [UserController::class, 'sendVerificationEmail'])->name('verification.email')->middleware(['auth']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get("/dashboard", [UserController::class, 'dashboard'])->name('dashboard');

    Route::get("/registration_requests", [UserController::class, 'registrationRequests']);
    Route::get("/users", [UserController::class, 'users'])->middleware('super_admin_level_access');
    Route::get("/new_user", [UserController::class, 'newUser'])->middleware('super_admin_level_access');
    Route::post("/save_new_user", [UserController::class, 'saveNewUser'])->middleware('super_admin_level_access');
    Route::get("/reset_password/{id}", [UserController::class, 'resetPassword'])->middleware(['admin_level_access', 'account_validity']);
    Route::get("/sales_accounts", [UserController::class, 'salesAccounts'])->middleware(['admin_level_access', 'account_validity']);
    Route::get("/edit_sales_account/{id}", [UserController::class, 'editSalesAccount'])->middleware(['admin_level_access', 'account_validity']);
    Route::post("/update_sales_account/{id}", [UserController::class, 'updateSalesAccount'])->middleware(['admin_level_access', 'account_validity']);
    Route::get("/create_sales_account", [UserController::class, 'createSalesAccount'])->middleware(['admin_level_access', 'account_validity']);
    Route::post("/save_sales_account", [UserController::class, 'saveSalesAccount'])->middleware(['admin_level_access', 'account_validity']);
    Route::get("/edit_registration_request/{id}", [UserController::class, 'editRegistrationRequest'])->middleware('super_admin_level_access');
    Route::get("/edit_user/{id}", [UserController::class, 'editUser'])->middleware('super_admin_level_access');
    Route::post("/update_user/{id}", [UserController::class, 'updateUser'])->middleware('super_admin_level_access');
    Route::post("/update_registration_info/{id}", [UserController::class, 'updateRegistrationInfo'])->middleware('super_admin_level_access');
    Route::get("/profile", [UserController::class, 'getProfileInfo']);
    Route::put("/update_user_profile/{id}", [UserController::class, 'updateUserProfile']);

    Route::get("/expenses", [ExpenseController::class, 'expenses'])->middleware(['account_validity']);
    Route::get("/create_expense", [ExpenseController::class, 'createExpense'])->middleware(['account_validity']);
    Route::post("/save_expense", [ExpenseController::class, 'saveExpense'])->middleware(['account_validity']);
    Route::get("/edit_expense/{id}", [ExpenseController::class, 'editExpense'])->middleware(['admin_level_access', 'account_validity']);
    Route::post("/update_expense/{id}", [ExpenseController::class, 'updateExpense'])->middleware(['admin_level_access', 'account_validity']);
    Route::get("/delete_expense/{id}", [ExpenseController::class, 'deleteExpense'])->middleware(['admin_level_access', 'account_validity']);

    Route::get("/products", [ProductController::class, 'productList'])->middleware(['admin_level_access', 'account_validity']);
    Route::get("/create_product", [ProductController::class, 'createProduct'])->middleware(['admin_level_access', 'account_validity']);
    Route::post("/save_product", [ProductController::class, 'saveProduct'])->middleware(['admin_level_access', 'account_validity']);
    Route::get("/edit_product/{id}", [ProductController::class, 'editProduct'])->middleware(['admin_level_access', 'account_validity']);
    Route::post("/update_product/{id}", [ProductController::class, 'updateProduct'])->middleware(['admin_level_access', 'account_validity']);

    Route::get("/categories", [CategoryController::class, 'categoryList'])->middleware(['admin_level_access', 'account_validity']);
    Route::get("/create_category", [CategoryController::class, 'createCategory'])->middleware(['admin_level_access', 'account_validity']);
    Route::post("/save_category", [CategoryController::class, 'saveCategory'])->middleware(['admin_level_access', 'account_validity']);
    Route::get("/edit_category/{id}", [CategoryController::class, 'editCategory'])->middleware(['admin_level_access', 'account_validity']);
    Route::post("/update_category/{id}", [CategoryController::class, 'updateCategory'])->middleware(['admin_level_access', 'account_validity']);

    Route::get("/tables", [TableController::class, 'index'])->middleware(['admin_level_access', 'account_validity']);
    Route::get("/create_table", [TableController::class, 'createTable'])->middleware(['admin_level_access', 'account_validity']);
    Route::post("/save_table", [TableController::class, 'saveTable'])->middleware(['admin_level_access', 'account_validity']);
    Route::get("/edit_table/{id}", [TableController::class, 'editTable'])->middleware(['admin_level_access', 'account_validity']);
    Route::put("/update_table/{id}", [TableController::class, 'updateTable'])->middleware(['admin_level_access', 'account_validity']);
    Route::get("/delete_table/{id}", [TableController::class, 'deleteTable'])->middleware(['admin_level_access', 'account_validity']);

    Route::get("/pending_sell_list", [SaleController::class, 'pendingSellList'])->middleware(['account_validity']);
    Route::get("/print/{invoice_id}", [SaleController::class, 'printOrder'])->middleware(['account_validity']);
    Route::get("/print_invoice/{invoice_id}", [SaleController::class, 'printInvoice'])->middleware(['account_validity']);
    Route::get("/sale_product", [SaleController::class, 'saleProduct'])->middleware(['account_validity']);
    Route::post("/save_sale_product", [SaleController::class, 'saveSaleProduct'])->middleware(['account_validity']);
    Route::get("/edit_order/{invoice_id}", [SaleController::class, 'editOrder'])->middleware(['account_validity']);
    Route::post("/update_sale_product", [SaleController::class, 'udpateSaleProduct'])->middleware(['account_validity']);
    Route::get("/reconcile_order", [SaleController::class, 'reconcileOrder'])->middleware(['admin_level_access', 'account_validity']);
    Route::post("/allow_reconciliation", [SaleController::class, 'allowReconciliation'])->middleware(['admin_level_access', 'account_validity']);
});

Route::middleware(['auth'])->group(function () {
    Route::get("/logout", [UserController::class, 'logout']);
});