<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreCategoryRequest;
use App\Http\Requests\Dashboard\StoreSubCategoryRequest;
use App\Http\Requests\Dashboard\UpdateCategoryRequest;
use App\Http\Requests\Dashboard\UpdateSubCategoryRequest;
use App\Models\Category;
use App\Models\CourseCategories;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class CourseCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $this->authorize('view_course_category');
        if ( $request->ajax() ) {

            $brands = getModelData( model: new CourseCategories() , searchingColumns: ['name_ar', 'name_en'] );

            return response()->json($brands);
        }
        return view('dashboard.coursecategory.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_course_category');

        return view('dashboard.coursecategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubCategoryRequest $request)
    {

        $this->authorize('create_course_category');
        $data = $request->validated();
        CourseCategories::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CourseCategories $category)
    {
         $this->authorize('show_course_category');

        return view('dashboard.coursecategory.show',compact('category' ));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function edit($id)
    {
        $this->authorize('update_course_category');
        $category=CourseCategories::find($id);

        return view('dashboard.coursecategory.edit',compact('category' ));
    }

    public function update(UpdateSubCategoryRequest $request, CourseCategories $category)
    {
        $this->authorize('update_course_category');
        $data = $request->validated();
        $category->update($data);
    }



    public function destroy(Request $request, $id)
    {
        $category=CourseCategories::find($id);
        $this->authorize('delete_course_category');

        if ($request->ajax())
        {
            if($category->courses()->count() > 0)
                throw ValidationException::withMessages([
                    'category' => __("This category is assigned to another and can't be deleted")
                ]);

            $category->delete();
        }
        }

}
