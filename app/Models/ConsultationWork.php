<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationWork extends Model
{

        use HasFactory;

        protected $table = "consultation_works";
        protected $guarded = [];
        protected $appends = [];
        protected $casts   = [
            'created_at' => 'date:Y-m-d',
            'updated_at' => 'date:Y-m-d'
        ];


        public function steps()
        {
            return $this->hasMany(ConsultationWorkStep::class, 'consultation_work_id'); // Adjust the foreign key if needed
        }

}
