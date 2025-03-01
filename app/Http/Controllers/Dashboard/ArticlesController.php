<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreArticlesRequest;
use App\Http\Requests\Dashboard\UpdateArticlesRequest;
use App\Models\Articles;
use App\Models\Category;
use Auth;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view_articles');

        if ($request->ajax())
        {
            $data = getModelData(model: new Articles());
      
             return response()->json($data);
        }

        return view('dashboard.articles.index');
    }



    public function create()
    {
 
        $this->authorize('create_articles');
        $categories=Category::select('id','name_' . getLocale())->get();

        return view('dashboard.articles.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(StoreArticlesRequest $request)
     {
         // Ensure proper authorization
         $this->authorize('create_articles');
     
         // Get validated data and exclude category_id
         $data = $request->validated();
         unset($data['category_id']); // Remove category_id from $data
            $data['publish']=1;
         // Check and upload the image if it's present
         if ($request->file('main_image')) {
             $data['main_image'] = uploadImage($request->file('main_image'), "articles");
         }
         $data['assign_to']=Auth::user()->id;
          // Create the article without category_id
         $article = Articles::create($data);
     
         // Check if the article was created
         if ($article) {
             // Sync the categories from the request data
             // Ensure category_id is passed as an array
             $article->categories()->sync($request->category_id);
         }
     
         // Optionally, return a success response or redirect
      }
     

 
    public function show(Articles $article)
    {
        $this->authorize('show_articles');
        return view('dashboard.articles.show',compact('article'));
    }
 
    public function edit(Articles $article)
    {
        // Ensure the user has permission to update articles
        $this->authorize('update_articles');
    
        // Fetch categories with the dynamic name based on the current locale
        // Explicitly reference 'categories.id' to avoid ambiguity
        $categories = Category::select('categories.id', 'name_' . app()->getLocale())
                              ->join('article_category', 'categories.id', '=', 'article_category.category_id')
                              ->get();
    
        // Get selected category IDs for the article
        // Explicitly reference 'categories.id' here too
        $selectedCategoriesIds = $article->categories()->pluck('categories.id')->toArray();
    
        // Return the view with article, categories, and selected category IDs
        return view('dashboard.articles.edit', compact('article', 'categories', 'selectedCategoriesIds'));
    }
  
    public function update(UpdateArticlesRequest $request, Articles $article)
    {
        $this->authorize('update_articles');
        
        // Get validated data from the request
        $data = $request->validated();
        unset($data['category_id']); // Remove category_id from $data
        // Check if the 'main_image' file is provided and update the image
        if ($request->hasFile('main_image')) {
            // Delete the existing image first if it exists
            deleteImage($article->main_image, 'articles');
            // Upload the new image
            $data['main_image'] = uploadImage($request->file('main_image'), 'articles');
        }
        $data['assign_to']=Auth::user()->id;

        // Update the article data (excluding category_id)
        $article->update($data);
    
        // Sync the categories using the category_id from the request
        if ($request->has('category_id') && is_array($request->category_id)) {
            // Sync the categories in the pivot table
            $article->categories()->sync($request->category_id);
        }
    
        // Optionally, return a success response or redirect
     }
    
    

    public function destroy(Request $request,Articles $article)
    {
        $this->authorize('delete_articles');

        if($request->ajax())
        {
            $article->delete();
            deleteImage($article->main_image , 'articles' );
        }
    }
}
