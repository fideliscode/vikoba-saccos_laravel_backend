<?php

namespace App;
use Eloquent;
use App\user;

use Illuminate\Database\Eloquent\Model;

class loan extends Model
{
   protected $table ='loans';
   protected $primaryKey ='id';

   public function user()
  {
  	return $this->belongsTo('App\user');
  }
}
