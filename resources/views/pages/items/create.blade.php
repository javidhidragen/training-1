@extends('layouts.main')

@section('content')
<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header card">
        <div class="card-block">
            <h5 class="m-b-10">Create Item</h5>

            
        </div>
    </div>
    <!-- Page-header end -->

    <!-- Page body start -->
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <!-- Basic Form Inputs card start -->
                <div class="card">
                    <div class="card-header">

                        <div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>

                        <div class="card-header-right">
                            <i class="icofont icofont-spinner-alt-5"></i>
                        </div>

                    </div>
                    <div class="card-block">
                        <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label>Item No <span class="text-danger">*</span></label>
                                    <input type="text" name="item_no"
                                        class="form-control @error('item_no') is-invalid @enderror"
                                        placeholder="Item No" value="{{ old('item_no', $item_no) }}" readonly>
                                    @error('item_no')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Item Name <span class="text-danger">*</span></label>
                                    <input type="text" name="item_name"
                                        class="form-control @error('item_name') is-invalid @enderror"
                                        placeholder="Item Name" value="{{ old('item_name') }}">
                                    @error('item_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Brand <span class="text-danger">*</span></label>

                                    <input type="text" name="brand"
                                        class="form-control @error('brand') is-invalid @enderror" placeholder="Brand"
                                        value="{{ old('brand') }}">
                                    @error('brand')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-sm-4">
                                    <label>Category <span class="text-danger">*</span></label>

                                    <input type="text" name="category"
                                        class="form-control @error('category') is-invalid @enderror"
                                        placeholder="Category">{{ old('category') }}</textarea>
                                    @error('category')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-8">
                                    <label>Inventory Location</label>

                                    <input type="text" name="inventory_location"
                                        class="form-control @error('inventory_location') is-invalid @enderror"
                                        placeholder="Inventory Location">{{ old('inventory_location') }}</textarea>
                                    @error('inventory_location')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-sm-4">
                                    <label>Supplier <span class="text-danger">*</span></label>
                                    <select name="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Unit <span class="text-danger">*</span></label>
                                    <select name="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Image</label>

                                    <input type="file" name="images[]" multiple
                                        class="form-control @error('images') is-invalid @enderror">
                                    @error('images')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                        
                                <div class="form-group col-sm-4">
                                    <label>Unit Price <span class="text-danger">*</span></label>
                                    <input type="text" name="unit_price"
                                        class="form-control @error('unit_price') is-invalid @enderror"
                                        placeholder="Unit Price">
                                        @error('unit_price')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="">Select Status</option>
                                        <option {{ (old('status') == 'Enabled') ? 'selected' : '' }} value="Enabled">Enabled</option>
                                        <option {{ (old('status') == 'Disabled') ? 'selected' : '' }} value="Disabled">Disabled</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row d-flex justify-content-end">
                                <div class="form-group">

                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                    </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</div>



@endsection