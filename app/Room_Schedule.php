<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Room_Schedule extends Model {
	protected $table = 'room_schedule';
	public $timestamps = false;

	protected $guarded = [];
}

?>