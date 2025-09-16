<?php

use App\Http\Controllers\aboutUsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\cardsTypeController;
use App\Http\Controllers\userController;
use App\Http\Controllers\agentController;
use App\Http\Controllers\delegateController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\commentController;
use App\Http\Controllers\companiesController;
use App\Http\Controllers\companiesTypeController;
use App\Http\Controllers\cityRegionController;
use App\Http\Controllers\companyProductsController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\complainController;
use App\Http\Controllers\WebNotificationController;
use App\Http\Controllers\complainsController;
use App\Http\Controllers\complainTypeController;
use App\Http\Controllers\catalogeController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClassificationsController;
use App\Http\Controllers\clinicsController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\offerController;
use App\Http\Controllers\taxController;
use App\Http\Controllers\repaymentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\earningController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\Follow_upsController;
use App\Http\Controllers\forwardController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\MedicalConsultationsController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\PatientMedicationsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\PatientServiceController;
use App\Http\Controllers\patientsVitalController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\pharmaceuticalClassController;
use App\Http\Controllers\pharmaceuticalController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShiftsController;
use App\Http\Controllers\sliderController;
use App\Http\Controllers\SubclassificationsController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestrequestController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\vitalsignsController;
use App\Http\Controllers\XrayController;
use App\Models\Service;
use App\Models\Transfer;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\userSubscriptionsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;


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

// //admin pannel

// Route::group(['prefix'=>'admin-panel'], function () {

//     Route::get('/home',[UserController::class, 'showAdminHome'])->name('admin.home');
//     Route::resource('/roles', RolesController::class);

// });


Route::get('/index', function () {
    return view('index');
})->name("index");

//spatie

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles',RoleController::class);
    Route::resource('/events',EventsController::class);

Route::resource('/agents', agentController::class);
Route::post('agent/{id}', [agentController::class, 'blocked'])->name("agents.blocked");
Route::post('unbloclAgent/{id}', [agentController::class, 'unblock'])->name("agents.unblock");

    Route::resource('permissions',PermissionController::class);
    Route::post('givePermission/{id}', [RoleController::class, 'givePermission'])->name("givePermission");
    Route::get('addPermissio/{id}', [RoleController::class, 'add'])->name("addPermission");
  /*  //patients
    Route::resource('patients',PatientsController::class);
    Route::get('/get-regions/{cityId}', [PatientsController::class, 'getRegions'])->name("getRegions");*/
    //

    //users
    // Route::resource('/all_users', UsersController::class);
    // Route::post('block_user/{id}', [UsersController::class, 'blocked'])->name("all_users.blocked");
    // Route::post('unblocl_user/{id}', [UsersController::class, 'unblock'])->name("all_users.unblock");

    //Countries
Route::resource('countries', CountriesController::class);



    Route::resource('about', aboutUsController::class);
    Route::resource('privacyPolicy', PrivacyPolicyController::class);
   /* //X-ray
    Route::resource('xray', XrayController::class);
    Route::get('addxray/{id}', [XrayController::class, 'addxray'])->name("xray.add");
    Route::get('getImages/{id}', [XrayController::class, 'getImages']);*/

    //Medical tests
    Route::resource('classifications', ClassificationsController::class);
    Route::resource('subclassifications', SubclassificationsController::class);
    Route::resource('testrequest', TestrequestController::class);
    Route::get('/get-subclassification/{classificationId}', [SubclassificationsController::class, 'getsubclassification'])->name("getSubclass");

    Route::get('addtest/{id}', [TestrequestController::class, 'addtest'])->name("addtest");
    Route::post('addtestresult/{id}', [TestrequestController::class, 'add_update_result'])->name("addtestresult");

    Route::get('addnote/{id}', [TestrequestController::class, 'addnote'])->name("addnote");

//doctors

Route::resource('groups', GroupsController::class);
Route::resource('doctors', DoctorsController::class);
Route::get('doctorsgroup/{id}', [DoctorsController::class, 'addgroup'])->name("doctorsgroup");
Route::get('doctorsclinic/{id}', [DoctorsController::class, 'addclinic'])->name("doctorsclinic");
//pharmacy
Route::resource('pharmaclassifications', pharmaceuticalClassController::class);
Route::resource('pharmaceutical', pharmaceuticalController::class);
Route::get('show/{id}', [PatientMedicationsController::class, 'showmed'])->name("showmed");
Route::get('patient_consultation/{id}', [MedicalConsultationsController::class, 'index'])->name("patient_consultation");
//Follow_up
Route::get('showfiles/{id}', [Follow_upsController::class, 'showfiles'])->name("showfiles");

Route::get('showFollow_ups/{id}', [Follow_upsController::class, 'showFollow_ups'])->name("showFollow_ups");

//shifts
Route::resource('shifts', ShiftsController::class);
//services
Route::resource('services', ServiceController::class);
Route::resource('patientservices', PatientServiceController::class);
Route::get('showpatientservices/{id}', [PatientServiceController::class, 'show'])->name("showpatientservices");
Route::get('medHistory/{id}', [MedicalHistoryController::class, 'show'])->name("medHistory");
Route::get('medicalHistory', [MedicalHistoryController::class, 'index'])->name("medicalHistory");

