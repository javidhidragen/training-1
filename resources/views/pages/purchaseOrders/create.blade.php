@extends('layouts.main')

@section('content')
<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header card">
        <div class="card-block">
            <h5 class="m-b-10">Create Purchase Order</h5>


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
                        <form action="{{ route('admin.purchases.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label>Order No <span class="text-danger">*</span></label>
                                    <input type="text" name="order_no"
                                        class="form-control @error('order_no') is-invalid @enderror"
                                        placeholder="Order No" value="{{ old('order_no', $order_no) }}" readonly>
                                    @error('order_no')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Order Date <span class="text-danger">*</span></label>
                                    <input type="date" name="order_date"
                                        class="form-control @error('order_date') is-invalid @enderror"
                                        value="{{ date('Y-m-d') }}">
                                    @error('order_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Supplier <span class="text-danger">*</span></label>
                                    <select name="supplier_id"
                                        class="form-control @error('supplier_id') is-invalid @enderror">
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table" id="itemsTable">
                                        <thead>
                                            <tr>
                                                <th>SI No</th>
                                                <th>Item</th>
                                                <th>Unit</th>
                                                <th>Qty</th>
                                                <th>Item Amount</th>
                                                <th>Discount</th>
                                                <th>Net Amount</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="btn btn-success btn-sm createNextRowBtn"><i
                                                class="fa fa-plus"></i></a>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label>Item Total <span class="text-danger">*</span></label>
                                    <input type="text" name="item_total"
                                        class="form-control @error('item_total') is-invalid @enderror"
                                        placeholder="Item Total" value="{{ old('item_total') }}">
                                    @error('item_total')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Discount <span class="text-danger">*</span></label>
                                    <input type="text" name="discount"
                                        class="form-control @error('discount') is-invalid @enderror"
                                        value="{{ old('discount') }}" placeholder="Discount">
                                    @error('discount')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Net Amount <span class="text-danger">*</span></label>
                                    <input type="text" name="net_amount"
                                        class="form-control @error('net_amount') is-invalid @enderror" placeholder="Net Amount">
                                    
                                    @error('net_amount')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row d-flex justify-content-end mt-4">
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

@push('scripts')
<script>
$(document).ready(function() {
    function siNo() {
        let i = 1;
        $(".siNo").each(function() {
            $(this).text(i);
            i++;
        });
    }
    siNo();

    let l = () => {
        let j = 1;
        $(".tableRow").each(function(){
            j++;
        });
        return j;
    }
    l();

    $(document).on('click', '.createNextRowBtn', function() {
        let html = '<tr class="tableRow">' +
            '<td class="siNo"></td>' +
            '<td>' +
            '<select name="items[]" id="item_id'+l()+'" class="form-control">' +
            '<option value="">Select Item</option>' +
            <?php foreach($items as $item) { ?> '<option value="{{ $item->id }}" data-unit-id="{{ $item->unit_id }}" data-unit-price="{{ $item->unit_price }}">{{ $item->item_no }}  {{ $item->item_name }}</option>' +
            <?php } ?> '</select>' +
            '</td>' +
            '<td>' +
            '<select name="unit_id[]" id="unit_id'+l()+'" class="form-control">' +
            '<option value="">Select Unit</option>' +
            <?php foreach($units as $unit) { ?> '<option value="{{ $unit->id }}">{{ $unit->name }}</option>' +
            <?php } ?> '</select>' +
            '</td>' +
            '<td>' +
            '<input type="text" name="quantity[]" id="quantity'+l()+'" class="form-control" placeholder="Qty">' +
            '</td>' +
            '<td>' +
            '<input type="text" name="item_amount[]" id="item_amount'+l()+'" class="form-control" placeholder="Item Amount">' +
            '</td>' +
            '<td>' +
            '<input type="text" name="discount[]" id="discount'+l()+'" class="form-control" placeholder="Discount">' +
            '</td>' +
            '<td>' +
            '<input type="text" name="net_amount[]" id="net_amount'+l()+'" class="form-control" placeholder="Net Amount">' +
            '</td>' +
            '<td>' +
            '<a href="#" class="btn btn-danger btn-sm btnRemove"><i class="fa fa-trash fa-lg"></i></a>' +
            '</td>' +
            '</tr>';

        $("#itemsTable tbody").append(html);
        siNo();
    });

    $(document).on('click', '.btnRemove', function(){
        $(this).closest('tr').remove();
        l();
        siNo();
    });

    $(document).on('change', '#item_id'+l(), function(){
        let unit_id = $(this).data('unit-id');
        console.log(unit_id);
        let unit_price = $(this).data('unit-price');
        $("#unit_id"+l()).val(unit_id).trigger('change');
        $("#quantity"+l()).val(1);
        $("#unit_price"+l()).val(unit_price);
    });
});
</script>
@endpush