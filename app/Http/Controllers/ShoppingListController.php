<?php

namespace App\Http\Controllers;
use App\User;
use App\ShoppingList;
use App\ShoppingListItem;
use App\ShoppingListRoomie;
use App\ShoppingListType;
use Validator;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShoppingListController extends Controller
{
    public function index(Request $request){
    	$user = $request->user();
    	$lists = ShoppingList::where('user_id', $user->id)->get();
        return response()->json(['status'=>1,'data'=>$lists,'message'=>'Shopping Lists founded'], 200);    	
    }

    public function store(Request $request){

    	$user = $request->user();

    	$validator = Validator::make($request->all(), [
            'name' => 'required',
            'type_id' => 'required',
            'roomies' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => $validator->messages()
            ]);
        }

        $list = new ShoppingList();
        $list->name = $request->name;
        $list->type_id = $request->type_id;
        $list->user_id = $user->id;
        $list->save();

        foreach ($request->roomies as $key => $roomie) {
        	$ro = new ShoppingListRoomie();
        	$ro->shopping_list_id = $list->id;
        	$ro->user_id = $roomie;
        	$ro->save();
        }

        return response()->json(['status'=>1,'message'=>'Shopping Lists created'], 200);

    }

    public function show(Request $request, $id){

    	$list = ShoppingList::find($id);
    	$list->items;
    	$list->type;
    	$list->roomies;

    	return response()->json(['status'=>1,'data'=>$list,'message'=>'Shopping List founded'], 200);

    }

    public function update(Request $request, $id){

    	$user = $request->user();

    	$validator = Validator::make($request->all(), [
            'name' => 'required',
            'type_id' => 'required',
            'roomies' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => $validator->messages()
            ]);
        }

        $list = ShoppingList::find($id);
        $list->name = $request->name;
        $list->type_id = $request->type_id;
        $list->save();

        $list->roomies()->delete();

        foreach ($request->roomies as $key => $roomie) {
        	$ro = new ShoppingListRoomie();
        	$ro->shopping_list_id = $list->id;
        	$ro->user_id = $roomie;
        	$ro->save();
        }

        return response()->json(['status'=>1,'message'=>'Shopping Lists created'], 200);

    }

    public function complete(Request $request){
    	$list = ShoppingList::find($request->id);
    	$list->completed = true;
    	$list->save();

    	return response()->json(['status'=>1,'message'=>'Shopping Lists completed'], 200);
    }

    public function addItemToList(Request $request){


    	

    }

    public function updateItemToList(Request $request){


    	$item = new ShoppingListItem();
    	$item->shopping_list_id = $request->id;
    	$item->name = $request->name;
    	$item->quantity = $request->quantity;
    	$item->shopping_list_id = $request->id;
    	$item->save();

    	return response()->json(['status'=>1,'message'=>'Items Saved'], 200);

    }
}
