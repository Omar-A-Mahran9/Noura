<?php

use App\Http\Controllers\SharedController;

/** "shared" means that routes that exist in dashboard and web **/

Route::controller(SharedController::class)->group(function (){

    /** ajax routes **/
    Route::get('get-course-parent-section/{course}', 'getSection')->middleware('web','set_locale');

     /** ajax routes **/

});
