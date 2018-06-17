<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model {
	protected $table = 'main_teacher';
	public $timestamps = false;

	protected $guarded = [];
}

?>