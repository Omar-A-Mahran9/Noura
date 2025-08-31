<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\CoursesStatus;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategories;
use App\Models\CourseImage;
use App\Models\Employee;
use App\Models\Outcome;
use App\Models\Section;
use Auth;
 use Illuminate\Http\Request;
 use Storage;

class CourseController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('view_courses');

        if ( $request->ajax() ) {

            $courses = getModelData(new Course(), relations: [
                        'instructor' => ['id', 'name','description_ar','description_en']
                    ]);

            return  response()->json($courses);
        }
        return view('dashboard.Courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::where('type','content_creators')->get(); // Assuming you want to fetch all employees
        $status = CoursesStatus::values(); // Fetch enum cases.  sections
        $categories=CourseCategories::select('id','name_' . getLocale())->get();
          $this->authorize('create_courses');

            return view('dashboard.Courses.create',compact('employees','status','categories'));
    }


    public function store(Request $request)
    {       // Validation rules
        $request->validate([
            'images' => 'required|mimes:webp,png,jpg|max:2048', // validate image type and size
        ]);
         $request->except(['moreimages']);

        // Check if the 'images' file is uploaded
        if ($request->hasFile('images')) {
            // Upload the image and store its path in $data['images']
            $data['images'] = uploadImage($request->file('images'), 'course');
        }

        $coursedata = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'preview_video_path' => $request->video_url,
            'discount_price' => $request->discount_price ,
            'have_discount' => $request->have_discount=== 'on' ? 1 : 0,
            'price' => $request->price,
            'discount_duration_days_counts' => $request->discount_duration_days_counts??0,
            'images' => $data['images'] ?? null, // Use uploaded image path or default to null
            'status' => $request->status,
            'from' => $request->from,
            'to' => $request->to,
            'open' => $request->open?$request->open:1,
            'created_by'=>Auth::user()->id,
            'assign_to'=>$request->assign_to,
            'category_ids'=>$request->category_ids,

        ];
        unset($coursedata['category_ids']); // Remove category_id from $data

         $course = Course::create($coursedata);


         if ($course) {
            $course->categories()->sync($request->category_ids);
        }
         if ($request->hasFile('moreimages')) {
            foreach ($request->file('moreimages') as $file) {
                // Upload each image
                $imagePath = uploadImage($file, "courses/images");

                // Create a BookImage record
                CourseImage::create([
                    'course_id' => $course->id,  // Associate image with the created book
                    'image' => $imagePath,    // Store the image path
                ]);
            }
        }
        $sections = $request->sections_list??[]; // Retrieve the sections list from the request
         $outcomes=$request->outcome_list??[];
        if (is_array($sections) && count($sections) > 0) {
            foreach ($sections as $section) {
                $lock = is_array($section['lock']) ? $section['lock'][0] : (isset($section['lock']) ? $section['lock'] : 0);
                 // Assuming each section contains a 'name' and 'description'
                $sectionData = [
                    'course_id'=>$course->id,
                    'lock'=>$lock,
                    'name_ar' => $section['name_ar'] ?? 'Default Name', // Fallback to default if 'name' is not set
                    'name_en' => $section['name_en'] ?? 'Default Name', // Fallback to default if 'name' is not set
                    'description_ar' => $section['description_ar'] ?? 'No description available',
                    'description_en' => $section['description_en'] ?? 'No description available',
                ];
                 // Example: Save section data to the database
                $section=Section::create($sectionData);


            }
        } else {
            // Handle case where sections_list is empty or not an array
            return response()->json(['message' => 'No sections provided.'], 400);
        }


        if (is_array($outcomes) && count($outcomes) > 0) {
            foreach ($outcomes as $outcome) {
                // Assuming each section contains a 'name' and 'description'
                $outcomeData = [
                    'course_id'=>$course->id,
                    'description_ar' => $outcome['description_ar'] ?? 'No description available',
                    'description_en' => $outcome['description_en'] ?? 'No description available',
                ];
                // Example: Save section data to the database
                $outcome=Outcome::create($outcomeData);

            }
        } else {
            // Handle case where sections_list is empty or not an array
            return response()->json(['message' => 'No outcomes provided.'], 400);
        }

    }
    public function removeImage($id)
    {

         $image = CourseImage::findOrFail($id);

        // Delete the image file
        deleteImage($image->image, 'Courses/images');

        // Delete the image record from the database
        $image->delete();
     }


    public function update(Request $request, Course $course)
    {
        // Validation rules
        $request->validate([
            'images' => 'nullable|mimes:webp,png,jpg|max:2048', // Validate image type and size (optional)
        ]);
        $request->validate([
            'moreimages'    => ['array'], // Ensure it is an array
            'moreimages.*'  => ['nullable','mimes:jpeg,png,jpg,webp,svg', 'max:2048']
             ]);

        // Check if a new image is uploaded
        if ($request->hasFile('images')) {
            // Delete the old image if it exists
            if ($course->images) {
                Storage::delete($course->images);
            }

            // Upload the new image and update the path
            $data['images'] = uploadImage($request->file('images'), 'course');
        }

        // Update course data
        $coursedata = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'preview_video_path' => $request->video_url,
            'discount_price' => $request->discount_price,
            'have_discount' => $request->have_discount === 'on' ? 1 : 0,
            'price' => $request->price,
            'discount_duration_days_counts' => $request->discount_duration_days_counts ?? 0,
            'images' => $data['images'] ?? $course->images, // Keep old image if no new image is uploaded

            'status' => $request->status,
            'from' => $request->from,
            'to' => $request->to,
            'open' => $request->open ? $request->open : $course->open,
            'assign_to' => $request->assign_to,
        ];

        $course->update($coursedata);

        // Update sections
        $sections = $request->sections_list ?? [];
        if (is_array($sections)) {
            foreach ($sections as $section) {
                $lock = is_array($section['lock']) ? $section['lock'][0] : (isset($section['lock']) ? $section['lock'] : 0);
                $sectionData = [
                    'course_id' => $course->id,
                    'lock' => $lock,
                    'name_ar' => $section['name_ar'] ?? 'Default Name',
                    'name_en' => $section['name_en'] ?? 'Default Name',
                    'description_ar' => $section['description_ar'] ?? 'No description available',
                    'description_en' => $section['description_en'] ?? 'No description available',
                ];

                if (isset($section['id'])) {
                    // Update existing section
                    $existingSection = Section::find($section['id']);
                    if ($existingSection) {
                        $existingSection->update($sectionData);
                    }
                } else {
                    // Create a new section
                    Section::create($sectionData);
                }
            }
        }

        // Update outcomes
        $outcomes = $request->outcome_list ?? [];
        if (is_array($outcomes)) {
            foreach ($outcomes as $outcome) {
                $outcomeData = [
                    'course_id' => $course->id,
                    'description_ar' => $outcome['description_ar'] ?? 'No description available',
                    'description_en' => $outcome['description_en'] ?? 'No description available',
                ];

                if (isset($outcome['id'])) {
                    // Update existing outcome
                    $existingOutcome = Outcome::find($outcome['id']);
                    if ($existingOutcome) {
                        $existingOutcome->update($outcomeData);
                    }
                } else {
                    // Create a new outcome
                    Outcome::create($outcomeData);
                }
            }
        }

        return response()->json(['message' => 'Course updated successfully!', 'course' => $course], 200);
    }

    public function show(Course $course)
    {
        //
    }


    public function edit(Course $course)
    {
        $employees = Employee::all(); // Assuming you want to fetch all employees
        $status = CoursesStatus::values(); // Fetch enum cases.  sections
        $sections = $course->getSectionsForCourse(); // This fetches the sections for the course
        $outcomes = $course->getOutcomesForCourse(); // This fetches the sections for the course
        // Explicitly reference 'categories.id' to avoid ambiguity
        $categories = CourseCategories::select('coursecategories.id', 'name_' . app()->getLocale())
        ->join('course_category', 'categories.id', '=', 'course_category.coursecategories_id')
        ->get();

        // Get selected category IDs for the article
        // Explicitly reference 'categories.id' here too
        $selectedCategoriesIds = $course->categories()->pluck('coursecategories.id')->toArray();
            $this->authorize('update_courses');
             return view('dashboard.Courses.edit',compact('course','employees','status','sections','outcomes','categories'));

    }

    public function validateStep( Request $request , Course $course = null)
    {
         if ($request['step'] == 1) {

            $discountPrice = $request['discount_price'] ?? 0;
            $price         = $request['price'] ?? 0;
            $request->validate([
                'name_ar' => ['required' , 'string','max:255'],
                'images' => 'required' ,'mimes:webp,png,jpg|max:2048', // validate image type and size
                'moreimages'    => ['array'], // Ensure it is an array
                'moreimages.*'  => ['mimes:jpeg,png,jpg,webp,svg', 'max:2048'], // Validate each file
                'name_en' => ['required' , 'string','max:255'],
                 'video_url' => ['required','nullable' , 'string','url'],
                 'price' => 'required | numeric|lte:2147483647|not_in:0|gt:' . $discountPrice,
                 'discount_price' => 'required_with:have_discount|nullable|numeric|not_in:0|lt:' . $price,
                 'discount_duration_days_counts' => 'required_with:have_discount|nullable|numeric',
                 'assign_to' => ['required'],
                 'from' => ['required', 'date', 'before:to'],
                 'to'   => ['required', 'date', 'after:from'],
                'status' => ['required'],

                 'category_ids'     => ['required', 'array'], // Ensures it's an array
                 'category_ids.*'   => ['exists:coursecategories,id'], // Ensures each selected ID exists in the `categories` table
            ]);

        }elseif ($request['step'] == 2) {
            $request->validate([
                'sections_list'                                  => [ 'required' ,'array'],
                'sections_list.*.name_ar'                        => [ 'required' ],
                'sections_list.*.name_en'                        => [ 'required' ],
                'sections_list.*.description_ar'                     => [ 'required' ],
                'sections_list.*.description_en'                     => [ 'required' ],
            ]);

        }elseif ($request['step'] == 3) {
            $request->validate([

                 'description_ar' => ['required' , 'string'],
                 'description_en' => ['required' , 'string'],

            ]);

        }elseif ($request['step'] == 4) {
         $request->validate([

           'outcome_list'                                  => [ 'required' ,'array'],
           'outcome_list.*.description_ar'                     => [ 'required' ],
           'outcome_list.*.description_en'                     => [ 'required' ],

            ]);

         if($request->course_id){
            $course=Course::find($request->course_id);
            $this->update( $request,$course );

         }else{
            $this->store( $request );

         }






        }
    }




        public function destroy(Request $request , Course $course)
        {
            $this->authorize('delete_courses');

            if ($request->ajax())
            {
                $course->delete();
             }

        }




}
