<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultaionSchedual extends Model
{
    use HasFactory;
    protected $table = "consultaion_schedual";

    protected $guarded            = [];
     protected $casts              = ['created_at' => 'date:Y-m-d', 'updated_at' => 'date:Y-m-d'];
  
 // In Section model
 public function scopeWithConsultation($query)
 {
     return $query->whereNotNull('consultaion_type_id');
 }
       
  // Relation with Consultaion
  public function consultaion()
  {
      return $this->belongsTo(Consultaion::class, 'consultaion_id');
  }
 
}
