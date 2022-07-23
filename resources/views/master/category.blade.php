@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">List Kategori</h2>
      <div class="card-tools">
        <a class="btn btn-primary" data-toggle="modal" data-target="#modal-description" data-backdrop="static" data-keyboard="false">
          <i class="fas fa-plus-circle"></i> Tambah
        </a>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-bordered table-sm " id="table-category">
        <thead>
          <tr>
            <th>Kategori</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

@include('component.modal-description')
@endsection

@section('content-script')
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="js/script.js"></script>

<script>
  let dataId = "";
  $(document).ready(function(){
    categoryTable= $('#table-category').DataTable({
      processing:true,
      serverSide:true,
      ajax:{
        url:"{{ route('category.index') }}",
        type:"GET",
      },
      columns:[
        {
          data:"name",
          defaultContent:"--"
        },
        {
          data:"description",
          defaultContent:"--"
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
						return '<a data-toggle="modal" data-target="#modal-description" title="Edit" class="btn bg-gradient-success edit-category"><i class="fas fa-edit"></i></a> ' +
							'<a class="btn bg-gradient-danger delete-category"><i class="fa fa-trash"></i></a>'
					}
				}
      ],
      columnDefs: [
          { 
            className: "text-center",
            targets: [2,3]
          },
        ],
      order:[[0,'asc']]
    })
    $('#table-category').on('click','.edit-category',function() {
      let data = categoryTable.row($(this).parents('tr')).data();
      dataId = data.id;
      $('#name').val(data.name??'--');
      $('#description').val(data.description??'');
    })
  })
</script>
@endsection