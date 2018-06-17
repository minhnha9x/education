<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model {
	protected $table = 'office_worker';
	public $timestamps = false;

	protected $guarded = [];
}

?>