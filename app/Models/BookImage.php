<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookImage extends Model
{
    use HasFactory;
        // Define the table if it's different from the default (optional)
        protected $table = 'book_images';

        // Define the fillable fields
        protected $fillable = [
            'book_id',
            'image',
        ];

    public function book()
        {
            return $this->belongsTo(Book::class);
        }
}
