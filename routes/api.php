<?php

use Illuminate\Http\Request;

use Illuminate\Foundation\Http\Kernel;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', 'JwtAuthenticateController@authenticate');


Route::put('editmemberpassword/{id}', ['uses'=>'JwtAuthenticateController@editmemberpassword']);
//Route::group(['middleware' => ['ability:author,create-group']], 
//function(){    
 //Route::get('/getusername/{user_id}', ['uses'=>'JwtAuthenticateController@getusername']);
Route::post('/creategroup', ['uses'=>'JwtAuthenticateController@postsaccos']);
Route::get('/viewgroupmembers/{id}', ['uses'=>'JwtAuthenticateController@getGroupmembers']);
//Route::post('/creategroup', ['uses'=>'JwtAuthenticateController@postsaccos']);
Route::get('/viewgroups', ['uses'=>'JwtAuthenticateController@getsaccosGroups']); 
Route::delete('deletegroup/{id}', ['uses'=>'JwtAuthenticateController@deletesaccos' ]); 
Route::post('/createadminuser', ['uses'=>'JwtAuthenticateController@signupadmin']);

Route::put('/admin/editgroup/{id}', ['uses'=>'JwtAuthenticateController@editgroup']);
Route::get('/users', ['uses'=> 'JwtAuthenticateController@index']);
Route::post('/user/role', ['uses'=> 'JwtAuthenticateController@createRole']);
Route::post('/user/permission', ['uses'=>'JwtAuthenticateController@createPermission']);
Route::post('/user/assign-role', ['uses'=>'JwtAuthenticateController@assignRole']);
Route::post('/user/attach-permission', ['uses'=> 'JwtAuthenticateController@attachPermission']);
Route::post('/user/check', ['uses'=>'JwtAuthenticateController@checkRoles']);
//});


//Route::group(['middleware' => ['ability:admin,edit-group']], 
//function(){ 

//Route::get('/createReport/{user_id}', ['uses'=>'contributionController@CreateReport']);



Route::post('/admin/createmember', ['uses'=>'JwtAuthenticateController@signup']);
Route::put('/admin/editmember/{id}', ['uses'=>'JwtAuthenticateController@editmember']);
Route::delete('/deletemember/{admin_email}/{id}', ['uses'=>'JwtAuthenticateController@deletemember']);

Route::post('/admin/contributions', ['uses'=>'contributionController@addcontribution']);
Route::put('/admin/contribution/{id}', ['uses'=>'contributionController@editcontribution']);
Route::delete('/admin/contribution/{id}', ['uses'=>'contributionController@deletecontribution']);

Route::post('/admin/share', ['uses'=>'shareController@addshare']);
Route::put('/admin/share/{id}', ['uses'=>'shareController@editshare']);
Route::delete('/admin/share/{id}', ['uses'=>'shareController@deleteshare']);      
Route::post('/admin/loan', ['uses'=>'loanController@addloan']); 
Route::put('/admin/loan/{id}', ['uses'=>'loanController@editloan']);
Route::delete('/admin/loan/{Id}', ['uses'=>'loanController@deleteloan']);


Route::get('/jumlacontr/{user_id}', ['uses'=>'contributionController@jumlamembercontributions']);
Route::get('/all_membercontr/{user_id}', ['uses'=>'contributionController@membercontributions']);
//Route::get('/viewgroup/{id}', ['uses'=>'JwtAuthenticateController@getsaccosGroup']); 
Route::get('/viewgroupmembers/{id}', ['uses'=>'JwtAuthenticateController@getGroupmembers']);

//Route::get('/viewmembercontr/{user_id}', ['uses'=>'contributionController@getmembercontributions']);
//Route::get('/viewgroupcontr/{group_id}', ['uses'=>'contributionController@getgroupcontributions']);
//Route::get('/viewgrouploans/{group_id}', ['uses'=>'loanController@getgrouploans']);

//Route::get('/viewgroupshares/{group_id}', ['uses'=>'shareController@getgroupshares']);
//Route::get('/viewmemberloan/{user_id}', ['uses'=>'loanController@getmemberloans']);
//Route::get('/viewmembershares/{user_id}', ['uses'=>'shareController@getmembershares']);   
//});

 
//Route::group(['middleware' => ['ability:member, view-members_info']], 
//function(){     

//Route::get('/showmember/{id}', ['uses'=>'JwtAuthenticateController@getmember']); 


//Route::get('/showgroup/{id}', ['uses'=>'JwtAuthenticateController@getsaccosGroup']); 

//Route::get('/groupmembers/{id}', ['uses'=>'JwtAuthenticateController@getGroupmembers']);

//Route::get('/membercontr/{user_id}', ['uses'=>'contributionController@getmembercontributions']);
Route::get('/all_membercontr/{user_id}', ['uses'=>'contributionController@membercontributions']);
Route::get('/viewgroupmembers/{id}', ['uses'=>'JwtAuthenticateController@getGroupmembers']);
Route::get('/jumlacontr/{user_id}', ['uses'=>'contributionController@jumlamembercontributions']);

//Route::get('/groupcontr/{group_id}', ['uses'=>'contributionController@getgroupcontributions']);

//Route::get('/grouploans/{group_id}', ['uses'=>'loanController@getgrouploans']);

//Route::get('/groupshares/{group_id}', ['uses'=>'shareController@getgroupshares']);

//Route::get('/memberloan/{user_id}', ['uses'=>'loanController@getmemberloans']);
//Route::get('/membershares/{user_id}', ['uses'=>'shareController@getmembershares']);        
//});