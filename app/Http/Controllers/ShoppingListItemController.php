<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\ShoppingListItem;

class ShoppingListItemController extends Controller
{
    public function store(Request $request){

    	$validator = Validator::make($request->all(), [
            'shopping_list_id' => 'required',
            'name' => 'required',
            'quantity' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => $validator->messages()
            ]);
        }

    	$item = new ShoppingListItem();
    	$item->shopping_list_id = $request->shopping_list_id;
    	$item->name = $request->name;
    	$item->quantity = $request->quantity;
    	$item->save();

    	return response()->json(['status'=>1,'message'=>'Items Saved'], 200);
    }

    public function update(Request $request, $id){

    	$validator = Validator::make($request->all(), [
            'name' => 'required',
            'quantity' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => $validator->messages()
            ]);
        }

    	$item = ShoppingListItem::find($id);
    	$item->name = $request->name;
    	$item->quantity = $request->quantity;
    	$item->save();

    	return response()->json(['status'=>1,'message'=>'Items Updated'], 200);
    }

    public function destroy(Request $request, $id){
    	$item = ShoppingListItem::find($id);
    	$item->delete();
    	return response()->json(['status'=>1,'message'=>'Items Deleted'], 200);
    }
}
