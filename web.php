<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\Adminlogincontoller;
use App\Http\Controllers\admin\usernotescontroller;

use App\Http\Controllers\admin\Dashboardcontoller;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\CrudAppController;
use App\Http\Controllers\Auth\displayusercontroller;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;



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



Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    return 'Successfully clear the cache from system!!'; //Return anything
});


// Route::get('email-test', function(){
//     $details['email'] = 'rathodkanchan12@gmail.com';
//     dispatch(new App\Jobs\SendEmailJob($details));
//     dd('done');
// });


Route::get('', [AuthController::class, 'home']); 

Route::group(['prefix' => 'user'],function(){

    Route::get('registration', [AuthController::class, 'registration'])->name('register');
    Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
     
    route::group(['middleware' => 'guest'],function(){  
        
        Route::get('login', [AuthController::class, 'index'])->name('login');
        Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
            
            
    });


    route::group(['middleware' => 'auth'],function(){

        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard'); 
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/export-profile', [displayusercontroller::class, 'exportProfile'])->name('export.profile');
        Route::get('user/edit', [UserController::class, 'edit'])->name('edit.user');
        Route::put('user/update', [UserController::class, 'update'])->name('update.record');
         Route::get('/all_records',[UserController::class,'all_records'])->name('all.records');


Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
Route::post('/notes/store', [NoteController::class, 'store'])->name('notes.store');
Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
Route::get('/notes/{note}', [NoteController::class, 'show'])->name('notes.show');
// Route to list all notes for a user
Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');



});

});


      
 
           

         
           

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');





  






Route::group(['prefix' => 'admin'],function(){
    
    route::group(['middleware' => 'admin.guest'],function(){
       
        Route::get('login', [Adminlogincontoller::class, 'showLoginForm'])->name('admin.login');
        Route::post('login', [Adminlogincontoller::class, 'login'])->name('admin.authenticate');
       
      
    });

    route::group(['middleware' => 'admin.auth'],function(){

        Route::get('/dashboard', [Dashboardcontoller::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [Dashboardcontoller::class, 'logout'])->name('admin.logout');

     
        Route::get('/users/{user}/notes', [Dashboardcontoller::class, 'userNotes'])->name('admin.users.notes');
        Route::get('/notes', [Dashboardcontoller::class, 'hello'])->name('admin.notes.hello');
       

        Route::get('/userindex',[usernotescontroller::class,'userindex'])->name('user.userindex');
      Route::delete('user/{id}',[usernotescontroller::class,'destroy'])->name('delete');
     
    });


});



