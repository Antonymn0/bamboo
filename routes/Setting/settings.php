<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Setting\SettingsController;

Route::group(['middleware' => ['auth','permission:manage_settings']], function () {
    Route::resource('settings',SettingsController::class);
});