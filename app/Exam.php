<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model {
    protected $table = 'exam';
    public $timestamps = false;

    protected $guarded = [];
}

?>