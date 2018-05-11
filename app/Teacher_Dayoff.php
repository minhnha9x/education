<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Teacher_Backup;

class Teacher_Dayoff extends Model {
    protected $table = 'teacher_dayoff';
    public $timestamps = false;

    protected $guarded = [];
}

?>