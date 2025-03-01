<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultaionType extends Model
{
    use HasFactory;

    protected $table = "consultaion_type";
    protected $guarded = [];
    protected $appends = ['name'];
    protected $casts   = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];
    public function getNameAttribute()
    {
        return $this->attributes['name_'. getLocale()];
    }

    // Relation with Consultaion
    public function consultaions()
    {
        return $this->hasMany(Consultaion::class, 'consultaion_type_id');
    }
}
