<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected  $table = 'hp';
    protected $fillable=[
        'name','email','password','confirmpassword',
        'image',
    ];
}
