<?php

namespace App\Http\Resources\Api;

use App\Models\Articles;
use Illuminate\Http\Resources\Json\JsonResource;
use Str;

use function PHPSTORM_META\map;

class ArticleResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $paginatedComments = $this->comments()->paginate(5); // Set per-page limit

        return [
             'id' => $this->id,
             'image' =>  getImagePathFromDirectory($this->main_image, 'articles'),
             'author_id' =>  $this->assign_to,

            'title' =>  $this->title,
            'short_description' => Str::limit($this->description, 35),
            'fully_description' =>$this->description,
            'created_at' => $this->created_at->format('Y-m-d'), // Manually format the date
            'comments_counts' => $this->comments->count(), // Total count of comments
            'latest_articles' => $this->getLatestArticlesByCategory(), // Get latest articles

        //     'comments' => [
        //     'data' => $paginatedComments->map(function ($comment) {
        //         return [
        //             'id' => $comment->id,
        //             'article_id' => $comment->article_id,
        //             'vendor_id' => $comment->vendor_id,
        //             'description' => $comment->description,
        //             'vendor' => [
        //                 'id' => $comment->vendor->id ?? null,
        //                 'name' => $comment->vendor->name ?? null,
        //                 'image' => getImagePathFromDirectory($comment->vendor->image ?? null, 'Vendors'),
        //             ],
        //             'created_at' => $comment->created_at->format('Y-m-d'),
        //         ];
        //     }),
        //     'links' => [
        //         'prev' => $paginatedComments->previousPageUrl(),
        //         'next' => $paginatedComments->nextPageUrl(),
        //     ],
        //     'meta' => [
        //         'total' => $paginatedComments->total(),
        //         'per_page' => $paginatedComments->perPage(),
        //         'current_page' => $paginatedComments->currentPage(),
        //         'last_page' => $paginatedComments->lastPage(),
        //     ],
        // ],
            ];
          }
          private function getLatestArticlesByCategory()
          {
              return Articles::whereHas('categories', function ($query) {
                      $query->whereIn('categories.id', $this->categories->pluck('id'));
                  })
                  ->where('id', '!=', $this->id) // Exclude current article
                  ->latest() // Order by latest
                  ->take(5) // Limit to 5 latest articles
                  ->get()
                  ->map(function ($article) {
                      return [
                          'id' => $article->id,
                          'title' => $article->title,
                          'image' => getImagePathFromDirectory($article->main_image, 'articles'),
                          'created_at' => $article->created_at->format('Y-m-d'),
                      ];
                  });
          }
        }
