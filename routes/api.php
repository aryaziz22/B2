<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CekSuratController;
use App\Http\Controllers\MobileAPI\Login;
use App\Http\Controllers\MobileAPI\NotifikasiMobile;
use App\Http\Controllers\MobileAPI\ProfilController;
use App\Http\Controllers\AuthController;





//tolak pengajuan surat web
Route::post('tolak',[CekSuratController::class, 'tolak'])->name('tolaksurat');
Route::post('tolak-detail',[CekSuratController::class, 'tolakdetail'])->name('tolaksuratdetail');
Route::post('kirimkodeotpweb', [AuthController::class, 'kode'])->name('kirimkodeotpweb');

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


Route::prefix('/MobileAPI')->group(function () {
    //login, register, lupa password
   Route::post('login', [Login::class, 'login'])->name('login');
   Route::post('register', [Login::class, 'register'])->name('register');
   Route::post('kirimkodeotp', [Login::class, 'kirimkodeotp'])->name('kirimkodeotp');
   Route::post('cekkodeotp', [Login::class, 'cekkodeotp']);
   Route::post('ubahpassword', [Login::class, 'ubahpassword']);
   Route::post('save_google_email', [Login::class, 'logingoogle']);



   
   Route::get('get_notifikasi', [NotifikasiMobile::class, 'getNotifikasi']);

   Route::post('upload_foto_profil', [ProfilController::class, 'upload']);
    
});
