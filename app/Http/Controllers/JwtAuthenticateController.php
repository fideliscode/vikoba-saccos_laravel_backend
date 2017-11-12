<?php
namespace App\Http\Controllers;
use App\Permission;
use App\Role;
use App\user;
use Zizaco\Entrust\EntrustRole;
use App\saccosGroup;

use Illuminate\Http\Request;
use DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Log;

class JwtAuthenticateController extends Controller
{
  /***********common to all****************/
public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['txt' => 'invalid_credentials'], 200);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['txt' => 'invalid_credentials'/*'could_not_create_token'*/], 200);
        }
        // if no errors are encountered we can return a JWT
       // return response()->json(compact('token'));
         $user = User::where('email', '=', $request->input('email'))->firstOrFail();
         Log::info($user);
        $saccos = saccosGroup::find($user->group_id);
         
         $grpname=$saccos->saccosName;
         if(true == $user->hasRole('author')){
          return response()->json([
            "token"=>$token, "userRole"=>"AUTHOR", "user_id"=>$user->id, "username"=>$user->fname.' '.$user->lname,  "group_id"=>$user->group_id, "email"=>$user->email, "groupname"=>$grpname], 200);
         }else if(true == $user->hasRole('admin')){
          return response()->json([
            "token"=>$token, "userRole"=>"ADMIN", "user_id"=>$user->id, "group_id"=>$user->group_id, "email"=>$user->email, "username"=>$user->fname.' '.$user->lname, "groupname"=>$grpname], 200);
        }else if(true == $user->hasRole('member')){
          return response()->json([
            "token"=>$token, "userRole"=>"MEMBER", "user_id"=>$user->id, "email"=>$user->email, "username"=>$user->fname.' '.$user->lname, "groupname"=>$grpname ], 200);
        }else{
          return response()->json(['error' => 'sory you have to be registered'], 500);
        }


}

/******************Author functions begins here************************************************/

public function postsaccos(Request $request){
     $saccos = new saccosGroup();
     $saccos->saccosName = $request->input('saccosName');
     $saccos->admin_email = $request->input('admin_email');
     $saccos->save();
     return response()->json(['saccosGroups'=> $saccos], 201);
}

public function getsaccosGroups(){
     $saccosGroups = saccosGroup::all(); 
     
     return response()->json(['auth'=>Auth::user(), 'saccosGroups' => $saccosGroups], 200); 
}


public function deletesaccos($id){
      $saccos = saccosGroup::find($id);
      $saccos->delete();
      return response()->json(['message'=>'Saccos group deleted'], 200);
}
public function signupadmin(Request $request){
  
     $this->validate($request, [
    'fname'=>'required',
    'lname'=>'required',
    'email'=>'required|email|unique:users',
    'phone'=>'required', 
    'password'=>'required',
    
    
    ]);
    $group = saccosGroup::where('admin_email', $request->input('email'))->firstOrFail();
    $user = new user([
    'fname'=>$request->input('fname'),
    'lname'=>$request->input('lname'),
    'email'=>$request->input('email'),
    'admin_email'=>$request->input('email'),
    'phone'=>$request->input('phone'), 
    'group_id'=> $group->id,
    'password'=> bcrypt($request->input('password'))
     ]);
     $user->save();

 
     $role ="admin";
     $user = User::where('email', '=', $request->input('email'))->firstOrFail();
     $role = Role::where('name', '=', $role )->firstOrFail();
     $user->roles()->attach($role->id);
     $rolename = $role->name;

     return response()->json(['admin'=>$user, 'message'=>'admin created!', 'role'=>$rolename], 201);
}

public function index()
    {
        return response()->json(['auth'=>Auth::user(), 'users'=>User::all()]);
}
/****************common to admin and author********************/
public function createRole(Request $request){
        $role = new Role();
        $role->name = $request->input('name');
        $role->save();
        return response()->json("created");
}


public function createPermission(Request $request){
        $viewUsers = new Permission();
        $viewUsers->name = $request->input('name');
        $viewUsers->save();
        return response()->json("created");
}

public function assignRole(Request $request){
        $user = User::where('email', '=', $request->input('email'))->firstOrFail();
        $role = Role::where('name', '=', $request->input('role'))->firstOrFail();
        $name = $user->fname;
        $rolename = $role->name;
        //$user->attachRole($request->input('role'));
        $user->roles()->attach($role->id);
        return response()->json(['user name'=>$name, 'role'=>$rolename]);
}

