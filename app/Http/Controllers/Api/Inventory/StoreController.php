<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use Illuminate\Http\Request;

use App\Models\Inventory\Store;
use App\Models\Inventory\StoreItem;

class StoreController extends Controller
{
    public function index()
    {
        return response()->json([
            'stores' => Store::where('status', '=', 1)->orderBy('name', 'ASC')->with(['department', 'branch'])->paginate(10),
        ]);
    }

    public function initials()
    {
        return response()->json([
            'branches' => Branch::where('status', '=', 1)->orderBy('name', 'ASC')->get(),
            'departments' => Department::where('status', '=', 1)->orderBy('name', 'ASC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'branch_id' => 'nullable|numeric',
            'department_id' => 'nullable|numeric',
            'status' => 'required|numeric',
            'store_items' => 'sometimes|array',
        ]);

        $store = Store::create([
            'name' => $request->input('name'),
            'branch_id' => $request->input('branch_id'),
            'department_id' => $request->input('department_id'),
            'status' => $request->input('status'),
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        if (is_array($request->input('store_items')) && count($request->input('store_items'))){ 
            foreach ($request->input('store_items') as $store_item){
                StoreItem::create([
                    'store_id' => $store->id,
                    'item_id' => $store_item->item_id,
                    'batch_id' => $store_item->batch_id,
                    'quantity' => $store_item->quantity,
                ]);
            }
        }

        return response()->json([
            'stores' => Store::where('status', '=', 1)->orderBy('name', 'ASC')->with(['department', 'branch'])->paginate(10),
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'store' => Store::where('id', '=', $id)->with(['department', 'branch'])->first(),
            'items' => StoreItem::where('store_id', '=', $id)->where('quantity', '>', 0)->with(['item', 'batch'])->paginate(10),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'branch_id' => 'nullable|numeric',
            'department_id' => 'nullable|numeric',
            'status' => 'required|numeric',
        ]);

        $store = Store::where('id', '=', $id)->first();

        $store->name = $request->input('name');
        $store->branch_id = $request->input('branch_id');
        $store->department_id = $request->input('department_id');
        $store->updated_by = auth('api')->id();
        $store->status = $request->input('status');

        $store->save();

        return response()->json([
            'stores' => Store::where('status', '=', 1)->orderBy('name', 'ASC')->with(['department', 'branch'])->paginate(10),
        ]);
    }

    public function destroy($id)
    {
        $store = Store::where('id', '=', $id)->first();

        $store->status = 0;
        $store->deleted_by = auth('api')->id();

        $store->save();

        return response()->json([
            'stores' => Store::where('status', '=', 1)->orderBy('name', 'ASC')->with(['department', 'branch'])->paginate(10),
        ]);
    }
}
