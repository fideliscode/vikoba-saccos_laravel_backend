<?php

namespace App;
use Eloquent;
use DB;
use Zizaco\Entrust\EntrustRole;
use App\user;

use Illuminate\Database\Eloquent\Model;

class saccosGroup extends Eloquent
{
  protected $table = 'saccosGroups';
  protected $primaryKey ='id';
  protected $fillable =['saccosName', 'admin_email'];
  
  public function user()
  {
  	return $this->belongsTo('App\user');
  }

 

}
