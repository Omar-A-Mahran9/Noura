<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class SharedController extends Controller
{
    /** shared means that functions that exist in dashboard and web **/


 

    public function getSection(Course $course)
    {
        // Now $course will contain the course model with ID 6 or whatever ID is in the URL
        $sections = $course->sections()->select('id', 'name_' . app()->getLocale(), 'description_' . app()->getLocale())->get();
    
        return response()->json([
            'sections' => $sections
        ]);
    }
    


 

}
