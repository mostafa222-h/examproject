<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quizze extends Model
{
    protected $fillable = [
        'title', 'description',   'start_date', 'duration', 'category_id'
    ];

}