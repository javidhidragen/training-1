@extends('layouts.main')

@section('content')
<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header card">
        <div class="card-block d-flex justify-content-between">
            <h5 class="m-b-10">Suppliers</h5>

            <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">+ Create</a>
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
                        <table class="table table-striped" id="suppliersTable">
                            <thead>
                                <tr>
                                    <th>SI No</th>
                                    <th>Supplier No</th>
                                    <th>Supplier Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(count($suppliers) > 0)
                                @foreach($suppliers as $supplier)
                                <tr>
                                    <td>{{ $suppliers->firstItem() + $loop->index }}</td>
                                    <td>{{ $supplier->supplier_no }}</td>
                                    <td>{{ $supplier->supplier_name }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>{{ $supplier->mobile_no }}</td>
                                    <td><span>{{ $supplier->status }}</span></td>
                                    <td>
                                        <a href="{{ route('admin.suppliers.edit', $supplier->id) }}"
                                            class="btn btn-warning btn-sm"><i class="fa fa-edit fa-lg"></i></a>
                                        <a href="#" data-url="{{ route('admin.suppliers.destroy', $supplier->id) }}"
                                            data-method="DELETE" class="btn btn-danger btn-sm btnDelete"><i
                                                class="fa fa-trash fa-lg"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">No Records available in table</td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">{{ $suppliers->links() }}</td>
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
    $("#suppliersTable").on('click', '.btnDelete', function() {
        let url = $(this).data('url');
        let method = $(this).data('method');

        swal({
                title: "Are you sure?",
                text: "Are you sure want to delete this Supplier",
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