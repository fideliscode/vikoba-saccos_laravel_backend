<?php
namespace App\Http\Controllers;
use App\share;

use App\saccosGroup;
use Illuminate\Http\Request;
use DB;

class shareController extends Controller
{   
   public function addshare(Request $request){
        $share = new share();
        $share->amount = $request->input('amount');
        $share->user_id = $request->input('user_id');
        $share->group_id = $request->input('group_id');
        $share->save();
        return response()->json(['shares'=>  $share], 201);
   } 
  
   public function getgroupshares($group_id){
        $shares = DB::table('shares')->where('group_id', $group_id)->get(); 
        if(!$shares){return response()->json(['message'=>'no shares yet in the group!'], 404);}else{
        $response = ['group shares' =>  $shares];
        return response()->json($response, 200);}
   } 
   
   public function getmembershares($user_id){
        $share = DB::table('shares')->where('user_id', $user_id)->get(); 
        if(!$share){return response()->json(['message'=>'No shares for this member!'], 404);}else{
        $response = ['Member shares' => $share];
        return response()->json($response, 200);}
   } 
  
   public function editshare(Request $request, $id){
        $share = DB::table('shares')->where('id', $idl);
        if(!$share){return response()->json(['message' =>'this share does not exist!'], 404);}
        else{
        $share->amount =$request->input('amount');
        $share->user_id = $request->input('user_id');
        $share->admin_user_id = $request->input('admin_user_id');
        $share->save();
        return response()->json(['share' => $share,'message' =>'share updated!'], 200);}
   } 
  
   public function deleteshare($Id){
         $share = DB::table('shares')->where(['id', $Id])->get();
         if(!$share){return response()->json(['message' =>' This share does not exist!'], 404);}
         else{
         $share->delete();
         return response()->json(['message'=>'share deleted!'], 200);}
   }
   
}
