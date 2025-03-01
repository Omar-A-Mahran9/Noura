<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    use HasFactory;

    protected $table = 'quezies_answers';
    protected $guarded = [];
    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return $this->attributes['name_' . getLocale()];
    }

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class);
    }
}
