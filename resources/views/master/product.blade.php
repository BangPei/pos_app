@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h5>List Produk</h5>
    </div>
    <div class="card-body">
      <table class="table table-striped table-bordered" id="table-product">
        <thead>
          <tr>
            <th>Barcode</th>
            <th>Nama</th>
            <th>Satuan</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
@endsection

@section('content-script')
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script>
  $(document).ready(function(){
    $('#table-product').DataTable({
      processing:true,
      serverSide:true,
      ajax:{
        url:"{{ route('product.index') }}",
        type:"GET",
      },
      columns:[
        {
          data:"barcode",
          defaultContent:"--"
        },
        {
          data:"name",
          defaultContent:"--"
        },
        {
          data:"uom.name",
          defaultContent:"--"
        },
        {
          data:"category.name",
          defaultContent:"--"
        },
        {
          data:"price",
          defaultContent:"0"
        },
        {
          data:"is_active",
          defaultContent:"--",
          mRender:function(data,type,full){
            return `<div class="badge badge-${data==1?'success':'danger'}">${data==1?'Aktif':'Tidak Aktif'}</div>`
          }
        },
        {
					data: 'id',
					mRender: function(data, type, full) {
						return '<a title="Edit" class="btn bg-gradient-success edit-product"><i class="fas fa-edit"></i></a> ' +
							'<a class="btn bg-gradient-danger delete-product"><i class="fa fa-trash"></i></a>'
					}
				}
      ],
      columnDefs: [
          { 
            className: "text-center",
            targets: [2,3,5,6]
          },
          { 
            className: "text-right",
            targets: [4]
          },
        ],
      order:[[1,'asc']]
    })
  })
</script>
@endsection