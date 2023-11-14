<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inventory\Category;
use App\Models\Inventory\Item;
use App\Models\Inventory\ItemType;
use App\Models\Inventory\PurchaseOrder;
use App\Models\Inventory\PurchaseOrderItem;
use App\Models\Inventory\ReceiveNote;
use App\Models\Inventory\ReceiveNoteItem;
use App\Models\Inventory\StoreItem;
use App\Models\Inventory\TransferOrder;
use App\Models\Inventory\TransferOrderItem;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function initials()
    {
        return response()->json([
            'categories' => Category::orderBy('name', 'ASC')->get(),
            'types' => ItemType::orderBy('name', 'ASC')->with(['categories'])->get(),
        ]);
    }

    public function index()
    {
        return response()->json([
            'items' => Item::orderBy('name', 'ASC')->with(['category', 'item_type'])->paginate(50),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'item_type_id' => 'required',
            'quantity' => 'sometimes|numeric',
            'minimum_level' => 'sometimes|numeric',
            'current_cost_price' => 'sometimes|numeric',
        ]);

        $item = Item::create([
            'name' => $request->input('name'),
            'item_type_id' => $request->input('item_type_id'),
            'category_id' => $request->input('category_id'),

            'quantity' => $request->input('quantity'),
            'minimum_level' => $request->input('minimum_level'),
            'current_cost_price' => $request->input('current_cost_price'),
            'status' => 1,
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        return response()->json([
            'items' => Item::orderBy('name', 'ASC')->paginate(50),
        ]);
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'name' => 'sometimes',
            'item_type_id' => 'nullable|numeric',
            'category_id' => 'nullable|numeric',
        ]);
        
        $query = Item::orderBy('name', 'ASC');

        if (!is_null($request->input('name')) || $request->input('name') != ''){
            $query = $query->where('name', 'LIKE', "%{$request->input('name')}%");
        }
        if (!is_null($request->input('item_type_id')) || $request->input('item_type_id') != ''){
            $query = $query->where('item_type_id', '=', $request->input('item_type_id'));
        }
        if (!is_null($request->input('category_id')) || $request->input('category_id') != ''){
            $query = $query->where('category_id', '=', $request->input('category_id'));
        }
        
        $query = $query->get();

        return response()->json([
            'search_results' => $query,
        ]);
    }

    public function show($id)
    {
        $purchase_orders = PurchaseOrderItem::where('item_id', '=', $id)->with(['purchase_order'])->latest()->limit(10);
        $transfer_orders = TransferOrderItem::where('item_id', '=', $id)->with(['transfer_order'])->latest()->limit(10);
        $locations = StoreItem::groupBy('store_id')
                    ->select(DB::raw("SUM(`quantity`) as `quantity_sum`, 'item_id'"))->with('store')
                    ->where('item_id', '=', '$id')->get();
        return response()->json([
            'item' => Item::where('id', $id)->with(['category', 'item_type'])->first(),
            'purchase_orders' => $purchase_orders,
            'transfer_orders' => $transfer_orders,
            'locations' => $locations,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'item_type_id' => 'required',
            'quantity' => 'sometimes|numeric',
            'minimum_level' => 'sometimes|numeric',
            'current_cost_price' => 'sometimes|numeric',
        ]);

        $item = Item::where('id', '=', $id)->first();
        
        $item->name = $request->input('name');
        $item->item_type_id = $request->input('item_type_id');
        $item->category_id = $request->input('category_id');
        $item->quantity = $request->input('quantity');
        $item->minimum_level = $request->input('minimum_level');
        $item->current_cost_price = $request->input('current_cost_price');
        $item->status = $request->input('status') ?? 1;
        $item->updated_by = auth('api')->id();
        
        $item->save();

        return response()->json([
            'items' => Item::orderBy('name', 'ASC')->paginate(50),
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
