<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Teacher_Backup;

class Teacher_Backup extends Model {
	protected $table = 'teacher_backup';
	public $timestamps = false;

	protected $guarded = [];
}

?>