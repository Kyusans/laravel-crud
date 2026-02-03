<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    public $fillable = [
        'student_id',
        'name',
        'section',
        'email',
        'age',
        'sex',
    ];
}
