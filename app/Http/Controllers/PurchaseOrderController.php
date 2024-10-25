<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = PurchaseOrder::with('supplier', 'orderDetails')->latest()->paginate(10);

        return view('pages.purchaseOrders.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $order_no = PurchaseOrder::generateOrderNo();
        $suppliers = Supplier::all();
        $items = Item::all();
        $units = Unit::all();

        return view('pages.purchaseOrders.create', compact('order_no', 'suppliers', 'items', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $inputs = $request->all();
            $validator = Validator::make($inputs, [
                'order_no' => ['required', Rule::unique('purchase_orders', 'order_no')],
                'order_date' => ['required'],
                'supplier_id' => ['required', Rule::exists('suppliers', 'id')],
                'item_total' => ['required', 'numeric'],
                'discount' => ['nullable', 'numeric'],
                'net_amount' => ['required', 'numeric']
            ]);

            if ($validator->fails()) {
                DB::rollBack();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $purchaseOrder = PurchaseOrder::create([
                'order_no' => $inputs['order_no'],
                'order_date' => $inputs['order_date'],
                'supplier_id' => $inputs['supplier_id'],
                'item_total' => $inputs['item_total'],
                'discount' => $inputs['discount'],
                'net_amount' => $inputs['net_amount']
            ]);

            collect($inputs['items'])->each(function ($item, $key) use ($inputs, $purchaseOrder) {
                PurchaseOrderDetail::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'item_id' => $item,
                    'unit_id' => $inputs['unit_id'][$key],
                    'order_qty' => $inputs['quantity'][$key],
                    'item_amount' => $inputs['item_amount'][$key],
                    'discount' => $inputs['discount'][$key] ?? null,
                    'net_amount' => $inputs['net_amount'][$key]
                ]);
            });

            DB::commit();

            return redirect()->route('admin.purchases.index')->with('success', 'Purchase Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Something went wrong!')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $order_no = PurchaseOrder::generateOrderNo();
        $suppliers = Supplier::all();
        $items = Item::all();
        $units = Unit::all();

        return view('pages.purchaseOrders.edit', compact('order_no', 'suppliers', 'items', 'units', 'purchaseOrder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        try {

            $inputs = $request->all();
            $validator = Validator::make($inputs, [
                'order_no' => ['required', Rule::unique('purchase_orders', 'order_no')->ignore($purchaseOrder->id)],
                'order_date' => ['required'],
                'supplier_id' => ['required', Rule::exists('suppliers', 'id')],
                'item_total' => ['required', 'numeric'],
                'discount' => ['nullable', 'numeric'],
                'net_amount' => ['required', 'numeric']
            ]);

            if ($validator->fails()) {
                DB::rollBack();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $purchaseOrder->update([
                'order_no' => $inputs['order_no'],
                'order_date' => $inputs['order_date'],
                'supplier_id' => $inputs['supplier_id'],
                'item_total' => $inputs['item_total'],
                'discount' => $inputs['discount'],
                'net_amount' => $inputs['net_amount']
            ]);

            PurchaseOrderDetail::where('purchase_order_id', $purchaseOrder->id)->delete();
            collect($inputs['items'])->each(function ($item, $key) use ($inputs, $purchaseOrder) {
                PurchaseOrderDetail::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'item_id' => $item,
                    'unit_id' => $inputs['unit_id'][$key],
                    'order_qty' => $inputs['quantity'][$key],
                    'item_amount' => $inputs['item_amount'][$key],
                    'discount' => $inputs['discount'][$key] ?? null,
                    'net_amount' => $inputs['net_amount'][$key]
                ]);
            });

            DB::commit();

            return redirect()->route('admin.purchases.index')->with('success', 'Purchase Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Something went wrong!')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PurchaseOrder::findOrFail($id)->delete();

        return response()->json(['success' => true, 'message' => 'Purchase Deleted Successfully']);
    }
}
