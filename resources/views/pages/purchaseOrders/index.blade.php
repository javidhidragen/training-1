@extends('layouts.main')

@section('content')
<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header card">
        <div class="card-block d-flex justify-content-between">
            <h5 class="m-b-10">Purchase Orders</h5>

            <a href="{{ route('admin.purchases.create') }}" class="btn btn-primary">+ Create</a>
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
                        <table class="table table-striped" id="purchasesTable">
                            <thead>
                                <tr>
                                    <th>SI No</th>
                                    <th>Order No</th>
                                    <th>Order Date</th>
                                    <th>Supplier</th>
                                    <th>Net Amount</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(count($purchases) > 0)
                                @foreach($purchases as $purchase)
                                <tr>
                                    <td>{{ $purchases->firstItem() + $loop->index }}</td>
                                    <td>{{ $purchase->order_no }}</td>
                                    <td>{{ date('d-m-Y', strtotime($purchase->order_date)) }}</td>
                                    <td>{{ $purchase->supplier->supplier_name }}</td>
                                    <td>{{ number_format($purchase->net_amount, 2) }}</td>
                                    <td>
                                        <a href="{{ route('admin.purchases.edit', $purchase->id) }}"
                                            class="btn btn-warning btn-sm"><i class="fa fa-edit fa-lg"></i></a>
                                        <a href="#" data-url="{{ route('admin.purchases.destroy', $purchase->id) }}"
                                            data-method="DELETE" class="btn btn-danger btn-sm btnDelete"><i
                                                class="fa fa-trash fa-lg"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center">No Records available in table</td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">{{ $purchases->links() }}</td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@push('scripts')
@if($message = session()->get('success'))
    <script>
        swal("{{ $message }}", {
            icon: "success",
        });
    </script>
@endif
<script>
$(document).ready(function() {
    $("#purchasesTable").on('click', '.btnDelete', function() {
        let url = $(this).data('url');
        let method = $(this).data('method');

        swal({
                title: "Are you sure?",
                text: "Are you sure want to delete this Purchase",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: url,
                        type: method,
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: "JSON",
                        success: function(response) {
                            swal(response.message, {
                                icon: "success",
                            })
                            .then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
    });
});
</script>
@endpush