//chat
Route::get('messages/{id}', [ChatController::class, 'Message'])->name('getmessages');
Route::get('chats', [ChatController::class, 'index'])->name('chats');



    Route::get('/dashboard/index', function () {
        return view('index');
    })->name("dashboard");
    Route::get('/login', function () {
        return view('admin.login');
    })->name('admin-login');
    Route::post("/login",[userController::class ,'postLogin'])->name("login");


    Route::resource('subjects', SubjectController::class);
    Route::resource('users', UserController::class);
    Route::resource('answers', AnswerController::class);
    Route::resource('exams', ExamController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('students', StudentController::class);














    });
//users
Route::get('/', function () {
    return view('admin.login');
})->name('admin-login');
Route::resource('/users', userController::class);
Route::get('/profile', [userController::class, 'showProfile'])->name("profile");
Route::post('/profile', [userController::class, 'updateProfile'])->name("profile.update");
Route::post("/logout",[userController::class ,'logout'])->name("logout");
Route::post("/login",[userController::class ,'postLogin'])->name("login");


//agent
Route::resource('/dashboard/agents', agentController::class);
    Route::post('agent/{id}', [agentController::class, 'blocked'])->name("agents.blocked");
    Route::post('unbloclAgent/{id}', [agentController::class, 'unblock'])->name("agents.unblock");



//delegates
Route::resource('/delegates', delegateController::class);
Route::get('/delegate_requests', [ delegateController::class,'delegate_requests'])->name('delegate_requests');
 Route::get('/ban_delegates', [ delegateController::class,'banned'])->name ('banned');
Route::post('/accept_delegate/{id}', [delegateController::class, 'accept_delegate'])->name('delegates.accept');
Route::post('/ban/{id}', [delegateController::class, 'ban_delegate'])->name('delegates.ban');



//media
Route::post('projects/media/{table}', [MediaController::class, 'storeMedia'])
    ->name('projects.storeMedia');
Route::delete('projects/media/{table}', [MediaController::class, 'destroyMedia'])
    ->name('projects.deleteMedia');


//payments order.. e-card type
Route::resource('/payment', paymentController::class);
Route::resource('/cards_type', cardsTypeController::class);

//comments
// Route::resource('/comment', commentController::class);
Route::get('/agent_evaluate', [ commentController::class,'agent_evaluate'])->name ('agent_evaluate');
Route::get('/delegate_evaluate', [ commentController::class,'delegate_evaluate'])->name ('delegate_evaluate');
Route::get('/comment/{id}', [ commentController::class,'comment']);
Route::get('/comment/{id}/edit', [ commentController::class,'edit']);
Route::DELETE('/comment/{id}/delete', [ commentController::class,'destroy']);


//companies
Route::resource('/companies', companiesController::class);
Route::resource('/company_type', companiesTypeController::class);
/*Route::resource('/city_region', cityRegionController::class);
Route::get('/countries', [cityRegionController::class,'countries'])->name('countries.index');
Route::get('/country/{id}/cities', [cityRegionController::class,'getCountryCities'])->name('country.cities');
Route::get('/cities', [cityRegionController::class,'cities'])->name('cities.index');*/

//company products
Route::resource('/company_products', companyProductsController::class);

//product component
Route::post('component', [companyProductsController::class, 'store_components'])->name('store_components');
Route::get('product/{id}/components', [companyProductsController::class, 'get_components'])->name('get_components');
Route::post('Update_components', [companyProductsController::class, 'Update_components'])->name('Update_components');
Route::delete('components/{id}', [companyProductsController::class, 'delete_components'])->name('delete_components');


//orders
Route::resource('/orders', orderController::class);
Route::get('order/{id}/conversation', [orderController::class, 'get_conversation']);


//complains
Route::resource('/complains', complainsController::class);
Route::resource('/complain_type', complainTypeController::class);
Route::get('/deleted', [ complainsController::class,'deleted'])->name ('deleted');
Route::post('/delete_complain/{id}', [complainsController::class, 'delete_complain'])
->name('delete_complain');



Route::post('/send-web-notification', [WebNotificationController::class, 'sendWebNotification'])->name('send.web-notification');


//cataloges
Route::resource('/cataloges', catalogeController::class);

//offers
Route::resource('/offers', offerController::class);


//taxes
Route::resource('/taxes', taxController::class);



//repayment
Route::resource('/repayment', repaymentController::class);
Route::post('/get_repayment_data/{id}', [repaymentController::class, 'get_repayment_data'])
->name('get_repayment_data');

//NotificationController
Route::resource('/notifications', NotificationController::class);

Route::get('map',[orderController::class, 'showMap']);


//earn
Route::resource('/earns', earningController::class);

//slider
Route::resource('/slider', sliderController::class);

Route::resource('/userProfile',UserProfileController::class);
Route::get('/user_profile/{id}', [ UserProfileController::class,'show'])->name('user_profile');


Route::get('addsubscription/{id}', [userSubscriptionsController::class, 'addsubscription'])->name("addsubscription");
Route::post('usersub_accept/{id}', [userSubscriptionsController::class, 'usersub_accept'])->name("usersub_accept");
Route::post('usersub_decline/{id}', [userSubscriptionsController::class, 'usersub_decline'])->name("usersub_decline");

Route::resource('events', EventsController::class);


