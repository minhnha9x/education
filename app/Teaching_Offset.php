<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Teacher_Backup;

class Teaching_Offset extends Model {
	protected $table = 'teaching_offset';
	public $timestamps = false;

	protected $guarded = [];
}

?>