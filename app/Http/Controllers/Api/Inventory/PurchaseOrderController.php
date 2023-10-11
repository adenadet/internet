<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\PurchaseOrder;
use App\Models\Inventory\PurchaseOrderItem;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        return response()->json([
            'purchase_orders' => PurchaseOrder::orderBy('date', 'ASC')->with(['purchase_order_items'])->paginate(50),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'status' => 'required',
            'purchase_order_items' => 'required|array',
        ]);

        $purchase_order = PurchaseOrder::create([
            'date' => $request->input('date'),
            'status' => $request->input('status'),
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        foreach ($request->input('purchase_order_items') as $purchase_order_item){
            PurchaseOrderItem::create([
                'po_id' => $purchase_order->id,
                
            ]);
        }

        return response()->json([
            'purchase_orders' => PurchaseOrder::orderBy('date', 'DESC')->paginate(50),
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
