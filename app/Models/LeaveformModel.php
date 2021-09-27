<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class AttendanceModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected  $table = 'leaveform ';
    protected $fillable=[
       'userid', 'from_date','to_date','reason',
    ];
   
    public function users()
    {
        return $this->hasOne(users::class, 'id','userid');
    }
}
