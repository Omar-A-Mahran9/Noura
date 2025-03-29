<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionPage extends Model
{
    use HasFactory;

    protected $table = 'sections_page';
    protected $guarded = [];
    protected $casts   = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];

    public function items()
    {
        return $this->hasMany(SectionItem::class, 'section_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
