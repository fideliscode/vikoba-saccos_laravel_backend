<?php
namespace App\Http\Controllers;
use App\user;

use App\saccosGroup;
use Illuminate\Http\Request;
use DB;

class loanController extends Controller
{     //adding new loans

   public function addloan(Request $request){
        $loan = new loan();
        $loan->amount = $request->input('amount');
        $loan->user_id = $request->input('user_id');
        $loan->group_id = $request->input('group_id');
        $loan->save();
        return response()->json(['loan'=> $loan], 201);
   } 

   public function getgrouploans($group_id){
        $loans = DB::table('loans')->where('group_id', $group_id)->get(); 
        if(!$loans){return response()->json(['message'=>'no loans this group!'], 404);}else{
        $response = ['group loans' => $loans];
        return response()->json($response, 200);}
   }  

   public function getmemberloans($user_id){
        $loan = DB::table('loans')->where('user_id',$user_id )->get(); 
        if(!$loan){return response()->json(['message'=>'No loans yet for this member!'], 404);}else{
        $response = ['member loans' => $loan];
        return response()->json($response, 200);}
   }  

   public function editloan(Request $request, $id){
        $loan = member::find($id);
        if(!$loan){return response()->json(['message' =>'this loan does not exist!'], 404);}
        else{
         $loan->amount =$request->input('amount');
         $loan->user_id = $request->input('user_id');
         $loan->group_id = $request->input('group_id');
         $loan->save();
        return response()->json(['loan'=>$loan, 'message' =>'loan updated!'], 200);}
   }  


   public function deleteloan($id){
         $loan = DB::table('loans')->where('id', $id)->get();
         if(!$loan){return response()->json(['message' =>'this loan does not exist!'], 404);}
         else{
         $loan->delete();
         return response()->json(['message'=>'loan deleted!'], 200);}
   }
   
}
