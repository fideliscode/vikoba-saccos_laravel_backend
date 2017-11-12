<?php

namespace App;
use App\user;
use Illuminate\Database\Eloquent\Model;

class contribution extends Model
{
   protected $table ='contributions';
   protected $primaryKey ='id';

  public function user()
  {
  	return $this->belongsTo('App\user');
  }

}
