<?php

namespace App\Models\HelpCenter;

use Illuminate\Database\Eloquent\Model;

class FrequentlyQuestion extends Model
{
    protected  $table = 'frequently_question';

    protected $fillable = [
        'id', 'question_title', 'question_answer',
    ];
}
