@extends('layouts.main-layout')
@section('content-class')
<link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">List Supplier</h2>
            <div class="card-tools">
                <a class="btn btn-primary" href="/supplier/create">
                    <i class="fas fa-plus-circle"></i> Tambah
                </a>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered table-sm " id="table-supplier">
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Tlp</th>
                        <th>NPWP</th>
                        <th>PIC / Supir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('content-script')
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function(){
    tblSupplier = $('#table-supplier').DataTable({
        processing:true,
        serverSide:true,
        ajax:{
            url:"{{ route('supplier.index') }}",
            type:"GET",
        },
        columns:[
            {
                data:"name",
                defaultContent:"--"
            },
            {
                data:"phone",
                defaultContent:"--"
            },
            {
                data:"npwp",
                defaultContent:"--"
            },
            {
                data:"pic",
                defaultContent:"-",
                mRender:function(data,type,full){
                    return `${data} / ${full.mobile}`
                }
            },
            {
                data: 'id',
                mRender: function(data, type, full) {
                    return `<a href="/supplier/${full.id}/edit" title="Edit" class="btn btn-sm bg-gradient-primary edit-product"><i class="fas fa-eye"></i></a>`
                }
            }
        ],
        columnDefs: [
            { 
                className: "text-center",
                targets: [2,3,4]
            },
        ],
        order:[[1,'asc']]
    })
    $('div.dataTables_filter input', tblSupplier.table().container()).focus();

    $('#table-supplier').on('click','.custom-control-input',function() {
        let bool = $(this).prop('checked');
        let data = tblSupplier.row($(this).parents('tr')).data();
        data.is_active = bool?1:0;
        data["_token"]= "{{ csrf_token() }}";
        $.ajax({
            url:`{{URL::to('/supplier/status')}}`,
            type:"PUT",
            data:data,
            dataType:"json",
            success:function (item) {
                tblSupplier.clear().draw();
            },
            error:function(params){
                console.log(params)
            }
        })
    })
})
</script>
@endsection