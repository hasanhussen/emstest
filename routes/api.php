
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebNotificationController;
use App\Http\Controllers\api\AuthController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/store-token', [WebNotificationController::class, 'storeToken'])->name('store.token');
// Route::post('/login', [AuthController::class, 'login']);

Route::post('/login', [App\Http\Controllers\api\user_control::class, 'login'])->name('login');
Route::post('/register', [App\Http\Controllers\api\user_control::class, 'Register'])->name('register');
Route::post('/profile', [App\Http\Controllers\api\user_control::class, 'getprofile'])->name('profile');
Route::post('/get_others_profile', [App\Http\Controllers\api\user_control::class, 'get_others_profile'])->name('get_others_profile');
Route::post('/update_user', [App\Http\Controllers\api\user_control::class, 'update'])->name('update_user');


Route::get('/subjects', [App\Http\Controllers\api\SubjectController::class, 'index'])->name('subjects.index');
Route::get('/questions', [App\Http\Controllers\api\QuestionController::class, 'index'])->name('questions.index');
Route::post('/answer-exam', [App\Http\Controllers\api\AnswerExamController::class, 'store'])->name('answer-exam.store');
Route::post('/exam/enter/{userId}/{examId}', [App\Http\Controllers\API\ExamUserController::class, 'enterExam'])->name('exam.enter');



//countries
Route::get('/get_countries', [App\Http\Controllers\api\countriescontroller::class, 'index'])->name('get_countries');

//friends request
Route::post('/sendRequest', [App\Http\Controllers\api\friendsrequest_controller::class, 'sendRequest'])->name('sendRequest');
Route::post('/friendsequests', [App\Http\Controllers\api\friendsrequest_controller::class, 'friendsequests'])->name('friendsequests');
Route::post('/Accept', [App\Http\Controllers\api\friendsrequest_controller::class, 'requestAccept'])->name('Accept');
Route::post('/Reject', [App\Http\Controllers\api\friendsrequest_controller::class, 'requestReject'])->name('Reject');
Route::post('/cancel', [App\Http\Controllers\api\friendsrequest_controller::class, 'cancel'])->name('cancel');
Route::post('/cancelRequest', [App\Http\Controllers\api\friendsrequest_controller::class, 'cancelRequest'])->name('cancelRequest');
//chat
Route::post('/send_message', [App\Http\Controllers\api\chatcontroller::class, 'send_message'])->name('send_message');
Route::post('/conversations', [App\Http\Controllers\api\chatcontroller::class, 'getconversations'])->name('conversations');
Route::post('/chat', [App\Http\Controllers\api\chatcontroller::class, 'getchat'])->name('chat');













Route::post('/addcompany', [App\Http\Controllers\api\user_control::class, 'Registercompany'])->name('addcompany');

Route::get('/complain_type', [App\Http\Controllers\api\complaint_control::class, 'index'])->name('complain_type');


Route::post('/addcomplain', [App\Http\Controllers\api\complaint_control::class, 'add'])->name('addcomplain');
Route::get('/category', [App\Http\Controllers\api\home_control::class, 'category'])->name('category');
Route::get('/slider', [App\Http\Controllers\api\home_control::class, 'getslider'])->name('slider');
Route::get('/country', [App\Http\Controllers\api\home_control::class, 'country'])->name('country');

Route::get('/cataloge', [App\Http\Controllers\api\home_control::class, 'catalog'])->name('cataloge');
Route::post('/store_product', [App\Http\Controllers\api\company_control::class, 'store_product'])->name('store_product');
Route::post('/addproduct', [App\Http\Controllers\api\company_control::class, 'addproduct'])->name('addproduct');

Route::post('/addcomp', [App\Http\Controllers\api\company_control::class, 'addcomp'])->name('addcomp');
Route::post('/store', [App\Http\Controllers\api\home_control::class, 'getstore'])->name('store');

//orders
Route::post('/get_my_order', [App\Http\Controllers\api\order_control::class, 'get_my_order'])->name('get_my_order');
Route::post('/inite_order', [App\Http\Controllers\api\order_control::class, 'add_order'])->name('inite_order');
Route::post('/get_my_order_driver', [App\Http\Controllers\api\order_control::class, 'get_my_order_driver'])->name('get_my_order_driver');
Route::post('/add_to_order', [App\Http\Controllers\api\order_control::class, 'add_to_order'])->name('add_to_order');
Route::post('/get_free_order_driver', [App\Http\Controllers\api\order_control::class, 'get_wait_order_for_driver'])->name('get_free_order_driver');
Route::post('/get_offers_for_order', [App\Http\Controllers\api\order_control::class, 'get_offers_for_order'])->name('get_offers_for_order');
Route::post('/accept_offers', [App\Http\Controllers\api\order_control::class, 'accept_offers'])->name('accept_offers');

Route::post('/decline_offers', [App\Http\Controllers\api\order_control::class, 'decline_offers'])->name('decline_offers');
//rate and comment
Route::post('/addrate', [App\Http\Controllers\api\rate_control::class, 'add_star'])->name('addrate');
Route::post('/addcoment', [App\Http\Controllers\api\rate_control::class, 'add_comment'])->name('addcoment');
Route::post('/comment', [App\Http\Controllers\api\rate_control::class, 'comment'])->name('comment');

Route::post('/user_comment', [App\Http\Controllers\api\rate_control::class, 'driver_comment'])->name('user_comment');
//my product
Route::post('/myproduct', [App\Http\Controllers\api\company_control::class, 'my_product'])->name('myproduct');




