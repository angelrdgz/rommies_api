<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Complaint;
use App\ComplaintRoomie;
use App\ComplaintPhoto;
use App\ComplaintComment;

use Validator;

class ComplaintController extends Controller
{
    public function index(Request $request){
    	$roomies = ComplaintRoomie::where('user_id', $request->user()->id)->get();
    	$ids = [];
    	if(count($roomies) > 0){
    		foreach ($roomies as $key => $roomie) {
    			array_push($ids, $roomie->complaint_id);
    		}
    	}
    	$complaints = Complaint::where('user_id', $request->user()->id)->whereIn('id', $ids)->get();

    	return response()->json(['status'=>1,'message'=>'Complaints Founded', 'data'=>$complaints], 200);
    }

    public function store(Request $request){
    	$user = $request->user();

    	$validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'roomies' => 'required',
            'photos' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => $validator->messages()
            ]);
        }

        $complaint = new Complaint();
        $complaint->title = $request->title;
        $complaint->description = $request->description;
        $complaint->user_id = $user->id;
        $complaint->save();

        foreach ($request->photos as $key => $photo) {
        	$pic = new ComplaintPhoto();
        	$pic->complaint_id = $complaint->id;
        	$pic->photo = $photo;
        	$pic->save();
        }

        foreach ($request->roomies as $key => $roomie) {
        	$roo = new ComplaintRoomie();
        	$roo->complaint_id = $complaint->id;
        	$roo->user_id = $roomie;
        	$roo->save();
        }

        return response()->json(['status'=>1,'message'=>'Complaints Saved', 'data'=>$complaints], 200);
    }

    public function show(Request $request, $id){}

    public function update(Request $request, $id){}

    public function destroy(Request $request, $id){}
}
