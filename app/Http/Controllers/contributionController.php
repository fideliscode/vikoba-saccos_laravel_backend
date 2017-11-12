<?php
namespace App\Http\Controllers;
use App\contribution;
use App\user;
use App\CustomClasses\Report;
use App\saccosGroup;
use Illuminate\Http\Request;
use DB;

class contributionController extends Controller
{  

public function CreateReport($id){
 
  $contribution = User::find($id)->contribution->amount;
 
  
  return response()->json([  'contributions'=>$contribution], 201);
}

   public function addcontribution(Request $request){
        $contribution = new contribution();
        $contribution->amount = $request->input('amount');
        $contribution->user_id= $request->input('user_id');
        $contribution->group_id = $request->input('group_id');
        $contribution->save();
        return response()->json(['contributions'=> $contribution], 201);
   }   

   public function getgroupcontributions($group_id){
   
        $contribution = DB::table('contributions')->where('group_id', $group_id)->get(['amount', 'updated_at', 'user_id']); 
         $user_id = DB::table('contributions')->where('group_id', $group_id)->get(['user_id']); 
        $id=$user_id[1];
        if(!$contribution){return response()->json(['message'=>'no contribution in group!'], 404);}else{
        $response = [' contributions' => $contribution, 'username'=>$id];
        return response()->json($response, 200);}
   }   

  

    public function membercontributions($user_id){
       $user = User::where('id', $user_id)->firstOrFail();
        $membercontributions = DB::table('contributions')->where('user_id', $user_id)->get(); 
        if(!$membercontributions){
          return response()->json(['message'=>'No contributions for this member!'], 404);}
          else{
            
        $response = ['contributions' => $membercontributions, 'name'=> $user->fname];
        return response()->json($response, 200);}
}

public function jumlamembercontributions($user_id){
      $sum = DB::table('contributions')->where('user_id', $user_id)->sum('amount');     
       
        return response()->json(['sum'=>$sum], 200);
}



   public function editcontribution(Request $request, $id){
        $contribution = contribution::find($id);
        if(!$contribution){return response()->json(['message' =>'there is no contribution contribution with this id  '], 404);}

        else{
        $contribution->amount =$request->input('amount');
        $contribution->user_id= $request->input('user_id');
        $contribution->group_id = $request->input('group_id');
        $contribution->save();
        return response()->json(['contribution'=>  $contribution, 'message' =>'contribution updated!'], 200);}
   }  

   public function deletecontribution($id){
        $contribution = contribution::find($id);
        if(!$contribution){return response()->json(['message' =>'the contribution does not exist'], 404);}
        else{
        $contribution->delete();
        return response()->json(['message'=>'contributions deleted!'], 200);}
   }
   
}
