<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::with('supplier')->latest()->paginate(10);

        return view('pages.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $units = Unit::all();
        $item_no = Item::generateItemNo();

        return view('pages.items.create', compact('suppliers', 'units', 'item_no'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'item_no' => ['required', Rule::unique('items', 'item_no')],
            'item_name' => ['required', Rule::unique('items', 'item_name')],
            'inventory_location' => ['nullable'],
            'brand' => ['required'],
            'category' => ['required'],
            'supplier_id' => ['required', Rule::exists('suppliers', 'id')],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'unit_id' => ['required', Rule::exists('units', 'id')],
            'unit_price' => ['required', 'numeric'],
            'status' => ['required', Rule::in(['Enabled', 'Disabled'])]
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        unset($inputs['images']);
        
        $item = Item::create($inputs);
       
        if($request->hasFile('images')) {
            collect($request->file('images'))->each(function($image) use ($item){
                $imageName = $image->getClientOriginalName();
                $image->storeAs('images', $imageName, 'public');
                $image = $imageName;
                ItemImage::create([
                    'item_id' => $item->id,
                    'name' => $image
                ]);
            });
        }
        
        return redirect()->route('admin.items.index')->with('success', 'Item Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $suppliers = Supplier::all();
        $units = Unit::all();

        return view('pages.items.edit', compact('item', 'units', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'item_no' => ['required', Rule::unique('items', 'item_no')->ignore($item->id)],
            'item_name' => ['required', Rule::unique('items', 'item_name')->ignore($item->id)],
            'inventory_location' => ['nullable'],
            'brand' => ['required'],
            'category' => ['required'],
            'supplier_id' => ['required', Rule::exists('suppliers', 'id')],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'unit_id' => ['required', Rule::exists('units', 'id')],
            'unit_price' => ['required', 'numeric'],
            'status' => ['required', Rule::in(['Enabled', 'Disabled'])]
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        unset($inputs['images']);
        
        $item->update($inputs);
       
        if($request->hasFile('images')) {
            ItemImage::whereItemId($item->id)->delete();
            collect($request->file('images'))->each(function($image) use ($item){
                $imageName = $image->getClientOriginalName();
                $image->storeAs('images', $imageName, 'public');
                $image = $imageName;
                ItemImage::create([
                    'item_id' => $item->id,
                    'name' => $image
                ]);
            });
        }
        
        return redirect()->route('admin.items.index')->with('success', 'Item Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json(['success' => true, 'message' => 'Item Deleted Successfully']);
    }
}
