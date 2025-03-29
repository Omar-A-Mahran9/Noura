<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ConsultationWorkStep extends Model
{
    use HasFactory;

    protected $table = 'consultation_work_steps'; // Ensure this matches your database table
    protected $guarded = [];

    public function consultationWork()
    {
        return $this->belongsTo(ConsultationWork::class, 'consultation_work_id'); // Adjust foreign key if necessary
    }
}
