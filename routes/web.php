<?php

use App\Http\Controllers\Dashboard\SettingController;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use BeyondCode\LaravelWebSockets\WebSockets\WebSocketHandler;
use Illuminate\Support\Facades\Route;

Route::get('/language/{lang}', [SettingController::class, 'changeLanguage'])->name('change-language');

Route::group(['namespace' => 'Auth' , 'middleware' => 'set_locale'] , function () {
    // Route::post('/','EmployeeAuthController@login')->name('employee.login');
    Route::get('/', function() {
        return redirect()->route('employee.login-form');
    });
    // employee login routes
    Route::get('employee/login','EmployeeAuthController@showLoginForm')->name('employee.login-form');
    Route::post('employee/login','EmployeeAuthController@login')->name('employee.login');
    Route::post('employee/logout','EmployeeAuthController@logout')->name('employee.logout');

    // user login routes
    Route::get('employee/login','EmployeeAuthController@showLoginForm')->name('employee.login-form');

    WebSocketsRouter::webSocket('/websocket', WebSocketHandler::class);


});




