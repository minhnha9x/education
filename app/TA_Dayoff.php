<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Teacher_Backup;

class TA_Dayoff extends Model {
	protected $table = 'ta_dayoff';
	public $timestamps = false;

	protected $guarded = [];
}

?>