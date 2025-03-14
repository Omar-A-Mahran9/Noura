<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreArticlesRequest;
use App\Http\Requests\Dashboard\UpdateArticlesRequest;
use App\Http\Resources\Api\ArticleResources;
use App\Http\Resources\Api\VendorResources;
use App\Models\ArticalComment;
use App\Models\Articles;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Vendor;
use Auth;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
public function authors(){
    $employee=Employee::where('type','author')->get();
        // Return the transformed article data
        return $this->success(
            message: "Authors",
            data: VendorResources::collection($employee)
        );
}



public function index(Request $request)
{
    // Get filter parameters from request
    $dateFilter = $request->query('date'); // Expected format: YYYY-MM-DD
    $authorFilter = $request->query('author_id'); // Filter by author ID

    // Query articles with comments and vendors
    $query = Articles::with('comments', 'comments.vendor');

    // Apply date filter if provided
    if ($dateFilter) {
        $query->whereDate('created_at', $dateFilter);
    }

    // Apply author filter if provided
    if ($authorFilter) {
        $query->where('assign_to', $authorFilter);
    }

    // Paginate the filtered results
    $articles = $query->paginate(10);

    // Fetch the latest 5 blogs
    $latestBlogs = Articles::with('comments', 'comments.vendor')
        ->latest()
        ->take(4)
        ->get();

    // Transform the latest blogs
    $transformedLatestBlogs = ArticleResources::collection($latestBlogs)->resolve();
    $Blogs = ArticleResources::collection($articles)->resolve();

    // Prepare the paginated response
    return response()->json([
        'success' => true,
        'data' => $articles->items(), // Current page's items
        'latest_blogs' => $transformedLatestBlogs, // Latest blogs transformed
        'links' => [
            'prev' => $articles->previousPageUrl(), // Previous page URL
            'next' => $articles->nextPageUrl(),     // Next page URL
        ],
        'meta' => [
            'total' => $articles->total(),                 // Total items
            'per_page' => $articles->perPage(),            // Items per page
            'current_page' => $articles->currentPage(),    // Current page
            'last_page' => $articles->lastPage(),          // Last page
            'number_of_new_data_on_page' => $articles->count(), // Current page item count
            'current_data_on_this_page' => min(
                $articles->total(),
                $articles->perPage() * $articles->currentPage()
            ), // Total items displayed so far
        ],
        'message' => "Filtered Pagination articles",
    ]);
}



    public function single($id)
    {
        // Retrieve the single article with its related comments and vendor data
        $article = Articles::where('id', $id)
            ->with('comments', 'comments.vendor')
            ->first();

        // If the article does not exist, return a 404 response
        if (!$article) {
            return $this->failure("Article not found");

        }

        // Use the singular ArticleResource to transform the single article
        $data = ArticleResources::make($article); // Use make() to transform a single resource

        // Return the transformed article data
        return $this->success(
            message: "Single article",
            data: $data
        );
    }

    public function comments($article_id)
    {
        // Fetch paginated comments for the given article ID
        $comments = ArticalComment::where('article_id', $article_id)->paginate(3);

        // Transform the data to include only required fields
        $transformedComments = $comments->through(function ($comment) {
            return [
                'id' => $comment->id,
                'description' => $comment->description,
                'client' => $comment->vendor->name,
                'client_image' => getImagePathFromDirectory($comment->vendor->image, 'ProfileImages'),
                'created_at' => $comment->created_at->format('Y-m-d'),
            ];
        });

        return $this->successWithPagination('Comments retrieved successfully', $transformedComments);
    }









     public function createCommentes(Request $request)
     {
         $data=$request->validate([
            'article_id' => 'required|exists:articles,id',
            'comment' => 'required|string|max:500',
        ]);
        if(Auth::guard('vendor')->user()){


            if(Auth::guard('vendor')->user()->status != 2){
            if(Auth::guard('vendor')->user()->status==1){
                  return $this->validationFailure(errors:['message'=>__('this account is pending please wait for admin approval')]);
            }
            elseif(Auth::guard('vendor')->user()->status==0){
                return $this->validationFailure(errors:['message'=>__('this account is blocekd please contact with admin')]);
            }
            elseif(Auth::guard('vendor')->user()->status==3){
                return $this->validationFailure(errors:['message'=>__('this account is rejected please create new account or contact with admin')]);
            }

        }
        else{
            $comment=ArticalComment::create([
                'vendor_id' => Auth::guard('vendor')->user()->id,
                'article_id' => $data['article_id'],
                'description_ar' => request('comment'),
                'description_en' => request('comment'),

                ]);
            return $this->success(data:$comment);
      }
    } else{
        return $this->validationFailure(errors:['message'=>__('must be login to create comment')]);

    }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Articles  $articles
     * @return \Illuminate\Http\Response
     */
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
