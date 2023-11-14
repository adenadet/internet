<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Category;
use App\Models\Inventory\ItemType;
use App\Models\Inventory\Store;
use Illuminate\Http\Request;

use App\Models\Inventory\TransferOrder;
use App\Models\Inventory\TransferOrderItem;

use App\Models\Inventory\UserStore;

class TransferOrderController extends Controller
{
    public function index()
    {
        //
    }

    public function initials()
    {
        $user_stores = UserStore::where('user_id', '=', auth('api')->id())->pluck('store_id');
        $my_stores = Store::whereIn('id', $user_stores)->where('status', '=', 1)->orderBy('name', 'ASC')->get();
        

        return response()->json([
            'categories' => Category::orderBy('name')->get(),
            'my_stores' => $my_stores,
            'stores' => Store::where('status', '=', 1)->orderBy('name', 'ASC')->get(),
            'types' => ItemType::orderBy('name')->get(),
        ]);        
    }

    public function my_store_requests()
    {
        $user_stores = UserStore::where('user_id', '=', auth('api')->id())->pluck('store_id');
        $transfer_orders = TransferOrder::whereIn('from_store_id', $user_stores)->where(['status', '=', 1])->latest()->paginate(20);

        return response()->json([
            'transfer_orders' => $transfer_orders
        ]);
    }

    public function my_store_delivers()
    {
        $user_stores = UserStore::where('user_id', '=', auth('api')->id())->pluck('store_id');
        $transfer_orders = TransferOrder::whereIn('to_store_id', $user_stores)->where(['status', '=', 1])->latest()->paginate(20);

        return response()->json([
            'transfer_orders' => $transfer_orders
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'sometimes', 
            'from_store_id' => 'required|numeric', 
            'to_store_id' => 'required|numeric', 
            'status' => 'sometimes|numeric',
        ]);

        $transfer_order = TransferOrder::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'), 
            'unique_id' => $request->input('unique_id'), 
            'from_store_id' => $request->input('from_store_id'), 
            'to_store_id' => $request->input('to_store_id'), 
            'status' => $request->input('status') ?? 0,
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        foreach ($request->input('transfer_order_items') as $transfer_order_item){
            TransferOrderItem::create([
                'transfer_order_id' => $transfer_order->id,
                'item_id' => $transfer_order_item->item_id,
                'quantity' => $transfer_order_item->quantity,
            ]);
        }

        return response()->json([
            'transfer_orders' => TransferOrder::orderBy('status', 'ASC')->with(['from', 'to'])->paginate(10),
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'transfer_order' => TransferOrder::where('id', $id)->with(['from', 'to', 'approver', 'transfer_order_items'])->first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'unique_id' => 'required',
            'description' => 'sometimes', 
            'from_store_id' => 'required|numeric', 
            'to_store_id' => 'required|numeric', 
            'status' => 'sometimes|numeric',
        ]);

        $transfer_order = TransferOrder::where('id', '=', $id)->first();
        
        $transfer_order->name = $request->input('name');
        $transfer_order->description = $request->input('description'); 
        $transfer_order->unique_id = $request->input('unique_id'); 
        $transfer_order->from_store_id = $request->input('from_store_id'); 
        $transfer_order->to_store_id = $request->input('to_store_id'); 
        $transfer_order->status = $request->input('status');
        $transfer_order->updated_by = auth('api')->id();
        
        $transfer_order->save();

        return response()->json([
            'transfer_order' =>  TransferOrder::where('id', $id)->with(['from', 'to', 'approver', 'transfer_order_items'])->first(),
            'transfer_orders' => TransferOrder::orderBy('status', 'ASC')->with(['from', 'to'])->paginate(10),
        ]);
    }

    public function destroy($id)
    {
        $transfer_order = TransferOrder::where('id', '=', $id)->first();

        $transfer_order->status = 5;
        $transfer_order->updated_by = auth('api')->id();
        $transfer_order->deleted_by = auth('api')->id();
        
        $transfer_order->save();

        return response()->json([
            'transfer_order' =>  TransferOrder::where('id', $id)->with(['from', 'to', 'approver', 'transfer_order_items'])->first(),
            'transfer_orders' => TransferOrder::orderBy('status', 'ASC')->with(['from', 'to'])->paginate(10),
        ]);
    }
}
