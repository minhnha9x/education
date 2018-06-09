<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class TA extends Model {
    protected $table = 'teaching_assistant';
    public $timestamps = false;

    protected $guarded = [];
}

?>