<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CycleController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BudgetTypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\TypeRecetteController;
use App\Http\Controllers\AutreRecetteController;
use App\Http\Controllers\HeadDepartmentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

    // Route::get('/', function () { 
    //     return view('index');
    // })->middleware(['auth']);


    // Route::get('/optimize', function(){
    //     $exitCode = Artisan::call('optimize');
    //     return 'DONE';
    // });

    // Route::get('/cache', function(){
    //     $exitCode = Artisan::call('cache:clear');
    //     $exitCode = Artisan::call('config:cache');
    //     return 'DONE';
    // });

    //dashboard
    // Route::group(['middleware' => ['auth:sanctum']], function(){
        
    //         Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['IsAdmin']);
    //         Route::resource('/cycle', CycleController::class);
    //         Route::resource('/faculty', FacultyController::class);
    //         Route::resource('/department', DepartmentController::class);
    //         Route::resource('/Lecturer', LecturerController::class);
    //         Route::resource('/payment_type', PaymentTypeController::class);
    //         Route::resource('/student', StudentController::class);
    //         Route::resource('/parent', ParentController::class);
    //         Route::resource('/head_department', HeadDepartmentController::class);
    //         Route::resource('/expense', ExpenseController::class);
    //         Route::resource('/expense_type', ExpenseTypeController::class);
    //         Route::resource('/classe', ClasseController::class);
    //         Route::resource('/course', CourseController::class);
    //         Route::resource('/payment', PaymentController::class);
    //         Route::resource('/type_recette', TypeRecetteController::class);
    //         Route::resource('/recette', AutreRecetteController::class);
    //         Route::resource('/budget_type', BudgetTypeController::class);
    //         Route::resource('/budget', BudgetController::class);
    // });
                    
    // Route::resource('/user', UserController::class);
    // Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    // Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Route::middleware('auth')->group(function () {
    //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // });



require __DIR__.'/auth.php';
