<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Teacher_Backup;

class Employee extends Model {
    protected $table = 'employee';
    public $timestamps = false;

    protected $guarded = [];
}

?>