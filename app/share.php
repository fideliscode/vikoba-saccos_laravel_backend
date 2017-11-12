<?php

namespace App;
use App\user;
use Illuminate\Database\Eloquent\Model;

class share extends Model
{
 protected $table ='shares';
  
    protected $primaryKey ='id';

 

  public function user()
  {
  	return $this->belongsTo('App\user');
  }
}
