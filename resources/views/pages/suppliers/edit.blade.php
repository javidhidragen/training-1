@extends('layouts.main')

@section('content')
<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header card">
        <div class="card-block">
            <h5 class="m-b-10">Edit Supplier</h5>

            
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

                        <div class="card-header-right"><i
                                class="icofont icofont-spinner-alt-5"></i></div>

                        <div class="card-header-right">
                            <i class="icofont icofont-spinner-alt-5"></i>
                        </div>

                    </div>
                    <div class="card-block">
                        <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label>Supplier No <span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_no" class="form-control @error('supplier_no') is-invalid @enderror" placeholder="Supplier No" value="{{ old('supplier_no', $supplier->supplier_no) }}" readonly>
                                    @error('supplier_no')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Supplier Name <span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_name" class="form-control @error('supplier_name') is-invalid @enderror"
                                        placeholder="Supplier Name" value="{{ old('supplier_name', $supplier->supplier_name) }}">
                                    @error('supplier_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Tax No <span class="text-danger">*</span></label>

                                    <input type="text" name="tax_no" class="form-control @error('tax_no') is-invalid @enderror"
                                        placeholder="Tax No" value="{{ old('tax_no', $supplier->tax_no) }}">
                                    @error('tax_no')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label>Address</label>

                                    <textarea type="textarea" name="address" class="form-control @error('address') is-invalid @enderror"
                                        placeholder="Address">{{ old('address', $supplier->address) }}</textarea>
                                    @error('address')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email', $supplier->email) }}">
                                    @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Mobile <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror"
                                        placeholder="Mobile No" value="{{ old('mobile_no', $supplier->mobile_no) }}">
                                    @error('mobile_no')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Country</label>

                                    <select name="country_id" class="form-control @error('country_id') is-invalid @enderror">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option {{ ($supplier->country_id == $country->id) ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="">Select Status</option>
                                        <option {{ ($supplier->status == 'Active') ? 'selected' : '' }} value="Active">Active</option>
                                        <option {{ ($supplier->status == 'Inactive') ? 'selected' : '' }} value="Inactive">Inactive</option>
                                        <option {{ ($supplier->status == 'Blocked') ? 'selected' : '' }} value="Blocked">Blocked</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row d-flex justify-content-end">
                                <div class="form-group">

                                                <button type="submit" class="btn btn-primary">Update</button>
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