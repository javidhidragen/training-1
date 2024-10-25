<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::whereStatus(Supplier::ACTIVE)->latest()->paginate(10);

        return view('pages.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        $supplier_no = Supplier::generateSupplierNo();

        return view('pages.suppliers.create', compact('countries', 'supplier_no'));   
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
            'supplier_no' => ['required', Rule::unique('suppliers', 'supplier_no')],
            'supplier_name' => ['required'],
            'address' => ['nullable'],
            'tax_no' => ['required'],
            'country_id' => ['required', Rule::exists('countries', 'id')],
            'mobile_no' => ['required', 'digits_between:10,15', 'regex:/^\+?[1-9]\d{1,14}$/', Rule::unique('suppliers', 'mobile_no')],
            'email' => ['required', 'email', Rule::unique('suppliers', 'email')],
            'status' => ['required', Rule::in(['Active', 'Inactive', 'Blocked'])]
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Supplier::create($inputs);
        
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplie
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $countries = Country::all();

        return view('pages.suppliers.edit', compact('supplier', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'supplier_no' => [
                'required', 
                Rule::unique('suppliers', 'supplier_no')->ignore($supplier->id)
            ],
            'supplier_name' => ['required'],
            'address' => ['nullable'],
            'tax_no' => ['required'],
            'country_id' => ['required', Rule::exists('countries', 'id')],
            'mobile_no' => [
                'required', 
                'digits_between:10,15', 
                'regex:/^\+?[1-9]\d{1,14}$/', 
                Rule::unique('suppliers', 'mobile_no')->ignore($supplier->id)
            ],
            'email' => [
                'required', 
                'email', 
                Rule::unique('suppliers', 'email')->ignore($supplier->id)
            ],
            'status' => ['required', Rule::in(['Active', 'Inactive', 'Blocked'])]
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $supplier->update($inputs);
        
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return response()->json(['success' => true, 'message' => 'Supplier Deleted Successfully']);
    }
}
