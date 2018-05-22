<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Course_Teacher extends Model {
    protected $table = 'course_teacher';
    public $timestamps = false;

    protected $guarded = [];
}

?>