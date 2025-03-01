<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultaion extends Model
{
    use HasFactory;
    protected $table = "consultaion";

    protected $guarded = [];
    protected $appends = ['title','description'];
    protected $casts   = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];
    public function getTitleAttribute()
    {
        return $this->attributes['title_'. getLocale()];
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['description_'. getLocale()];
    }

        // Relation with ConsultaionSchedual
        public function consultaionScheduals()
        {
            return $this->hasMany(ConsultaionSchedual::class, 'consultaion_id');
        }

        // Relation with ConsultaionType
        public function consultaionType()
        {
            return $this->belongsTo(ConsultaionType::class, 'consultaion_type_id');
        }

        public function quizzes()
        {
            return $this->hasMany(Quiz::class, 'consultaion_id');
        }

}
