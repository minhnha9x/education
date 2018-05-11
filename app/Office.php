<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model {
    protected $table = 'office';
    public $timestamps = false;

    protected $guarded = [];
}

?>