public function attachPermission(Request $request){
        $role = Role::where('name', '=', $request->input('role'))->first();
        $permission = Permission::where('name', '=', $request->input('permission'))->first();
        $role->attachPermission($permission);
        return response()->json("created");
}

/*********************admin functions begins here**********************************************/	

public function signup(Request $request){
	
	   $this->validate($request, [
		'fname'=>'required',
    'lname'=>'required',
		'email'=>'required|email|unique:users',
		'phone'=>'required', 
		'password'=>'required',
    'admin_email'=>'required',
    'group_id'=>'required'
    ]);
	  $user = new user([
		'fname'=>$request->input('fname'),
    'lname'=>$request->input('lname'),
		'email'=>$request->input('email'),
    'admin_email'=>$request->input('admin_email'),
		'phone'=>$request->input('phone'),
    'group_id'=>$request->input('group_id'),
		'password'=> bcrypt($request->input('password'))
		 ]);
	   $user->save();
     $role ="member";
     $user = User::where('email', '=', $request->input('email'))->firstOrFail();
        $role = Role::where('name', '=', $role )->firstOrFail();
        $user->roles()->attach($role->id);
        $rolename = $role->name;
	   return response()->json(['user'=>$user, 'message'=>'user created!', 'role'=>$rolename], 201);
}

   
public function getsaccosGroup($id){
     $saccosGroup = saccosGroup::find($id); 
     
     return response()->json(['auth'=>Auth::user(), 'saccosGroup' => $saccosGroup], 200); 
}
public function editgroup(Request $request, $id){
      $saccos = saccosGroup::find($id);
      if(!$saccos){return response()->json(['message' =>'group not found!'], 404);}else{
      $saccos->saccosName =$request->input('saccosName');
      $saccos->admin_email =$request->input('admin_email');
      $saccos->save();
      return response()->json(['saccosGroup'=>$saccos, 'message' =>'Group successfull updated!'], 200);}
}


   
public function editmember(Request $request, $id){
      $member = user::find($id);
      if(!$member){return response()->json(['message' =>'there is no member with that email '], 404);}
      else{
      $member->fname =$request->input('fname');
      $member->lname =$request->input('lname');
      $member->phone =$request->input('phone');
      $member->email =$request->input('email');
       $member->group_id =$request->input('group_id');
      $member->admin_email = $request->input('admin_email');

      $member->save();
      return response()->json(['member'=>$member, 'message' =>'member is succesfull updated!'], 200);}
}
public function editmemberpassword(Request $request, $id){
$member=user::find($id);
$member->password=bcrypt($request->input('password'));

 $member->save();
      return response()->json(['member'=>$member->password, 'message' =>$member], 200);


}
 


public function deletemember($admin_email, $id){
      $member = user::find($id);
      if(!$member){return response()->json(['message' =>'user does not exist'], 404);}
      else if ($member->email === $admin_email) {
        return response()->json(['message' =>'can not delete the admin,please consult the author'], 404);}
        else {
      $member->delete();
      return response()->json(['message'=>'Member succesfull deleted!'], 200);}
}
/**********commom to login users/members and admin**********/
public function getmember($id){
      $member = DB::table('users')->where('id', $id)->get(); 
      if(!$member){return response()->json(['message'=>'this members does not exist'], 404);}else{ 
      $response = ['member' => $member];
      return response()->json($response, 200);}
}    
public function getGroupmembers($id){
      $user = user::find($id);
      $group_id=$user->group_id;
      $saccosGroup = saccosGroup::find($group_id);
      $saccosName = DB::table('saccosGroups')->where('id', $id)->value('saccosName');
     
      if(!$saccosGroup){return response()->json(['message'=>'there are no members in this saccos group'], 404);}
      else{
      
      $members = DB::table('users')->where('group_id', $group_id)->get(); 

      $contribution = DB::table('contributions')->where('group_id', $group_id)->get(); 
        
        if(!$contribution){return response()->json(['message'=>'no contribution in group!'], 404);}
        else{
        
       // $response = ['contributions' => $contribution, 'members' => $members];
        return response()->json(['contributions' => $contribution, 'members' => $members], 200);}
        }   
    }

  

}
   



