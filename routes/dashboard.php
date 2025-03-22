<?php

use App\Http\Controllers\Dashboard\ArticlesController;
use App\Http\Controllers\Dashboard\BookController;
use App\Http\Controllers\Dashboard\ConsultaionController;
use App\Http\Controllers\Dashboard\CourseController;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use BeyondCode\LaravelWebSockets\WebSockets\WebSocketHandler;
use Illuminate\Support\Facades\Route;


Route::group([ 'prefix' => 'dashboard' , 'namespace' => 'Dashboard', 'as' => 'dashboard.' , 'middleware' => ['web', 'auth:employee', 'set_locale'] ] , function (){
    Route::get('/consultation-orders', [ConsultaionController::class, 'order'])
    ->name('consultation_order.index');

    Route::get('/consultation-orders/{id}', [ConsultaionController::class, 'order_show'])
    ->name('consultation_order.show');


    /** set theme mode ( light , dark ) **/
    Route::get('/change-theme-mode/{mode}', 'SettingController@changeThemeMode');

    /** dashboard index **/
    Route::get('/' , 'DashboardController@index')->name('index');


    /** resources routes **/
    Route::resource('consultationtype', 'ConsultaionTypeController');
    Route::resource('consultation_time', 'ConsultaionController');


    Route::resource('categories', 'CategoriesController');
    Route::resource('coursecategories', 'CourseCategoriesController');

    Route::resource('tags', 'TagController');
    Route::resource('courses','CourseController');
    Route::resource('Courses_Order','CourseController');

    Route::post('course-validate/{course?}','CourseController@validateStep');

    Route::prefix('courses')->group(function () {
        Route::resource('videos', 'VideosController')->names([
            'index' => 'courses.videos.index',
            'create' => 'courses.videos.create',
            'store' => 'courses.videos.store',
            'show' => 'courses.videos.show',
            'edit' => 'courses.videos.edit',
            'update' => 'courses.videos.update',
            'destroy' => 'courses.videos.destroy',
        ]);
        Route::resource('attachment', 'AttachmentController')->names([
            'index' => 'courses.attachment.index',
            'create' => 'courses.attachment.create',
            'store' => 'courses.attachment.store',
            'show' => 'courses.attachment.show',
            'edit' => 'courses.attachment.edit',
            'update' => 'courses.attachment.update',
            'destroy' => 'courses.attachment.destroy',
        ]);
    });
    Route::resource('books', 'BookController');
    Route::resource('books_orders', 'BookController');
    Route::resource('group_chat', 'GroupsController');
    Route::get('/chat', 'ChatController@groups')->name('chat.groups');
    Route::get('/chat/group/{id}', 'ChatController@group')->name('chat.group');
    Route::post('/chat/join-group/{id}', 'ChatController@joinToGroup')->name('chat.joinGroup');
    Route::post('/chat/send-message', 'ChatController@sendMessage')->name('chat.sendMessage');

    Route::resource('consultation', '');

    Route::post('bookImages/{id}', [BookController::class, 'removeImage'])
    ->name('dashboard.bookImages.removeImage');

    Route::post('courseImages/{id}', [CourseController::class, 'removeImage'])
    ->name('dashboard.courseImages.removeImage');

    Route::resource('articles', 'ArticlesController');
    Route::resource('comments', 'CommentsController');

    Route::resource('quizzes','QuizzeController');
    Route::prefix('quizzes')->group(function () {
        Route::resource('questions', 'QuestionsController')->names([
            'index' => 'quizzes.questions.index',
            'create' => 'quizzes.questions.create',
            'store' => 'quizzes.questions.store',
            'show' => 'quizzes.questions.show',
            'edit' => 'quizzes.questions.edit',
            'update' => 'quizzes.questions.update',
            'destroy' => 'quizzes.questions.destroy',
        ]);

    });

     Route::resource('roles','RoleController');
    Route::resource('employees','EmployeeController');
    Route::resource('vendors','VendorController');
    Route::resource('contact-us','ContactUsController')->except(['store','create','destroy']);
    Route::resource('news-subscribers','NewsSubscriberController')->except(['store','create','show']);
    Route::resource('settings','SettingController')->only(['index','store']);

    /** ajax routes **/
    Route::get('role/{role}/employees','RoleController@employees');
     Route::post('change-status/{order}','OrderController@changeStatus');

    /** employee profile routes **/

    Route::view('edit-profile','dashboard.employees.edit-profile')->name('edit-profile');
    Route::put('update-profile', 'EmployeeController@updateProfile')->name('update-profile');
    Route::put('update-password', 'EmployeeController@updatePassword')->name('update-password');

    WebSocketsRouter::webSocket('/websocket',WebSocketHandler::class);


});
