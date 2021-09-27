<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;
    protected $table='trainer';
    protected $fillable=[
        'name','email','password','confirmpassword',
        'phone','shift',];
}
