<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inventory\Item;
use App\Models\Inventory\PurchaseOrder;
use App\Models\Inventory\ReceiveNote;
use App\Models\Inventory\ReceiveNoteItem;
use App\Models\Inventory\TransferOrder;

class ItemController extends Controller
{
    public function index()
    {
        return response()->json([
            'items' => Item::orderBy('name', 'ASC')->with(['item_type'])->paginate(50),
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

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
