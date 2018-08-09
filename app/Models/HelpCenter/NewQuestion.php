<?php

namespace App\Models\HelpCenter;

use Illuminate\Database\Eloquent\Model;

class NewQuestion extends Model
{
    protected  $table = 'new_question';

    protected $fillable = [
        'id', 'question_title', 'question_desc','master_name','master_phone'
    ];
}
